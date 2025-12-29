<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class CallWebhookApiService
{
    public function execute(array $config, array $context, int $taskId)
    {
        // Transform context structure to be compatible with dot notation

        $context = $this->normalizeURLContextStructure($context);

        // Debug: Log normalized context
        Log::debug('Normalized Context', [
            'task_id' => $taskId,
            'context' => $context,
            'flattened_keys' => $this->flattenContext($context)
        ]);

        // Normalize headers to lowercase for case-insensitive access
        if (isset($context['headers']) && is_array($context['headers'])) {
            $context['headers'] = array_change_key_case($context['headers'], CASE_LOWER);
        }

        // 
        $url = '';
        if (isset($config['url'])) {
            $url = $this->processURLTemplate($config['url'], $context);
        }

        if (!$url) {
            Log::warning("API task {$taskId} skipped: URL is empty.");
            return;
        }

        // HTTP Method
        $method = strtoupper($config['http_method'] ?? 'POST');

        // Initialize headers and parameters
        $headers = [];
        $queryParams = [];
        $body = '';

        // Process Headers
        if (($config['add_headers'] ?? '') === "1") {
            $this->processKeyValuePairs(
                $config,
                'headers_key',
                'headers_value_variable',
                'headers_value_static',
                $context,
                $headers
            );
        }

        // Process Query Parameters
        if (($config['add_params'] ?? '') === "1") {
            $this->processKeyValuePairs(
                $config,
                'params_key',
                'params_value_variable',
                'params_value_static',
                $context,
                $queryParams
            );
        }

        // Apply Authentication
        $this->applyAuthentication($config, $context, $headers);

        // Build URL with query parameters
        $url = $this->buildUrlWithQuery($url, $queryParams);

        // Prepare request body
        $body = $this->resolveRequestBody($config, $context);

        // Debugging
        Log::debug("Template Resolution Debug", [
            'task_id' => $taskId,
            'template' => $config['data'],
            'resolved_body' => $body,
            'context_structure' => $this->flattenContext($context),
            'found_variables' => $this->findVariablesInContext($config['data'], $context),
        ]);

        // Make API call
        return $this->makeApiRequest($method, $url, $headers, $body, $taskId);
    }

    private function processURLTemplate(string $urlTemplate, array $payload): string
    {
        // If no variables in template, return as static URL
        if (strpos($urlTemplate, '{{') === false) {
            return $urlTemplate;
        }

        // Log the full payload structure for debugging
        Log::debug('Full payload structure', ['payload' => $payload]);

        // Process template with variables using the existing method
        $result = preg_replace_callback('/{{\s*(.*?)\s*}}/', function ($matches) use ($payload) {
            $value = $this->getValueByDotNotation($payload, $matches[1]);
            Log::debug('URL template variable replacement', [
                'variable' => $matches[1],
                'value' => $value,
                'payload_keys' => array_keys($payload)
            ]);

            // If value is null, keep the original template for debugging
            return $value ?? 'MISSING_' . $matches[1];
        }, $urlTemplate);

        Log::debug('URL template processing result', [
            'template' => $urlTemplate,
            'result' => $result
        ]);

        return $result;
    }
    protected function getURLValueByDotNotation(array $context, string $key)
    {
        // Debug: Log the key we're trying to access
        Log::debug("Getting value by dot notation", [
            'key' => $key,
            'context_keys' => array_keys($context)
        ]);

        // Handle direct top-level keys
        if (array_key_exists($key, $context)) {
            return $context[$key];
        }

        $keys = explode('.', $key);
        $value = $context;

        foreach ($keys as $part) {
            // Debug: Log current traversal state
            Log::debug("Traversing dot notation", [
                'current_part' => $part,
                'current_keys' => is_array($value) ? array_keys($value) : 'N/A',
                'current_value' => $value
            ]);

            // Check if we can traverse deeper
            if (is_array($value) && (isset($value[$part]) || array_key_exists($part, $value))) {
                $value = $value[$part];
            } else {
                // Key doesn't exist at this level
                Log::warning("Key not found in dot notation path", [
                    'missing_key' => $part,
                    'full_path' => $key,
                    'available_keys' => is_array($value) ? array_keys($value) : 'N/A'
                ]);
                return null;
            }
        }

        return $value;
    }

    // UPDATED CONTEXT NORMALIZATION
    // UPDATED CONTEXT NORMALIZATION
    protected function normalizeContextStructure(array $context): array
    {

        // Check if we have a nested body structure
        if (isset($context['body']['body']) && is_array($context['body']['body'])) {
            // Extract the inner body and merge it with the outer context
            $normalized = array_merge($context, $context['body']['body']);

            // Preserve headers separately
            $normalized['headers'] = $context['headers'] ?? [];

            // Remove the redundant nested structure
            unset($normalized['body']['body']);

            return $normalized;
        }

        // If we already have a flat structure, return as is
        if (isset($context['body']) && is_array($context['body'])) {
            return $context;
        }

        // Transform legacy format to nested structure
        $normalized = [];

        foreach ($context as $key => $item) {
            if (is_array($item) && isset($item['value'])) {
                // Legacy format: ['body.contact_person' => ['value' => 'John Doe']]
                $value = $item['value'];
                $keys = explode('.', $key);
                $current = &$normalized;

                foreach ($keys as $part) {
                    if (!isset($current[$part])) {
                        $current[$part] = [];
                    }
                    $current = &$current[$part];
                }

                $current = $value;
            } else {
                // Direct value assignment
                $normalized[$key] = $item;
            }
        }

        return $normalized;
    }


    protected function normalizeURLContextStructure(array $context): array
    {
        // Check if we have a nested body structure
        if (isset($context['body']) && is_array($context['body'])) {
            // Extract the inner body and merge it with the outer context
            $normalized = array_merge($context, $context['body']);

            // Preserve headers separately
            $normalized['headers'] = $context['headers'] ?? [];

            return $normalized;
        }

        // If we already have a flat structure, return as is
        if (isset($context['body']) && is_array($context['body'])) {
            return $context;
        }

        // Transform legacy format to nested structure
        $normalized = [];

        foreach ($context as $key => $item) {
            if (is_array($item) && isset($item['value'])) {
                // Legacy format: ['body.contact_person' => ['value' => 'John Doe']]
                $value = $item['value'];
                $keys = explode('.', $key);
                $current = &$normalized;

                foreach ($keys as $part) {
                    if (!isset($current[$part])) {
                        $current[$part] = [];
                    }
                    $current = &$current[$part];
                }

                $current = $value;
            } else {
                // Direct value assignment
                $normalized[$key] = $item;
            }
        }

        return $normalized;
    }
    // ADD THIS NEW METHOD TO TRANSFORM CONTEXT STRUCTURE
    protected function transformContextStructure(array $context): array
    {
        $transformed = [];

        foreach ($context as $key => $item) {
            // Skip if not a valid structure
            if (!is_array($item)) continue;

            // Extract the value
            $value = $item['value'] ?? null;

            // Convert dot notation to nested array
            $keys = explode('.', $key);
            $current = &$transformed;

            foreach ($keys as $part) {
                if (!isset($current[$part])) {
                    $current[$part] = [];
                }
                $current = &$current[$part];
            }

            $current = $value;
        }

        return $transformed;
    }

    protected function processKeyValuePairs(
        array $config,
        string $keyField,
        string $valueVarField,
        string $valueStaticField,
        array $context,
        array &$output
    ) {
        $keys = $config[$keyField] ?? [];
        $valueVars = $config[$valueVarField] ?? [];
        $valueStatics = $config[$valueStaticField] ?? [];

        foreach ($keys as $i => $key) {
            $value = '';

            // Prioritize variable value
            if (!empty($valueVars[$i])) {
                $value = $this->getValueByDotNotation($context, $valueVars[$i]);
            }

            // Fallback to static value
            if (empty($value) && isset($valueStatics[$i])) {
                $value = $valueStatics[$i];
            }

            if (!empty($value)) {
                $output[$key] = $value;
            }
        }
    }

    // UPDATED TO HANDLE TOP-LEVEL KEYS
    protected function getValueByDotNotation(array $context, string $key)
    {
        // Debug: Log the key we're trying to access
        Log::debug("Getting value by dot notation", [
            'key' => $key,
            'context_keys' => array_keys($context)
        ]);

        // Handle direct top-level keys
        if (array_key_exists($key, $context)) {
            return $context[$key];
        }

        $keys = explode('.', $key);
        $value = $context;

        foreach ($keys as $part) {
            // Debug: Log current traversal state
            Log::debug("Traversing dot notation", [
                'current_part' => $part,
                'current_keys' => is_array($value) ? array_keys($value) : 'N/A',
                'current_value' => $value
            ]);

            // Check if we can traverse deeper
            if (is_array($value) && (isset($value[$part]) || array_key_exists($part, $value))) {
                $value = $value[$part];
            } else {
                // Key doesn't exist at this level
                Log::warning("Key not found in dot notation path", [
                    'missing_key' => $part,
                    'full_path' => $key,
                    'available_keys' => is_array($value) ? array_keys($value) : 'N/A'
                ]);
                return null;
            }
        }

        return $value;
    }

    protected function applyAuthentication(array $config, array $context, array &$headers)
    {
        $authType = $config['auth_type'] ?? 'none';

        if ($authType === 'basic') {
            $username = $this->resolveAuthValue($config, 'basic_auth_username_', $context);
            $password = $this->resolveAuthValue($config, 'basic_auth_password_', $context);

            if ($username && $password) {
                $headers['Authorization'] = 'Basic ' . base64_encode("$username:$password");
            }
        } elseif ($authType === 'bearer') {
            $token = $this->resolveAuthValue($config, 'bearer_token_', $context);
            if ($token) {
                $headers['Authorization'] = "Bearer $token";
            }
        }
    }

    protected function resolveAuthValue(array $config, string $prefix, array $context)
    {
        return !empty($config[$prefix . 'variable'])
            ? $this->getValueByDotNotation($context, $config[$prefix . 'variable'])
            : ($config[$prefix . 'static'] ?? '');
    }

    protected function buildUrlWithQuery(string $url, array $queryParams): string
    {
        if (empty($queryParams)) return $url;

        $parsedUrl = parse_url($url);
        $existingParams = [];
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $existingParams);
        }

        $mergedParams = array_merge($existingParams, $queryParams);
        $queryString = http_build_query($mergedParams);

        return (isset($parsedUrl['scheme']) ? "{$parsedUrl['scheme']}://" : '')
            . ($parsedUrl['host'] ?? '')
            . (isset($parsedUrl['port']) ? ":{$parsedUrl['port']}" : '')
            . ($parsedUrl['path'] ?? '')
            . ($queryString ? "?$queryString" : '');
    }

    // UPDATED TO HANDLE OBJECTS AND IMPROVE LOGGING
    protected function resolveRequestBody(array $config, array $context): string
    {
        if (empty($config['data'])) return '';

        // If $config['data'] is JSON, decode it to array
        $bodyData = json_decode($config['data'], true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($bodyData)) {
            $bodyData = $this->replacePlaceholdersRecursive($bodyData, $context);
            return json_encode($bodyData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        // If plain string, replace placeholders normally
        $body = $config['data'];
        preg_match_all('/{{\s*(.+?)\s*}}/', $body, $matches);
        foreach ($matches[1] as $index => $key) {
            $value = $this->getValueByDotNotation($context, $key);
            if ($value === null) $value = '';
            elseif (is_array($value) || is_object($value)) $value = json_encode($value);
            elseif (is_bool($value)) $value = $value ? 'true' : 'false';
            $body = str_replace($matches[0][$index], $value, $body);
        }

        return $body;
    }

    private function replacePlaceholdersRecursive($data, array $context)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->replacePlaceholdersRecursive($value, $context);
            }
        } elseif (is_string($data)) {
            // Replace all {{ var }} inside the string
            preg_match_all('/{{\s*(.+?)\s*}}/', $data, $matches);
            foreach ($matches[1] as $index => $varKey) {
                $value = $this->getValueByDotNotation($context, $varKey);
                if ($value === null) $value = '';
                elseif (is_array($value) || is_object($value)) $value = json_encode($value);
                elseif (is_bool($value)) $value = $value ? 'true' : 'false';
                $data = str_replace($matches[0][$index], $value, $data);
            }
        }
        return $data;
    }


    private function flattenContext(array $context, string $prefix = ''): array
    {
        $result = [];

        foreach ($context as $key => $value) {
            $fullKey = $prefix ? "$prefix.$key" : $key;

            if (is_array($value)) {
                $result = array_merge($result, $this->flattenContext($value, $fullKey));
            } else {
                $result[$fullKey] = is_scalar($value) ? $value : gettype($value);
            }
        }

        return $result;
    }

    private function findVariablesInContext(string $template, array $context): array
    {
        preg_match_all('/{{\s*(.+?)\s*}}/', $template, $matches);
        $results = [];

        foreach ($matches[1] as $key) {
            $value = $this->getValueByDotNotation($context, $key);
            $results[$key] = [
                'exists' => $value !== null,
                'type' => $value !== null ? gettype($value) : 'null',
                'value_sample' => $value !== null && is_scalar($value) ? substr((string)$value, 0, 50) : null,
            ];
        }

        return $results;
    }

    protected function makeApiRequest(string $method, string $url, array $headers, string $body, int $taskId)
    {
        try {
            // Ensure JSON content type if not set
            if (!isset($headers['Content-Type'])) {
                $headers['Content-Type'] = 'application/json';
            }

            $client = new Client();
            $options = [
                'headers' => $headers,
                'timeout' => 15,
                'http_errors' => false
            ];

            if ($method !== 'GET' && $body) {
                $options['body'] = $body;
            }

            $response = $client->request($method, $url, $options);
            $responseContent = $response->getBody()->getContents();
            $statusCode = $response->getStatusCode();

            // Log successful requests (level: info)
            Log::info("API task {$taskId} completed", [
                'status' => $statusCode,
                'url' => $url,
                'response_size' => strlen($responseContent)
            ]);

            return [
                'status' => $statusCode,
                'body' => $responseContent,
                'headers' => $response->getHeaders()
            ];
        } catch (GuzzleException $e) {
            // Log error with minimal sensitive data
            Log::error("API task {$taskId} failed", [
                'error' => $e->getMessage(),
                'url' => $url,
                'method' => $method
            ]);

            return [
                'error' => 'API request failed',
                'message' => $e->getMessage()
            ];
        } catch (\Exception $e) {
            Log::error("API task {$taskId} failed (non-Guzzle)", [
                'error' => $e->getMessage()
            ]);

            return [
                'error' => 'Unexpected API error',
                'message' => $e->getMessage()
            ];
        }
    }
}
