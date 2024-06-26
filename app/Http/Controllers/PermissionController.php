<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Nwidart\Modules\Facades\Module;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{
    public function index()
    {
        $x['title']     = 'Permisos';
        $x['data']      = Permission::get();
        return view('admin.permission', $x);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => ['required'],
            'guard_name'    => ['required'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        try {
            $permission = Permission::create([
                'name'          => $request->name,
                'guard_name'    => $request->guard_name,
            ]);
            Alert::success('Atenci&oacute;n', 'Data <b>' . $permission->name . '</b> creado exitosamente')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Atenci&oacute;n', 'Data <b>' . $permission->name . '</b> fallo al crear : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function show(Request $request)
    {
        $permission = Permission::find($request->id);
        return response()->json([
            'status'    => Response::HTTP_OK,
            'message'   => 'Data permission by id',
            'data'      => $permission
        ], Response::HTTP_OK);
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => ['required'],
            'guard_name'    => ['required'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        try {
            $permission = Permission::find($request->id);
            $permission->update([
                'name'          => $request->name,
                'guard_name'    => $request->guard_name,
            ]);
            Alert::success('Atenci&oacute;n', 'Data <b>' . $permission->name . '</b> guardado exitosamente')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Atenci&oacute;n', 'Data <b>' . $permission->name . '</b> error al guardar : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function destroy(Request $request)
    {
        try {
            $permission = Permission::find($request->id);
            $permission->delete();
            Alert::success('Atenci&oacute;n', 'Data <b>' . $permission->name . '</b> borrado exitosamente')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Atenci&oacute;n', 'Data <b>' . $permission->name . '</b> no se pudo eliminar : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }
    public function reloadPermission()
    {
        try {
            $this->initModules();
            Alert::success('Atenci&oacute;n', 'Permisos actualizados exitosamente')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Atenci&oacute;n', 'El permiso no se pudo actualizar : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    private function initModules()
    {
        $modules = Module::getOrdered();

        foreach ($modules as $module) {
            $moduleJson = json_decode(file_get_contents($module->getPath() . '/module.json', true));
            $permissions = $moduleJson->permissions;
            for ($i = 0; $i < count($permissions); $i++) {
                $permissionMappings = ['delete', 'update', 'read', 'create'];
                foreach ($permissionMappings as $permissionMapping) {
                    $name = $permissionMapping . ' ' . $permissions[$i];
                    $permission = Permission::where(['name' => $name])->count();
                    if ($permission == 0) {
                        Permission::create(['name' => $name]);
                    }
                }
            }
        }
    }
}
