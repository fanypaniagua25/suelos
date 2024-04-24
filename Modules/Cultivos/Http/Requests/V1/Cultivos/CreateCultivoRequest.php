<?php

namespace App\Http\Requests\V1\Cultivos;

use Illuminate\Foundation\Http\FormRequest;;

class CreateCultivoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required'
        ];
    }
}
