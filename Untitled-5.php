<?php

namespace App\Service;

use App\Models\Soil;

class CropRotationService
{
    private $idealValues = [
        'ph' => 5.5,
        'mo' => 2.5,
        'al3' => 0.5,
        'fosforo' => 10,
        'precipitacion_anual' => 1000,
        'temperatura' => 25,
        'humedad' => 60,
    ];

    public function recommendCrops(Soil $soil): array
    {
        $crops = [];

        // Asignar valores predeterminados si alguna propiedad es nula
        $soil = $this->assignDefaultValues($soil);

        // Lógica para recomendar cultivos basada en las propiedades del suelo
        if ($soil->orden == 'ULTISOL') {
            $crops = [
                'Soja' => $this->calculateSuitability($this->getActualValues($soil, 'Soja')),
                'Maíz' => $this->calculateSuitability($this->getActualValues($soil, 'Maíz')),
                'Algodón' => $this->calculateSuitability($this->getActualValues($soil, 'Algodón')),
                'Arroz secano' => $this->calculateSuitability($this->getActualValues($soil, 'Arroz secano')),
                'Batata' => $this->calculateSuitability($this->getActualValues($soil, 'Batata')),
                'Mandioca' => $this->calculateSuitability($this->getActualValues($soil, 'Mandioca')),
                'Maní' => $this->calculateSuitability($this->getActualValues($soil, 'Maní')),
                'Sorgo para grano' => $this->calculateSuitability($this->getActualValues($soil, 'Sorgo para grano')),
                'Menta' => $this->calculateSuitability($this->getActualValues($soil, 'Menta')),
                'Stevia' => $this->calculateSuitability($this->getActualValues($soil, 'Stevia')),
                'Tabaco' => $this->calculateSuitability($this->getActualValues($soil, 'Tabaco')),
            ];
        } elseif ($soil->orden == 'ENTISOL') {
            $crops = [
                'Arroz secano' => $this->calculateSuitability($this->getActualValues($soil, 'Arroz secano')),
                'Maíz' => $this->calculateSuitability($this->getActualValues($soil, 'Maíz')),
                'Sorgo para grano' => $this->calculateSuitability($this->getActualValues($soil, 'Sorgo para grano')),
                'Soja' => $this->calculateSuitability($this->getActualValues($soil, 'Soja')),
                'Algodón' => $this->calculateSuitability($this->getActualValues($soil, 'Algodón')),
                'Girasol' => $this->calculateSuitability($this->getActualValues($soil, 'Girasol')),
                'Tabaco' => $this->calculateSuitability($this->getActualValues($soil, 'Tabaco')),
                'Sésamo' => $this->calculateSuitability($this->getActualValues($soil, 'Sésamo')),
                'Tartago sin cáscara' => $this->calculateSuitability($this->getActualValues($soil, 'Tartago sin cáscara')),
            ];
            //Arroz secano, Maíz, Sorgo para grano, Soja, Algodón, Girasol
        } elseif ($soil->orden == 'ALFISOL') {
            $crops = [
                'Ajo' => $this->calculateSuitability($this->getActualValues($soil, 'Ajo')),
                'Algodón' => $this->calculateSuitability($this->getActualValues($soil, 'Algodón')),
                'Arveja' => $this->calculateSuitability($this->getActualValues($soil, 'Arveja')),
                'Batata' => $this->calculateSuitability($this->getActualValues($soil, 'Batata')),
                'Canola' => $this->calculateSuitability($this->getActualValues($soil, 'Canola')),
                'Cebolla de cabeza' => $this->calculateSuitability($this->getActualValues($soil, 'Cebolla de Cabeza')),
                'Frutilla' => $this->calculateSuitability($this->getActualValues($soil, 'Frutilla')),
                'Girasol' => $this->calculateSuitability($this->getActualValues($soil, 'Girasol')),
                'Habilla' => $this->calculateSuitability($this->getActualValues($soil, 'Habilla')),
                'Locote' => $this->calculateSuitability($this->getActualValues($soil, 'Locote')),
                'Maíz' => $this->calculateSuitability($this->getActualValues($soil, 'Maíz')),
                'Maní' => $this->calculateSuitability($this->getActualValues($soil, 'Maní')),
                'Papa' => $this->calculateSuitability($this->getActualValues($soil, 'Papa')),
                'Poroto' => $this->calculateSuitability($this->getActualValues($soil, 'Poroto')),
                'Soja' => $this->calculateSuitability($this->getActualValues($soil, 'Soja')),
                'Sorgo para grano' => $this->calculateSuitability($this->getActualValues($soil, 'Sorgo para grano')),
                'Tomate' => $this->calculateSuitability($this->getActualValues($soil, 'Tomate')),
                'Trigo' => $this->calculateSuitability($this->getActualValues($soil, 'Trigo')),
                'Zanahoria' => $this->calculateSuitability($this->getActualValues($soil, 'Zanahoria')),
                'Tabaco' => $this->calculateSuitability($this->getActualValues($soil, 'Tabaco')),
                'Sésamo' => $this->calculateSuitability($this->getActualValues($soil, 'Sésamo')),
                'Tartago sin cáscara' => $this->calculateSuitability($this->getActualValues($soil, 'Tartago sin cáscara')),
            ];
            //Ajo, Algodón, Arveja, Batata, Canola, Cebolla de cabeza, Frutilla, Girasol, Habilla,
            // Locote, Maíz, Maní, Papa, Poroto, Soja, Sorgo para grano, Tomate, Trigo, Zanahoria

        } elseif ($soil->orden == 'OXISOL') {
            $crops = [
                'Caña de azúcar' => $this->calculateSuitability($this->getActualValues($soil, 'Caña de azúcar')),
                'Mandioca' => $this->calculateSuitability($this->getActualValues($soil, 'Mandioca')),
                'Soja' => $this->calculateSuitability($this->getActualValues($soil, 'Soja')),
                'Maní' => $this->calculateSuitability($this->getActualValues($soil, 'Maní')),
                'Algodón' => $this->calculateSuitability($this->getActualValues($soil, 'Algodón')),
                'Sorgo para grano' => $this->calculateSuitability($this->getActualValues($soil, 'Sorgo para grano')),
                'Tabaco' => $this->calculateSuitability($this->getActualValues($soil, 'Tabaco')),
                'Sésamo' => $this->calculateSuitability($this->getActualValues($soil, 'Sésamo')),
                'Tartago sin cáscara' => $this->calculateSuitability($this->getActualValues($soil, 'Tartago sin cáscara')),
            ];
            //Caña de azúcar, Mandioca, Soja, Maní, Algodón, Sorgo para grano,Tabaco,Sésamo,Tartago sin cáscara
        } elseif ($soil->orden == 'INCEPTISOL') {
            $crops = [
                'Ajo' => $this->calculateSuitability($this->getActualValues($soil, 'Ajo')),
                'Algodón' => $this->calculateSuitability($this->getActualValues($soil, 'Algodón')),
                'Arveja' => $this->calculateSuitability($this->getActualValues($soil, 'Arveja')),
                'Batata' => $this->calculateSuitability($this->getActualValues($soil, 'Batata')),
                'Canola' => $this->calculateSuitability($this->getActualValues($soil, 'Canola')),
                'Cebolla de cabeza' => $this->calculateSuitability($this->getActualValues($soil, 'Cebolla de Cabeza')),
                'Frutilla' => $this->calculateSuitability($this->getActualValues($soil, 'Frutilla')),
                'Girasol' => $this->calculateSuitability($this->getActualValues($soil, 'Girasol')),
                'Habilla' => $this->calculateSuitability($this->getActualValues($soil, 'Habilla')),
                'Locote' => $this->calculateSuitability($this->getActualValues($soil, 'Locote')),
                'Maíz' => $this->calculateSuitability($this->getActualValues($soil, 'Maíz')),
                'Maní' => $this->calculateSuitability($this->getActualValues($soil, 'Maní')),
                'Papa' => $this->calculateSuitability($this->getActualValues($soil, 'Papa')),
                'Poroto' => $this->calculateSuitability($this->getActualValues($soil, 'Poroto')),
                'Soja' => $this->calculateSuitability($this->getActualValues($soil, 'Soja')),
                'Sorgo para grano' => $this->calculateSuitability($this->getActualValues($soil, 'Sorgo para grano')),
                'Tomate' => $this->calculateSuitability($this->getActualValues($soil, 'Tomate')),
                'Trigo' => $this->calculateSuitability($this->getActualValues($soil, 'Trigo')),
                'Zanahoria' => $this->calculateSuitability($this->getActualValues($soil, 'Zanahoria')),
                'Tabaco' => $this->calculateSuitability($this->getActualValues($soil, 'Tabaco')),
                'Menta' => $this->calculateSuitability($this->getActualValues($soil, 'Menta')),
                'Sésamo' => $this->calculateSuitability($this->getActualValues($soil, 'Sésamo')),
            ];
        } elseif ($soil->orden == 'TIERRAS MISCELANEAS') {
            $crops = [
                'Algodón' => $this->calculateSuitability($this->getActualValues($soil, 'Algodón')),
                'Arroz secano' => $this->calculateSuitability($this->getActualValues($soil, 'Arroz secano')),
                'Batata' => $this->calculateSuitability($this->getActualValues($soil, 'Batata')),
                'Maíz' => $this->calculateSuitability($this->getActualValues($soil, 'Maíz')),
                'Mandioca' => $this->calculateSuitability($this->getActualValues($soil, 'Mandioca')),
                'Maní' => $this->calculateSuitability($this->getActualValues($soil, 'Maní')),
                'Sorgo para grano' => $this->calculateSuitability($this->getActualValues($soil, 'Sorgo para grano')),
                'Tabaco' => $this->calculateSuitability($this->getActualValues($soil, 'Tabaco')),
                'Menta' => $this->calculateSuitability($this->getActualValues($soil, 'Menta')),
                'Stevia' => $this->calculateSuitability($this->getActualValues($soil, 'Stevia')),
            ];
        }
            //Algodón, Arroz secano, Batata, Maíz, Mandioca, Maní, Sorgo para grano,Tabaco, Menta, Stevia

        // ... (resto del código para otras órdenes de suelo)
       
        //Ordenar la lista de cultivos por conveniencia
        return collect($crops)->sortByDesc('suitability')->keys()->toArray();
    }

