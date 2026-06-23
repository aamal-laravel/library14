<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'payment_method' => [
                'required',
                Rule::in(['cash', 'electronic'])
            ],

            'books' => [
                'required',
                'array',
                'min:1'
            ],

            'books.*' => [
                'required',
                'integer',
                'exists:books,id'
            ],

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            apiFail(
                'Invalid checkout data',
                $validator->errors(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }
}