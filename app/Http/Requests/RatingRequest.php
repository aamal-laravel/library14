<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RatingRequest extends FormRequest
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
        //$rating = $this->route('rating');  use it when Updating ratings

        return [
            'book_id' => ['required', 'exists:books,id'],

            //  1–5 
            'rate' => ['required', Rule::in(['1', '2', '3', '4', '5'])],
        ];
    }


     public function messages(): array
    {
        return [
            'rate.in' => 'Rating must be between 1 and 5',
            'book_id.exists' => 'Book does not exist',
        ];
    }



    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            apiFail(
                "Invalid rating data",
                $validator->errors(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }
}
