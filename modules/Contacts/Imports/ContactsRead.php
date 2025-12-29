<?php

namespace Modules\Contacts\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Contacts\Models\Contact;
use Modules\Contacts\Models\Field;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ContactsRead implements ToModel, WithHeadingRow, WithChunkReading {

    public function chunkSize(): int {
        return 150;
    }



    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row) {
        $keys = array_keys($row);

        $data = array_filter([
            'phone' => isset($row[(isset($keys[0]) ? $keys[0] : null)]) ? $row[$keys[0]] : null,
            'name' => isset($row[(isset($keys[1]) ? $keys[1] : null)]) ? $row[$keys[1]] : null,
            'lastname' => isset($row[(isset($keys[2]) ? $keys[2] : null)]) ? $row[$keys[2]] : null,
            'email' => isset($row[(isset($keys[3]) ? $keys[3] : null)]) ? $row[$keys[3]] : null,
            'country' => isset($row[(isset($keys[4]) ? $keys[4] : null)]) ? $row[$keys[4]] : null,
            'company' => isset($row[(isset($keys[5]) ? $keys[5] : null)]) ? $row[$keys[5]] : null,
            'address' => isset($row[(isset($keys[6]) ? $keys[6] : null)]) ? $row[$keys[6]] : null,
        ]);

        return $data; //new Contact($data);

        // Create or update contact
        /*
        $keysForFields = [];
        foreach ($keys as $key => $value) {
            $keysForFields[$key] = $this->getOrMakeField($value);
        }
        $prevContact = Contact::where('phone', $row['phone'])->first();
        if ($prevContact) {
            return $prevContact;
        }

        $data['phone'] = strpos($data['phone'], "+") ? $data['phone'] : "+" . $data['phone'];
        $contact = new Contact($data);
        $contact->save();

        if (isset($row['avatar'])) {
            $contact->avatar = $row['avatar'];
        }

        foreach ($keysForFields as $key => $fieldID) {
            if ($fieldID != 0 && $row[$keys[$key]]) {
                $contact->fields()->attach($fieldID, ['value' =>  $row[$keys[$key]]]);
            }
        }
        $contact->update();


        return $contact; */
    }

    private function getOrMakeField($field_name) {
        if ($field_name == "name" || $field_name == "lastname" || $field_name == "phone" || $field_name == "avatar") {
            return 0;
        }
        $field = Field::where('name', $field_name)->first();
        if (!$field) {
            $field = Field::create([
                'name'     => $field_name,
                'type' => "text",
            ]);
            $field->save();
        }
        return $field->id;
    }
}
