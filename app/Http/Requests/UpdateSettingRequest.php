<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
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
        'max_borrow_books' => 'sometimes|integer|min:1',
        'borrow_days' => 'sometimes|integer|min:1',
        'late_fee_per_day' => 'sometimes|numeric|min:0',
        'deposit_ratio' => 'sometimes|numeric|min:0',
    ];
    }
}
