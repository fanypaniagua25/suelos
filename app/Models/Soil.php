<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Service\CropRotationService;

class Soil extends Model
{
    protected $fillable = [
        'orden',
        'ph',
        'mo',
        'al3',
        'fosforo',
        'precipitacion_anual',
        'temperatura',
        'humedad',
    ];

    protected $casts = [
        'orden' => 'string',
        'ph' => 'float',
        'mo' => 'float',
        'al3' => 'float',
        'fosforo' => 'float',
        'precipitacion_anual' => 'float',
        'temperatura' => 'float',
        'humedad' => 'float',
    ];

    public function getCropRotation(): array
    {
        $cropRotationService = new CropRotationService();
        return $cropRotationService->recommendCrops($this);
    }
}
