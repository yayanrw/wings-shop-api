<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use function PHPUnit\Framework\assertTrue;

class StoreCartRequest extends FormRequest
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
        return [
            'product_code' => ['required', 'string', 'max:18', Rule::exists('products', 'code')],
            'price' => ['required', 'integer', 'max_digits:6'],
            'quantity' => ['required', 'integer', 'max_digits:6'],
            'unit' => ['required', 'string', 'max:5'],
            'currency' => ['required', 'string', 'max:5'],
        ];
    }
}
