<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchase extends FormRequest
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
            'supplierId' => ['required'],
            "additionalPayments" => ['numeric'],
            "discountsValue" => ['numeric', "min:0", "max:999999"],
            "quantityValue" => ['required', 'numeric', "min:0", "max:999999"],
            "subtotalValue" => ['required', 'numeric', "min:0", "max:999999"],
            "totalValue" => ['required', 'numeric', "min:0", "max:999999"],
            "products" => ['required', 'array', "min:1"],
            "products.*.isNewProduct" => ["required"],
            "products.*.id" => ["numeric", "required_if:products.*.isNewProduct,false", "distinct"],
            "products.*.quantity" => ["required", "numeric", "min:1"],
            "products.*.price" => ["required_if:products.*.isNewProduct,true", "numeric", "min:0.01", "max:999999"],
            "products.*.name" => ["required_if:products.*.isNewProduct,true"],
            "products.*.code" => ["required_if:products.*.isNewProduct,true", "unique:products"],
            "products.*.category" => ["required_if:products.*.isNewProduct,true", "numeric"],
            "products.*.total" => ["required", "numeric", "min:0.01","max:999999"],
            "products.*.purchase" => ["required", "numeric", "min:0.01","max:999999"]
        ];
    }

    public function messages()
    {
        return [
            'products.required' => 'At least 1 product is required',
        ];
    }
}
