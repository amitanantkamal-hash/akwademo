import { Handle, Position, Node } from '@xyflow/react';
import { MessageSquare, Plus, X, Trash2, Copy, AlertCircle } from 'lucide-react';
import { Label } from "@/components/ui/label";
import { Button } from "@/components/ui/button";
import { NodeData } from '@/types/flow';
import { VariableTextArea } from '../common/VariableTextArea';
import { VariableInput } from '../common/VariableInput';
import { useCallback, useState, useEffect } from 'react';
import { useFlowActions } from "@/hooks/useFlowActions";
import { useReactFlow } from '@xyflow/react';
import { nanoid } from 'nanoid';
import {
  ContextMenu,
  ContextMenuContent,
  ContextMenuItem,
  ContextMenuTrigger,
} from "@/components/ui/context-menu";

interface QuickRepliesNodeProps {
  data: NodeData;
  id: string;
  selected?: boolean;
  isConnectable?: boolean;
}

interface NodeSettings {
  header: string;
  body: string;
  footer: string;
  activeButtons: number;
  listButtonName: string;
  [key: string]: string | number;
}

// ...imports remain the same

const QuickRepliesNode = ({ data, id, selected, isConnectable }: QuickRepliesNodeProps) => {
  const { deleteNode } = useFlowActions();
  const { getNodes, setNodes } = useReactFlow();

  const [nodeSettings, setNodeSettings] = useState<NodeSettings>(() => {
    const initialSettings: NodeSettings = {
      header: data.settings?.header || '',
      body: data.settings?.body || '',
      footer: data.settings?.footer || '',
      activeButtons: Math.min(data.settings?.activeButtons || 1, 3),
      listButtonName: data.settings?.listButtonName || '',
    };

    for (let i = 1; i <= 3; i++) {
      initialSettings[`button${i}`] = data.settings?.[`button${i}`] || '';
    }

    return initialSettings;
  });

  useEffect(() => {
    if (data.settings) {
      Object.keys(nodeSettings).forEach(key => {
        data.settings[key] = nodeSettings[key];
      });
    }
  }, [nodeSettings, data]);

  const updateNodeData = useCallback((key: string, value: any) => {
    // Enforce character limits
    if (key === 'header' || key === 'footer') value = value.slice(0, 60);
    if (key === 'body') value = value.slice(0, 1024);
    if (key.startsWith('button')) value = value.slice(0, 25);

    setNodeSettings(prev => ({
      ...prev,
      [key]: value
    }));
  }, []);

  const addButton = useCallback(() => {
    if (nodeSettings.activeButtons < 3) { // limit to 3 buttons
      updateNodeData('activeButtons', nodeSettings.activeButtons + 1);
    }
  }, [nodeSettings.activeButtons, updateNodeData]);

  const removeButton = useCallback((buttonIndex: number) => {
    if (nodeSettings.activeButtons > 1) {
      const newSettings = { ...nodeSettings };
      for (let i = buttonIndex; i < 3; i++) {
        newSettings[`button${i}`] = nodeSettings[`button${i + 1}`] || '';
      }
      newSettings[`button3`] = '';
      newSettings.activeButtons = nodeSettings.activeButtons - 1;
      setNodeSettings(newSettings);
    }
  }, [nodeSettings]);

  const duplicateNode = () => {
    const nodes = getNodes();
    const nodeToDuplicate = nodes.find(n => n.id === id);
    if (!nodeToDuplicate) return;

    const newId = nanoid();
    const duplicatedNode: Node<any> = {
      ...nodeToDuplicate,
      id: newId,
      position: {
        x: nodeToDuplicate.position.x + 40,
        y: nodeToDuplicate.position.y + 40,
      },
      data: { ...nodeToDuplicate.data },
    };
    setNodes([...nodes, duplicatedNode]);
  };

  return (
    <ContextMenu>
      <ContextMenuTrigger>
        <div className="bg-white rounded-lg shadow-lg w-[300px]">
          <Handle
            type="target"
            position={Position.Left}
            style={{ left: '-4px', background: '#555', zIndex: 50 }}
            isConnectable={isConnectable}
          />

          <div className="flex items-center gap-2 mb-4 pb-2 border-b border-gray-100 px-4 pt-3 bg-gray-50">
            <MessageSquare className="h-4 w-4 text-indigo-600" />
            <div className="font-medium flex-1">Quick Replies Message</div>
          </div>

          <div className="p-4 space-y-4">
            <div className="space-y-2">
              <Label htmlFor={`${id}-header`}>Header</Label>
              <VariableInput
                id={`${id}-header`}
                placeholder="Enter header text (max 60 chars)"
                value={nodeSettings.header}
                onChange={(value) => updateNodeData('header', value)}
              />
            </div>

            <div className="space-y-2">
              <Label htmlFor={`${id}-body`}>Body</Label>
              <VariableTextArea
                value={nodeSettings.body}
                onChange={(value) => updateNodeData('body', value)}
                placeholder="Enter message body (max 1024 chars)"
              />
            </div>

            <div className="space-y-2">
              <Label htmlFor={`${id}-footer`}>Footer</Label>
              <VariableInput
                id={`${id}-footer`}
                placeholder="Enter footer text (max 60 chars)"
                value={nodeSettings.footer}
                onChange={(value) => updateNodeData('footer', value)}
              />
            </div>

            <div className="space-y-3">
              {Array.from({ length: nodeSettings.activeButtons }).map((_, index) => {
                const buttonNum = index + 1;
                return (
                  <div key={buttonNum} className="relative">
                    <div className="flex items-start gap-2">
                      <div className="flex-1">
                        <Label htmlFor={`${id}-button-${buttonNum}`}>Button {buttonNum}</Label>
                        <VariableInput
                          id={`${id}-button-${buttonNum}`}
                          placeholder={`Enter button ${buttonNum} text (max 25 chars)`}
                          value={nodeSettings[`button${buttonNum}`]}
                          onChange={(value) => updateNodeData(`button${buttonNum}`, value)}
                        />
                      </div>
                      {nodeSettings.activeButtons > 1 && (
                        <Button
                          variant="ghost"
                          size="icon"
                          className="mt-6"
                          onClick={() => removeButton(buttonNum)}
                        >
                          <X className="h-4 w-4" />
                        </Button>
                      )}
                    </div>
                    <Handle
                      type="source"
                      position={Position.Right}
                      id={`button-${buttonNum}`}
                      className="!bg-gray-400 !w-3 !h-3 !min-w-[12px] !min-h-[12px] !border-2 !border-white"
                      style={{
                        right: '-20px',
                        top: '50%',
                        transform: 'translateY(-50%)',
                        zIndex: 50
                      }}
                      isConnectable={isConnectable}
                    />
                  </div>
                );
              })}

              {nodeSettings.activeButtons < 3 && (
                <Button
                  variant="outline"
                  className="w-full"
                  onClick={addButton}
                >
                  <Plus className="h-4 w-4 mr-2" />
                  Add Button
                </Button>
              )}
            </div>
          </div>
        </div>
      </ContextMenuTrigger>

      <ContextMenuContent>
        <ContextMenuItem
          className="text-blue-600 flex items-center"
          onClick={duplicateNode}
        >
          <Copy className="mr-2 h-4 w-4" /> Duplicate
        </ContextMenuItem>

        <ContextMenuItem
          className="text-red-600 flex items-center"
          onClick={() => deleteNode(id)}
        >
          <Trash2 className="mr-2 h-4 w-4" /> Delete
        </ContextMenuItem>
      </ContextMenuContent>
    </ContextMenu>
  );
};

export default QuickRepliesNode;

