<?php

namespace App\Service;

use App\Models\Soil;
use Illuminate\Support\Facades\Log;

class CropRotationService
{
    private $idealValues = [
        'ULTISOL' => [
            'Soja' => ['ph' => 6.2, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 25, 'humedad' => 70],
            'Maíz' => ['ph' => 6.0, 'mo' => 3.1, 'al3' => 0.5, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 23, 'humedad' => 72],
            'Algodón' => ['ph' => 6.0, 'mo' => 2.5, 'al3' => 0.6, 'fosforo' => 18, 'precipitacion_anual' => 1300, 'temperatura' => 27, 'humedad' => 65],
            'Arroz secano' => ['ph' => 5.8, 'mo' => 2.2, 'al3' => 0.8, 'fosforo' => 12, 'precipitacion_anual' => 1600, 'temperatura' => 26, 'humedad' => 75],
            'Batata' => ['ph' => 5.8, 'mo' => 2.0, 'al3' => 0.7, 'fosforo' => 14, 'precipitacion_anual' => 1200, 'temperatura' => 24, 'humedad' => 70],
            'Mandioca' => ['ph' => 5.8, 'mo' => 2.5, 'al3' => 0.9, 'fosforo' => 10, 'precipitacion_anual' => 1500, 'temperatura' => 27, 'humedad' => 72],
            'Maní' => ['ph' => 6.0, 'mo' => 2.7, 'al3' => 0.5, 'fosforo' => 18, 'precipitacion_anual' => 1300, 'temperatura' => 26, 'humedad' => 68],
            'Sorgo para grano' => ['ph' => 6.5, 'mo' => 2.4, 'al3' => 0.4, 'fosforo' => 20, 'precipitacion_anual' => 1100, 'temperatura' => 28, 'humedad' => 65],
            'Menta' => ['ph' => 6.0, 'mo' => 3.0, 'al3' => 0.6, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 24, 'humedad' => 75],
            'Stevia' => ['ph' => 5.8, 'mo' => 2.8, 'al3' => 0.7, 'fosforo' => 12, 'precipitacion_anual' => 1500, 'temperatura' => 26, 'humedad' => 70],
            'Tabaco' => ['ph' => 6.2, 'mo' => 2.6, 'al3' => 0.5, 'fosforo' => 18, 'precipitacion_anual' => 1300, 'temperatura' => 27, 'humedad' => 68]
        ],
        'ENTISOL' => [
            'Arroz secano' => ['ph' => 5.8, 'mo' => 2.2, 'al3' => 0.8, 'fosforo' => 12, 'precipitacion_anual' => 1600, 'temperatura' => 26, 'humedad' => 75],
            'Maíz' => ['ph' => 6.0, 'mo' => 3.1, 'al3' => 0.5, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 23, 'humedad' => 72],
            'Sorgo para grano' => ['ph' => 6.5, 'mo' => 2.4, 'al3' => 0.4, 'fosforo' => 20, 'precipitacion_anual' => 1100, 'temperatura' => 28, 'humedad' => 65],
            'Soja' => ['ph' => 6.2, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 25, 'humedad' => 70],
            'Algodón' => ['ph' => 6.0, 'mo' => 2.5, 'al3' => 0.6, 'fosforo' => 18, 'precipitacion_anual' => 1300, 'temperatura' => 27, 'humedad' => 65],
            'Girasol' => ['ph' => 6.5, 'mo' => 2.6, 'al3' => 0.4, 'fosforo' => 22, 'precipitacion_anual' => 1000, 'temperatura' => 26, 'humedad' => 60],
            'Tabaco' => ['ph' => 6.2, 'mo' => 2.6, 'al3' => 0.5, 'fosforo' => 18, 'precipitacion_anual' => 1300, 'temperatura' => 27, 'humedad' => 68],
            'Sésamo' => ['ph' => 6.0, 'mo' => 2.4, 'al3' => 0.6, 'fosforo' => 16, 'precipitacion_anual' => 1200, 'temperatura' => 28, 'humedad' => 65],
            'Tartago sin cáscara' => ['ph' => 6.2, 'mo' => 2.2, 'al3' => 0.5, 'fosforo' => 18, 'precipitacion_anual' => 1100, 'temperatura' => 27, 'humedad' => 62]
        ],
        'ALFISOL' => [
            'Ajo' => ['ph' => 6.0, 'mo' => 3.0, 'al3' => 0.4, 'fosforo' => 20, 'precipitacion_anual' => 1200, 'temperatura' => 18, 'humedad' => 70],
            'Algodón' => ['ph' => 6.0, 'mo' => 2.5, 'al3' => 0.6, 'fosforo' => 18, 'precipitacion_anual' => 1300, 'temperatura' => 27, 'humedad' => 65],
            'Arveja' => ['ph' => 6.5, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 16, 'precipitacion_anual' => 1100, 'temperatura' => 20, 'humedad' => 75],
            'Batata' => ['ph' => 5.8, 'mo' => 2.0, 'al3' => 0.7, 'fosforo' => 14, 'precipitacion_anual' => 1200, 'temperatura' => 24, 'humedad' => 70],
            'Canola' => ['ph' => 6.2, 'mo' => 2.6, 'al3' => 0.5, 'fosforo' => 18, 'precipitacion_anual' => 1000, 'temperatura' => 18, 'humedad' => 72],
            'Cebolla de cabeza' => ['ph' => 6.0, 'mo' => 2.8, 'al3' => 0.6, 'fosforo' => 16, 'precipitacion_anual' => 1300, 'temperatura' => 20, 'humedad' => 68],
            'Frutilla' => ['ph' => 6.2, 'mo' => 3.2, 'al3' => 0.4, 'fosforo' => 22, 'precipitacion_anual' => 1100, 'temperatura' => 18, 'humedad' => 75],
            'Girasol' => ['ph' => 6.5, 'mo' => 2.6, 'al3' => 0.4, 'fosforo' => 22, 'precipitacion_anual' => 1000, 'temperatura' => 26, 'humedad' => 60],
            'Habilla' => ['ph' => 6.0, 'mo' => 2.4, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1400, 'temperatura' => 22, 'humedad' => 70],
            'Locote' => ['ph' => 6.2, 'mo' => 2.6, 'al3' => 0.6, 'fosforo' => 18, 'precipitacion_anual' => 1300, 'temperatura' => 24, 'humedad' => 68],
            'Maíz' => ['ph' => 6.0, 'mo' => 3.1, 'al3' => 0.5, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 23, 'humedad' => 72],
            'Maní' => ['ph' => 6.0, 'mo' => 2.7, 'al3' => 0.5, 'fosforo' => 18, 'precipitacion_anual' => 1300, 'temperatura' => 26, 'humedad' => 68],
            'Papa' => ['ph' => 5.8, 'mo' => 3.4, 'al3' => 0.7, 'fosforo' => 20, 'precipitacion_anual' => 1000, 'temperatura' => 18, 'humedad' => 75],
            'Poroto' => ['ph' => 6.2, 'mo' => 2.6, 'al3' => 0.4, 'fosforo' => 18, 'precipitacion_anual' => 1200, 'temperatura' => 24, 'humedad' => 70],
            'Soja' => ['ph' => 6.2, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 25, 'humedad' => 70],
            'Sorgo para grano' => ['ph' => 6.5, 'mo' => 2.4, 'al3' => 0.4, 'fosforo' => 20, 'precipitacion_anual' => 1100, 'temperatura' => 28, 'humedad' => 65],
            'Tomate' => ['ph' => 6.0, 'mo' => 3.0, 'al3' => 0.5, 'fosforo' => 18, 'precipitacion_anual' => 1300, 'temperatura' => 22, 'humedad' => 72],
            'Trigo' => ['ph' => 6.2, 'mo' => 2.6, 'al3' => 0.4, 'fosforo' => 22, 'precipitacion_anual' => 900, 'temperatura' => 20, 'humedad' => 68],
            'Zanahoria' => ['ph' => 6.0, 'mo' => 2.8, 'al3' => 0.6, 'fosforo' => 16, 'precipitacion_anual' => 1100, 'temperatura' => 18, 'humedad' => 74],
            'Tabaco' => ['ph' => 6.2, 'mo' => 2.6, 'al3' => 0.5, 'fosforo' => 18, 'precipitacion_anual' => 1300, 'temperatura' => 27, 'humedad' => 68],
            'Sésamo' => ['ph' => 6.0, 'mo' => 2.4, 'al3' => 0.6, 'fosforo' => 16, 'precipitacion_anual' => 1200, 'temperatura' => 28, 'humedad' => 65],
            'Tartago sin cáscara' => ['ph' => 6.2, 'mo' => 2.2, 'al3' => 0.5, 'fosforo' => 18, 'precipitacion_anual' => 1100, 'temperatura' => 27, 'humedad' => 62]
        ],
        'OXISOL' => [
            'Caña de azúcar' => ['ph' => 5.8, 'mo' => 2.0, 'al3' => 0.8, 'fosforo' => 12, 'precipitacion_anual' => 1800, 'temperatura' => 28, 'humedad' => 78],
            'Mandioca' => ['ph' => 5.8, 'mo' => 2.5, 'al3' => 0.9, 'fosforo' => 10, 'precipitacion_anual' => 1500, 'temperatura' => 27, 'humedad' => 72],
            'Soja' => ['ph' => 6.2, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 25, 'humedad' => 70],
            'Maní' => ['ph' => 6.0, 'mo' => 2.7, 'al3' => 0.5, 'fosforo' => 18, 'precipitacion_anual' => 1300, 'temperatura' => 26, 'humedad' => 68],
            'Algodón' => ['ph' => 6.0, 'mo' => 2.5, 'al3' => 0.6, 'fosforo' => 18, 'precipitacion_anual' => 1300, 'temperatura' => 27, 'humedad' => 65],
            'Sorgo para grano' => ['ph' => 6.5, 'mo' => 2.4, 'al3' => 0.4, 'fosforo' => 20, 'precipitacion_anual' => 1100, 'temperatura' => 28, 'humedad' => 65],
            'Tabaco' => ['ph' => 6.2, 'mo' => 2.6, 'al3' => 0.5, 'fosforo' => 18, 'precipitacion_anual' => 1300, 'temperatura' => 27, 'humedad' => 68],
            'Sésamo' => ['ph' => 6.0, 'mo' => 2.4, 'al3' => 0.6, 'fosforo' => 16, 'precipitacion_anual' => 1200, 'temperatura' => 28, 'humedad' => 65],
            'Tartago sin cáscara' => ['ph' => 6.2, 'mo' => 2.2, 'al3' => 0.5, 'fosforo' => 18, 'precipitacion_anual' => 1100, 'temperatura' => 27, 'humedad' => 62]
        ],
        'INCEPTISOL' => [
            'Ajo' => ['ph' => 6.0, 'mo' => 3.0, 'al3' => 0.4, 'fosforo' => 20, 'precipitacion_anual' => 1200, 'temperatura' => 18, 'humedad' => 70],
            'Algodón' => ['ph' => 6.0, 'mo' => 2.5, 'al3' => 0.6, 'fosforo' => 18, 'precipitacion_anual' => 1300, 'temperatura' => 27, 'humedad' => 65],
            'Arveja' => ['ph' => 6.5, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 16, 'precipitacion_anual' => 1100, 'temperatura' => 20, 'humedad' => 75],
            'Batata' => ['ph' => 5.8, 'mo' => 2.0, 'al3' => 0.7, 'fosforo' => 14, 'precipitacion_anual' => 1200, 'temperatura' => 24, 'humedad' => 70],
            'Canola' => ['ph' => 6.2, 'mo' => 2.6, 'al3' => 0.5, 'fosforo' => 18, 'precipitacion_anual' => 1000, 'temperatura' => 18, 'humedad' => 72],
            'Cebolla de cabeza' => ['ph' => 6.0, 'mo' => 2.8, 'al3' => 0.6, 'fosforo' => 16, 'precipitacion_anual' => 1300, 'temperatura' => 20, 'humedad' => 68],
            'Frutilla' => ['ph' => 6.2, 'mo' => 3.2, 'al3' => 0.4, 'fosforo' => 22, 'precipitacion_anual' => 1100, 'temperatura' => 18, 'humedad' => 75],
            'Girasol' => ['ph' => 6.5, 'mo' => 2.6, 'al3' => 0.4, 'fosforo' => 22, 'precipitacion_anual' => 1000, 'temperatura' => 26, 'humedad' => 60],
            'Habilla' => ['ph' => 6.0, 'mo' => 2.4, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1400, 'temperatura' => 22, 'humedad' => 70],
            'Locote' => ['ph' => 6.2, 'mo' => 2.6, 'al3' => 0.6, 'fosforo' => 18, 'precipitacion_anual' => 1300, 'temperatura' => 24, 'humedad' => 68],
            'Maíz' => ['ph' => 6.0, 'mo' => 3.1, 'al3' => 0.5, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 23, 'humedad' => 72],
            'Maní' => ['ph' => 6.0, 'mo' => 2.7, 'al3' => 0.5, 'fosforo' => 18, 'precipitacion_anual' => 1300, 'temperatura' => 26, 'humedad' => 68],
            'Papa' => ['ph' => 5.8, 'mo' => 3.4, 'al3' => 0.7, 'fosforo' => 20, 'precipitacion_anual' => 1000, 'temperatura' => 18, 'humedad' => 75],
            'Poroto' => ['ph' => 6.2, 'mo' => 2.6, 'al3' => 0.4, 'fosforo' => 18, 'precipitacion_anual' => 1200, 'temperatura' => 24, 'humedad' => 70],
            'Soja' => ['ph' => 6.2, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 25, 'humedad' => 70],
            'Sorgo para grano' => ['ph' => 6.5, 'mo' => 2.4, 'al3' => 0.4, 'fosforo' => 20, 'precipitacion_anual' => 1100, 'temperatura' => 28, 'humedad' => 72],
            'Tomate' => ['ph' => 6.0, 'mo' => 3.0, 'al3' => 0.5, 'fosforo' => 18, 'precipitacion_anual' => 1300, 'temperatura' => 22, 'humedad' => 72],
            'Trigo' => ['ph' => 6.2, 'mo' => 2.6, 'al3' => 0.4, 'fosforo' => 22, 'precipitacion_anual' => 900, 'temperatura' => 20, 'humedad' => 68],
            'Zanahoria' => ['ph' => 6.0, 'mo' => 2.8, 'al3' => 0.6, 'fosforo' => 16, 'precipitacion_anual' => 1100, 'temperatura' => 18, 'humedad' => 74],
            'Tabaco' => ['ph' => 6.2, 'mo' => 2.6, 'al3' => 0.5, 'fosforo' => 18, 'precipitacion_anual' => 1300, 'temperatura' => 27, 'humedad' => 68],
            'Menta' => ['ph' => 6.0, 'mo' => 3.0, 'al3' => 0.6, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 24, 'humedad' => 75],
            'Sésamo' => ['ph' => 6.0, 'mo' => 2.4, 'al3' => 0.6, 'fosforo' => 16, 'precipitacion_anual' => 1200, 'temperatura' => 28, 'humedad' => 65]
        ],
        'TIERRAS MISCELANEAS' => [
            'Algodón' => ['ph' => 6.0, 'mo' => 2.5, 'al3' => 0.6, 'fosforo' => 18, 'precipitacion_anual' => 1300, 'temperatura' => 27, 'humedad' => 65],
            'Arroz secano' => ['ph' => 5.8, 'mo' => 2.2, 'al3' => 0.8, 'fosforo' => 12, 'precipitacion_anual' => 1600, 'temperatura' => 26, 'humedad' => 75],
            'Batata' => ['ph' => 5.8, 'mo' => 2.0, 'al3' => 0.7, 'fosforo' => 14, 'precipitacion_anual' => 1200, 'temperatura' => 24, 'humedad' => 70],
            'Maíz' => ['ph' => 6.0, 'mo' => 3.1, 'al3' => 0.5, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 23, 'humedad' => 72],
            'Mandioca' => ['ph' => 5.8, 'mo' => 2.5, 'al3' => 0.9, 'fosforo' => 10, 'precipitacion_anual' => 1500, 'temperatura' => 27, 'humedad' => 72],
            'Maní' => ['ph' => 6.0, 'mo' => 2.7, 'al3' => 0.5, 'fosforo' => 18, 'precipitacion_anual' => 1300, 'temperatura' => 26, 'humedad' => 68],
            'Sorgo para grano' => ['ph' => 6.5, 'mo' => 2.4, 'al3' => 0.4, 'fosforo' => 20, 'precipitacion_anual' => 1100, 'temperatura' => 28, 'humedad' => 65],
            'Tabaco' => ['ph' => 6.2, 'mo' => 2.6, 'al3' => 0.5, 'fosforo' => 18, 'precipitacion_anual' => 1300, 'temperatura' => 27, 'humedad' => 68],
            'Menta' => ['ph' => 6.0, 'mo' => 3.0, 'al3' => 0.6, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 24, 'humedad' => 75],
            'Stevia' => ['ph' => 5.8, 'mo' => 2.8, 'al3' => 0.7, 'fosforo' => 12, 'precipitacion_anual' => 1500, 'temperatura' => 26, 'humedad' => 70]
        ],

        'default' => [
            'ph' => 5.5,
            'mo' => 2.5,
            'al3' => 0.5,
            'fosforo' => 10,
            'precipitacion_anual' => 1000,
            'temperatura' => 25,
            'humedad' => 60,
        ],
    ];

