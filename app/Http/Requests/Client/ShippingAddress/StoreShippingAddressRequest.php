<?php

namespace App\Http\Requests\Client\ShippingAddress;

use Illuminate\Foundation\Http\FormRequest;

class StoreShippingAddressRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:250',
            'fullname' => 'required|string|max:250',
            'address' => 'required|string|max:1000',
            'phone_number' => 'required|string|max:11|regex:/^\d{10,11}$/',
            'is_default' => 'nullable|boolean',
        ];
    }
}
