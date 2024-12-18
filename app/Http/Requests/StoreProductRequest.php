<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
