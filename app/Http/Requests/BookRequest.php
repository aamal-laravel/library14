<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
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
        $book = $this->route('book'); //route parameter {}
        return [
            'ISBN' => ['required', 'digits:13' , Rule::unique('books' , 'ISBN')->ignore($book?->id)],
            'title' => 'required|max:150',
            
            'rental_price' => 'nullable|decimal:0,2',
            'deposit' => 'nullable|decimal:0,2',

            'pages' => 'nullable|integer',
            'default_borrow_days' => 'nullable|integer|decimal:2',

            'total_copies' => 'nullable|integer',
            'stock' => 'nullable|integer',

            'published_at' => 'nullable|date',
            'cover' => 'nullable|image|max:2000',

            'category_id' => 'required|exists:categories,id'
        ];
    }
}
