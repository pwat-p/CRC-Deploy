<?php

namespace App\Http\Controllers;

use App\Models\RepairOrder;
use Illuminate\Http\Request;

class StatusPaymentController extends Controller
{
    public function timestampStatus(Request $request, $id)
    {
        $order = RepairOrder::findOrFail($id);
        if($order->customer == null)
        {
            return redirect()->back()->withErrors("ไม่ได้ผูก line user");
        }

        $order->car_received = $request->input('car_received');
        $order->in_queued = $request->input('in_queued');
        $order->repairing  = $request->input('repairing');
        $order->last_check  = $request->input('last_check');
        $order->cleaning  = $request->input('cleaning');
        $order->returning   = $request->input('returning');

        $order->save();
        LineController::notifyUser($order);
        return redirect()->route('repairOrder.show', ['repairOrder' => $id]);
    }

    public function setPayPrice(Request $request, $id)
    {
        $request->validate([
            'cost' => 'required|numeric|min:0'
        ]);
        $cost = $request->input('cost');
        $order = RepairOrder::findOrFail($id);
        $order->cost = $cost;
        $order->save();

        return redirect()->route('repairOrder.show', ['repairOrder' => $id]);
    }
}
