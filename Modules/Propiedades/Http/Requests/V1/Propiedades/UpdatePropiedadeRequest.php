<?php

namespace App\Http\Requests\V1\Propiedades;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePropiedadeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required'
        ];
    }
}
