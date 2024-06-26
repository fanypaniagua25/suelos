<?php

namespace App\Service;

use App\Models\Soil;

class CropRotationService
{
    private $soilData;

    public function __construct()
    {
        $this->soilData = json_decode(file_get_contents('path/to/soil_data.json'), true);
    }

    public function recommendCrops(string $soilType): array
    {
        $soil = new Soil($this->soilData[$soilType]);
        $crops = [];

        if ($soil->orden == 'ULTISOL') {
            $crops = [
                'Soja' => $this->calculateSuitability($soil, ['ph' => 6.2, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 25, 'humedad' => 70]),
                'Maíz' => $this->calculateSuitability($soil, ['ph' => 6.0, 'mo' => 3.1, 'al3' => 0.5, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 23, 'humedad' => 72]),
                'Algodón' => $this->calculateSuitability($soil, ['ph' => 6.2, 'mo' => 2.2, 'al3' => 0.7, 'fosforo' => 15, 'precipitacion_anual' => 1300, 'temperatura' => 25, 'humedad' => 68]),
                'Arroz secano' => $this->calculateSuitability($soil, ['ph' => 6.0, 'mo' => 3.2, 'al3' => 0.8, 'fosforo' => 15, 'precipitacion_anual' => 1450, 'temperatura' => 24, 'humedad' => 78]),
                'Batata' => $this->calculateSuitability($soil, ['ph' => 5.8, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 12, 'precipitacion_anual' => 1500, 'temperatura' => 25, 'humedad' => 70]),
                'Mandioca' => $this->calculateSuitability($soil, ['ph' => 5.5, 'mo' => 2.7, 'al3' => 0.8, 'fosforo' => 12, 'precipitacion_anual' => 1550, 'temperatura' => 24, 'humedad' => 75]),
                'Maní' => $this->calculateSuitability($soil, ['ph' => 6.2, 'mo' => 2.3, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1400, 'temperatura' => 25, 'humedad' => 70]),
                'Sorgo para grano' => $this->calculateSuitability($soil, ['ph' => 6.0, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1350, 'temperatura' => 24, 'humedad' => 72]),
                'Menta' => $this->calculateSuitability($soil, ['ph' => 6.0, 'mo' => 3.0, 'al3' => 0.3, 'fosforo' => 18, 'precipitacion_anual' => 1500, 'temperatura' => 21, 'humedad' => 75]),
                'Stevia' => $this->calculateSuitability($soil, ['ph' => 5.8, 'mo' => 2.6, 'al3' => 0.6, 'fosforo' => 14, 'precipitacion_anual' => 1500, 'temperatura' => 22, 'humedad' => 75]),
                'Tabaco' => $this->calculateSuitability($soil, ['ph' => 5.8, 'mo' => 2.7, 'al3' => 0.6, 'fosforo' => 18, 'precipitacion_anual' => 1400, 'temperatura' => 21, 'humedad' => 75]),
            ];
        }
        elseif ($soil->orden == 'ENTISOL') {
        $crops = [
            'Arroz secano' => $this->calculateSuitability($soil, ['ph' => 6.0, 'mo' => 3.2, 'al3' => 0.8, 'fosforo' => 15, 'precipitacion_anual' => 1450,'temperatura' => 24, 'humedad' => 78]),
            'Maíz' => $this->calculateSuitability($soil, ['ph' => 6.0, 'mo' => 3.1, 'al3' => 0.5, 'fosforo' => 16,'precipitacion_anual' => 1400,'temperatura' => 23,'humedad' => 72 ]),
            'Sorgo para grano' => $this->calculateSuitability($soil, ['ph' => 6.0, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1350, 'temperatura' => 24, 'humedad' => 72]),
            'Soja' => $this->calculateSuitability($soil, ['ph' => 6.2, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 16, 'precipitacion_anual' => 1400,'temperatura' => 25, 'humedad' => 70]),
            'Algodón' => $this->calculateSuitability($soil, ['ph' => 6.2, 'mo' => 2.2, 'al3' => 0.7, 'fosforo' => 15, 'precipitacion_anual' => 1300,'temperatura' => 25, 'humedad' => 68]),
            'Girasol' => $this->calculateSuitability($soil, ['ph' => 6.2, 'mo' => 2.4, 'al3' => 0.5, 'fosforo' => 15, 'precipitacion_anual' => 1350, 'temperatura' => 23, 'humedad' => 68]),
            'Tabaco' => $this->calculateSuitability($soil, ['ph' => 5.8, 'mo' => 2.7, 'al3' => 0.6, 'fosforo' => 18, 'precipitacion_anual' => 1400, 'temperatura' => 21, 'humedad' => 75]),
            'Sésamo' => $this->calculateSuitability($soil, ['ph' => 6.0, 'mo' => 2.2, 'al3' => 0.6, 'fosforo' => 13, 'precipitacion_anual' => 1350, 'temperatura' => 24, 'humedad' => 68]),
            'Tartago sin cáscara' => $this->calculateSuitability($soil, ['ph' => 6.1, 'mo' => 2.3, 'al3' => 0.5, 'fosforo' => 15, 'precipitacion_anual' => 1350, 'temperatura' => 23, 'humedad' => 70]),
       ];
        //Arroz secano, Maíz, Sorgo para grano, Soja, Algodón, Girasol
    } elseif ($soil->orden == 'ALFISOL') {
        $crops = [
            'Ajo' => $this->calculateSuitability($soil, ['ph' => 6.5, 'mo' => 3.0, 'al3' => 0.3, 'fosforo' => 20, 'precipitacion_anual' => 1600, 'temperatura' => 22, 'humedad' => 75]),
            'Algodón' => $this->calculateSuitability($soil, ['ph' => 6.2, 'mo' => 2.2, 'al3' => 0.7, 'fosforo' => 15, 'precipitacion_anual' => 1300,'temperatura' => 25, 'humedad' => 68]),
            'Algodón' => $this->calculateSuitability($soil, ['ph' => 6.2, 'mo' => 2.2, 'al3' => 0.7, 'fosforo' => 15, 'precipitacion_anual' => 1300,'temperatura' => 25, 'humedad' => 68]),
            'Arveja' => $this->calculateSuitability($soil, ['ph' => 6.3, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 18, 'precipitacion_anual' => 1400, 'temperatura' => 21, 'humedad' => 72]),

            'Batata' => $this->calculateSuitability($soil, ['ph' => 5.8, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 12, 'precipitacion_anual' => 1500,'temperatura' => 25, 'humedad' => 70]),
            'Canola' => $this->calculateSuitability($soil, ['ph' => 6.0, 'mo' => 2.2, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1400, 'temperatura' => 20, 'humedad' => 75]),
            'Cebolla de cabeza' => $this->calculateSuitability($soil, ['ph' => 6.5, 'mo' => 2.8, 'al3' => 0.2, 'fosforo' => 22, 'precipitacion_anual' => 1500, 'temperatura' => 22, 'humedad' => 72]),
            'Frutilla' => $this->calculateSuitability($soil, ['ph' => 5.5, 'mo' => 3.2, 'al3' => 0.4, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 20, 'humedad' => 75]),
            'Girasol' => $this->calculateSuitability($soil, ['ph' => 6.2, 'mo' => 2.4, 'al3' => 0.5, 'fosforo' => 15, 'precipitacion_anual' => 1350, 'temperatura' => 23, 'humedad' => 68]),
            'Habilla' => $this->calculateSuitability($soil, ['ph' => 6.0, 'mo' => 2.8, 'al3' => 0.3, 'fosforo' => 18, 'precipitacion_anual' => 1400, 'temperatura' => 21, 'humedad' => 72]),
            'Locote' => $this->calculateSuitability($soil, ['ph' => 6.3, 'mo' => 2.9, 'al3' => 0.4, 'fosforo' => 19, 'precipitacion_anual' => 1450, 'temperatura' => 24, 'humedad' => 70]),
            'Maíz' => $this->calculateSuitability($soil, ['ph' => 6.0, 'mo' => 3.1, 'al3' => 0.5, 'fosforo' => 16,'precipitacion_anual' => 1400,'temperatura' => 23,'humedad' => 72 ]),
            'Maní' => $this->calculateSuitability($soil, ['ph' => 6.2, 'mo' => 2.3, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1400, 'temperatura' => 25, 'humedad' => 70]),
            'Papa' => $this->calculateSuitability($soil, ['ph' => 5.8, 'mo' => 2.6, 'al3' => 0.6, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 18, 'humedad' => 78]),
            'Poroto' => $this->calculateSuitability($soil, ['ph' => 6.1, 'mo' => 2.9, 'al3' => 0.4, 'fosforo' => 17, 'precipitacion_anual' => 1450, 'temperatura' => 22, 'humedad' => 72]),
             'Soja' => $this->calculateSuitability($soil, ['ph' => 6.2, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 16, 'precipitacion_anual' => 1400,'temperatura' => 25, 'humedad' => 70]),

            'Sorgo para grano' => $this->calculateSuitability($soil, ['ph' => 6.0, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1350, 'temperatura' => 24, 'humedad' => 72]),
            'Tomate' => $this->calculateSuitability($soil, ['ph' => 6.3, 'mo' => 2.9, 'al3' => 0.3, 'fosforo' => 20, 'precipitacion_anual' => 1450, 'temperatura' => 22, 'humedad' => 72]),
            'Trigo' => $this->calculateSuitability($soil, ['ph' => 6.0, 'mo' => 2.6, 'al3' => 0.5, 'fosforo' => 15, 'precipitacion_anual' => 1300, 'temperatura' => 19, 'humedad' => 75]),
            'Zanahoria' => $this->calculateSuitability($soil, ['ph' => 6.2, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 18, 'precipitacion_anual' => 1400, 'temperatura' => 20, 'humedad' => 72]),
            'Tabaco' => $this->calculateSuitability($soil, ['ph' => 5.8, 'mo' => 2.7, 'al3' => 0.6, 'fosforo' => 18, 'precipitacion_anual' => 1400, 'temperatura' => 21, 'humedad' => 75]),
            'Sésamo' => $this->calculateSuitability($soil, ['ph' => 6.0, 'mo' => 2.2, 'al3' => 0.6, 'fosforo' => 13, 'precipitacion_anual' => 1350, 'temperatura' => 24, 'humedad' => 68]),
            'Tartago sin cáscara' => $this->calculateSuitability($soil, ['ph' => 6.1, 'mo' => 2.3, 'al3' => 0.5, 'fosforo' => 15, 'precipitacion_anual' => 1350, 'temperatura' => 23, 'humedad' => 70]),
       ];
        //Ajo, Algodón, Arveja, Batata, Canola, Cebolla de cabeza, Frutilla, Girasol, Habilla,
        // Locote, Maíz, Maní, Papa, Poroto, Soja, Sorgo para grano, Tomate, Trigo, Zanahoria

    } elseif ($soil->orden == 'OXISOL') {
        $crops = [
            'Caña de azúcar' => $this->calculateSuitability($soil, ['ph' => 6.2, 'mo' => 3.5, 'al3' => 0.3, 'fosforo' => 18, 'precipitacion_anual' => 1600, 'temperatura' => 24, 'humedad' => 80]),
            'Mandioca' => $this->calculateSuitability($soil, ['ph' => 5.5, 'mo' => 2.7, 'al3' => 0.8, 'fosforo' => 12, 'precipitacion_anual' => 1550, 'temperatura' => 24, 'humedad' => 75]),
             'Soja' => $this->calculateSuitability($soil, ['ph' => 6.2, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 16, 'precipitacion_anual' => 1400,'temperatura' => 25, 'humedad' => 70]),
            'Maní' => $this->calculateSuitability($soil, ['ph' => 6.2, 'mo' => 2.3, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1400, 'temperatura' => 25, 'humedad' => 70]),
            'Algodón' => $this->calculateSuitability($soil, ['ph' => 6.2, 'mo' => 2.2, 'al3' => 0.7, 'fosforo' => 15, 'precipitacion_anual' => 1300,'temperatura' => 25, 'humedad' => 68]),
            'Sorgo para grano' => $this->calculateSuitability($soil, ['ph' => 6.0, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1350, 'temperatura' => 24, 'humedad' => 72]),
            'Tabaco' => $this->calculateSuitability($soil, ['ph' => 5.8, 'mo' => 2.7, 'al3' => 0.6, 'fosforo' => 18, 'precipitacion_anual' => 1400, 'temperatura' => 21, 'humedad' => 75]),
            'Sésamo' => $this->calculateSuitability($soil, ['ph' => 6.0, 'mo' => 2.2, 'al3' => 0.6, 'fosforo' => 13, 'precipitacion_anual' => 1350, 'temperatura' => 24, 'humedad' => 68]),
            'Tartago sin cáscara' => $this->calculateSuitability($soil, ['ph' => 6.1, 'mo' => 2.3, 'al3' => 0.5, 'fosforo' => 15, 'precipitacion_anual' => 1350, 'temperatura' => 23, 'humedad' => 70]),
        ];
        //Caña de azúcar, Mandioca, Soja, Maní, Algodón, Sorgo para grano,Tabaco,Sésamo,Tartago sin cáscara
    } elseif ($soil->orden == 'INCEPTISOL') {
        $crops = [
            'Ajo' => $this->calculateSuitability($soil, ['ph' => 6.5, 'mo' => 3.0, 'al3' => 0.3, 'fosforo' => 20, 'precipitacion_anual' => 1600, 'temperatura' => 22, 'humedad' => 75]),
            'Algodón' => $this->calculateSuitability($soil, ['ph' => 6.2, 'mo' => 2.2, 'al3' => 0.7, 'fosforo' => 15, 'precipitacion_anual' => 1300,'temperatura' => 25, 'humedad' => 68]),
            'Arveja' => $this->calculateSuitability($soil, ['ph' => 6.3, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 18, 'precipitacion_anual' => 1400, 'temperatura' => 21, 'humedad' => 72]),
            'Batata' => $this->calculateSuitability($soil, ['ph' => 5.8, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 12, 'precipitacion_anual' => 1500,'temperatura' => 25, 'humedad' => 70]),
            'Canola' => $this->calculateSuitability($soil, ['ph' => 6.0, 'mo' => 2.2, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1400, 'temperatura' => 20, 'humedad' => 75]),
            'Cebolla de cabeza' => $this->calculateSuitability($soil, ['ph' => 6.5, 'mo' => 2.8, 'al3' => 0.2, 'fosforo' => 22, 'precipitacion_anual' => 1500, 'temperatura' => 22, 'humedad' => 72]),
            'Frutilla' => $this->calculateSuitability($soil, ['ph' => 5.5, 'mo' => 3.2, 'al3' => 0.4, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 20, 'humedad' => 75]),
            'Girasol' => $this->calculateSuitability($soil, ['ph' => 6.2, 'mo' => 2.4, 'al3' => 0.5, 'fosforo' => 15, 'precipitacion_anual' => 1350, 'temperatura' => 23, 'humedad' => 68]),
            'Habilla' => $this->calculateSuitability($soil, ['ph' => 6.0, 'mo' => 2.8, 'al3' => 0.3, 'fosforo' => 18, 'precipitacion_anual' => 1400, 'temperatura' => 21, 'humedad' => 72]),
            'Locote' => $this->calculateSuitability($soil, ['ph' => 6.3, 'mo' => 2.9, 'al3' => 0.4, 'fosforo' => 19, 'precipitacion_anual' => 1450, 'temperatura' => 24, 'humedad' => 70]),
            'Maíz' => $this->calculateSuitability($soil, ['ph' => 6.0, 'mo' => 3.1, 'al3' => 0.5, 'fosforo' => 16,'precipitacion_anual' => 1400,'temperatura' => 23,'humedad' => 72 ]),
            'Maní' => $this->calculateSuitability($soil, ['ph' => 6.2, 'mo' => 2.3, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1400, 'temperatura' => 25, 'humedad' => 70]),
            'Papa' => $this->calculateSuitability($soil, ['ph' => 5.8, 'mo' => 2.6, 'al3' => 0.6, 'fosforo' => 16, 'precipitacion_anual' => 1400, 'temperatura' => 18, 'humedad' => 78]),
            'Poroto' => $this->calculateSuitability($soil, ['ph' => 6.1, 'mo' => 2.9, 'al3' => 0.4, 'fosforo' => 17, 'precipitacion_anual' => 1450, 'temperatura' => 22, 'humedad' => 72]),
            'Soja' => $this->calculateSuitability($soil, ['ph' => 6.2, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 16, 'precipitacion_anual' => 1400,'temperatura' => 25, 'humedad' => 70]),
            'Sorgo para grano' => $this->calculateSuitability($soil, ['ph' => 6.0, 'mo' => 2.5, 'al3' => 0.5, 'fosforo' => 14, 'precipitacion_anual' => 1350, 'temperatura' => 24, 'humedad' => 72]),
            'Tomate' => $this->calculateSuitability($soil, ['ph' => 6.3, 'mo' => 2.9, 'al3' => 0.3, 'fosforo' => 20, 'precipitacion_anual' => 1450, 'temperatura' => 22, 'humedad' => 72]),
            'Trigo' => $this->calculateSuitability($soil, ['ph' => 6.0, 'mo' => 2.6, 'al3' => 0.5, 'fosforo' => 15, 'precipitacion_anual' => 1300, 'temperatura' => 19, 'humedad' => 75]),
            'Zanahoria' => $this->calculateSuitability($soil, ['ph' => 6.2, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 18, 'precipitacion_anual' => 1400, 'temperatura' => 20, 'humedad' => 72]),
            'Tabaco' => $this->calculateSuitability($soil, ['ph' => 5.8, 'mo' => 2.7, 'al3' => 0.6, 'fosforo' => 18, 'precipitacion_anual' => 1400, 'temperatura' => 21, 'humedad' => 75]),
            'Menta' => $this->calculateSuitability($soil, ['ph' => 6.0, 'mo' => 3.0, 'al3' => 0.3, 'fosforo' => 18, 'precipitacion_anual' => 1500, 'temperatura' => 21, 'humedad' => 75]),
            'Sésamo' => $this->calculateSuitability($soil, ['ph' => 6.0, 'mo' => 2.2, 'al3' => 0.6, 'fosforo' => 13, 'precipitacion_anual' => 1350, 'temperatura' => 24, 'humedad' => 68]),
        ]; }

        return collect($crops)->sortByDesc('suitability')->keys()->toArray();
    }

    private function calculateSuitability(Soil $soil, array $idealValues): float
    {
        $suitability = 0;
        $suitability += $this->calculateSuitabilityFactor($soil->ph, $idealValues['ph']);
        $suitability += $this->calculateSuitabilityFactor($soil->mo, $idealValues['mo']);
        $suitability += $this->calculateSuitabilityFactor($soil->al3, $idealValues['al3']);
        $suitability += $this->calculateSuitabilityFactor($soil->fosforo, $idealValues['fosforo']);
        $suitability += $this->calculateSuitabilityFactor($soil->precipitacion_anual, $idealValues['precipitacion_anual']);
        $suitability += $this->calculateSuitabilityFactor($soil->temperatura, $idealValues['temperatura']);
        $suitability += $this->calculateSuitabilityFactor($soil->humedad, $idealValues['humedad']);

        return $suitability;
    }

    private function calculateSuitabilityFactor(float $actual, float $ideal): float
    {
        $difference = abs($actual - $ideal);
        return 1 - ($difference / $ideal);
    }
}