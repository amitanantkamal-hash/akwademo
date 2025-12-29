import { Handle, Position, Node, useReactFlow } from '@xyflow/react';
import { Image as ImageIcon, Trash2, Upload, Copy } from 'lucide-react';
import { useFlowActions } from "@/hooks/useFlowActions";
import {
  ContextMenu,
  ContextMenuContent,
  ContextMenuItem,
  ContextMenuTrigger,
} from "@/components/ui/context-menu";
import { useCallback, useState } from 'react';
import { Button } from "@/components/ui/button";
import { NodeData } from "@/types/flow";
import { Label } from "@/components/ui/label";
import { VariableTextArea } from '../common/VariableTextArea';

interface ImageNodeProps {
  id: string;
  data: NodeData;
}

const ImageNode = ({ id, data }: ImageNodeProps) => {
  const { deleteNode } = useFlowActions();
  const { setNodes, getNode, setEdges } = useReactFlow();
  const [isUploading, setIsUploading] = useState(false);
  const [caption, setCaption] = useState(data.settings?.caption || '');
  const [uploadError, setUploadError] = useState<string | null>(null);

  const handleImageUpload = useCallback((event: React.ChangeEvent<HTMLInputElement>) => {
    const file = event.target.files?.[0];
    if (!file) return;

    setIsUploading(true);
    setUploadError(null);
    
    const formData = new FormData();
    formData.append('file', file);
    formData.append('type', 'image');

    fetch('/flowmakermedia', { method: 'POST', body: formData })
      .then(res => res.json())
      .then(data => {
        if (data.error) throw new Error(data.error);

        setNodes((nodes) =>
          nodes.map((node: Node<NodeData>) =>
            node.id === id
              ? {
                  ...node,
                  data: {
                    ...node.data,
                    settings: { ...node.data.settings, imageUrl: data.url },
                  },
                }
              : node
          )
        );
        setIsUploading(false);
      })
      .catch(err => {
        setUploadError(err.message || 'Failed to upload image');
        setIsUploading(false);
      });
  }, [id, setNodes]);

  const handleCaptionChange = useCallback((value: string) => {
    setCaption(value);
    setNodes((nodes) =>
      nodes.map((node: Node<NodeData>) =>
        node.id === id
          ? {
              ...node,
              data: {
                ...node.data,
                settings: { ...node.data.settings, caption: value },
              },
            }
          : node
      )
    );
  }, [id, setNodes]);

  const handleDuplicate = useCallback(() => {
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
      data: { ...original.data, settings: { ...original.data.settings } },
    };

    setNodes((nodes) => [...nodes, duplicated]);
  }, [id, getNode, setNodes]);

  const handleDelete = useCallback(() => {
    deleteNode(id);
    setEdges((edges) => edges.filter((e) => e.source !== id && e.target !== id));
  }, [id, deleteNode, setEdges]);

  return (
    <ContextMenu>
      <ContextMenuTrigger>
        <div className="w-[300px] bg-white rounded-lg shadow-lg cursor-pointer">
          <Handle type="target" position={Position.Left} className="!bg-gray-300 !w-3 !h-3 !rounded-full" />
          
          <div className="flex items-center gap-2 border-b border-gray-100 px-3 py-2 bg-gray-50">
            <ImageIcon className="h-4 w-4 text-purple-600 flex-shrink-0" />
            <div className="font-medium leading-none">Send Image</div>
          </div>

          <div className="p-4 space-y-4">
            <div className="space-y-2">
              {data.settings?.imageUrl ? (
                <div className="relative group">
                  <img 
                    src={data.settings.imageUrl} 
                    alt="Uploaded preview" 
                    className="w-full h-[200px] object-cover rounded-md"
                  />
                  <div className="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <Button
                      variant="secondary"
                      size="sm"
                      onClick={() => document.getElementById(`image-upload-${id}`)?.click()}
                    >
                      Change Image
                    </Button>
                  </div>
                </div>
              ) : (
                <div 
                  className="border-2 border-dashed border-gray-200 rounded-md p-8 text-center cursor-pointer hover:border-gray-300 transition-colors"
                  onClick={() => document.getElementById(`image-upload-${id}`)?.click()}
                >
                  <Upload className="w-8 h-8 mx-auto mb-2 text-gray-400" />
                  <div className="text-sm text-gray-500">Click to upload an image</div>
                </div>
              )}
              <input
                type="file"
                id={`image-upload-${id}`}
                className="hidden"
                accept="image/*"
                onChange={handleImageUpload}
                disabled={isUploading}
              />
              {isUploading && <div className="text-sm text-center text-blue-600">Uploading image...</div>}
              {uploadError && <div className="text-sm text-center text-red-600">{uploadError}</div>}
            </div>

            <div className="space-y-2">
              <Label htmlFor="caption">Caption</Label>
              <VariableTextArea
                value={caption}
                onChange={handleCaptionChange}
                placeholder="Add a caption..."
              />
            </div>
          </div>

          <Handle type="source" position={Position.Right} className="!bg-gray-300 !w-3 !h-3 !rounded-full" />
        </div>
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

export default ImageNode;
