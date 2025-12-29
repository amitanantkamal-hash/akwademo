import { MessageCircle, Trash2, Copy } from 'lucide-react';
import { Label } from "@/components/ui/label";
import { useCallback } from 'react';
import { useReactFlow, Handle, Position } from '@xyflow/react';
import BaseNodeLayout from './BaseNodeLayout';
import { VariableTextArea } from '../common/VariableTextArea';
import {
  ContextMenu,
  ContextMenuContent,
  ContextMenuItem,
  ContextMenuTrigger,
} from "@/components/ui/context-menu";

interface MessageNodeProps {
  id: string;
  data: {
    label: string;
    settings?: {
      message?: string;
    };
  };
}

const MessageNode = ({ id, data }: MessageNodeProps) => {
  const { getNodes, getNode, setNodes, setEdges } = useReactFlow();

  // Update message in node data
  const handleMessageChange = useCallback((value: string) => {
    setNodes((nodes) =>
      nodes.map((node) => {
        if (node.id === id) {
          return {
            ...node,
            data: {
              ...node.data,
              settings: {
                ...node.data.settings,
                message: value,
              },
            },
          };
        }
        return node;
      })
    );
  }, [id, setNodes]);

  // Duplicate node
  const duplicateNode = useCallback(() => {
    const original = getNode(id);
    if (!original) return;

    const newId = `${id}-copy-${Date.now()}`;
    const duplicated = {
      ...original,
      id: newId,
      position: {
        x: (original.position?.x || 0) + 50,
        y: (original.position?.y || 0) + 50,
      },
      selected: false,
      data: {
        ...original.data,
        settings: { ...original.data.settings },
      },
    };

    setNodes((nodes) => [...nodes, duplicated]);
  }, [id, getNode, setNodes]);

  // Delete node (and edges)
  const deleteNode = useCallback(() => {
    setNodes((nodes) => nodes.filter((n) => n.id !== id));
    setEdges((edges) => edges.filter((e) => e.source !== id && e.target !== id));
  }, [id, setNodes, setEdges]);

  return (
    <ContextMenu>
      <ContextMenuTrigger>
        <div className="bg-white rounded-lg shadow-lg">
          <Handle
            type="target"
            position={Position.Left}
            className="!bg-gray-300 !w-3 !h-3 !rounded-full"
          />

          <BaseNodeLayout
            id={id}
            title="Send Message"
            icon={<MessageCircle className="h-4 w-4 text-blue-600" />}
            headerBackground="bg-gray-50"
            borderColor="border-gray-100"
          >
            <div className="space-y-4">
              <div className="space-y-2">
                <Label htmlFor="message">Message</Label>
                <VariableTextArea
                  value={data.settings?.message || ""}
                  onChange={handleMessageChange}
                  placeholder="Enter your message..."
                />
              </div>
            </div>
          </BaseNodeLayout>

          <Handle
            type="source"
            position={Position.Right}
            className="!bg-gray-300 !w-3 !h-3 !rounded-full"
          />
        </div>
      </ContextMenuTrigger>

      <ContextMenuContent>
        <ContextMenuItem onClick={duplicateNode} className="flex items-center gap-2">
          <Copy className="h-4 w-4" /> Duplicate Node
        </ContextMenuItem>
        <ContextMenuItem onClick={deleteNode} className="flex items-center gap-2 text-red-600">
          <Trash2 className="h-4 w-4" /> Delete Node
        </ContextMenuItem>
      </ContextMenuContent>
    </ContextMenu>
  );
};

export default MessageNode;
