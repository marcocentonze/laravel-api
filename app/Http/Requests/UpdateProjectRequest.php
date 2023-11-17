<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type_id' => 'nullable|exists:types,id',
            'title' => 'required|bail|min:3|max:150',
            'slug' => 'min:3|max:50',
            'description' => 'nullable|max:350',
            'cover_image' => 'nullable|image|max:500',
            'website_link' => 'nullable|url',
            'github_link' => 'nullable|url'
        ];
    }
}
