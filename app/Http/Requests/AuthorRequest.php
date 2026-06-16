<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $authorId = $this->route('author');

        return [
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'email'      => [
                'required',
                'email',
                Rule::unique('authors', 'email')->ignore($authorId),
            ],
            'birth-date' => 'nullable|date',
            'bio'        => 'nullable|string',
        ];
    }
}