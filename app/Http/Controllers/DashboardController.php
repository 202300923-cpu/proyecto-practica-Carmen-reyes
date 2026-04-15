<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sell;
use App\SellDetails;
use App\Product;
use App\Stock;
use App\Category;
use App\Vendor;
use App\Customer;
use App\Accesorio;
use App\Reparacion;

class DashboardController extends Controller
{
    /**
     * Display dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total_invoice = Sell::count();
        $total_customer = Customer::count();
        $total_vendor = Vendor::count();
        $total_reparaciones = Reparacion::count();

        // Si tu sistema realmente usa Accesorio, usamos ese conteo
        $total_accesorios = class_exists(\App\Accesorio::class) ? Accesorio::count() : 0;

        $total_sold_amount = Sell::sum('total_amount');
        $total_paid_amount = Sell::sum('paid_amount');
        $total_outstanding = $total_sold_amount - $total_paid_amount;

        // Si todavía usas Product en alguna parte
        $total_product = class_exists(\App\Product::class) ? Product::count() : 0;

        $total_quantity = Stock::sum('stock_quantity');
        $total_sold_quantity = SellDetails::sum('sold_quantity');
        $total_current_quantity = $total_quantity - $total_sold_quantity;

        $total_buy_price = SellDetails::sum('total_buy_price');
        $total_gross_profit = $total_sold_amount - $total_buy_price;
        $total_net_profit = $total_paid_amount - $total_buy_price;

        return view('welcome', compact(
            'total_invoice',
            'total_customer',
            'total_vendor',
            'total_reparaciones',
            'total_accesorios',
            'total_sold_amount',
            'total_paid_amount',
            'total_outstanding',
            'total_product',
            'total_quantity',
            'total_sold_quantity',
            'total_current_quantity',
            'total_gross_profit',
            'total_net_profit'
        ));
    }

    public function InfoBox()
    {
        $total_invoice = Sell::count();
        $total_customer = Customer::count();
        $total_vendor = Vendor::count();
        $total_reparacion = Reparacion::count();
        $total_sold_amount = Sell::sum('total_amount');
        $total_paid_amount = Sell::sum('paid_amount');
        $total_outstanding = $total_sold_amount - $total_paid_amount;
        $total_product = Product::count();
        $total_quantity = Stock::sum('stock_quantity');
        $total_sold_quantity = SellDetails::sum('sold_quantity');
        $total_current_quantity = $total_quantity - $total_sold_quantity;

        $total_buy_price = SellDetails::sum('total_buy_price');
        $total_gross_profit = $total_sold_amount - $total_buy_price;
        $total_net_profit = $total_paid_amount - $total_buy_price;

        return response()->json([
            'total_invoice' => $total_invoice,
            'total_customer' => $total_customer,
            'total_vendor' => $total_vendor,
            'total_reparaciones' => $total_reparacion,
            'total_sold_amount' => round($total_sold_amount),
            'total_paid_amount' => round($total_paid_amount),
            'total_outstanding' => round($total_outstanding),
            'total_product' => $total_product,
            'total_quantity' => $total_quantity,
            'total_sold_quantity' => $total_sold_quantity,
            'total_current_quantity' => $total_current_quantity,
            'total_stock_quantity' => $total_current_quantity,
            'total_gross_profit' => round($total_gross_profit),
            'total_net_profit' => round($total_net_profit)
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}