<?php

namespace App\Http\Controllers;

use App\Models\TaxonomiaSueloCaaguazu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TaxonomiaSueloCaaguazuController extends Controller
{
    public function index()
    {
        $x['title']     = "Taxonomia";
        $x['data']      = TaxonomiaSueloCaaguazu::get();

        return view('TaxonomiaSueloCaaguazu::index', $x);
    }

    public function guardarcambios(Request $request)
    {
        try {
            Log::info('Entró al método guardarcambios');

            // Agrega este log para verificar el contenido de la solicitud
            Log::info('Contenido de la solicitud:', $request->all());
            Log::info('Datos recibidos en el controlador: ', $request->all());
            // Validación
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'desc' => 'required',
                'orden' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => 'Error de validación', 'errors' => $validator->errors()], 422);
            }

            $idActualizar = $request->input('id');
            $nuevaDesc = $request->input('desc');
            $nuevoOrden = $request->input('orden');

            Log::info('Datos recibidos: ', [
                'id' => $idActualizar,
                'desc' => $nuevaDesc,
                'orden' => $nuevoOrden,
            ]);

            // Actualizar la base de datos utilizando el como clave primaria
            $registro = TaxonomiaSueloCaaguazu::find($idActualizar);
            if ($registro) {
                Log::info('Registro encontrado. Aplicando cambios.');

                $registro->desc = $nuevaDesc;
                $registro->orden = $nuevoOrden;
                $registro->save();

                Log::info('Cambios aplicados correctamente.');
            } else {
                Log::info('Registro no encontrado.');
            }

            return response()->json(['message' => 'Datos actualizados correctamente'], 200);
        } catch (\Exception $e) {
            $errorMessage = 'Error en el controlador guardar: ' . $e->getMessage();
            Log::error($errorMessage);
            Log::error('Excepción completa: ' . $e);

            return response()->json(['error' => $errorMessage], 500);
        }
    }
    public function cargar()
    {
        $rutaArchivo = public_path('geojson\taxonomia.json');
        if (File::exists($rutaArchivo)) {

            $contenidoJSON = file_get_contents($rutaArchivo);

            $array = json_decode($contenidoJSON,true);

            $id = 5;
            $nuevoValor = "Prueba de cambio";
            $array['features'] = $this->replaceFeatures($id, $array['features'], $nuevoValor);
            unlink($rutaArchivo);
            // dd(file_put_contents($rutaArchivo,json_encode($array)));
            Storage::disk('local')->put('geojson\taxonomia.json', 'json_encode($array)');
            return response()->json(['taxonomia'=>$array]);
        } else {
            return response()->json(['error' => 'El archivo JSON no existe'], 404);
        }
    }

    private function replaceFeatures ($id, $features, $newVal){
        foreach ($features as $key => $feature) {
            if($id == $feature['properties']['ID']){
                $features[$key]['properties']['DESC'] = $newVal;

                return $features;
            }
        }

        return $features;
    }


}
