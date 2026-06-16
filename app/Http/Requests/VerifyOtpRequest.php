<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Override;

class VerifyOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

   public function rules(): array
{
    return [
        'email'  => 'required|email|exists:users,email',
        'otp_hash' => 'required|digits:6',
    ];
}

    #[Override]
    public function failedValidation(Validator $validator)
    {
        $response = apiFail(data: $validator->errors(), code: 422);
        throw new HttpResponseException($response);
    }

    #[Override]
    public function messages(): array
    {
        return [
            'otp_hash.required'    => 'الايميل مطلوب لا يمكن تركه فارغا',
            'otp_hash.digits'      =>"لازم يكون 6"
        ];
    }
}