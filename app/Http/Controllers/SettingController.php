<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class SettingController extends Controller
{
    public function index()
    {
        $x['title']     = 'Configuraciones';
        $x['category']  = Setting::select('category')->groupBy('category')->get();
        return view('admin.setting', $x);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'string'],
            'role'      => ['required']
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        try {
            $setting = Setting::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => bcrypt($request->password)
            ]);
            $setting->assignRole($request->role);
            Alert::success('Atenci&oacute;n', 'Data <b>' . $setting->name . '</b> creado exitosamente')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Atenci&oacute;n', 'Data <b>' . $setting->name . '</b> no se pudo crear : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function show(Request $request)
    {
        $setting = Setting::find($request->id);
        return response()->json([
            'status'    => Response::HTTP_OK,
            'message'   => 'Data setting by id',
            'data'      => $setting
        ], Response::HTTP_OK);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key'       => ['required'],
            'value'     => ['required']
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }

        try {
            for ($i = 0; $i < count($request->key); $i++) {
                Setting::where(['key' => $request->key[$i]])->update(['value' => $request->value[$i]]);
            }
            Alert::success('Atenci&oacute;n', 'Configuración guardada exitosamente')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Atenci&oacute;n', 'La configuración no se pudo guardar : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function destroy(Request $request)
    {
        try {
            $setting = Setting::find($request->id);
            $setting->delete();
            Alert::success('Atenci&oacute;n', 'Data <b>' . $setting->name . '</b> borrado exitosamente')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Atenci&oacute;n', 'Data <b>' . $setting->name . '</b> no se pudo eliminar : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }
}
