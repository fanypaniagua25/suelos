<?php

namespace Modules\Cultivos\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;
use Modules\Cultivos\Models\Cultivo;
use App\Models\Soil;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;
use App\Service\CropRotationService;
use Illuminate\Support\Arr;


class CultivosController extends Controller
{
    private $cropRotationService;

    public function __construct(CropRotationService $cropRotationService)
    {
        $this->cropRotationService = $cropRotationService;
    }
    public function index()
    {
        $x['title']     = "Cultivo";
        $x['data']      = Cultivo::get();

        return view('cultivos::index', $x);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => ['required', 'string', 'max:255']
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        try {
            $cultivo = Cultivo::create([
                'name'      => $request->name
            ]);
            Alert::success('Pemberitahuan', 'Data <b>' . $cultivo->name . '</b> berhasil dibuat')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Pemberitahuan', 'Data <b>' . $cultivo->name . '</b> gagal dibuat : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function show($id)
    {
        $cultivo = Cultivo::find($id);
        if (!$cultivo) {
            return response()->json([
                'status'    => Response::HTTP_NOT_FOUND,
                'message'   => 'Data cultivo not found',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status'    => Response::HTTP_OK,
            'message'   => 'Data cultivo by id',
            'data'      => $cultivo
        ], Response::HTTP_OK);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => ['required', 'string', 'max:255']
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        try {
            $cultivo = Cultivo::find($request->id);
            $cultivo->update([
                'name'  => $request->name
            ]);
            Alert::success('Pemberitahuan', 'Data <b>' . $cultivo->name . '</b> berhasil disimpan')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Pemberitahuan', 'Data <b>' . $cultivo->name . '</b> gagal disimpan : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function destroy(Request $request)
    {
        try {
            $cultivo = Cultivo::find($request->id);
            $cultivo->delete();
            Alert::success('Pemberitahuan', 'Data <b>' . $cultivo->name . '</b> berhasil dihapus')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Pemberitahuan', 'Data <b>' . $cultivo->name . '</b> gagal dihapus : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }
    public function showCropRotationModal(Request $request)
    {
        // Obtener los datos del suelo desde la base de datos o cualquier otra fuente
        $soil = Soil::findOrFail($request->input('soil_id'));

        // Obtener los cultivos recomendados del servicio
        $recommendedCrops = $this->cropRotationService->recommendCrops($soil);

        // Pasar los cultivos recomendados a la vista
        return view('modal.crop_rotation', compact('recommendedCrops'));
    }
    public function calculateCropRotation(Request $request)
    {
        $district = $request->input('district');
        $soilOrder = $request->input('soilOrder');
        $currentCrop = $request->input('currentCrop');

        // Obtener el objeto Soil correspondiente al distrito y al orden de suelo
        // Obtener los datos de distritos desde el JSON
        $distritosData = json_decode(file_get_contents(base_path('path/to/your/distritos.json')), true);

        // Obtener los datos de taxonomía de suelos desde el JSON
        $suelosData = json_decode(file_get_contents(base_path('path/to/your/taxonomia.json')), true);

        // Buscar el distrito seleccionado en los datos de distritos
        $distritoSeleccionado = array_filter($distritosData, function ($distrito) use ($district) {
            return $distrito['DIST_DESC'] === $district;
        });

        if ($distritoSeleccionado) {
            $distritoSeleccionado = reset($distritoSeleccionado);

            // Filtrar los datos de suelos por el distrito y el orden de suelo seleccionados
            $suelosDelDistrito = array_filter($suelosData, function ($suelo) use ($distritoSeleccionado, $soilOrder) {
                return $suelo['DISTRITO'] === $distritoSeleccionado['DISTRITO'] && $suelo['ORDEN'] === $soilOrder;
            });

            if ($suelosDelDistrito) {
                $sueloSeleccionado = reset($suelosDelDistrito);

                $cropRotationService = new CropRotationService();
                $recommendedCrops = $cropRotationService->recommendCrops($sueloSeleccionado);

                // Mover el cultivo actual al final de la rotación
                $currentCropIndex = array_search($currentCrop, $recommendedCrops);
                if ($currentCropIndex !== false) {
                    array_splice($recommendedCrops, $currentCropIndex, 1);
                    array_push($recommendedCrops, $currentCrop);
                }

                return response()->json([
                    'success' => true,
                    'crops' => $recommendedCrops,
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'No se encontró el suelo para el distrito y orden seleccionados',
        ]);
    }
    public function getRecommendedCrops(Request $request, CropRotationService $cropRotationService)
    {
        $distritoId = $request->input('distritoId');
        $orden = $request->input('orden');

        // Obtener los datos JSON de los distritos
        $distritosJson = json_decode(file_get_contents(resource_path('js2/data/Distritos_Caaguazu_4.js')), true);

        // Encontrar el distrito correspondiente al distritoId
        $distritoObj = Arr::first($distritosJson['features'], function ($distrito) use ($distritoId) {
            return $distrito['properties']['DISTRITO'] == $distritoId;
        });

        if (!$distritoObj) {
            return response()->json([], 404);
        }

        // Obtener los datos JSON de la taxonomía de suelos
        $suelosJson = json_decode(file_get_contents(resource_path('js2/data/Taxonomiadesuelos_DeptoCaaguazucopiar_2.js')), true);

        // Filtrar los suelos por el distrito y orden seleccionados
        $suelosData = array_filter($suelosJson['features'], function ($suelo) use ($distritoObj, $orden) {
            return $suelo['properties']['DISTRITO'] == $distritoObj['properties']['DISTRITO'] && $suelo['properties']['ORDEN'] == $orden;
        });

        // Crear un objeto Soil a partir de los datos filtrados
        $soil = (object) array_merge(...array_map(function ($suelo) {
            return $suelo['properties'];
        }, $suelosData));

        // Obtener los cultivos recomendados
        $recommendedCrops = $cropRotationService->recommendCrops($soil);

        return response()->json($recommendedCrops);
    }
}
