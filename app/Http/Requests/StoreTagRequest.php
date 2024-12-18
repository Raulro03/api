<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTagRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'slug' => ['required'],
            'products' => 'array',
            'products.*' => 'exists:products,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
