<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSale extends FormRequest
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
            "products" => ['required', 'array', "min:1"],
            "customerName" => ['required'],
            "products.*.id" => ["required", "numeric"],
            "products.*.quantity" => ["required", "numeric"],
            "products.*.tax" => ["required", "numeric"],
            "products.*.price" => ["required", "numeric","min:0","max:999999"],
            "products.*.total" => ["required", "numeric","min:0","max:999999"]
        ];
    }
}
