<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reparacion;
use App\Customer;

class ReparacionController extends Controller
{
    public function index(Request $request)
    {
        $query = Reparacion::query();

        if ($request->buscar != '') {
            $query->where('etiqueta', 'like', '%' . $request->buscar . '%');
        }

        if ($request->cliente_id != '') {
            $query->where('cliente_id', $request->cliente_id);
        }

        $reparaciones = $query->orderBy('id', 'desc')->paginate(10);
        $clientes = Customer::orderBy('customer_name', 'asc')->get();

        return view('reparaciones.index', compact('reparaciones', 'clientes'));
    }

    public function show()
    {
        return Reparacion::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required',
            'equipo' => 'required',
            'problema' => 'required',
            'accesorios' => 'nullable',
            'fecha_ingreso' => 'required',
            'fecha_salida' => 'nullable',
            'responsable' => 'required',
        ], [
            'cliente_id.required' => 'Debe seleccionar un cliente.',
            'equipo.required' => 'El equipo es obligatorio.',
            'problema.required' => 'El problema es obligatorio.',
            'fecha_ingreso.required' => 'La fecha de ingreso es obligatoria.',
            'responsable.required' => 'El responsable es obligatorio.',
        ]);

        $ultimo = Reparacion::orderBy('id', 'desc')->first();

        if ($ultimo) {
            $numero = intval(substr($ultimo->etiqueta, 4)) + 1;
        } else {
            $numero = 1;
        }

        $etiqueta = 'REP-' . str_pad($numero, 3, '0', STR_PAD_LEFT);

        Reparacion::create([
            'etiqueta' => $etiqueta,
            'cliente_id' => $request->cliente_id,
            'equipo' => $request->equipo,
            'problema' => $request->problema,
            'encontrado' => $request->encontrado,
            'accesorios' => $request->accesorios,
            'estado' => $request->estado ?: 'pendiente',
            'fecha_ingreso' => $request->fecha_ingreso,
            'fecha_salida' => $request->fecha_salida,
            'responsable' => $request->responsable
        ]);

        return redirect()->back()->with('success', 'Reparación creada correctamente');
    }

    public function destroy($id)
    {
        $reparacion = Reparacion::find($id);

        if ($reparacion) {
            $reparacion->delete();
        }

        return redirect()->back()->with('success', 'Reparación eliminada correctamente');
    }

    public function estado(Request $request)
    {
        $rep = Reparacion::find($request->id);

        if ($rep) {
            $rep->estado = $request->estado;
            $rep->save();
        }

        return redirect()->back()->with('success', 'Estado actualizado correctamente');
    }
}