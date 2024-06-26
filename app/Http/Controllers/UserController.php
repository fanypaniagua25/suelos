<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;




class UserController extends Controller
{
    public function index()
    {
        $x['title']     = 'Usuarios';
        $x['data']      = User::get();
        $x['role']      = Role::get();
        return view('admin.user', $x);
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
        DB::beginTransaction();
        try {
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => bcrypt($request->password)
            ]);
            $user->assignRole($request->role);
            DB::commit();
            Alert::success('Atencion', 'Data <b>' . $user->name . '</b> creado exitosamente')->toToast()->toHtml();
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error('Atencion', 'Data <b>' . $user->name . '</b> fallo al crear : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function show(Request $request)
    {
        $user = UserResource::collection(User::where(['id' => $request->id])->get());
        return response()->json([
            'status'    => Response::HTTP_OK,
            'message'   => 'Data user by id',
            'data'      => $user[0]
        ], Response::HTTP_OK);
    }

    public function update(Request $request)
    {
        $rules = [
            'name'      => ['required', 'string', 'max:255'],
            'password'  => ['nullable', 'string'],
            'role'      => ['required']
        ];

        if ($request->email != $request->old_email) {
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users'];
            $validator = Validator::make($request->all(), $rules);
        } else {
            $rules['email'] = ['required', 'string', 'email', 'max:255'];
            $validator = Validator::make($request->all(), $rules);
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
        ];
        if (!empty($request->password)) {
            $data['password']   = bcrypt($request->password);
        }

        DB::beginTransaction();
        try {
            $user = User::find($request->id);
            $user->update($data);
            $user->syncRoles($request->role);
            DB::commit();
            Alert::success('Atencion', 'Data <b>' . $user->name . '</b> guardado correctamente')->toToast()->toHtml();
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error('Atencion', 'Data <b>' . $user->name . '</b> error al guardar : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

    public function destroy(Request $request)
    {
        try {
            $user = User::find($request->id);
            $user->delete();
            Alert::success('Atenci&oacute;n', 'Data <b>' . $user->name . '</b>borrado exitosamente')->toToast()->toHtml();
        } catch (\Throwable $th) {
            Alert::error('Atenci&oacute;n', 'Data <b>' . $user->name . '</b> no se pudo eliminar: ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }
    public function obtener(Request $request)
    {
        if ($request->user()) {
            $role = $request->user()->roles->first();
            return response()->json(['role' => $role ? $role->name : null]);
        }
    }

}
