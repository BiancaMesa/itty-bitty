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
            'original_url' => ['required', 'regex:/^https:\/\/www\./'],
        ];
    }

    //Show a message if the URL format is invalid
    public function messages()
    {
        return [
            'original_url.regex' => 'The URL must start with "https://www."',
        ];
    }
}
