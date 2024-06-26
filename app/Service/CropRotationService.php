<?php

namespace App\Service;

use App\Models\Soil;
use Illuminate\Support\Facades\Log;

class CropRotationService
{
    private $cropToFamily = [];
    private $idealValues = [
        'ULTISOL' => [
            'ph' => 5.5,
            'mo' => 2.5,
            'al3' => 0.5,
            'fosforo' => 10,
            'precipitacion_anual' => 1000,
            'temperatura' => 25,
            'humedad' => 60,
            'Soja' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 70],
            'Maíz' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 72],
            'Algodón' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 65],
            'Arroz secano' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 75],
            'Batata' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 70],
            'Mandioca' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 72],
            'Maní' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 68],
            'Sorgo para grano' => ['ph' => 6.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 65],
            'Menta' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 75],
            'Stevia' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 70],
            'Tabaco' => ['ph' => 6.2, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 68]
        ],
        'ENTISOL' => [
            'Arroz secano' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 75],
            'Maíz' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 72],
            'Sorgo para grano' => ['ph' => 6.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 65],
            'Soja' => ['ph' => 6.2, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 70],
            'Algodón' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 65],
            'Girasol' => ['ph' => 6.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 60],
            'Tabaco' => ['ph' => 6.2, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 68],
            'Sesamo' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 65],
            'Tartago sin cáscara' => ['ph' => 6.2, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 62]
        ],
        'ALFISOL' => [
            'Ajo' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 70],
            'Algodón' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 65],
            'Arveja' => ['ph' => 6.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 75],
            'Batata' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 70],
            'Canola' => ['ph' => 6.2, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 72],
            'Cebolla de cabeza' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 68],
            'Frutilla' => ['ph' => 6.2, 'mo' => 3.2, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 75],
            'Girasol' => ['ph' => 6.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 60],
            'Habilla' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 70],
            'Locote' => ['ph' => 6.2, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 68],
            'Maíz' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 72],
            'Maní' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 68],
            'Papa' => ['ph' => 5.5, 'mo' => 3.4, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 75],
            'Poroto' => ['ph' => 6.2, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 70],
            'Soja' => ['ph' => 6.2, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 70],
            'Sorgo para grano' => ['ph' => 6.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 65],
            'Tomate' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 72],
            'Trigo' => ['ph' => 6.2, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 68],
            'Zanahoria' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 74],
            'Tabaco' => ['ph' => 6.2, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 68],
            'Sesamo' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 65],
            'Tartago sin cáscara' => ['ph' => 6.2, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 62]
        ],
        'OXISOL' => [
            'Caña de azúcar' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1800, 'temperatura' => 25, 'humedad' => 78],
            'Mandioca' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 72],
            'Soja' => ['ph' => 6.2, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 70],
            'Maní' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 68],
            'Algodón' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 65],
            'Sorgo para grano' => ['ph' => 6.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 65],
            'Tabaco' => ['ph' => 6.2, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 68],
            'Sesamo' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 65],
            'Tartago sin cáscara' => ['ph' => 6.2, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 62]
        ],
        'INCEPTISOL' => [
            'Ajo' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 70],
            'Algodón' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 65],
            'Arveja' => ['ph' => 6.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 75],
            'Batata' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 70],
            'Canola' => ['ph' => 6.2, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 72],
            'Cebolla de cabeza' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 68],
            'Frutilla' => ['ph' => 6.2, 'mo' => 3.2, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 75],
            'Girasol' => ['ph' => 6.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 60],
            'Habilla' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 70],
            'Locote' => ['ph' => 6.2, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 68],
            'Maíz' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 72],
            'Maní' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 68],
            'Papa' => ['ph' => 5.5, 'mo' => 3.4, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 75],
            'Poroto' => ['ph' => 6.2, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 70],
            'Soja' => ['ph' => 6.2, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 70],
            'Sorgo para grano' => ['ph' => 6.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 72],
            'Tomate' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 72],
            'Trigo' => ['ph' => 6.2, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 68],
            'Zanahoria' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 74],
            'Tabaco' => ['ph' => 6.2, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 68],
            'Menta' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 75],
            'Sesamo' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 65]
        ],
        'TIERRAS MISCELANEAS' => [
            'Algodón' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 65],
            'Arroz secano' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 75],
            'Batata' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 70],
            'Maíz' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 72],
            'Mandioca' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 72],
            'Maní' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 68],
            'Sorgo para grano' => ['ph' => 6.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 65],
            'Tabaco' => ['ph' => 6.2, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 68],
            'Menta' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 75],
            'Stevia' => ['ph' => 5.5, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 10, 'precipitacion_anual' => 1000, 'temperatura' => 25, 'humedad' => 70]
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
        $soil = $this->assignDefaultValues($soil);
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
                'Sesamo' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Sesamo'), $this->idealValues['ENTISOL']['Sesamo'], $this->weights),
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
                'Sesamo' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Sesamo'), $this->idealValues['ALFISOL']['Sesamo'], $this->weights),
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
                'Sesamo' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Sesamo'), $this->idealValues['OXISOL']['Sesamo'], $this->weights),
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
                'Sesamo' => $this->calculateGlobalSuitability($this->getActualValues($soil, 'Sesamo'), $this->idealValues['INCEPTISOL']['Sesamo'], $this->weights),
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
        Log::info('Cultivos recomendados antes de ordenar: ' . implode(', ', array_keys($crops)));
        $orderedCrops = collect($crops)->sortByDesc('suitability')->keys()->toArray();
        Log::debug('Cultivos después de ordenar: ' . implode(', ', $orderedCrops));
        $orderedCrops = $this->applyRotationRules($orderedCrops);
        return $orderedCrops;
    }
    private function getActualValues(Soil $soil, string $crop): array
    {
        $soilType = $soil->orden;
        if (!isset($this->idealValues[$soilType][$crop])) {
            throw new \InvalidArgumentException("No hay datos para el cultivo '$crop' en el tipo de suelo '$soilType'");
        }

        $actualValues = [
            'ph' => $soil->ph,
            'mo' => $soil->mo,
            'al3' => $soil->al3,
            'fosforo' => $soil->fosforo,
            'precipitacion_anual' => $soil->precipitacion_anual,
            'temperatura' => $soil->temperatura,
            'humedad' => $soil->humedad,
        ];

        // Usar valores ideales si los valores reales no están disponibles
        foreach ($actualValues as $key => &$value) {
            if ($value === null || $value === 0) {
                $value = $this->idealValues[$soilType][$crop][$key];
            }
        }

        return $actualValues;
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
        $maxDifference = 0.5 * $ideal;
        $difference = abs($actual - $ideal);
        if ($difference > $maxDifference) {
            return 0;
        }
        return 1 - pow($difference / $maxDifference, 2); // Función cuadrática para una penalización más suave
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
    private $familyGroups = [
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
        'Pedaliáceas' => ['Sesamo'],
        'Lamiáceas' => ['Menta'],
        'Asteráceas' => ['Girasol'],
        'Rubiáceas' => ['Tabaco'],
        'Esteviáceas' => ['Stevia'],
        'Fabáceas' => ['Tartago sin cáscara'],
    ];

    private $cropProperties = [
        'Soja' => ['family' => 'Leguminosas', 'nutrientDemand' => 'medium', 'rootDepth' => 'medium', 'nitrogenFixing' => true, 'soilImprovement' => 'high'],
        'Maíz' => ['family' => 'Gramíneas', 'nutrientDemand' => 'high', 'rootDepth' => 'deep', 'nitrogenFixing' => false, 'soilImprovement' => 'medium'],
        'Algodón' => ['family' => 'Malváceas', 'nutrientDemand' => 'high', 'rootDepth' => 'deep', 'nitrogenFixing' => false, 'soilImprovement' => 'low'],
        'Arroz secano' => ['family' => 'Gramíneas', 'nutrientDemand' => 'high', 'rootDepth' => 'shallow', 'nitrogenFixing' => false, 'soilImprovement' => 'low'],
        'Batata' => ['family' => 'Convolvuláceas', 'nutrientDemand' => 'medium', 'rootDepth' => 'medium', 'nitrogenFixing' => false, 'soilImprovement' => 'medium'],
        'Mandioca' => ['family' => 'Euforbiáceas', 'nutrientDemand' => 'low', 'rootDepth' => 'deep', 'nitrogenFixing' => false, 'soilImprovement' => 'medium'],
        'Maní' => ['family' => 'Leguminosas', 'nutrientDemand' => 'medium', 'rootDepth' => 'medium', 'nitrogenFixing' => true, 'soilImprovement' => 'high'],
        'Sorgo para grano' => ['family' => 'Gramíneas', 'nutrientDemand' => 'medium', 'rootDepth' => 'deep', 'nitrogenFixing' => false, 'soilImprovement' => 'medium'],
        'Menta' => ['family' => 'Lamiáceas', 'nutrientDemand' => 'medium', 'rootDepth' => 'shallow', 'nitrogenFixing' => false, 'soilImprovement' => 'low'],
        'Stevia' => ['family' => 'Asteráceas', 'nutrientDemand' => 'medium', 'rootDepth' => 'shallow', 'nitrogenFixing' => false, 'soilImprovement' => 'low'],
        'Tabaco' => ['family' => 'Solanáceas', 'nutrientDemand' => 'high', 'rootDepth' => 'medium', 'nitrogenFixing' => false, 'soilImprovement' => 'low'],
        'Girasol' => ['family' => 'Asteráceas', 'nutrientDemand' => 'high', 'rootDepth' => 'deep', 'nitrogenFixing' => false, 'soilImprovement' => 'medium'],
        'Trigo' => ['family' => 'Gramíneas', 'nutrientDemand' => 'medium', 'rootDepth' => 'medium', 'nitrogenFixing' => false, 'soilImprovement' => 'medium'],
        'Zanahoria' => ['family' => 'Apiáceas', 'nutrientDemand' => 'medium', 'rootDepth' => 'deep', 'nitrogenFixing' => false, 'soilImprovement' => 'medium'],
        'Poroto' => ['family' => 'Leguminosas', 'nutrientDemand' => 'low', 'rootDepth' => 'shallow', 'nitrogenFixing' => true, 'soilImprovement' => 'high'],
        'Ajo' => ['family' => 'Liliáceas', 'nutrientDemand' => 'medium', 'rootDepth' => 'shallow', 'nitrogenFixing' => false, 'soilImprovement' => 'low'],
        'Sesamo' => ['family' => 'Pedaliáceas', 'nutrientDemand' => 'medium', 'rootDepth' => 'medium', 'nitrogenFixing' => false, 'soilImprovement' => 'low'],
        'Arveja' => ['family' => 'Leguminosas', 'nutrientDemand' => 'low', 'rootDepth' => 'medium', 'nitrogenFixing' => true, 'soilImprovement' => 'high'],
        'Canola' => ['family' => 'Crucíferas', 'nutrientDemand' => 'high', 'rootDepth' => 'medium', 'nitrogenFixing' => false, 'soilImprovement' => 'medium'],
        'Cebolla de cabeza' => ['family' => 'Liliáceas', 'nutrientDemand' => 'medium', 'rootDepth' => 'shallow', 'nitrogenFixing' => false, 'soilImprovement' => 'low'],
        'Frutilla' => ['family' => 'Rosáceas', 'nutrientDemand' => 'medium', 'rootDepth' => 'shallow', 'nitrogenFixing' => false, 'soilImprovement' => 'low'],
        'Habilla' => ['family' => 'Leguminosas', 'nutrientDemand' => 'low', 'rootDepth' => 'medium', 'nitrogenFixing' => true, 'soilImprovement' => 'high'],
        'Locote' => ['family' => 'Solanáceas', 'nutrientDemand' => 'medium', 'rootDepth' => 'medium', 'nitrogenFixing' => false, 'soilImprovement' => 'low'],
        'Papa' => ['family' => 'Solanáceas', 'nutrientDemand' => 'high', 'rootDepth' => 'shallow', 'nitrogenFixing' => false, 'soilImprovement' => 'low'],
        'Tomate' => ['family' => 'Solanáceas', 'nutrientDemand' => 'high', 'rootDepth' => 'medium', 'nitrogenFixing' => false, 'soilImprovement' => 'low'],
        'Caña de azúcar' => ['family' => 'Gramíneas', 'nutrientDemand' => 'high', 'rootDepth' => 'deep', 'nitrogenFixing' => false, 'soilImprovement' => 'medium'],
        'Tartago sin cáscara' => ['family' => 'Euforbiáceas', 'nutrientDemand' => 'medium', 'rootDepth' => 'deep', 'nitrogenFixing' => false, 'soilImprovement' => 'low'],
    ];
    private function applyRotationRules(array $orderedCrops): array
    {
        $rotatedCrops = [];
        $familyHistory = [];
        $lastNutrientDemand = null;
        $lastRootDepth = null;
        $remainingCrops = $orderedCrops;

        while (!empty($remainingCrops)) {
            $bestCrop = null;
            $bestScore = -1;

            foreach ($remainingCrops as $key => $crop) {
                $score = $this->calculateRotationScore($crop, $rotatedCrops, $familyHistory, $lastNutrientDemand, $lastRootDepth);

                if ($score > $bestScore) {
                    $bestScore = $score;
                    $bestCrop = $crop;
                    $bestKey = $key;
                }
            }

            if ($bestCrop) {
                $rotatedCrops[] = $bestCrop;
                $familyHistory[$this->cropProperties[$bestCrop]['family']] = count($rotatedCrops) - 1;
                $lastNutrientDemand = $this->cropProperties[$bestCrop]['nutrientDemand'];
                $lastRootDepth = $this->cropProperties[$bestCrop]['rootDepth'];
                unset($remainingCrops[$bestKey]);
            }
        }

        return $rotatedCrops;
    }
    private function calculateRotationScore($crop, $rotatedCrops, $familyHistory, $lastNutrientDemand, $lastRootDepth)
    {
        $score = 0;
        $properties = $this->cropProperties[$crop];

        // Factor 1: Tiempo desde el último uso de la familia
        $timeSinceLastUsed = isset($familyHistory[$properties['family']]) ? count($rotatedCrops) - $familyHistory[$properties['family']] : PHP_INT_MAX;
        $score += $timeSinceLastUsed * 10;

        // Factor 2: Alternancia de demanda de nutrientes
        if ($lastNutrientDemand) {
            if ($lastNutrientDemand === 'high' && $properties['nutrientDemand'] === 'low') {
                $score += 30;
            } elseif ($lastNutrientDemand === 'low' && $properties['nutrientDemand'] === 'high') {
                $score += 20;
            } elseif ($lastNutrientDemand !== $properties['nutrientDemand']) {
                $score += 10;
            }
        }

        // Factor 3: Alternancia de profundidad de raíces
        if ($lastRootDepth && $lastRootDepth !== $properties['rootDepth']) {
            $score += 15;
        }

        // Factor 4: Beneficios para el suelo
        if ($properties['nitrogenFixing']) {
            $score += 25;
        }
        switch ($properties['soilImprovement']) {
            case 'high':
                $score += 20;
                break;
            case 'medium':
                $score += 10;
                break;
            case 'low':
                $score += 5;
                break;
        }

        // Factor 5: Priorizar cultivos de cobertura después de cultivos de alta demanda
        if ($lastNutrientDemand === 'high' && $properties['soilImprovement'] === 'high') {
            $score += 15;
        }

        return $score;
    }


    public function __construct()
    {
        // Precalcular el mapeo inverso de cultivos a familias para un acceso más rápido
        $this->cropToFamily = [];
        foreach ($this->familyGroups as $family => $crops) {
            foreach ($crops as $crop) {
                $this->cropToFamily[$crop] = $family;
            }
        }
    }

    private function getCropFamily(string $crop): ?string
    {
        return $this->cropToFamily[$crop] ?? null;
    }
}
