<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Session;
use Auth;

class UserController extends Controller
{

    // LISTAR USUARIOS
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->name != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->email != '') {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        $users = $query->orderBy('id', 'desc')->get();

        return view('user.user', compact('users'));
    }

    // CREAR USUARIO
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->back()->with('success', 'Usuario creado correctamente');
    }

    // ELIMINAR USUARIO
    public function destroy($id)
    {
        User::find($id)->delete();

        return redirect()->back()->with('success', 'Usuario eliminado correctamente');
    }

    // LOGOUT
    public function logout()
    {
        Auth::logout();
        Session::forget('side_menu');
        return redirect('/');
    }

}