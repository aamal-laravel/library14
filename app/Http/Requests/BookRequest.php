<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Override;

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

            'pages' => 'nullable|integer|min:0',
            'default_borrow_days' => 'nullable|integer|min:0',

            'total_copies' => 'nullable|integer',
            'stock' => 'nullable|integer',

            'published_at' => 'nullable|date',
            'cover' => 'nullable|image|max:2000', //size in kByte

            'category_id' => 'required|exists:categories,id',

            'authors' => 'nullable|array',
            'authors.*' => 'exists:authors,id',
        ];
    }

    #[Override]
    function messages()
    {
        return [
            'ISBN.unique' => 'رقم مكرر',
        ];
    }
    
    #[Override]
    function failedValidation(Validator $validator)
    {      
        throw new HttpResponseException(
            apiFail("المدخلات غير صحيحة" ,
            $validator->errors() , 
            Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
