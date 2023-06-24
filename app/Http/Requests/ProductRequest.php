<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'code' => ['required', 'string', 'max:18', 'unique:products'],
            'name' => ['required', 'string', 'max:30'],
            'price' => ['required', 'integer', 'size:6'],
            'currency' => ['required', 'string', 'max:5'],
            'discount' => ['string', 'integer', 'size:6'],
            'dimension' => ['string', 'max:50'],
            'unit' => ['required', 'string', 'max:5'],
        ];
    }
}
