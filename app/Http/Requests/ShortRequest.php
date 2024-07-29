<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShortRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'original_url' => 'required|url',
            // 'original_url' => ['required', 'regex:/^(https?:\/\/(www\.)?|www\.)/'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The title is required.',
            'original_url.regex' => 'The URL must start with "https://www.", "http://www.", "www.", "https://", or "http://".',
        ];
    }
}
