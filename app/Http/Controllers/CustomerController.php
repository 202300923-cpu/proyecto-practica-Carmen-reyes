<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;

        $customers = Customer::withCount([
            'sell AS total_amount' => function ($query) {
                $query->select(DB::raw("COALESCE(SUM(total_amount),0)"));
            },
            'sell AS total_paid_amount' => function ($query) {
                $query->select(DB::raw("COALESCE(SUM(paid_amount),0)"));
            },
        ])->orderBy('customer_name', 'asc');

        if ($name != '') {
            $customers->where('customer_name', 'LIKE', '%' . $name . '%');
        }

        if ($email != '') {
            $customers->where('email', 'LIKE', '%' . $email . '%');
        }

        if ($phone != '') {
            $customers->where('phone', 'LIKE', '%' . $phone . '%');
        }

        $customers = $customers->paginate(10);

        return view('customer.customer', compact('customers', 'name', 'email', 'phone'));
    }

    public function CustomerList(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;

        $customer = Customer::withCount([
            'sell AS total_amount' => function ($query) {
                $query->select(DB::raw("COALESCE(SUM(total_amount),0)"));
            },
            'sell AS total_paid_amount' => function ($query) {
                $query->select(DB::raw("COALESCE(SUM(paid_amount),0)"));
            },
        ])->orderBy('customer_name', 'asc');

        if ($name != '') {
            $customer->where('customer_name', 'LIKE', '%' . $name . '%');
        }

        if ($email != '') {
            $customer->where('email', 'LIKE', '%' . $email . '%');
        }

        if ($phone != '') {
            $customer->where('phone', 'LIKE', '%' . $phone . '%');
        }

        $customer = $customer->paginate(10);

        return $customer;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'email' => 'nullable|email|unique:customers',
            'phone' => 'nullable|numeric|unique:customers',
        ]);

        try {
            $customer = new Customer;
            $customer->customer_name = $request->customer_name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->save();

            return redirect()->route('customer.index')->with('success', 'Cliente agregado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', '¡Algo salió mal!');
        }
    }

    public function show(Customer $customer)
    {
        //
    }

    public function edit(Customer $customer)
    {
        return view('customer.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'required',
            'email' => 'nullable|email|unique:customers,email,' . $id,
            'phone' => 'nullable|numeric|unique:customers,phone,' . $id,
        ]);

        try {
            $customer = Customer::findOrFail($id);
            $customer->customer_name = $request->customer_name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->save();

            return redirect()->route('customer.index')->with('success', 'Información del cliente actualizada');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', '¡Algo salió mal!');
        }
    }

    public function destroy($id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $customer->delete();

            return redirect()->route('customer.index')->with('success', 'Cliente eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '¡Algo salió mal!');
        }
    }
}