<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'image' => ['image'],
            'code' => ['required'],
            'provider_id' => ['required', 'numeric'],
            'category_id' => ['required', 'numeric'],
            'manufacturer_id' => ['required', 'numeric'],
            'purchase' => ['required', 'numeric'],
            'prices' => ['required', 'array', 'min:1'],
            'prices.*.price' => ['numeric', 'gt:purchase'],
            'prices.*.utility' => ['numeric', 'min:0'],
            'is_available' => ['required','numeric'],
            'type' => ['required','numeric'],
            'stock' => ['required','numeric'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del producto es obligatorio',
            'code.required' => 'El codigo del producto es obligatorio',
            'purchase.required' => 'El precio de compra del producto es obligatorio',
            'prices.required' => 'Al menos un precio es obligatorio',
            'stock.required' => 'La cantidad en inventario es requerido',
        ];
    }
}
