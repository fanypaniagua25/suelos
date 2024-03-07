<?php

namespace App\Http\Requests\V1\Coberturasuelos;

use Illuminate\Foundation\Http\FormRequest;;

class CreateCoberturasueloRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required'
        ];
    }
}
