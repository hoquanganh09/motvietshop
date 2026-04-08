<?php

namespace App\Http\Requests\Client\Order;

use App\Enums\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fullname' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:1000'],
            'phone_number' => ['required', 'string', 'max:20'],
            'payment_method' => ['required', Rule::in([PaymentMethod::Cod->value, PaymentMethod::Online->value])],
            'note' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'fullname.required' => 'Họ tên không được để trống.',
            'address.required' => 'Địa chỉ không được để trống.',
            'phone_number.required' => 'Số điện thoại không được để trống.',
            'payment_method.required' => 'Phương thức thanh toán là bat buộc.',
        ];
    }
}
