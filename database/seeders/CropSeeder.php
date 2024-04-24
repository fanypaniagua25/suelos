<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Soil;

class CropSeeder extends Seeder
{
    public function run()
    {
        $crops = [
            [

                'cultivo' => 'Ajo',
                'ph' => 6.5,
                'mo' => 3.0,
                'fosforo' => 20,
                'al3' => 0.3,
                'precipitacion_anual' => 1600,
                'temperatura' => 22,
                'humedad' => 75,
            ],
            [
                'cultivo' => 'Algodón',
                'ph' => 6.2,
                'mo' => 2.2,
                'fosforo' => 15,
                'al3' => 0.7,
                'precipitacion_anual' => 1300,
                'temperatura' => 25,
                'humedad' => 68,
            ],
            [
                'cultivo' => 'Arroz de secano',
                'ph' => 6.0,
                'mo' => 3.2,
                'fosforo' => 15,
                'al3' => 0.8,
                'precipitacion_anual' => 1450,
                'temperatura' => 24,
                'humedad' => 78,
            ],
            [
                'cultivo' => 'Arveja',
                'ph' => 6.3,
                'mo' => 2.8,
                'fosforo' => 18,
                'al3' => 0.4,
                'precipitacion_anual' => 1400,
                'temperatura' => 21,
                'humedad' => 72,
            ],
            [
                'cultivo' => 'Batata',
                'ph' => 5.8,
                'mo' => 2.5,
                'fosforo' => 12,
                'al3' => 0.6,
                'precipitacion_anual' => 1500,
                'temperatura' => 23,
                'humedad' => 70,
            ],
            [
                'cultivo' => 'Canola',
                'ph' => 6.0,
                'mo' => 2.2,
                'fosforo' => 14,
                'al3' => 0.5,
                'precipitacion_anual' => 1400,
                'temperatura' => 20,
                'humedad' => 75,
            ],
            [
                'cultivo' => 'Caña de azúcar',
                'ph' => 6.2,
                'mo' => 3.5,
                'fosforo' => 18,
                'al3' => 0.3,
                'precipitacion_anual' => 1600,
                'temperatura' => 24,
                'humedad' => 80,
            ],
            [
                'cultivo' => 'Cebolla de cabeza',
                'ph' => 6.5,
                'mo' => 2.8,
                'fosforo' => 22,
                'al3' => 0.2,
                'precipitacion_anual' => 1500,
                'temperatura' => 22,
                'humedad' => 72,
            ],
            [
                'cultivo' => 'Frutilla',
                'ph' => 5.5,
                'mo' => 3.2,
                'fosforo' => 16,
                'al3' => 0.4,
                'precipitacion_anual' => 1400,
                'temperatura' => 20,
                'humedad' => 75,
            ],
            [
                'cultivo' => 'Girasol',
                'ph' => 6.2,
                'mo' => 2.4,
                'fosforo' => 15,
                'al3' => 0.5,
                'precipitacion_anual' => 1350,
                'temperatura' => 23,
                'humedad' => 68,
            ],
            [
                'cultivo' => 'Habilla',
                'ph' => 6.0,
                'mo' => 2.8,
                'fosforo' => 18,
                'al3' => 0.3,
                'precipitacion_anual' => 1400,
                'temperatura' => 21,
                'humedad' => 72,
            ],
            [
                'cultivo' => 'Stevia',
                'ph' => 5.8,
                'mo' => 2.6,
                'fosforo' => 14,
                'al3' => 0.6,
                'precipitacion_anual' => 1500,
                'temperatura' => 22,
                'humedad' => 75,
            ],
            [
                'cultivo' => 'Locote',
                'ph' => 6.3,
                'mo' => 2.9,
                'fosforo' => 19,
                'al3' => 0.4,
                'precipitacion_anual' => 1450,
                'temperatura' => 24,
                'humedad' => 70,
            ],
            [
                'cultivo' => 'Maíz',
                'ph' => 6.0,
                'mo' => 3.1,
                'fosforo' => 16,
                'al3' => 0.5,
                'precipitacion_anual' => 1400,
                'temperatura' => 23,
                'humedad' => 72,
            ],
            [
                'cultivo' => 'Mandioca',
                'ph' => 5.5,
                'mo' => 2.7,
                'fosforo' => 12,
                'al3' => 0.8,
                'precipitacion_anual' => 1550,
                'temperatura' => 24,
                'humedad' => 75,
            ],
            [
                'cultivo' => 'Maní',
                'ph' => 6.2,
                'mo' => 2.3,
                'fosforo' => 14,
                'al3' => 0.5,
                'precipitacion_anual' => 1400,
                'temperatura' => 25,
                'humedad' => 70,
            ],
            [
                'cultivo' => 'Menta',
                'ph' => 6.0,
                'mo' => 3.0,
                'fosforo' => 18,
                'al3' => 0.3,
                'precipitacion_anual' => 1500,
                'temperatura' => 21,
                'humedad' => 75,
            ],
            [
                'cultivo' => 'Papa',
                'ph' => 5.8,
                'mo' => 2.6,
                'fosforo' => 16,
                'al3' => 0.6,
                'precipitacion_anual' => 1400,
                'temperatura' => 18,
                'humedad' => 78,
            ],
            [
                'cultivo' => 'Poroto',
                'ph' => 6.1,
                'mo' => 2.9,
                'fosforo' => 17,
                'al3' => 0.4,
                'precipitacion_anual' => 1450,
                'temperatura' => 22,
                'humedad' => 72,
            ],
            [
                'cultivo' => 'Sésamo',
                'ph' => 6.0,
                'mo' => 2.2,
                'fosforo' => 13,
                'al3' => 0.6,
                'precipitacion_anual' => 1350,
                'temperatura' => 24,
                'humedad' => 68,
            ],
            [
                'cultivo' => 'Soja',
                'ph' => 6.2,
                'mo' => 2.8,
                'fosforo' => 16,
                'al3' => 0.4,
                'precipitacion_anual' => 1400,
                'temperatura' => 25,
                'humedad' => 70,
            ],
            [
                'cultivo' => 'Sorgo para grano',
                'ph' => 6.0,
                'mo' => 2.5,
                'fosforo' => 14,
                'al3' => 0.5,
                'precipitacion_anual' => 1350,
                'temperatura' => 24,
                'humedad' => 72,
            ],
            [
                'cultivo' => 'Tabaco',
                'ph' => 5.8,
                'mo' => 2.7,
                'fosforo' => 18,
                'al3' => 0.6,
                'precipitacion_anual' => 1400,
                'temperatura' => 21,
                'humedad' => 75,
            ],
            [
                'cultivo' => 'Tartago sin cáscara',
                'ph' => 6.1,
                'mo' => 2.3,
                'fosforo' => 15,
                'al3' => 0.5,
                'precipitacion_anual' => 1350,
                'temperatura' => 23,
                'humedad' => 70,
            ],
            [
                'cultivo' => 'Tomate',
                'ph' => 6.3,
                'mo' => 2.9,
                'fosforo' => 20,
                'al3' => 0.3,
                'precipitacion_anual' => 1450,
                'temperatura' => 22,
                'humedad' => 72,
            ],
            [
                'cultivo' => 'Trigo',
                'ph' => 6.0,
                'mo' => 2.6,
                'fosforo' => 15,
                'al3' => 0.5,
                'precipitacion_anual' => 1300,
                'temperatura' => 19,
                'humedad' => 75,
            ],
            [
                'cultivo' => 'Zanahoria',
                'ph' => 6.2,
                'mo' => 2.8,
                'fosforo' => 18,
                'al3' => 0.4,
                'precipitacion_anual' => 1400,
                'temperatura' => 20,
                'humedad' => 72,
            ],
            // Agrega los demás cultivos aquí con la misma estructura
        ];

        foreach ($crops as $cropData) {
            Soil::create($cropData);
        }
}
}
