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
<<<<<<< HEAD
            'name' => ['required'],
            'image' => ['image'],
            'code' => ['required', 'unique:products'],
            'provider_id' => ['required', 'numeric'],
            'category_id' => ['required', 'numeric'],
            'manufacturer_id' => ['required', 'numeric'],
=======
            'name' => ['required', 'unique:products'],
            'image' => ['image'],
            'code' => ['required', 'unique:products'],
            'supplier_id' => ['required', 'numeric'],
            'category_id' => ['required', 'numeric'],
            'brand_id' => ['required', 'numeric'],
>>>>>>> database
            'purchase' => ['required', 'numeric'],
            'prices' => ['required', 'array', 'min:1'],
            'prices.*.price' => ['numeric', 'gt:purchase'],
            'prices.*.utility' => ['numeric', 'min:0'],
            'is_available' => ['required','numeric'],
<<<<<<< HEAD
            'type' => ['required','numeric'],
=======
>>>>>>> database
            'stock' => ['required','numeric'],

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del producto es obligatorio',
<<<<<<< HEAD
=======
            'name.unique' => 'El nombre ya está en uso',
>>>>>>> database
            'code.required' => 'El codigo del producto es obligatorio',
            'code.unique' => 'El codigo ya está en uso',
            'purchase.required' => 'El precio de compra del producto es obligatorio',
            'prices.required' => 'Al menos un precio es obligatorio',
            'stock.required' => 'La cantidad en inventario es requerido',
            'prices.*.price.numeric' => 'El precio :attribute debe ser una cantidad numerica',
            'prices.*.price.gt' => 'El precio :attribute debe ser mayor al precio de compra',
            'prices.*.utility.numeric' => 'La utilidad :attribute debe ser una cantidad numerica',
            'prices.*.utility.min' => 'La utilidad :attribute debe ser mayor a 0',
        ];
    }
}
