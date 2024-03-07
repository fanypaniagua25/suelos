<?php

namespace Modules\Coberturasuelos\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;
use Modules\Coberturasuelos\Models\Coberturasuelo;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class CoberturasuelosController extends Controller
{
    public function index()
    {
        $x['title']     = "Coberturasuelo";
        $x['data']      = Coberturasuelo::get();

        return view('coberturasuelos::index', $x);
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
            $coberturasuelo = Coberturasuelo::create([
                'name'      => $request->name
            ]);
            Alert::success('Pemberitahuan', 'Data <b>' . $coberturasuelo->name . '</b> berhasil dibuat')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Pemberitahuan', 'Data <b>' . $coberturasuelo->name . '</b> gagal dibuat : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function show(Request $request)
    {
        $coberturasuelo = Coberturasuelo::find($request->id);
        return response()->json([
            'status'    => Response::HTTP_OK,
            'message'   => 'Data coberturasuelo by id',
            'data'      => $coberturasuelo
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
            $coberturasuelo = Coberturasuelo::find($request->id);
            $coberturasuelo->update([
                'name'  => $request->name
            ]);
            Alert::success('Pemberitahuan', 'Data <b>' . $coberturasuelo->name . '</b> berhasil disimpan')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Pemberitahuan', 'Data <b>' . $coberturasuelo->name . '</b> gagal disimpan : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function destroy(Request $request)
    {
        try {
            $coberturasuelo = Coberturasuelo::find($request->id);
            $coberturasuelo->delete();
            Alert::success('Pemberitahuan', 'Data <b>' . $coberturasuelo->name . '</b> berhasil dihapus')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Pemberitahuan', 'Data <b>' . $coberturasuelo->name . '</b> gagal dihapus : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }
}
