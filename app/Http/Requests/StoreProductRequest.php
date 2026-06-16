<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_name' => 'nullable|string|max:30',
            'category_id' => 'nullable|integer|exists:Categories,category_id',
            'size' => 'nullable|in:S,M,L,XL',
            'quantity' => 'nullable|integer',
            'uom_id' => 'nullable|integer|exists:Unit_of_Measure,uom_id',
            'weight' => 'nullable|numeric',
            'supplier_id' => 'nullable|integer|exists:Suppliers,supplier_id',
            'brand_id' => 'nullable|integer|exists:Brands,brand_id',
            'mark_up' => 'nullable|numeric',
            'cost_price' => 'nullable|numeric',
        ];
    }
}
