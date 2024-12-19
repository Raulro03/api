<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'rol' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
