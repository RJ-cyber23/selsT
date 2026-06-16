<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'nullable|integer|exists:Products,product_id',
            'customer_id' => 'nullable|integer|exists:Customers,customer_id',
            'quantity' => 'nullable|integer|min:1',
        ];
    }
}
