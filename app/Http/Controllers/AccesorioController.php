<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;

class AccesorioController extends Controller
{
    // ✅ LISTAR + FILTRAR
    public function index(Request $request)
    {
        $query = Product::with('category');

        // 🔍 FILTRO POR CATEGORÍA
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // 🔍 FILTRO POR NOMBRE
        if ($request->name) {
            $query->where('product_name', 'LIKE', '%' . $request->name . '%');
        }

        $accesorios = $query->orderBy('id', 'desc')->get();

        // 🔽 PARA EL SELECT
        $categories = Category::orderBy('name', 'asc')->get();

        return view('accesorios.index', compact('accesorios', 'categories'));
    }

    // ✅ GUARDAR
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'product_name' => 'required',
            'details' => 'nullable',
        ]);

        $producto = new Product();
        $producto->category_id = $request->category_id;
        $producto->product_name = $request->product_name;
        $producto->details = $request->details;
        $producto->status = 1;
        $producto->save();

        return redirect()->back()->with('success', 'Accesorio creado correctamente');
    }

    // ✅ ELIMINAR
    public function destroy($id)
    {
        $producto = Product::find($id);

        if ($producto) {
            $producto->delete();
            return redirect()->back()->with('success', 'Accesorio eliminado correctamente');
        }

        return redirect()->back()->with('error', 'El accesorio no existe');
    }

    // ✅ ACTUALIZAR
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required',
            'product_name' => 'required',
            'details' => 'nullable',
        ]);

        $producto = Product::find($id);

        if ($producto) {
            $producto->category_id = $request->category_id;
            $producto->product_name = $request->product_name;
            $producto->details = $request->details;
            $producto->save();

            return redirect()->back()->with('success', 'Accesorio actualizado correctamente');
        }

        return redirect()->back()->with('error', 'El accesorio no existe');
    }

    // ✅ LISTA (AJAX)
    public function AccesoriosList()
    {
        return Product::with('category')->orderBy('id', 'desc')->get();
    }

    // ✅ FILTRAR POR CATEGORÍA (AJAX)
    public function accesoriosByCategory($id)
    {
        return Product::where('category_id', $id)
            ->orderBy('product_name', 'asc')
            ->get();
    }
}