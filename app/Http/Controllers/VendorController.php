<?php

namespace App\Http\Controllers;

use App\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    // ✅ LISTAR + FILTRAR
    public function index(Request $request)
    {
        $query = Vendor::query();

        // 🔍 FILTRO POR NOMBRE
        if ($request->name) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        // 🔍 FILTRO POR EMAIL
        if ($request->email) {
            $query->where('email', 'LIKE', '%' . $request->email . '%');
        }

        // 🔍 FILTRO POR TELÉFONO
        if ($request->phone) {
            $query->where('phone', 'LIKE', '%' . $request->phone . '%');
        }

        $vendors = $query->orderBy('id', 'desc')->get();

        return view('vendor.vendor', compact('vendors'));
    }

    // ✅ GUARDAR
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|unique:vendors',
            'phone' => 'required|unique:vendors'
        ]);

        $vendor = new Vendor();
        $vendor->name = $request->name;
        $vendor->email = $request->email;
        $vendor->phone = $request->phone;
        $vendor->address = $request->address;
        $vendor->save();

        return redirect()->back()->with('success', 'Proveedor creado correctamente');
    }

    // ✅ EDITAR
    public function edit($id)
    {
        return Vendor::find($id);
    }

    // ✅ ACTUALIZAR
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required'
        ]);

        $vendor = Vendor::find($id);

        if (!$vendor) {
            return redirect()->back()->with('error', 'El proveedor no existe.');
        }

        $vendor->name = $request->name;
        $vendor->email = $request->email;
        $vendor->phone = $request->phone;
        $vendor->address = $request->address;
        $vendor->save();

        return redirect()->back()->with('success', 'Proveedor actualizado correctamente');
    }

    // ✅ ELIMINAR
    public function destroy($id)
    {
        $vendor = Vendor::find($id);

        if (!$vendor) {
            return redirect()->back()->with('error', 'El proveedor no existe.');
        }

        $vendor->delete();

        return redirect()->back()->with('success', 'Proveedor eliminado correctamente');
    }
}