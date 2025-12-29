<?php

namespace Modules\Flowmaker\Models\Nodes;

use App\Models\Company;
use Illuminate\Support\Facades\Log;
use Modules\Flowmaker\Models\Contact;
use Illuminate\Support\Facades\Http;

class UserReply extends Node
{
    private function transcribeAudio($audioUrl)
    {
        try {
            $tmpFile = tempnam(sys_get_temp_dir(), 'audio_') . '.mp3';
            file_put_contents($tmpFile, file_get_contents($audioUrl));

            $apiKey = env('OPENAI_API_KEY');
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/audio/transcriptions');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);

            $cfile = new \CURLFile($tmpFile, 'audio/mpeg', basename($tmpFile));
            $postData = [
                'model' => 'whisper-1',
                'file' => $cfile,
            ];

            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $apiKey"]);

            $response = curl_exec($ch);
            curl_close($ch);

            unlink($tmpFile);

            $result = json_decode($response, true);

            if (isset($result['text'])) {
                return $result['text'];
            } else {
                Log::error('Whisper transcription failed', ['response' => $result]);
                return null;
            }
        } catch (\Exception $e) {
            Log::error('Error in transcribeAudio', ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function listenForReply($message, $data)
    {
        if (empty($message)) {
            if (!empty($data['header_image'])) {
                $message = $data['header_image'];
            } elseif (!empty($data['header_audio'])) {
                $message = $this->transcribeAudio($data['header_audio']);
            } else {
                $message = $data['value'] ?? null;
            }
        }

        $contact = Contact::find($data['contact_id']);
        $settings = $this->getDataAsArray()['settings'];

        $variableName = $settings['variableName'] ?? 'user_response';

        Log::info('Storing user reply in variable', [
            'variableName' => $variableName,
            'reply' => $message,
            'contact_id' => $contact->id,
            'flow_id' => $this->flow_id,
        ]);

        $contact->setContactState($this->flow_id, $variableName, $message);

        Log::info('clear current node from contact state for contact ' . $contact->id . ' and flow ' . $this->flow_id);
        $contact->clearContactState($this->flow_id, 'current_node');
        $this->isStartNode = false;

        $nextNode = $this->getNextNodeId();
        if ($nextNode != null) {
            Log::info('Next node found, process it', ['next_node' => $nextNode->id]);
            $nextNode->process($message, $data);
        } else {
            Log::info('No next node found');
        }
    }

    public function process($message, $data)
    {
        Log::info('Processing message in user reply node', ['message' => $message, 'data' => $data]);

        if (empty($message)) {
            if (!empty($data['header_image'])) {
                $message = $data['header_image'];
            } elseif (!empty($data['header_audio'])) {
                $message = $this->transcribeAudio($data['header_audio']);
            } else {
                $message = $data['value'] ?? null;
            }
        }

        if ($this->isStartNode) {
            $this->listenForReply($message, $data);
            return ['success' => true];
        }

        $contact = Contact::find($data['contact_id']);
        $settings = $this->getDataAsArray()['settings'];

        $question = $contact->changeVariables($settings['question'] ?? 'Please provide your response:', $this->flow_id);

        $company = Company::find($contact->company_id);
        $token = $company->getConfig('plain_token', '');

        $payload = [
            'token' => $token,
            'phone' => $contact->phone,
            'message' => $question,
        ];

        try {
            $response = Http::post(config('app.url') . '/api/wpbox/sendmessage', $payload);
            Log::info('Question message API response', ['response' => $response->json()]);

            if (!$response->successful()) {
                Log::error('Failed to send question message', ['error' => $response->body()]);
            } else {
                $contact->setContactState($this->flow_id, 'current_node', $this->id);
                Log::info('Set contact state to wait for user reply', ['node_id' => $this->id]);
            }
        } catch (\Exception $e) {
            Log::error('Error sending question message', ['error' => $e->getMessage()]);
        }

        return ['success' => true];
    }

    protected function getNextNodeId($handleId = null)
    {
        foreach ($this->outgoingEdges as $edge) {
            return $edge->getTarget();
        }
        return null;
    }
}
