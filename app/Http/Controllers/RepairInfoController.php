<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RepairOrder;
use App\Models\Customer;

class RepairInfoController extends Controller
{
    public function index(Request $request)
    {
        return view('lineliff.repairInfo');
    }

    public function getRepairInfo(Request $request) {

        $userId = $request->get('lui');
        $customerId = Customer::where('line_id', '=', $userId)->value('id');
        if (is_null($customerId)) {
            $order_list = array('status' => 404);
        } else {
            $name = Customer::where('line_id', '=', $userId)->value('name');
            $car_list = RepairOrder::where('customer_id', '=', $customerId)->orderBy('created_at', 'desc')->get('car_registration');
            $order_list = array('status' => 200, 'lui' => $userId, 'name' => $name);
            foreach ($car_list as $car) {
                $regis = $car['car_registration'];
                if (!in_array($regis, $order_list)) {
                    $vin = RepairOrder::where('car_registration', '=', $regis)->value('vin');
                    $repair_order = RepairOrder::where('car_registration', '=', $regis)->orderBy('created_at', 'desc')->select('created_at','repair_list')->get();

                    $repair_list = array();
                    foreach ($repair_order as $order) {
                        $date = $order['created_at'];
                        if (!in_array($date, $repair_list)) {
                            $repair_list[strval($date)] = $order['repair_list'];
                        }
                    }
                    $order_list['car_list'][$regis] = array('vin' => $vin, 'repair_list' => $repair_list);
                }
            }
        }
        return response()->json($order_list);
    }

    public function getCarInfo(Request $request) {
        $carId = $request->get('cid');
        $carRegis = RepairOrder::where('id', '=', $carId)->value('car_registration');
        $vin = RepairOrder::where('id', '=', $carId)->value('vin');

        $arr = array('cid' => $carId, 'vin' => $vin,  'car_registration' => $carRegis);

        return response()->json($arr);
    }

    public function connect(Request $request) {
        $customerId = Customer::where('line_id', '=', $request->input('lui'))->value('id');
        $order = RepairOrder::findOrFail($request->input('id'));
        $order->customer_id = $customerId;
        $order->save();

        LineController::sendConnectStatus($request->input('lui'), $order['car_registration']);
        LineController::notifyUser($order);

        return redirect()->to("https://liff.line.me/" . config("liff.car_register_id") . "?success=true");
    }

}
