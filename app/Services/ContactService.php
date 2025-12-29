<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Modules\Contacts\Models\Contact;
use Modules\Contacts\Models\Country;
use Modules\Contacts\Models\Field;
use Illuminate\Support\Facades\DB;
use Modules\Contacts\Models\Group;

class ContactService
{
    private $countryCodes;

    public function __construct()
    {
        $this->countryCodes = Country::pluck('id', 'phone_code')->toArray();
    }

    public function createContact(array $data, int $companyId, array $config)
    {
        // Get name/phone with fallbacks
        $name = $this->getValue($config['name_variable'], $config['name_static'], $data);


        $phone = $this->processPhoneTemplate($config['phone'], $data);


        // Normalize phone - remove all non-digit characters
        $normalizedPhone = $this->normalizePhone($phone);

        // Skip if no phone
        if (!$normalizedPhone) {
            throw new \Exception('Phone number is required for contact creation');
        }

        // Check duplicate
        $existingContact = Contact::where('company_id', $companyId)
            ->where(function ($query) use ($normalizedPhone) {
                $query->where('phone', $normalizedPhone)
                    ->orWhere('phone', ltrim($normalizedPhone, '+'));
            })
            ->withoutTrashed()
            ->first();


        if ($existingContact) {
            Log::info('Found existing contact', ['contact_id' => $existingContact->id]);
            return $this->updateExistingContact($existingContact, $config, $data);
        }

        Log::info('Creating new contact', [
            'name' => $name,
            'phone' => $normalizedPhone,
            'company_id' => $companyId,
        ]);

        // Create new contact
        $contact = $this->createNewContact($name, $normalizedPhone, $companyId, $data, $config);
        return $contact;
    }

    private function processPhoneTemplate(string $phoneTemplate, array $payload): string
    {
        // If no variables in template, return as static phone number
        if (strpos($phoneTemplate, '{{') === false) {
            return $phoneTemplate;
        }

        // Process template with variables
        return preg_replace_callback('/{{\s*(.*?)\s*}}/', function ($matches) use ($payload) {
            $value = $this->getValueByDotNotation($payload, $matches[1]);
            return $value ?? '';
        }, $phoneTemplate);
    }

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

    // private function getValue($variableKey, $staticValue, $data)
    // {
    //     if ($variableKey && isset($data[$variableKey])) {
    //         return $data[$variableKey];
    //     }
    //     return $staticValue ?: '';
    // }

    private function getValue($variableKey, $staticValue, $data)
    {
        // If static value is provided, return it
        if (!empty($staticValue)) {
            return $staticValue;
        }

        // Return directly if the key exists at the top level
        if ($variableKey && isset($data[$variableKey])) {
            return $data[$variableKey];
        }

        // Handle dot notation like "billing.first_name" or "line_items.0.name"
        if (strpos($variableKey, '.') !== false) {
            $keys = explode('.', $variableKey);
            $value = $data;

            foreach ($keys as $key) {
                if (is_array($value)) {
                    if (!isset($value[$key])) {
                        return ''; // Key missing
                    }
                    $value = $value[$key];
                } elseif (is_object($value)) {
                    if (!isset($value->$key)) {
                        return ''; // Key missing
                    }
                    $value = $value->$key;
                } else {
                    return '';
                }
            }

            return $value;
        }

        // Default fallback
        return '';
    }


    private function normalizePhone($phone): string
    {
        if (!$phone) {
            return '';
        }
        return preg_replace('/\D/', '', $phone); // Remove all non-digit characters
    }

    // private function updateExistingContact(Contact $contact, array $config, array $data)
    // {
    //     Log::info('Updating existing contact', ['contact_id' => $contact->id]);

    //     // Update name if provided
    //     $name = $this->getValue($config['name_variable'], $config['name_static'], $data);
    //     if ($name) {
    //         $contact->name = $name;
    //         $contact->save();
    //     }

    //     // Update groups
    //     if (!empty($config['add_groups'])) {
    //         $contact->groups()->syncWithoutDetaching($config['add_groups']);
    //         Log::info('Added groups to existing contact', [
    //             'contact_id' => $contact->id,
    //             'groups' => $config['add_groups'],
    //         ]);
    //     }

    //     if (!empty($config['remove_groups'])) {
    //         $contact->groups()->detach($config['remove_groups']);
    //         Log::info('Removed groups from existing contact', [
    //             'contact_id' => $contact->id,
    //             'groups' => $config['remove_groups'],
    //         ]);
    //     }

    //     // Update custom fields
    //     if ($this->shouldProcessCustomFields($config)) {
    //         Log::info('Updating custom fields for existing contact', ['contact_id' => $contact->id]);
    //         $this->handleCustomFields($contact, $data, $config);
    //     }

    //     // Process tags
    //     $this->handleTags($contact, $config);

