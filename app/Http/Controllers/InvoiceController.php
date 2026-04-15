<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Stock;
use App\Vendor;
use App\Customer;
use App\Sell;
use App\SellDetails;
use App\Payment;
use App\Company;
use DB;
use Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        $category = Category::orderBy('name', 'asc')->get();
        $customer = Customer::orderBy('customer_name', 'asc')->get();
        $invoice_no = $this->getLastInvoice();

        return view('invoice.invoice', [
            'category' => $category,
            'customer' => $customer,
            'invoice_no' => $invoice_no,
        ]);
    }

    public function getLastInvoice()
    {
        $invoice = Sell::orderBy('id', 'desc')->first();

        if ($invoice) {
            return $invoice->id + 1;
        }

        return 1;
    }

    public function InvoiceList(Request $request)
    {
        $invoice = Sell::with([
            'customer' => function ($query) {
                $query->select('customer_name', 'id');
            },
            'user' => function ($query) {
                $query->select('name', 'id');
            }
        ])->orderBy('updated_at', 'desc');

        if ($request->invoice_id != '') {
            $invoice->where('id', '=', $request->invoice_id);
        }

        if ($request->customer_id != '') {
            $invoice->where('customer_id', '=', $request->customer_id);
        }

        if ($request->start_date != '' && $request->end_date != '') {
            $invoice->whereBetween('sell_date', [$request->start_date, $request->end_date]);
        }

        return $invoice->paginate(10);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'invoice_date' => 'required',
            'product.0.category' => 'required',
            'product.0.product_id' => 'required',
            'product.0.chalan_id' => 'required',
            'product.0.quantity' => 'required|integer|min:1',
            'product.0.price' => 'required|numeric|min:0',
        ], [
            'customer_id.required' => 'Debe seleccionar un cliente.',
            'invoice_date.required' => 'La fecha de la factura es obligatoria.',
            'product.0.category.required' => 'La categoría es obligatoria.',
            'product.0.product_id.required' => 'El producto es obligatorio.',
            'product.0.chalan_id.required' => 'El comprobante/lote es obligatorio.',
            'product.0.quantity.required' => 'La cantidad es obligatoria.',
            'product.0.price.required' => 'El precio es obligatorio.',
        ]);

        try {
            DB::beginTransaction();

            $customer_id = $request->customer_id;

            $invoice = new Sell;
            $invoice->user_id = Auth::user()->id;
            $invoice->customer_id = $customer_id;
            $invoice->branch_id = Auth::user()->branch_id;
            $invoice->total_amount = $request->grand_total ?? 0;
            $invoice->discount_amount = $request->total_discount ?? 0;
            $invoice->paid_amount = $request->paid_amount ?? 0;
            $invoice->sell_date = date("Y-m-d", strtotime($request->invoice_date));
            $invoice->payment_method = ($request->payment_info == 'bank') ? 2 : 1;
            $invoice->payment_status = (($request->paid_amount ?? 0) >= ($request->grand_total ?? 0)) ? 1 : 0;
            $invoice->save();

            foreach ($request->product as $value) {
                if (
                    empty($value['category']) &&
                    empty($value['product_id']) &&
                    empty($value['chalan_id'])
                ) {
                    continue;
                }

                $stock = Stock::find($value['chalan_id']);

                if (!$stock) {
                    continue;
                }

                $quantity = (int) $value['quantity'];
                $price = (float) $value['price'];
                $discount = isset($value['discount']) ? (float) $value['discount'] : 0;
                $discount_type = $value['discount_type'] ?? 'amount';

                $line_total = $quantity * $price;

                if ($discount_type == 'percent') {
                    $discount_amount = ($line_total * $discount) / 100;
                } else {
                    $discount_amount = $discount;
                }

                $total_price = $line_total - $discount_amount;

                $inv_details = new SellDetails;
                $inv_details->stock_id = $value['chalan_id'];
                $inv_details->sell_id = $invoice->id;
                $inv_details->product_id = $value['product_id'];
                $inv_details->category_id = $value['category'];
                $inv_details->customer_id = $customer_id;
                $inv_details->vendor_id = $stock->vendor_id;
                $inv_details->user_id = Auth::user()->id;
                $inv_details->chalan_no = $stock->chalan_no;
                $inv_details->selling_date = date("Y-m-d", strtotime($request->invoice_date));
                $inv_details->sold_quantity = $quantity;
                $inv_details->buy_price = $stock->buying_price;
                $inv_details->sold_price = $price;
                $inv_details->total_buy_price = $stock->buying_price * $quantity;
                $inv_details->total_sold_price = $total_price;
                $inv_details->discount = $discount;
                $inv_details->discount_type = $discount_type;
                $inv_details->discount_amount = $discount_amount;
                $inv_details->save();

                $stock->current_quantity = $stock->current_quantity - $quantity;
                $stock->save();
            }

            if (($request->paid_amount ?? 0) > 0) {
                $payment = new Payment;
                $payment->sell_id = $invoice->id;
                $payment->customer_id = $customer_id;
                $payment->user_id = Auth::user()->id;
                $payment->date = date("Y-m-d", strtotime($request->invoice_date));
                $payment->paid_in = $request->payment_in ?? 'Caja';
                $payment->bank_information = $request->bank_info ?? null;
                $payment->amount = $request->paid_amount;
                $payment->save();
            }

            DB::commit();

            return redirect()->route('invoice.index')->with('success', '¡Factura creada correctamente!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', '¡Algo salió mal al crear la factura!')->withInput();
        }
    }

    public function show($id)
    {
        $invoice = Sell::find($id);

        $invoice_details = SellDetails::with(['stock.category:id,name', 'stock.product:id,product_name'])
            ->where('sell_id', '=', $id)
            ->get();

        $payment = Payment::where('sell_id', '=', $id)->get();

        $company = Company::find(1);

        return view('invoice.print_invoice', [
            'invoice' => $invoice,
            'invoice_details' => $invoice_details,
            'payment' => $payment,
            'company' => $company,
        ]);
    }

    public function edit($id)
    {
        $sell = Sell::find($id);

        $invoice_details = SellDetails::where('sell_details.sell_id', '=', $id)->get();

        $arr = [
            'invoice_no' => $sell->id,
            'customer_id' => $sell->customer_id,
            'total_discount' => $sell->discount_amount,
            'total_amount' => $sell->total_amount + $sell->discount_amount,
            'invoice_date' => $sell->sell_date,
            'grand_total' => $sell->total_amount,
            'paid_amount' => $sell->paid_amount,
            'product' => []
        ];

        $product = [];
        foreach ($invoice_details as $key => $value) {
            $products = Product::where('category_id', '=', $value->category_id)->get();
            $stocks = Stock::where('product_id', '=', $value->product_id)->get();
            $product['id'] = $value->id;
            $product['category'] = $value->category_id;
            $product['product_id'] = $value->product_id;
            $product['chalan_id'] = $value->stock_id;
            $product['stock_quantity'] = 0;
            $product['quantity'] = $value->sold_quantity;
            $product['price'] = $value->sold_price;
            $product['total_price'] = $value->total_sold_price;
            $product['discount'] = $value->discount;
            $product['discount_type'] = $value->discount_type;
            $product['discount_amount'] = $value->discount_amount;
            $product['products'] = $products;
            $product['stocks'] = $stocks;

            array_push($arr['product'], $product);
        }

        return $arr;
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('invoice.index')->with('error', 'La edición avanzada se dejó pendiente en esta versión Blade.');
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $sell = Sell::find($id);

            if ($sell) {
                $sell->delete();
            }

            $details = SellDetails::where('sell_id', '=', $id)->get();

            foreach ($details as $value) {
                $stock = Stock::find($value->stock_id);

                if ($stock) {
                    $stock->current_quantity = $stock->current_quantity + $value->sold_quantity;
                    $stock->save();
                }
            }

            SellDetails::where('sell_id', '=', $id)->delete();
            Payment::where('sell_id', '=', $id)->delete();

            DB::commit();

            return response()->json(['status' => 'success', 'message' => '¡Factura eliminada!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => '¡Algo salió mal!']);
        }
    }
}