    private $weights = [
        'ph' => 0.3,
        'mo' => 0.2,
        'al3' => 0.1,
        'fosforo' => 0.2,
        'precipitacion_anual' => 0.1,
        'temperatura' => 0.05,
        'humedad' => 0.05,
    ];

    public function recommendCrops(Soil $soil): array
    {
        Log::info('Entrando al método recommendCrops');
        Log::info('Orden de suelo recibida: ' . $soil->orden);

        $crops = [];

        // Asignar valores predeterminados si alguna propiedad es nula
        $soil = $this->assignDefaultValues($soil);

        // Lógica para recomendar cultivos basada en las propiedades del suelo
        if ($soil->orden == 'ULTISOL') {
            $crops = [
                'Soja' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Soja'), $this->idealValues['ULTISOL']['Soja'], $this->weights),
                'Maíz' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Maíz'), $this->idealValues['ULTISOL']['Maíz'], $this->weights),
                'Algodón' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Algodón'), $this->idealValues['ULTISOL']['Algodón'], $this->weights),
                'Arroz secano' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Arroz secano'), $this->idealValues['ULTISOL']['Arroz secano'], $this->weights),
                'Batata' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Batata'), $this->idealValues['ULTISOL']['Batata'], $this->weights),
                'Mandioca' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Mandioca'), $this->idealValues['ULTISOL']['Mandioca'], $this->weights),
                'Maní' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Maní'), $this->idealValues['ULTISOL']['Maní'], $this->weights),
                'Sorgo para grano' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Sorgo para grano'), $this->idealValues['ULTISOL']['Sorgo para grano'], $this->weights),
                'Menta' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Menta'), $this->idealValues['ULTISOL']['Menta'], $this->weights),
                'Stevia' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Stevia'), $this->idealValues['ULTISOL']['Stevia'], $this->weights),
                'Tabaco' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Tabaco'), $this->idealValues['ULTISOL']['Tabaco'], $this->weights),
            ];
        } elseif ($soil->orden == 'ENTISOL') {
            $crops = [
                'Arroz secano' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Arroz secano'), $this->idealValues['ENTISOL']['Arroz secano'], $this->weights),
                'Maíz' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Maíz'), $this->idealValues['ENTISOL']['Maíz'], $this->weights),
                'Sorgo para grano' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Sorgo para grano'), $this->idealValues['ENTISOL']['Sorgo para grano'], $this->weights),
                'Soja' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Soja'), $this->idealValues['ENTISOL']['Soja'], $this->weights),
                'Algodón' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Algodón'), $this->idealValues['ENTISOL']['Algodón'], $this->weights),
                'Girasol' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Girasol'), $this->idealValues['ENTISOL']['Girasol'], $this->weights),
                'Tabaco' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Tabaco'), $this->idealValues['ENTISOL']['Tabaco'], $this->weights),
                'Sésamo' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Sésamo'), $this->idealValues['ENTISOL']['Sésamo'], $this->weights),
                'Tartago sin cáscara' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Tartago sin cáscara'), $this->idealValues['ENTISOL']['Tartago sin cáscara'], $this->weights),
            ];
        } elseif ($soil->orden == 'ALFISOL') {
            $crops = [
                'Ajo' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Ajo'), $this->idealValues['ALFISOL']['Ajo'], $this->weights),
                'Algodón' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Algodón'), $this->idealValues['ALFISOL']['Algodón'], $this->weights),
                'Arveja' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Arveja'), $this->idealValues['ALFISOL']['Arveja'], $this->weights),
                'Batata' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Batata'), $this->idealValues['ALFISOL']['Batata'], $this->weights),
                'Canola' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Canola'), $this->idealValues['ALFISOL']['Canola'], $this->weights),
                'Cebolla de cabeza' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Cebolla de cabeza'), $this->idealValues['ALFISOL']['Cebolla de cabeza'], $this->weights),
                'Frutilla' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Frutilla'), $this->idealValues['ALFISOL']['Frutilla'], $this->weights),
                'Girasol' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Girasol'), $this->idealValues['ALFISOL']['Girasol'], $this->weights),
                'Habilla' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Habilla'), $this->idealValues['ALFISOL']['Habilla'], $this->weights),
                'Locote' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Locote'), $this->idealValues['ALFISOL']['Locote'], $this->weights),
                'Maíz' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Maíz'), $this->idealValues['ALFISOL']['Maíz'], $this->weights),
                'Maní' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Maní'), $this->idealValues['ALFISOL']['Maní'], $this->weights),
                'Papa' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Papa'), $this->idealValues['ALFISOL']['Papa'], $this->weights),
                'Poroto' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Poroto'), $this->idealValues['ALFISOL']['Poroto'], $this->weights),
                'Soja' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Soja'), $this->idealValues['ALFISOL']['Soja'], $this->weights),
                'Sorgo para grano' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Sorgo para grano'), $this->idealValues['ALFISOL']['Sorgo para grano'], $this->weights),
                'Tomate' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Tomate'), $this->idealValues['ALFISOL']['Tomate'], $this->weights),
                'Trigo' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Trigo'), $this->idealValues['ALFISOL']['Trigo'], $this->weights),
                'Zanahoria' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Zanahoria'), $this->idealValues['ALFISOL']['Zanahoria'], $this->weights),
                'Tabaco' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Tabaco'), $this->idealValues['ALFISOL']['Tabaco'], $this->weights),
                'Sésamo' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Sésamo'), $this->idealValues['ALFISOL']['Sésamo'], $this->weights),
                'Tartago sin cáscara' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Tartago sin cáscara'), $this->idealValues['ALFISOL']['Tartago sin cáscara'], $this->weights),
            ];
        } elseif ($soil->orden == 'OXISOL') {
            $crops = [
                'Caña de azúcar' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Caña de azúcar'), $this->idealValues['OXISOL']['Caña de azúcar'], $this->weights),
                'Mandioca' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Mandioca'), $this->idealValues['OXISOL']['Mandioca'], $this->weights),
                'Soja' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Soja'), $this->idealValues['OXISOL']['Soja'], $this->weights),
                'Maní' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Maní'), $this->idealValues['OXISOL']['Maní'], $this->weights),
                'Algodón' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Algodón'), $this->idealValues['OXISOL']['Algodón'], $this->weights),
                'Sorgo para grano' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Sorgo para grano'), $this->idealValues['OXISOL']['Sorgo para grano'], $this->weights),
                'Tabaco' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Tabaco'), $this->idealValues['OXISOL']['Tabaco'], $this->weights),
                'Sésamo' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Sésamo'), $this->idealValues['OXISOL']['Sésamo'], $this->weights),
                'Tartago sin cáscara' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Tartago sin cáscara'), $this->idealValues['OXISOL']['Tartago sin cáscara'], $this->weights),
            ];
        } elseif ($soil->orden == 'INCEPTISOL') {
            $crops = [
                'Ajo' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Ajo'), $this->idealValues['INCEPTISOL']['Ajo'], $this->weights),
                'Algodón' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Algodón'), $this->idealValues['INCEPTISOL']['Algodón'], $this->weights),
                'Arveja' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Arveja'), $this->idealValues['INCEPTISOL']['Arveja'], $this->weights),
                'Batata' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Batata'), $this->idealValues['INCEPTISOL']['Batata'], $this->weights),
                'Canola' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Canola'), $this->idealValues['INCEPTISOL']['Canola'], $this->weights),
                'Cebolla de cabeza' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Cebolla de cabeza'), $this->idealValues['INCEPTISOL']['Cebolla de cabeza'], $this->weights),
                'Frutilla' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Frutilla'), $this->idealValues['INCEPTISOL']['Frutilla'], $this->weights),
                'Girasol' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Girasol'), $this->idealValues['INCEPTISOL']['Girasol'], $this->weights),
                'Habilla' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Habilla'), $this->idealValues['INCEPTISOL']['Habilla'], $this->weights),
                'Locote' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Locote'), $this->idealValues['INCEPTISOL']['Locote'], $this->weights),
                'Maíz' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Maíz'), $this->idealValues['INCEPTISOL']['Maíz'], $this->weights),
                'Maní' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Maní'), $this->idealValues['INCEPTISOL']['Maní'], $this->weights),
                'Papa' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Papa'), $this->idealValues['INCEPTISOL']['Papa'], $this->weights),
                'Poroto' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Poroto'), $this->idealValues['INCEPTISOL']['Poroto'], $this->weights),
                'Soja' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Soja'), $this->idealValues['INCEPTISOL']['Soja'], $this->weights),
                'Sorgo para grano' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Sorgo para grano'), $this->idealValues['INCEPTISOL']['Sorgo para grano'], $this->weights),
                'Tomate' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Tomate'), $this->idealValues['INCEPTISOL']['Tomate'], $this->weights),
                'Trigo' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Trigo'), $this->idealValues['INCEPTISOL']['Trigo'], $this->weights),
                'Zanahoria' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Zanahoria'), $this->idealValues['INCEPTISOL']['Zanahoria'], $this->weights),
                'Tabaco' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Tabaco'), $this->idealValues['INCEPTISOL']['Tabaco'], $this->weights),
                'Menta' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Menta'), $this->idealValues['INCEPTISOL']['Menta'], $this->weights),
                'Sésamo' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Sésamo'), $this->idealValues['INCEPTISOL']['Sésamo'], $this->weights),
            ];
        } elseif ($soil->orden == 'TIERRAS MISCELANEAS') {
            $crops = [
                'Algodón' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Algodón'), $this->idealValues['TIERRAS MISCELANEAS']['Algodón'], $this->weights),
                'Arroz secano' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Arroz secano'), $this->idealValues['TIERRAS MISCELANEAS']['Arroz secano'], $this->weights),
                'Batata' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Batata'), $this->idealValues['TIERRAS MISCELANEAS']['Batata'], $this->weights),
                'Maíz' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Maíz'), $this->idealValues['TIERRAS MISCELANEAS']['Maíz'], $this->weights),
                'Mandioca' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Mandioca'), $this->idealValues['TIERRAS MISCELANEAS']['Mandioca'], $this->weights),
                'Maní' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Maní'), $this->idealValues['TIERRAS MISCELANEAS']['Maní'], $this->weights),
                'Sorgo para grano' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Sorgo para grano'), $this->idealValues['TIERRAS MISCELANEAS']['Sorgo para grano'], $this->weights),
                'Tabaco' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Tabaco'), $this->idealValues['TIERRAS MISCELANEAS']['Tabaco'], $this->weights),
                'Menta' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Menta'), $this->idealValues['TIERRAS MISCELANEAS']['Menta'], $this->weights),
                'Stevia' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Stevia'), $this->idealValues['TIERRAS MISCELANEAS']['Stevia'], $this->weights),
            ];
        }
        // ... (agregar las demás órdenes de suelo)

        Log::info('Cultivos recomendados antes de ordenar: ' . implode(', ', array_keys($crops)));

        // Ordenar la lista de cultivos por conveniencia global
        // Ordenar la lista de cultivos por conveniencia global
        $orderedCrops = collect($crops)->sortByDesc('suitability')->keys()->toArray();

        Log::debug('Cultivos después de ordenar: ' . implode(', ', $orderedCrops));

        // Aplicar reglas de rotación de cultivos
        $orderedCrops = $this->applyRotationRules($orderedCrops);

        return $orderedCrops;
    }

