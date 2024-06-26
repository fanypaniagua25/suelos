<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Soil;
use App\Service\CropRotationService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;


class SoilController extends Controller
{
    private $cropRotationService;

    public function __construct(CropRotationService $cropRotationService)
    {
        $this->cropRotationService = $cropRotationService;
    }

    public function calcular(Request $request)
    {
        try {
            $ordenSuelo = $request->input('ordenSuelo');
            Log::info('Orden de suelo recibida: ' . $ordenSuelo);

            // Crear una instancia del modelo Soil con la orden de suelo recibida
            $suelo = new Soil();
            $suelo->orden = $ordenSuelo;

            Log::info('Antes de llamar al servicio CropRotationService');

            // Obtener los cultivos recomendados utilizando el servicio CropRotationService
            $cultivosRecomendados = $this->cropRotationService->recommendCrops($suelo);

            Log::info('Después de llamar al servicio CropRotationService');
            Log::info('Cultivos recomendados: ' . implode(', ', $cultivosRecomendados));

            return response()->json($cultivosRecomendados);
        } catch (\Exception $e) {
            Log::error('Error en la función calcular: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Ocurrió un error al procesar la solicitud'], 500);
        }
    }
}
