<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            "stock" => "required|numeric",
            "kind_id" => "required|exists:kinds,id",
            "is_active" => "nullable|boolean",
            "name" => "required|string|max:250",
            "price" => "required|numeric",
            "old_price" => "nullable|numeric",
            "colors" => 'nullable|array',
            "sizes" => 'nullable|array',
            "description" => "nullable|string",
            "washing_instructions" => "nullable|string",
            "thumbnail" => 'nullable|file|max:2048|mimes:png,jpg,jpeg',
            "images" => 'nullable|array',
            "images.*" => 'nullable|file|max:2048|mimes:png,jpg,jpeg',
        ];
    }
}
