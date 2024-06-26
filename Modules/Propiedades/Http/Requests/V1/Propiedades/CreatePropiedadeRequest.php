<?php

namespace App\Http\Requests\V1\Propiedades;

use Illuminate\Foundation\Http\FormRequest;;

class CreatePropiedadeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required'
        ];
    }
}
