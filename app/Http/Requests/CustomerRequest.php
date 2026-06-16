<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (bool) Auth::user()?->customer;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $customer = Auth::user()->customer;

        return [
            'gender' => 'nullable|in:M,F',
            'DOB' => 'nullable|date',
            'phone' => 'required|string|unique:customers,phone,'.$customer?->id,
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'lang' => 'nullable|in:ar,en',
        ];

    }
}
