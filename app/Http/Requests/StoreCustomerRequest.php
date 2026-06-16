<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'nullable|string|max:60',
            'last_name' => 'nullable|string|max:60',
            'bod' => 'nullable|date',
            'phone_number' => 'nullable|string|max:11',
            'Gmail' => 'nullable|email|max:60',
            'location_address' => 'nullable|string|max:60',
        ];
    }
}
