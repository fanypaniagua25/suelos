<?php

namespace App\Http\Requests\V1\Suelos;

use Illuminate\Foundation\Http\FormRequest;;

class CreateSueloRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required'
        ];
    }
}
