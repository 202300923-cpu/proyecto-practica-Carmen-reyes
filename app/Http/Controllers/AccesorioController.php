<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccesorioController extends Controller
{
    public function index()
    {
        return view('accesorios.index');
    }

    public function destroy($id)
    {
        // eliminar accesorio
    }

    public function update(Request $request, $id)
    {
        // actualizar accesorio
    }

    public function AccesoriosList()
    {
        // listar accesorios
    }

    public function accesoriosByCategory($id)
    {
        // accesorios por categoría
    }
}