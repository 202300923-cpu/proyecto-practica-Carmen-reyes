<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reparacion;

class ReparacionController extends Controller
{

    public function index()
    {
        $reparaciones = Reparacion::all();
        return view('reparaciones.index', compact('reparaciones'));
    }

    public function show()
    {
        return Reparacion::all();
    }

    public function store(Request $request)
    {

        $ultimo = Reparacion::orderBy('id','desc')->first();

        if($ultimo){
            $numero = intval(substr($ultimo->etiqueta,4)) + 1;
        }else{
            $numero = 1;
        }

        $etiqueta = 'REP-'.str_pad($numero,3,'0',STR_PAD_LEFT);

        Reparacion::create([

            'etiqueta' => $etiqueta,
            'cliente_id' => $request->cliente_id,
            'equipo' => $request->equipo,
            'problema' => $request->problema,
            'encontrado' => $request->encontrado,
            'accesorios' => $request->accesorios,
            'estado' => 'pendiente',
            'fecha_ingreso' => $request->fecha_ingreso,
            'fecha_salida' => $request->fecha_salida,
            'responsable' => $request->responsable

        ]);

        return response()->json([
            'message' => 'Reparación creada'
        ]);

    }

    public function destroy($id)
    {

        Reparacion::find($id)->delete();

        return response()->json([
            'message' => 'Reparación eliminada'
        ]);

    }

    public function estado(Request $request)
    {

        $rep = Reparacion::find($request->id);

        $rep->estado = $request->estado;

        $rep->save();

        return response()->json([
            'message' => 'Estado actualizado'
        ]);

    }

}