    private function getActualValues(Soil $soil, string $crop): array
    {
        // Aquí puedes definir los valores actuales para cada cultivo según la orden de suelo
        // Por ejemplo:
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
                    return ['ph' => 6.3, 'mo' => 2.8, 'al3' => 0.4, 'fosforo' => 18, 'precipitacion_anual' => 1400, 'temperatura' => 21,'humedad' => 72];
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

        // Si no se encuentra un valor actual definido, se devuelven los valores ideales
        return $this->idealValues;
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

    private function calculateSuitability(array $actualValues): float
    {
        $suitability = 0;

        $suitability += $this->calculateSuitabilityFactor($actualValues['ph'], $this->idealValues['ph']);
        $suitability += $this->calculateSuitabilityFactor($actualValues['mo'], $this->idealValues['mo']);
        $suitability += $this->calculateSuitabilityFactor($actualValues['al3'], $this->idealValues['al3']);
        $suitability += $this->calculateSuitabilityFactor($actualValues['fosforo'], $this->idealValues['fosforo']);
        $suitability += $this->calculateSuitabilityFactor($actualValues['precipitacion_anual'], $this->idealValues['precipitacion_anual']);
        $suitability += $this->calculateSuitabilityFactor($actualValues['temperatura'], $this->idealValues['temperatura']);
        $suitability += $this->calculateSuitabilityFactor($actualValues['humedad'], $this->idealValues['humedad']);

        return $suitability;
    }

    private function calculateSuitabilityFactor(float $actual, float $ideal): float
    {
        $difference = abs($actual - $ideal);
        return 1 - ($difference / $ideal);
    }
}