    //     return $contact;
    // }

    // private function createNewContact($name, $phone, $companyId, $data, $config)
    // {
    //     $country_id = $this->getCountryByPhoneNumber($phone);

    //     $contact = Contact::create([
    //         'name' => $name,
    //         'phone' => $phone,
    //         'country_id' => $country_id,
    //         'company_id' => $companyId,
    //     ]);

    //     Log::info('Created new contact', [
    //         'id' => $contact->id,
    //         'name' => $name,
    //         'phone' => $phone,
    //         'country_id' => $country_id,
    //     ]);

    //     // Handle groups
    //     $this->handleGroups($contact, $config);

    //     // Handle custom fields
    //     if ($this->shouldProcessCustomFields($config)) {
    //         Log::info('Adding custom fields to new contact', ['contact_id' => $contact->id]);
    //         $this->handleCustomFields($contact, $data, $config);
    //     }

    //     // Process tags
    //     $this->handleTags($contact, $config);

    //     return $contact;
    // }

    private function updateExistingContact(Contact $contact, array $config, array $data)
    {
        Log::info('Updating existing contact', ['contact_id' => $contact->id]);

        // Update name if provided
        $name = $this->getValue($config['name_variable'], $config['name_static'], $data);
        if ($name) {
            $contact->name = $name;
        }

        // --- Handle agent assignment ---
        if (!empty($config['assign_to_user'])) {
            $contact->user_id = $config['assign_to_user'];
            Log::info('Assigned agent to existing contact', [
                'contact_id' => $contact->id,
                'agent_id' => $config['assign_to_user'],
            ]);
        }

        $contact->save();

        // Update groups
        if (!empty($config['add_groups'])) {
            $contact->groups()->syncWithoutDetaching($config['add_groups']);
            Log::info('Added groups to existing contact', [
                'contact_id' => $contact->id,
                'groups' => $config['add_groups'],
            ]);
        }

        if (!empty($config['remove_groups'])) {
            $contact->groups()->detach($config['remove_groups']);
            Log::info('Removed groups from existing contact', [
                'contact_id' => $contact->id,
                'groups' => $config['remove_groups'],
            ]);
        }

        // Update custom fields
        if ($this->shouldProcessCustomFields($config)) {
            Log::info('Updating custom fields for existing contact', ['contact_id' => $contact->id]);
            $this->handleCustomFields($contact, $data, $config);
        }

        // Process tags
        $this->handleTags($contact, $config);

        return $contact;
    }

    private function createNewContact($name, $phone, $companyId, $data, $config)
    {
        $country_id = $this->getCountryByPhoneNumber($phone);

        $contact = Contact::create([
            'name'       => $name,
            'phone'      => $phone,
            'country_id' => $country_id,
            'company_id' => $companyId,
            'user_id'    => !empty($config['assign_to_user']) ? $config['assign_to_user'] : null, // <-- assign agent if present
        ]);

        Log::info('Created new contact', [
            'id'        => $contact->id,
            'name'      => $name,
            'phone'     => $phone,
            'country_id' => $country_id,
            'agent_id'  => $config['assign_to_user'] ?? null,
        ]);

        // Handle groups
        $this->handleGroups($contact, $config);

        // Handle custom fields
        if ($this->shouldProcessCustomFields($config)) {
            Log::info('Adding custom fields to new contact', ['contact_id' => $contact->id]);
            $this->handleCustomFields($contact, $data, $config);
        }

        // Process tags
        $this->handleTags($contact, $config);

        return $contact;
    }


    private function shouldProcessCustomFields(array $config): bool
    {
        return $config['add_custom_fields'] == 1 || $config['add_custom_fields'] === true || $config['add_custom_fields'] === '1';
    }

    private function handleGroups(Contact $contact, array $config)
    {
        // Add groups
        if (!empty($config['add_groups'])) {
            $contact->groups()->attach($config['add_groups']);
            Log::info('Added groups to contact', [
                'contact_id' => $contact->id,
                'groups' => $config['add_groups'],
            ]);
        }

        // Remove groups
        if (!empty($config['remove_groups'])) {
            $contact->groups()->detach($config['remove_groups']);
            Log::info('Removed groups from contact', [
                'contact_id' => $contact->id,
                'groups' => $config['remove_groups'],
            ]);
        }
    }

    private function handleTags(Contact $contact, array $config)
    {
        if (empty($config['tags'])) {
            return;
        }

        try {
            // Decode new tags from config
            $tags = json_decode($config['tags'], true);
            $newTagNames = array_column($tags, 'value');

            // Get existing tags (make sure it's an array)
            $existingTags = is_string($contact->tags) ? json_decode($contact->tags, true) : (is_array($contact->tags) ? $contact->tags : []);

            // Merge and remove duplicates
            $mergedTags = array_unique(array_merge($existingTags, $newTagNames));

            // Save back as JSON
            $contact->tags = json_encode(array_values($mergedTags));
            $contact->save();
        } catch (\Exception $e) {
            Log::error('Tag processing failed', ['error' => $e->getMessage()]);
        }
    }

