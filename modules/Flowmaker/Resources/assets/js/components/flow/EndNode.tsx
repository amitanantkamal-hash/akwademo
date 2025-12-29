import { Square } from 'lucide-react';
import BaseNodeLayout from './BaseNodeLayout';
import { useReactFlow, Node } from '@xyflow/react';
import { ContextMenu, ContextMenuContent, ContextMenuItem, ContextMenuTrigger } from "@/components/ui/context-menu";
import { Copy, Trash2 } from 'lucide-react';

interface EndNodeProps {
  id: string;
  data: {
    label: string;
  };
}

const EndNode = ({ id, data }: EndNodeProps) => {
  const { getNode, setNodes, setEdges } = useReactFlow();

  const handleDuplicate = () => {
    const original = getNode(id);
    if (!original) return;

    const newId = `${id}-copy-${Date.now()}`;
    const duplicated: Node<any> = {
      ...original,
      id: newId,
      position: {
        x: (original.position?.x || 0) + 50,
        y: (original.position?.y || 0) + 50,
      },
      selected: false,
      data: { ...original.data },
    };

    setNodes((nodes) => [...nodes, duplicated]);
  };

  const handleDelete = () => {
    setNodes((nodes) => nodes.filter((n) => n.id !== id));
    setEdges((edges) => edges.filter((e) => e.source !== id && e.target !== id));
  };

  return (
    <ContextMenu>
      <ContextMenuTrigger>
        <BaseNodeLayout
          id={id}
          title={data.label}
          icon={<Square className="h-4 w-4 text-red-600" />}
          headerBackground="bg-gray-50"
          borderColor="border-gray-100"
          handles={{ left: true }}
        >
          <div className="text-sm text-gray-600">
            <p>This marks the end of your flow.</p>
          </div>
        </BaseNodeLayout>
      </ContextMenuTrigger>

      <ContextMenuContent>
        <ContextMenuItem onClick={handleDuplicate} className="flex items-center gap-2">
          <Copy className="h-4 w-4" /> Duplicate Node
        </ContextMenuItem>
        <ContextMenuItem onClick={handleDelete} className="flex items-center gap-2 text-red-600">
          <Trash2 className="h-4 w-4" /> Delete Node
        </ContextMenuItem>
      </ContextMenuContent>
    </ContextMenu>
  );
};

export default EndNode;
