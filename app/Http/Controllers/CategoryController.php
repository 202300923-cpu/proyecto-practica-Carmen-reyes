<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    // ✅ LISTAR + FILTRAR
    public function index(Request $request)
    {
        $query = Category::query();

        // 🔍 FILTRO POR NOMBRE
        if ($request->name) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        $categories = $query->orderBy('id', 'desc')->get();

        return view('category.category', compact('categories'));
    }

    // ✅ LISTA PARA AJAX (SI TU SISTEMA LA USA)
    public function CategoryList(Request $request)
    {
        $query = Category::query();

        if ($request->name) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        $categories = $query->orderBy('id', 'desc')->paginate(10);

        return response()->json($categories);
    }

    // ✅ TODAS LAS CATEGORÍAS
    public function AllCategory()
    {
        $categories = Category::orderBy('id', 'desc')->get();

        return response()->json($categories);
    }

    // ✅ GUARDAR
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ], [
            'name.required' => 'El nombre de la categoría es obligatorio.'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return redirect()->back()->with('success', 'Categoría creada correctamente');
    }

    // ✅ EDITAR (AJAX)
    public function edit($id)
    {
        $category = Category::find($id);

        if ($category) {
            return response()->json($category);
        }

        return response()->json('La categoría no existe');
    }

    // ✅ ACTUALIZAR
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ], [
            'name.required' => 'El nombre de la categoría es obligatorio.'
        ]);

        $category = Category::find($id);

        if ($category) {
            $category->name = $request->name;
            $category->save();

            return redirect()->back()->with('success', 'Categoría actualizada correctamente');
        }

        return redirect()->back()->with('error', 'La categoría no existe');
    }

    // ✅ ELIMINAR
    public function destroy($id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->delete();
            return redirect()->back()->with('success', 'Categoría eliminada correctamente');
        }

        return redirect()->back()->with('error', 'La categoría no existe');
    }
}