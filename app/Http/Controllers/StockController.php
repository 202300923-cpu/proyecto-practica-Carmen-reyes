<?php

namespace App\Http\Controllers;

use App\Stock;
use App\Product;
use App\Vendor;
use App\SellDetails;
use App\Category;
use Illuminate\Http\Request;
use Auth;
use DB;

class StockController extends Controller
{
    public function index()
    {
        $vendor = Vendor::orderBy('name', 'asc')->get();
        $category = Category::orderBy('name', 'asc')->get();
        $product = Product::orderBy('product_name', 'asc')->get();

        return view('stock.stock', [
            'vendor' => $vendor,
            'category' => $category,
            'product' => $product,
        ]);
    }

    public function StockList(Request $request)
    {
        $stock = Stock::with([
            'product' => function ($query) {
                $query->select('id', 'product_name');
            },
            'vendor' => function ($query) {
                $query->select('id', 'name');
            },
            'user' => function ($query) {
                $query->select('id', 'name');
            },
            'category' => function ($query) {
                $query->select('id', 'name');
            }
        ])->orderBy('updated_at', 'desc');

        if ($request->category != '') {
            $stock->where('category_id', '=', $request->category);
        }

        if ($request->product != '') {
            $stock->where('product_id', '=', $request->product);
        }

        if ($request->vendor != '') {
            $stock->where('vendor_id', '=', $request->vendor);
        }

        return $stock->paginate(10);
    }

    public function ChalanList($id)
    {
        return Stock::where('product_id', '=', $id)
            ->where('current_quantity', '>', 0)
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
{
    $type      = $request->type;
    $from_date = $request->from_date;
    $to_date   = $request->to_date;
    $user_id   = $request->user_id;

    // Ejemplo simple (puedes adaptar después)
    $data = DB::table('sells')
        ->whereBetween('created_at', [$from_date, $to_date])
        ->where('user_id', $user_id)
        ->get();

    return view('report.result', compact('data','type','from_date','to_date'));
};

        try {
            $stock = new Stock;
            $stock->category_id = $request->category;
            $stock->product_id = $request->product;
            $stock->product_code = time();
            $stock->vendor_id = $request->vendor;
            $stock->user_id = Auth::user()->id;
            $stock->buying_price = $request->buying_price;
            $stock->selling_price = $request->selling_price;
            $stock->chalan_no = date('Y-m-d');
            $stock->stock_quantity = $request->quantity;
            $stock->current_quantity = $request->quantity;
            $stock->discount = 0;
            $stock->note = $request->note;
            $stock->status = 1;
            $stock->save();

            Stock::where('product_id', '=', $request->product)
                ->where('current_quantity', '>', 0)
                ->update(['selling_price' => $request->selling_price]);

            return redirect()->route('stock.index')->with('success', 'Producto añadido a existencias');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Problema para actualizar existencia')->withInput();
        }
    }

    public function show(Stock $stock)
    {
        return $stock;
    }

    public function edit($stock)
    {
        return Stock::with('product')->where('id', '=', $stock)->first();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required',
            'product' => 'required',
            'vendor' => 'required',
            'buying_price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'selling_price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
        ]);

        try {
            $stock = Stock::find($id);
            $stock->category_id = $request->category;
            $stock->product_id = $request->product;
            $stock->vendor_id = $request->vendor;
            $stock->buying_price = $request->buying_price;
            $stock->selling_price = $request->selling_price;
            $stock->note = $request->note;
            $stock->update();

            return response()->json(['status' => 'success', 'message' => 'Existencia actualizada']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Problema para actualizar existencia']);
        }
    }

    public function StockUpdate(Request $request)
    {
        $request->validate([
            'new_qty' => 'required|integer',
            'state' => 'required',
        ]);

        $stock = Stock::find($request->id);

        if ($request->state == '+') {
            $stock->current_quantity = $stock->current_quantity + $request->new_qty;
            $stock->stock_quantity = $stock->stock_quantity + $request->new_qty;
            $stock->update();

            return response()->json(['status' => 'success', 'message' => 'Cantidad actualizada']);
        } else {
            if ($request->new_qty > $stock->current_quantity) {
                return response()->json(['status' => 'error', 'message' => 'La cantidad es mayor que la cantidad actual']);
            } else {
                $stock->current_quantity = $stock->current_quantity - $request->new_qty;
                $stock->stock_quantity = $stock->stock_quantity - $request->new_qty;
                $stock->update();

                return response()->json(['status' => 'success', 'message' => 'Cantidad actualizada']);
            }
        }
    }

    public function destroy($id)
    {
        $check = SellDetails::where('stock_id', '=', $id)->count();

        if ($check > 0) {
            return response()->json(['status' => 'error', 'message' => 'Esta factura tiene registro de ventas, eliminar los artículos vendidos primero']);
        }

        try {
            Stock::where('id', '=', $id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => '¡Algo salió mal!']);
        }
    }
}