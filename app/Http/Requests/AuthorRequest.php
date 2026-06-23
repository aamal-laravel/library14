<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
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
            "first_name"=>"required|max:50|min:3",
            "last_name"=>"required|max:50|min:3",
            "email"=>["required","email",Rule::unique("authors","email")->ignore($authorId)],
            "birth-date"=>"nullable|date",
            "bio"=>"nullable"
        ];
    }

    public function failedValidation(Validator $validator){
        $response =apifail($validator->errors()->first(),422);
       throw new \Illuminate\Validation\ValidationException($validator,$response);
    }
}