    private function handleCustomFields(Contact $contact, array $data, array $config)
    {
        Log::debug('Processing custom fields', [
            'contact_id' => $contact->id,
            'custom_fields_config' => $config['custom_fields'] ?? [],
        ]);

        if (empty($config['custom_fields'])) {
            Log::debug('No custom fields to process');
            return;
        }

        $fieldGroups = $this->groupFieldConfig($config['custom_fields'] ?? []);
        $syncData = [];

        foreach ($fieldGroups as $fieldConfig) {
            if (empty($fieldConfig['field_id'])) {
                continue;
            }

            $fieldId = $fieldConfig['field_id'];
            $value = $this->getFieldValue($fieldConfig, $data);

            if ($value !== '' && $value !== null) {
                $syncData[$fieldId] = ['value' => $value];
            }
        }

        if (!empty($syncData)) {
            $contact->fields()->syncWithoutDetaching($syncData);
        }
    }

    private function updateCustomFields(Contact $contact, array $updates)
    {
        $currentFields = $contact->fields->pluck('pivot.value', 'id')->toArray();
        $syncData = [];

        foreach ($currentFields as $id => $value) {
            $syncData[$id] = ['value' => $updates[$id] ?? $value];
        }

        foreach ($updates as $id => $value) {
            $syncData[$id] = ['value' => $value];
        }

        $contact->fields()->sync($syncData);
    }

    // In ContactService.php
    private function groupFieldConfig(array $customFields): array
    {
        $grouped = [];
        $currentField = null;

        // Track position: 0=field_id, 1=value_variable, 2=value_static
        $position = 0;

        foreach ($customFields as $item) {
            if (isset($item['field_id'])) {
                // Save previous field if exists
                if ($currentField) {
                    $grouped[] = $currentField;
                }

                // Start new field
                $currentField = [
                    'field_id' => $item['field_id'],
                    'value_variable' => '',
                    'value_static' => '',
                ];
                $position = 1; // Next should be value_variable
            } elseif ($position === 1 && isset($item['value_variable'])) {
                $currentField['value_variable'] = $item['value_variable'];
                $position = 2; // Next should be value_static
            } elseif ($position === 2 && isset($item['value_static'])) {
                $currentField['value_static'] = $item['value_static'];
                $position = 0; // Reset for next field
            }
        }

        // Add the last field
        if ($currentField) {
            $grouped[] = $currentField;
        }

        Log::debug('Grouped field config', ['grouped' => $grouped]);
        return $grouped;
    }

    private function getFieldValue(array $fieldConfig, array $data)
    {
        // Use value_variable if not empty
        if (!empty($fieldConfig['value_variable'])) {
            $value = $data[$fieldConfig['value_variable']] ?? '';
            if ($value !== '') {
                return $value;
            }
        }

        // Fallback to value_static
        return $fieldConfig['value_static'] ?? '';
    }

    private function setCustomField(Contact $contact, $fieldId, $value)
    {
        $fieldId = (int) $fieldId;

        // Use the same approach as in your controller
        $this->syncCustomFieldToContact($fieldId, $value, $contact);

        Log::info('Set custom field', [
            'contact_id' => $contact->id,
            'field_id' => $fieldId,
            'value' => $value,
        ]);
    }

    /**
     * Mirror the sync approach from your controller
     */
    private function syncCustomFieldToContact($fieldId, $value, Contact $contact)
    {
        // Get current fields
        $currentFields = $contact->fields->pluck('pivot.value', 'id')->toArray();

        // Update the specific field
        $currentFields[$fieldId] = $value;

        // Sync all fields
        $syncData = [];
        foreach ($currentFields as $id => $val) {
            $syncData[$id] = ['value' => $val];
        }

        $contact->fields()->sync($syncData);
    }

    private function getCountryByPhoneNumber($phoneNumber)
    {
        // Skip if no phone number
        if (!$phoneNumber) {
            return null;
        }

        // Ensure phone number is properly formatted
        $normalized = $this->normalizePhone($phoneNumber);

        // Match country code from longest to shortest
        foreach ($this->countryCodes as $code => $country_id) {
            // Remove '+' for comparison
            $cleanCode = ltrim($code, '+');
            $cleanPhone = ltrim($normalized, '+');

            if (strpos($cleanPhone, $cleanCode) === 0) {
                Log::debug('Matched country by phone', [
                    'phone' => $normalized,
                    'code' => $code,
                    'country_id' => $country_id,
                ]);
                return $country_id;
            }
        }

        Log::debug('No country matched for phone', ['phone' => $normalized]);
        return null;
    }
}
