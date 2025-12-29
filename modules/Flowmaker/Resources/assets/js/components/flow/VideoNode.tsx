import { Handle, Position, Node } from '@xyflow/react';
import { Video, Trash2, Upload, Copy } from 'lucide-react';
import { useCallback, useState } from 'react';
import { useReactFlow } from '@xyflow/react';
import { Button } from "@/components/ui/button";
import { NodeData } from "@/types/flow";
import { Label } from "@/components/ui/label";
import { VariableTextArea } from '../common/VariableTextArea';
import {
  ContextMenu,
  ContextMenuContent,
  ContextMenuItem,
  ContextMenuTrigger,
} from "@/components/ui/context-menu";

interface VideoNodeProps {
  id: string;
  data: NodeData;
}

const VideoNode = ({ id, data }: VideoNodeProps) => {
  const { setNodes } = useReactFlow();
  const [isUploading, setIsUploading] = useState(false);
  const [caption, setCaption] = useState(data.settings?.caption || '');
  const [uploadError, setUploadError] = useState<string | null>(null);

  /** Upload video */
  const handleVideoUpload = useCallback((event: React.ChangeEvent<HTMLInputElement>) => {
    const file = event.target.files?.[0];
    if (!file) return;

    setIsUploading(true);
    setUploadError(null);

    const formData = new FormData();
    formData.append('file', file);
    formData.append('type', 'video');

    fetch('/flowmakermedia', {
      method: 'POST',
      body: formData,
    })
      .then(res => res.json())
      .then(data => {
        if (data.error) throw new Error(data.error);

        setNodes(nodes =>
          nodes.map((node: Node<NodeData>) => {
            if (node.id === id) {
              const settings = node.data.settings || {};
              return { ...node, data: { ...node.data, settings: { ...settings, videoUrl: data.url } } };
            }
            return node;
          })
        );
        setIsUploading(false);
      })
      .catch(err => {
        console.error('Error uploading video:', err);
        setUploadError(err.message || 'Failed to upload video');
        setIsUploading(false);
      });
  }, [id, setNodes]);

  /** Caption change */
  const handleCaptionChange = useCallback((value: string) => {
    setCaption(value);
    setNodes(nodes =>
      nodes.map((node: Node<NodeData>) => {
        if (node.id === id) {
          const settings = node.data.settings || {};
          return { ...node, data: { ...node.data, settings: { ...settings, caption: value } } };
        }
        return node;
      })
    );
  }, [id, setNodes]);

  /** Delete node */
  const deleteNode = useCallback((nodeId: string) => {
    setNodes(nodes => nodes.filter(n => n.id !== nodeId));
  }, [setNodes]);

  /** Duplicate node */
  const duplicateNode = useCallback((nodeId: string) => {
    setNodes(nodes => {
      const nodeToDuplicate = nodes.find(n => n.id === nodeId);
      if (!nodeToDuplicate) return nodes;

      const newId = `${nodeId}-${Date.now()}`; // unique ID
      const duplicatedNode = {
        ...nodeToDuplicate,
        id: newId,
        position: {
          x: nodeToDuplicate.position.x + 30, // offset position
          y: nodeToDuplicate.position.y + 30,
        },
      };

      return [...nodes, duplicatedNode];
    });
  }, [setNodes]);

  return (
    <ContextMenu>
      <ContextMenuTrigger>
        <div className="w-[300px] bg-white rounded-lg shadow-lg">
          <Handle type="target" position={Position.Left} className="!bg-gray-300 !w-3 !h-3 !rounded-full" />

          <div className="flex items-center gap-2 border-b border-gray-100 px-3 py-2 bg-gray-50">
            <Video className="h-4 w-4 text-purple-600 flex-shrink-0" />
            <div className="font-medium leading-none">Send Video</div>
          </div>

          <div className="p-4 space-y-4">
            <div className="space-y-2">
              {data.settings?.videoUrl ? (
                <div className="relative group">
                  <video src={data.settings.videoUrl} controls className="w-full h-[200px] object-cover rounded-md" />
                  <div className="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <Button
                      variant="secondary"
                      size="sm"
                      onClick={() => document.getElementById(`video-upload-${id}`)?.click()}
                    >
                      Change Video
                    </Button>
                  </div>
                </div>
              ) : (
                <div 
                  className="border-2 border-dashed border-gray-200 rounded-md p-8 text-center cursor-pointer hover:border-gray-300 transition-colors"
                  onClick={() => document.getElementById(`video-upload-${id}`)?.click()}
                >
                  <Upload className="w-8 h-8 mx-auto mb-2 text-gray-400" />
                  <div className="text-sm text-gray-500">Click to upload a video</div>
                </div>
              )}
              <input
                type="file"
                id={`video-upload-${id}`}
                className="hidden"
                accept="video/*"
                onChange={handleVideoUpload}
                disabled={isUploading}
              />
              {isUploading && <div className="text-sm text-center text-blue-600">Uploading video...</div>}
              {uploadError && <div className="text-sm text-center text-red-600">{uploadError}</div>}
            </div>

            <div className="space-y-2">
              <Label htmlFor="caption">Caption</Label>
              <VariableTextArea value={caption} onChange={handleCaptionChange} placeholder="Add a caption..." />
            </div>
          </div>

          <Handle type="source" position={Position.Right} className="!bg-gray-300 !w-3 !h-3 !rounded-full" />
        </div>
      </ContextMenuTrigger>

      <ContextMenuContent>
        <ContextMenuItem className="text-blue-600" onClick={() => duplicateNode(id)}>
          <Copy className="mr-2 h-4 w-4" />
          Duplicate
        </ContextMenuItem>

        <ContextMenuItem className="text-red-600 focus:text-red-600 focus:bg-red-100" onClick={() => deleteNode(id)}>
          <Trash2 className="mr-2 h-4 w-4" />
          Delete
        </ContextMenuItem>
      </ContextMenuContent>
    </ContextMenu>
  );
};

export default VideoNode;
