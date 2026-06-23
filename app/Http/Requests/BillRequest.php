<?php
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;


class BillRequest extends FormRequest
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
            'total_amount' => ['required', 'numeric', 'min:0'],

            'status' => [
                'nullable',
                Rule::in([
                    'unpaid',
                    'pending_payment',
                    'paid',
                    'cancelled'
                ])
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'total_amount.required' => 'Total amount is required',
            'total_amount.numeric' => 'Total amount must be a number',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            apiFail(
                "Invalid bill data",
                $validator->errors(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }
}
