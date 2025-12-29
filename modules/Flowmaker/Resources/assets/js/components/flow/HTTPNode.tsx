import React, { useEffect, useRef, useState } from 'react';
import { Handle, Position, useReactFlow, Node } from '@xyflow/react';
import { Globe, Trash2, Copy } from 'lucide-react';
import { Label } from "@/components/ui/label";
import { VariableTextArea } from '../common/VariableTextArea';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import { NodeData } from '@/types/flow';
import HeadersSection from './http/HeadersSection';
import ParametersSection from './http/ParametersSection';
import { VariableInput } from '@/components/common/VariableInput';
import { useFlowActions } from "@/hooks/useFlowActions";
import {
  ContextMenu,
  ContextMenuContent,
  ContextMenuItem,
  ContextMenuTrigger,
} from "@/components/ui/context-menu";

interface HTTPNodeProps {
  id: string;
  data: NodeData;
}

type HTTPMethod = 'GET' | 'POST' | 'PUT' | 'DELETE';

interface KeyValue {
  id: string;
  key: string;
  value: string;
}

interface HTTPSettings {
  method: HTTPMethod;
  url: string;
  headers: KeyValue[];
  params: KeyValue[];
  responseVar: string;
  body: string;
}

const defaultSettings: HTTPSettings = {
  method: 'GET',
  url: '',
  headers: [],
  params: [],
  responseVar: '',
  body: ''
};

// Safe ID generator
const generateId = () =>
  typeof crypto !== "undefined" && typeof (crypto as any).randomUUID === "function"
    ? (crypto as any).randomUUID()
    : Math.random().toString(36).substring(2, 11);

