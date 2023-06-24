<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $productId = $this->route('product'); // Assuming the route parameter is named 'product'

        return [
            'code' => [
                'required',
                'string',
                'max:18',
                Rule::unique('products', 'code')->ignore($productId),
            ],
            'name' => ['required', 'string', 'max:30'],
            'price' => ['required', 'integer', 'max_digits:6'],
            'currency' => ['required', 'string', 'max:5'],
            'discount' => ['nullable', 'integer', 'max_digits:6'],
            'dimension' => ['nullable', 'string', 'max:50'],
            'unit' => ['required', 'string', 'max:5'],
        ];
    }
}
