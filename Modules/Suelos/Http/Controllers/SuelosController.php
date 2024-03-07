<?php

namespace Modules\Suelos\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;
use Modules\Suelos\Models\Suelo;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class SuelosController extends Controller
{
    public function index()
    {
        $x['title']     = "Suelo";
        $x['data']      = Suelo::get();
        $x['taxonomia'] = '';

        $rutaArchivo = public_path('geojson\taxonomia.json');
        if (File::exists($rutaArchivo)) {

            $contenidoJSON = file_get_contents($rutaArchivo);
            $x['taxonomia'] = json_decode($contenidoJSON);
        }

        return view('suelos::index', $x);
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
            $suelo = Suelo::create([
                'name'      => $request->name
            ]);
            Alert::success('Atenci&oacute', 'Data <b>' . $suelo->name . '</b> berhasil dibuat')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Atenci&oacute', 'Data <b>' . $suelo->name . '</b> gagal dibuat : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function show(Request $request)
    {
        $suelo = Suelo::find($request->id);
        return response()->json([
            'status'    => Response::HTTP_OK,
            'message'   => 'Data suelo by id',
            'data'      => $suelo
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
            $suelo = Suelo::find($request->id);
            $suelo->update([
                'name'  => $request->name
            ]);
            Alert::success('Pemberitahuan', 'Data <b>' . $suelo->name . '</b> berhasil disimpan')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Pemberitahuan', 'Data <b>' . $suelo->name . '</b> gagal disimpan : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function destroy(Request $request)
    {
        try {
            $suelo = Suelo::find($request->id);
            $suelo->delete();
            Alert::success('Pemberitahuan', 'Data <b>' . $suelo->name . '</b> berhasil dihapus')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Pemberitahuan', 'Data <b>' . $suelo->name . '</b> gagal dihapus : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

}