const HTTPNode = ({ id, data }: HTTPNodeProps) => {
  const { setNodes, getNode, setEdges } = useReactFlow();
  const { deleteNode } = useFlowActions();

  const initialSettings: HTTPSettings = {
    ...defaultSettings,
    ...(data.settings?.http || {})
  };

  const [httpSettings, setHttpSettings] = useState<HTTPSettings>(initialSettings);

  useEffect(() => {
    setNodes(nodes =>
      nodes.map(node => {
        if (node.id === id) {
          const currentData = (node.data || {}) as Record<string, unknown>;
          const currentSettings = ((currentData.settings || {}) as Record<string, unknown>);
          return {
            ...node,
            data: {
              ...currentData,
              settings: {
                ...currentSettings,
                http: httpSettings,
              },
            },
          };
        }
        return node;
      })
    );
  }, [httpSettings, id, setNodes]);

  const updateSettings = (updates: Partial<HTTPSettings>) => {
    setHttpSettings(current => ({
      ...current,
      ...updates,
    }));
  };

  const addHeader = () => updateSettings({ headers: [...httpSettings.headers, { id: generateId(), key: '', value: '' }] });
  const updateHeader = (id: string, key: string, value: string) => updateSettings({ headers: httpSettings.headers.map(h => h.id === id ? { ...h, key, value } : h) });
  const updateHeaderField = (id: string, field: 'key' | 'value', value: string) => updateSettings({ headers: httpSettings.headers.map(h => h.id === id ? { ...h, [field]: value } : h) });
  const removeHeader = (id: string) => updateSettings({ headers: httpSettings.headers.filter(h => h.id !== id) });

  const addParam = () => updateSettings({ params: [...httpSettings.params, { id: generateId(), key: '', value: '' }] });
  const updateParam = (id: string, key: string, value: string) => updateSettings({ params: httpSettings.params.map(p => p.id === id ? { ...p, key, value } : p) });
  const updateParamField = (id: string, field: 'key' | 'value', value: string) => updateSettings({ params: httpSettings.params.map(p => p.id === id ? { ...p, [field]: value } : p) });
  const removeParam = (id: string) => updateSettings({ params: httpSettings.params.filter(p => p.id !== id) });

  const bodyRef = useRef<HTMLTextAreaElement | null>(null);
  const insertVariableToBody = (variableName: string) => {
    if (!bodyRef.current) return;
    const textarea = bodyRef.current;
    const start = textarea.selectionStart ?? textarea.value.length;
    const end = textarea.selectionEnd ?? textarea.value.length;
    const insert = `{{${variableName}}}`;
    const newText = textarea.value.slice(0, start) + insert + textarea.value.slice(end);
    updateSettings({ body: newText });
    requestAnimationFrame(() => {
      textarea.focus();
      textarea.selectionStart = textarea.selectionEnd = start + insert.length;
    });
  };

  const onInsertVariableClicked = () => {
    const varName = window.prompt('Variable name (without braces), e.g. user_name');
    if (!varName) return;
    insertVariableToBody(varName.trim());
  };

  // Duplicate Node
  const handleDuplicate = () => {
    const original = getNode(id);
    if (!original) return;

    const newId = `${id}-copy-${Date.now()}`;
    const duplicated: Node<NodeData> = {
      ...original,
      id: newId,
      position: {
        x: (original.position?.x || 0) + 50,
        y: (original.position?.y || 0) + 50,
      },
      selected: false,
      data: { ...original.data, settings: { ...original.data.settings } },
    };
    setNodes(nodes => [...nodes, duplicated]);
  };

  const handleDelete = () => {
    deleteNode(id);
    setEdges(edges => edges.filter(e => e.source !== id && e.target !== id));
  };

  return (
    <ContextMenu>
      <ContextMenuTrigger>
        <div className="w-[500px] bg-white rounded-lg shadow-lg cursor-pointer">
          <Handle type="target" position={Position.Left} className="!bg-gray-300 !w-3 !h-3 !rounded-full" />

          <div className="flex items-center gap-2 mb-4 pb-2 border-b border-gray-100 px-4 pt-3 bg-gray-50">
            <Globe className="h-4 w-4 text-blue-600" />
            <div className="font-medium">HTTP Request</div>
          </div>

          <div className="p-4 space-y-4">
            {/* Method + URL */}
            <div className="flex gap-4">
              <div className="w-32">
                <Label>Method</Label>
                <Select
                  value={httpSettings.method}
                  onValueChange={(value: HTTPMethod) => updateSettings({ method: value })}
                >
                  <SelectTrigger><SelectValue /></SelectTrigger>
                  <SelectContent>
                    <SelectItem value="GET">GET</SelectItem>
                    <SelectItem value="POST">POST</SelectItem>
                    <SelectItem value="PUT">PUT</SelectItem>
                    <SelectItem value="DELETE">DELETE</SelectItem>
                  </SelectContent>
                </Select>
              </div>
              <div className="flex-1">
                <Label>URL</Label>
                <VariableInput placeholder="Enter URL" value={httpSettings.url} onChange={value => updateSettings({ url: value })} />
              </div>
            </div>

            <Label>Response Variable</Label>
            <VariableInput placeholder="e.g. responseData" value={httpSettings.responseVar} onChange={value => updateSettings({ responseVar: value })} />

            <HeadersSection headers={httpSettings.headers} onAddHeader={addHeader} onUpdateHeader={(id, key, value) => updateHeader(id, key, value)} onUpdateHeaderField={updateHeaderField} onRemoveHeader={removeHeader} useVariableInput />
            <ParametersSection params={httpSettings.params} onAddParam={addParam} onUpdateParam={(id, key, value) => updateParam(id, key, value)} onUpdateParamField={updateParamField} onRemoveParam={removeParam} useVariableInput />

            {(httpSettings.method === 'POST' || httpSettings.method === 'PUT') && (
              <div className="space-y-2">
                <Label>Request Body (JSON)</Label>
                <VariableTextArea ref={bodyRef} value={httpSettings.body} onChange={value => updateSettings({ body: value })} placeholder='{"key": "value"}' rows={8} />
              </div>
            )}
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

export default HTTPNode;
