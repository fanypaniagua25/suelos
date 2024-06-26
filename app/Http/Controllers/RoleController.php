<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    public function index()
    {
        $x['title']         = 'Roles';
        $x['data']          = Role::with('permissions')->get();
        $x['permission']    = Permission::orderBy('id', 'desc')->get();
        return view('admin.role', $x);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => ['required'],
            'guard_name'    => ['required'],
            'permissions'   => ['required', 'array'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();
        try {
            $role = Role::create([
                'name'          => $request->name,
                'guard_name'    => $request->guard_name,
            ]);
            $role->givePermissionTo($request->permissions);
            DB::commit();
            Alert::success('Atenci&oacute;n', 'Data <b>' . $role->name . '</b> creado exitosamente')->toToast()->toHtml();
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error('Atenci&oacute;n', 'Data <b>' . $role->name . '</b> fallo al crear : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function show(Request $request)
    {
        $role = Role::with('permissions')->find($request->id);
        return response()->json([
            'status'    => Response::HTTP_OK,
            'message'   => 'Data role by id',
            'data'      => $role
        ], Response::HTTP_OK);
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => ['required'],
            'guard_name'    => ['required'],
            'permissions'   => ['required', 'array'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();
        try {
            $role = Role::find($request->id);
            $role->update([
                'name'          => $request->name,
                'guard_name'    => $request->guard_name,
            ]);
            $role->syncPermissions($request->permissions);
            DB::commit();
            Alert::success('Atenci&oacute;n', 'Data <b>' . $role->name . '</b> Guardado exitosamente')->toToast()->toHtml();
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error('Atenci&oacute;n', 'Data <b>' . $role->name . '</b> error al guardar : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function destroy(Request $request)
    {
        try {
            $role = Role::find($request->id);
            $role->delete();
            Alert::success('Atenci&oacute;n', 'Data <b>' . $role->name . '</b> borrado exitosamente')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Atenci&oacute;n', 'Data <b>' . $role->name . '</b> no se pudo eliminar : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }
}
