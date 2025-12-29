<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialMediaTokenRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true; // Adjust this based on your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {
        return [
            'social_media_name' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'app_id' => 'nullable|string',
            'access_token' => 'nullable|string',
        ];
    }
}
