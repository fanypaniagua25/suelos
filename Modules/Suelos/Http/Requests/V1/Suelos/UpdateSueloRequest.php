<?php

namespace App\Http\Requests\V1\Suelos;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSueloRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required'
        ];
    }
}
