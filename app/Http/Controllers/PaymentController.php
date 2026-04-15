<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;
use App\Sell;
use App\SellDetails;
use Auth;
use DB;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'payment_date' => 'required',
            'payment_amount' => 'required|numeric',
            'payment_in' => 'required',
        ]);

        try {

            DB::beginTransaction();

            $sell = Sell::findOrFail($request->id);

            $payment = new Payment;

            // ✅ CORREGIDO AQUÍ
            $payment->sell_id = $request->id;
            $payment->customer_id = $sell->customer_id;
            $payment->user_id = Auth::id();
            $payment->date = date("Y-m-d", strtotime($request->payment_date));
            $payment->amount = $request->payment_amount;
            $payment->paid_in = $request->payment_in;
            $payment->bank_information = $request->bank_info;

            $payment->save();

            // ✅ ACTUALIZAR MONTO PAGADO
            $paid_amount = $sell->paid_amount + $request->payment_amount;

            if ($paid_amount >= $sell->total_amount) {
                $sell->payment_status = 1;
            }

            $sell->paid_amount = $paid_amount;
            $sell->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Pago guardado correctamente'
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() // 👈 para ver el error real
            ]);
        }
    }

    public function show($id)
    {
        $sell = Sell::with('customer')->find($id);
        $payment = Payment::with('user')->where('sell_id', $id)->get();

        return [
            'payment' => $payment,
            'invoice' => $sell
        ];
    }

    public function destroy($id)
    {
        try {

            DB::beginTransaction();

            $payment = Payment::findOrFail($id);
            $sell = Sell::findOrFail($payment->sell_id);

            $sell->paid_amount = $sell->paid_amount - $payment->amount;
            $sell->save();

            $payment->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Pago eliminado correctamente'
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}