<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShortRequest extends FormRequest
{
    // Determine if the user is authorized to make this request
    public function authorize(): bool
    {
        return true;
    }

    // Get the validation rules that apply to the request. Regex pattern
    public function rules(): array
    {
        // return [
        //     'original_url' => 'required|url'
        // ];
        return [
            'title' => 'required|string|max:255',
            'original_url' => ['required', 'regex:/^(https?:\/\/(www\.)?|www\.)/'],
        ];
    }

    //Show a message if the URL format is invalid
    public function messages()
    {
        return [
            'title.required' => 'The title is required.',
            'original_url.regex' => 'The URL must start with "https://www.", "http://www.", "www.", "https://", or "http://".',
        ];
    }
}
