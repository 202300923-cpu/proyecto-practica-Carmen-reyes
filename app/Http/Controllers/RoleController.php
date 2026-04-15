<?php

namespace App\Http\Controllers;

use App\Role;
use App\Menu;
use App\Permission;
use DB;
use Auth;
use Session;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('id', 'desc')->get();
        return view('user.role', compact('roles'));
    }

    public function RoleList()
    {
        $role = Role::all();
        return $role;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|unique:roles,role_name'
        ], [
            'role_name.required' => 'El nombre del rol es obligatorio.',
            'role_name.unique' => 'Ese rol ya existe.'
        ]);

        $role = new Role;
        $role->role_name = $request->role_name;
        $role->save();

        return redirect()->route('role.index')->with('success', 'Rol creado correctamente');
    }

    public function show($id)
    {
        $menu = Menu::select('id', 'name', 'parent_id')->orderBy('parent_id', 'asc')->get()->toArray();
        $permission = Permission::where('role_id', '=', $id)->pluck('menu_id')->toArray();

        $menus = [];

        foreach ($menu as $key => $value) {
            if (in_array($value['id'], $permission)) {
                $value['check'] = true;
            } else {
                $value['check'] = false;
            }

            array_push($menus, $value);
        }

        return makeNested($menus);
    }

    public function Permission(Request $request)
    {
        try {
            DB::beginTransaction();

            Permission::where('role_id', '=', $request->id)->delete();

            foreach ($request->menus as $key => $value) {
                if (count($value['sub_menu']) > 0) {
                    $flag = 0;

                    foreach ($value['sub_menu'] as $sub_menu) {
                        if ($sub_menu['check'] == true) {
                            $sub = new Permission;
                            $sub->role_id = $request->id;
                            $sub->menu_id = $sub_menu['id'];
                            $sub->save();

                            $flag = 1;
                        }
                    }

                    if ($flag == 1) {
                        $menu_per = new Permission;
                        $menu_per->role_id = $request->id;
                        $menu_per->menu_id = $value['id'];
                        $menu_per->save();

                        $flag = 0;
                    }
                } else {
                    if ($value['check'] == true) {
                        $parent_per = new Permission;
                        $parent_per->role_id = $request->id;
                        $parent_per->menu_id = $value['id'];
                        $parent_per->save();
                    }
                }
            }

            DB::commit();

            if (Auth::user()->role_id == $request->id) {
                Session::forget('side_menu');
                $permited_menu = sideMenu(Auth::user()->role_id);
                Session::push('side_menu', $permited_menu);
            }

            return response()->json(['status' => 'success', 'message' => 'New Permission Given']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => '¡Algo salió mal!']);
        }
    }

    public function edit(Role $role)
    {
        return $role;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'role_name' => 'required|unique:roles,role_name,' . $id
        ], [
            'role_name.required' => 'El nombre del rol es obligatorio.',
            'role_name.unique' => 'Ese rol ya existe.'
        ]);

        try {
            $role = Role::findOrFail($id);
            $role->role_name = $request->role_name;
            $role->save();

            return redirect()->route('role.index')->with('success', 'Rol actualizado correctamente');
        } catch (\Exception $e) {
            return redirect()->route('role.index')->with('error', '¡Algo salió mal!');
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return redirect()->route('role.index')->with('success', 'Rol eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->route('role.index')->with('error', '¡Algo salió mal!');
        }
    }

    public function userRole()
    {
        $role_id = Auth::user()->role_id;

        echo "<pre>";
        print_r(sideMenu($role_id));
        echo "</pre>";
    }
}