    private function getActualValues(Soil $soil, string $crop): array
    {
        if ($soil->orden == 'ULTISOL') {
            switch ($crop) {
                case 'Soja':
                    return ['ph' => 6.2, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 25, 'humedad' => 70];
                case 'Maíz':
                    return ['ph' => 6.0, 'mo' => 3.1, 'al3' => 0.5, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 23, 'humedad' => 72];
                case 'Algodón':
                    return ['ph' => 6.2, 'mo' => 2.2, 'al3' => 0.7, 'fosforo' => 15, 'precipitacion_anual' => 1300, 'temperatura' => 25, 'humedad' => 68];
                case 'Arroz secano':
                    return ['ph' => 6.0, 'mo' => 3.2, 'al3' => 0.8, 'fosforo' => 15, 'precipitacion_anual' => 1450, 'temperatura' => 24, 'humedad' => 78];
                case 'Batata':
                    return ['ph' => 5.8, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 12, 'precipitacion_anual' => 1500, 'temperatura' => 25, 'humedad' => 70];
                case 'Mandioca':
                    return ['ph' => 5.5, 'mo' => 2.7, 'al3' => 0.8, 'fosforo' => 12, 'precipitacion_anual' => 1550, 'temperatura' => 24, 'humedad' => 75];
                case 'Maní':
                    return ['ph' => 6.2, 'mo' => 2.3, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1400, 'temperatura' => 25, 'humedad' => 70];
                case 'Sorgo para grano':
                    return ['ph' => 6.0, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1350, 'temperatura' => 24, 'humedad' => 72];
                case 'Menta':
                    return ['ph' => 6.0, 'mo' => 3.0, 'al3' => 0.3, 'fosforo' => 18, 'precipitacion_anual' => 1500, 'temperatura' => 21, 'humedad' => 75];
                case 'Stevia':
                    return ['ph' => 5.8, 'mo' => 2.6, 'al3' => 0.6, 'fosforo' => 14, 'precipitacion_anual' => 1500, 'temperatura' => 22, 'humedad' => 75];
                case 'Tabaco':
                    return ['ph' => 5.8, 'mo' => 2.7, 'al3' => 0.6, 'fosforo' => 18, 'precipitacion_anual' => 1400, 'temperatura' => 21, 'humedad' => 75];
                default:
                    return $this->idealValues;
            }
        } elseif ($soil->orden == 'ENTISOL') {
            switch ($crop) {
                case 'Arroz secano':
                    return ['ph' => 6.0, 'mo' => 3.2, 'al3' => 0.8, 'fosforo' => 15, 'precipitacion_anual' => 1450, 'temperatura' => 24, 'humedad' => 78];
                case 'Maíz':
                    return ['ph' => 6.0, 'mo' => 3.1, 'al3' => 0.5, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 23, 'humedad' => 72];
                case 'Sorgo para grano':
                    return ['ph' => 6.0, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1350, 'temperatura' => 24, 'humedad' => 72];
                case 'Soja':
                    return ['ph' => 6.2, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 25, 'humedad' => 70];
                case 'Algodón':
                    return ['ph' => 6.2, 'mo' => 2.2, 'al3' => 0.7, 'fosforo' => 15, 'precipitacion_anual' => 1300, 'temperatura' => 25, 'humedad' => 68];
                case 'Girasol':
                    return ['ph' => 6.2, 'mo' => 2.4, 'al3' => 0.5, 'fosforo' => 15, 'precipitacion_anual' => 1350, 'temperatura' => 23, 'humedad' => 68];
                case 'Tabaco':
                    return ['ph' => 5.8, 'mo' => 2.7, 'al3' => 0.6, 'fosforo' => 18, 'precipitacion_anual' => 1400, 'temperatura' => 21, 'humedad' => 75];
                case 'Sésamo':
                    return ['ph' => 6.0, 'mo' => 2.2, 'al3' => 0.6, 'fosforo' => 13, 'precipitacion_anual' => 1350, 'temperatura' => 24, 'humedad' => 68];
                case 'Tartago sin cáscara':
                    return ['ph' => 6.1, 'mo' => 2.3, 'al3' => 0.5, 'fosforo' => 15, 'precipitacion_anual' => 1350, 'temperatura' => 23, 'humedad' => 70];
                default:
                    return $this->idealValues;
            }
        } elseif ($soil->orden == 'ALFISOL') {
            switch ($crop) {
                case 'Ajo':
                    return ['ph' => 6.5, 'mo' => 3.0, 'al3' => 0.3, 'fosforo' => 20, 'precipitacion_anual' => 1600, 'temperatura' => 22, 'humedad' => 75];
                case 'Algodón':
                    return ['ph' => 6.2, 'mo' => 2.2, 'al3' => 0.7, 'fosforo' => 15, 'precipitacion_anual' => 1300, 'temperatura' => 25, 'humedad' => 68];
                case 'Arveja':
                    return ['ph' => 6.3, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 18, 'precipitacion_anual' => 1400, 'temperatura' => 21, 'humedad' => 72];
                case 'Batata':
                    return ['ph' => 5.8, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 12, 'precipitacion_anual' => 1500, 'temperatura' => 25, 'humedad' => 70];
                case 'Canola':
                    return ['ph' => 6.0, 'mo' => 2.2, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1400, 'temperatura' => 20, 'humedad' => 75];
                case 'Cebolla de cabeza':
                    return ['ph' => 6.5, 'mo' => 2.8, 'al3' => 0.2, 'fosforo' => 22, 'precipitacion_anual' => 1500, 'temperatura' => 22, 'humedad' => 72];
                case 'Frutilla':
                    return ['ph' => 5.5, 'mo' => 3.2, 'al3' => 0.4, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 20, 'humedad' => 75];
                case 'Girasol':
                    return ['ph' => 6.2, 'mo' => 2.4, 'al3' => 0.5, 'fosforo' => 15, 'precipitacion_anual' => 1350, 'temperatura' => 23, 'humedad' => 68];
                case 'Habilla':
                    return ['ph' => 6.0, 'mo' => 2.8, 'al3' => 0.3, 'fosforo' => 18, 'precipitacion_anual' => 1400, 'temperatura' => 21, 'humedad' => 72];
                case 'Locote':
                    return ['ph' => 6.3, 'mo' => 2.9, 'al3' => 0.4, 'fosforo' => 19, 'precipitacion_anual' => 1450, 'temperatura' => 24, 'humedad' => 70];
                case 'Maíz':
                    return ['ph' => 6.0, 'mo' => 3.1, 'al3' => 0.5, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 23, 'humedad' => 72];
                case 'Maní':
                    return ['ph' => 6.2, 'mo' => 2.3, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1400, 'temperatura' => 25, 'humedad' => 70];
                case 'Papa':
                    return ['ph' => 5.8, 'mo' => 2.6, 'al3' => 0.6, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 18, 'humedad' => 78];
                case 'Poroto':
                    return ['ph' => 6.1, 'mo' => 2.9, 'al3' => 0.4, 'fosforo' => 17, 'precipitacion_anual' => 1450, 'temperatura' => 22, 'humedad' => 72];
                case 'Soja':
                    return ['ph' => 6.2, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 25, 'humedad' => 70];
                case 'Sorgo para grano':
                    return ['ph' => 6.0, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1350, 'temperatura' => 24, 'humedad' => 72];
                case 'Tomate':
                    return ['ph' => 6.3, 'mo' => 2.9, 'al3' => 0.3, 'fosforo' => 20, 'precipitacion_anual' => 1450, 'temperatura' => 22, 'humedad' => 72];
                case 'Trigo':
                    return ['ph' => 6.0, 'mo' => 2.6, 'al3' => 0.5, 'fosforo' => 15, 'precipitacion_anual' => 1300, 'temperatura' => 19, 'humedad' => 75];
                case 'Zanahoria':
                    return ['ph' => 6.2, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 18, 'precipitacion_anual' => 1400, 'temperatura' => 20, 'humedad' => 72];
                case 'Tabaco':
                    return ['ph' => 5.8, 'mo' => 2.7, 'al3' => 0.6, 'fosforo' => 18, 'precipitacion_anual' => 1400, 'temperatura' => 21, 'humedad' => 75];
                case 'Sésamo':
                    return ['ph' => 6.0, 'mo' => 2.2, 'al3' => 0.6, 'fosforo' => 13, 'precipitacion_anual' => 1350, 'temperatura' => 24, 'humedad' => 68];
                case 'Tartago sin cáscara':
                    return ['ph' => 6.1, 'mo' => 2.3, 'al3' => 0.5, 'fosforo' => 15, 'precipitacion_anual' => 1350, 'temperatura' => 23, 'humedad' => 70];
                default:
                    return $this->idealValues;
            }
        } elseif ($soil->orden == 'OXISOL') {
            switch ($crop) {
                case 'Caña de azúcar':
                    return ['ph' => 6.2, 'mo' => 3.5, 'al3' => 0.3, 'fosforo' => 18, 'precipitacion_anual' => 1600, 'temperatura' => 24, 'humedad' => 80];
                case 'Mandioca':
                    return ['ph' => 5.5, 'mo' => 2.7, 'al3' => 0.8, 'fosforo' => 12, 'precipitacion_anual' => 1550, 'temperatura' => 24, 'humedad' => 75];
                case 'Soja':
                    return ['ph' => 6.2, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 25, 'humedad' => 70];
                case 'Maní':
                    return ['ph' => 6.2, 'mo' => 2.3, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1400, 'temperatura' => 25, 'humedad' => 70];
                case 'Algodón':
                    return ['ph' => 6.2, 'mo' => 2.2, 'al3' => 0.7, 'fosforo' => 15, 'precipitacion_anual' => 1300, 'temperatura' => 25, 'humedad' => 68];
                case 'Sorgo para grano':
                    return ['ph' => 6.0, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1350, 'temperatura' => 24, 'humedad' => 72];
                case 'Tabaco':
                    return ['ph' => 5.8, 'mo' => 2.7, 'al3' => 0.6, 'fosforo' => 18, 'precipitacion_anual' => 1400, 'temperatura' => 21, 'humedad' => 75];
                case 'Sésamo':
                    return ['ph' => 6.0, 'mo' => 2.2, 'al3' => 0.6, 'fosforo' => 13, 'precipitacion_anual' => 1350, 'temperatura' => 24, 'humedad' => 68];
                case 'Tartago sin cáscara':
                    return ['ph' => 6.1, 'mo' => 2.3, 'al3' => 0.5, 'fosforo' => 15, 'precipitacion_anual' => 1350, 'temperatura' => 23, 'humedad' => 70];
                default:
                    return $this->idealValues;
            }
        } elseif ($soil->orden == 'INCEPTISOL') {
            switch ($crop) {
                case 'Ajo':
                    return ['ph' => 6.5, 'mo' => 3.0, 'al3' => 0.3, 'fosforo' => 20, 'precipitacion_anual' => 1600, 'temperatura' => 22, 'humedad' => 75];
                case 'Algodón':
                    return ['ph' => 6.2, 'mo' => 2.2, 'al3' => 0.7, 'fosforo' => 15, 'precipitacion_anual' => 1300, 'temperatura' => 25, 'humedad' => 68];
                case 'Arveja':
                    return ['ph' => 6.3, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 18, 'precipitacion_anual' => 1400, 'temperatura' => 21, 'humedad' => 72];
                case 'Batata':
                    return ['ph' => 5.8, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 12, 'precipitacion_anual' => 1500, 'temperatura' => 25, 'humedad' => 70];
                case 'Canola':
                    return ['ph' => 6.0, 'mo' => 2.2, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1400, 'temperatura' => 20, 'humedad' => 75];
                case 'Cebolla de cabeza':
                    return ['ph' => 6.5, 'mo' => 2.8, 'al3' => 0.2, 'fosforo' => 22, 'precipitacion_anual' => 1500, 'temperatura' => 22, 'humedad' => 72];
                case 'Frutilla':
                    return ['ph' => 5.5, 'mo' => 3.2, 'al3' => 0.4, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 20, 'humedad' => 75];
                case 'Girasol':
                    return ['ph' => 6.2, 'mo' => 2.4, 'al3' => 0.5, 'fosforo' => 15, 'precipitacion_anual' => 1350, 'temperatura' => 23, 'humedad' => 68];
                case 'Habilla':
                    return ['ph' => 6.0, 'mo' => 2.8, 'al3' => 0.3, 'fosforo' => 18, 'precipitacion_anual' => 1400, 'temperatura' => 21, 'humedad' => 72];
                case 'Locote':
                    return ['ph' => 6.3, 'mo' => 2.9, 'al3' => 0.4, 'fosforo' => 19, 'precipitacion_anual' => 1450, 'temperatura' => 24, 'humedad' => 70];
                case 'Maíz':
                    return ['ph' => 6.0, 'mo' => 3.1, 'al3' => 0.5, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 23, 'humedad' => 72];
                case 'Maní':
                    return ['ph' => 6.2, 'mo' => 2.3, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1400, 'temperatura' => 25, 'humedad' => 70];
                case 'Papa':
                    return ['ph' => 5.8, 'mo' => 2.6, 'al3' => 0.6, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 18, 'humedad' => 78];
                case 'Poroto':
                    return ['ph' => 6.1, 'mo' => 2.9, 'al3' => 0.4, 'fosforo' => 17, 'precipitacion_anual' => 1450, 'temperatura' => 22, 'humedad' => 72];
                case 'Soja':
                    return ['ph' => 6.2, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 25, 'humedad' => 70];
                case 'Sorgo para grano':
                    return ['ph' => 6.0, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1350, 'temperatura' => 24, 'humedad' => 72];
                case 'Tomate':
                    return ['ph' => 6.3, 'mo' => 2.9, 'al3' => 0.3, 'fosforo' => 20, 'precipitacion_anual' => 1450, 'temperatura' => 22, 'humedad' => 72];
                case 'Trigo':
                    return ['ph' => 6.0, 'mo' => 2.6, 'al3' => 0.5, 'fosforo' => 15, 'precipitacion_anual' => 1300, 'temperatura' => 19, 'humedad' => 75];
                case 'Zanahoria':
                    return ['ph' => 6.2, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 18, 'precipitacion_anual' => 1400, 'temperatura' => 20, 'humedad' => 72];
                case 'Tabaco':
                    return ['ph' => 5.8, 'mo' => 2.7, 'al3' => 0.6, 'fosforo' => 18, 'precipitacion_anual' => 1400, 'temperatura' => 21, 'humedad' => 75];
                case 'Menta':
                    return ['ph' => 6.0, 'mo' => 3.0, 'al3' => 0.3, 'fosforo' => 18, 'precipitacion_anual' => 1500, 'temperatura' => 21, 'humedad' => 75];
                case 'Sésamo':
                    return ['ph' => 6.0, 'mo' => 2.2, 'al3' => 0.6, 'fosforo' => 13, 'precipitacion_anual' => 1350, 'temperatura' => 24, 'humedad' => 68];
                default:
                    return $this->idealValues;
            }
        } elseif ($soil->orden == 'TIERRAS MISCELANEAS') {
            switch ($crop) {
                case 'Algodón':
                    return ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 60];
                case 'Arroz secano':
                    return ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 60];
                case 'Batata':
                    return ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 60];
                case 'Maíz':
                    return ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 60];
                case 'Mandioca':
                    return ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 60];
                case 'Maní':
                    return ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 60];
                case 'Sorgo para grano':
                    return ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 60];
                case 'Tabaco':
                    return ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 60];
                case 'Menta':
                    return ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 60];
                case 'Stevia':
                    return ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 60];
                default:
                    return $this->idealValues;
            }
        }
    }

    private function calculateGlobalSuitability(array $actualValues, array $idealValues, array $weights): float
    {
        $globalSuitability = 0;

        foreach ($actualValues as $property => $actualValue) {
            $idealValue = $idealValues[$property];
            $weight = $weights[$property];

            $suitability = $this->calculateSuitabilityFactor($actualValue, $idealValue);
            $globalSuitability += $suitability * $weight;
        }

        return $globalSuitability;
    }

    private function calculateSuitabilityFactor(float $actual, float $ideal): float
    {
        $maxDifference = 0.5 * $ideal; // Se considera una diferencia máxima del 50% del valor ideal
        $difference = abs($actual - $ideal);
        if ($difference > $maxDifference) {
            return 0; // Si la diferencia excede el 50% del valor ideal, se asigna una conveniencia de 0
        }

        $suitability = 1 - ($difference / $maxDifference); // Cálculo lineal de la conveniencia

        return $suitability;
    }

    private function assignDefaultValues(Soil $soil): Soil
    {
        $soil->ph = $soil->ph ?? 0;
        $soil->mo = $soil->mo ?? 0;
        $soil->al3 = $soil->al3 ?? 0;
        $soil->fosforo = $soil->fosforo ?? 0;
        $soil->precipitacion_anual = $soil->precipitacion_anual ?? 0;
        $soil->temperatura = $soil->temperatura ?? 0;
        $soil->humedad = $soil->humedad ?? 0;

        return $soil;
    }

    private function applyRotationRules(array $orderedCrops): array
    {
        $rotatedCrops = [];

        $familyGroups = [
            'Leguminosas' => ['Soja', 'Arveja', 'Poroto', 'Habilla', 'Maní'],
            'Solanáceas' => ['Tomate', 'Papa', 'Locote'],
            'Crucíferas' => ['Canola', 'Zanahoria'],
            'Cucurbitáceas' => ['Zapallo', 'Melón', 'Sandía', 'Pepino'],
            'Gramíneas' => ['Maíz', 'Trigo', 'Arroz', 'Sorgo', 'Caña de azúcar'],
            'Liliáceas' => ['Ajo', 'Cebolla'],
            'Rosáceas' => ['Frutilla'],
            'Malváceas' => ['Algodón'],
            'Convolvuláceas' => ['Batata'],
            'Euforbiáceas' => ['Mandioca'],
            'Pedaliáceas' => ['Sésamo'],
            'Lamiáceas' => ['Menta'],
            'Asteráceas' => ['Girasol'],
            'Rubiáceas' => ['Tabaco'],
            'Esteviáceas' => ['Stevia'],
            'Fabáceas' => ['Tartago sin cáscara'],
        ];

        $previousFamily = null;
        $remainingCrops = $orderedCrops;

        while (!empty($remainingCrops)) {
            foreach ($remainingCrops as $key => $crop) {
                $currentFamily = $this->getCropFamily($crop, $familyGroups);

                if ($currentFamily !== $previousFamily) {
                    $rotatedCrops[] = $crop;
                    unset($remainingCrops[$key]);
                    $previousFamily = $currentFamily;
                    break;
                }
            }
        }

        return $rotatedCrops;
    }

    private function getCropFamily(string $crop, array $familyGroups): ?string
    {
        foreach ($familyGroups as $family => $crops) {
            if (in_array($crop, $crops)) {
                return $family;
            }
        }

        return null;
    }
}
