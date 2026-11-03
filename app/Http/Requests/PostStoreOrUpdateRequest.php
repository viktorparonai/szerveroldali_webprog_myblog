<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PostStoreOrUpdateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'content' => 'required|string|min:10',
            'categories' => 'array',
            'categories.*' => 'integer|distinct|exists:categories,id',
            'image_file' => 'nullable|image|mimetypes:image/jpeg,image/png,image/gif|max:2048'
        ];
    }

    public function messages(){
        return[
            'content.min' => 'A tartalom legalább 10 karakter kell legyen!',
            'image_file.image' => 'Csak képfájl tölthető fel!',
            'image_file.mimetypes' => 'Csak JPG, PNG vagy GIF formátum engedélyezett!'
        ];
    }
}
