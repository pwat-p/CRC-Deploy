<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRegisterRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public function index(Request $request) {
        return view('lineliff.customerRegister');
    }

    public function editIndex(Request $request) {
        return view('lineliff.customerEdit');
    }

    public function store(CustomerRegisterRequest $request) {
        $customer = new Customer();

        $customer->name = $request->input('name');
        $customer->profile = $request->input('profileUrl');
        $customer->address = $request->input('address');
        $customer->phone_number = $request->input('tel');
        $customer->email = $request->input('email');
        $customer->line_id = $request->input('lui');
        $customer->line_basic_id = $request->input('line_id');
        $customer->created_at = Carbon::now();

        $customer->save();
        return redirect()->to("https://liff.line.me/". config("liff.register_id") . "?success=true");
    }

    public function update(CustomerUpdateRequest $request) {
        $lui = $request->input('lui');
        $customerId = Customer::where('line_id', '=', $lui)->value('id');
        $customer = Customer::findorfail($customerId);
        $customer->name = $request->input('name');
        $customer->profile = $request->input('profileUrl');
        $customer->address = $request->input('address');
        $customer->phone_number = $request->input('tel');
        $customer->email = $request->input('email');
        $customer->line_basic_id = $request->input('line_id');

        $customer->save();
        return redirect()->to("https://liff.line.me/". config("liff.profile_edit_id") . "?success=true");
    }

    public function profile(Request $request) {
        $lui = $request->input('lui');
        $customerId = Customer::where('line_id', '=', $lui)->value('id');

        if (is_null($customerId)) {
            return 404;
        } else {
            $customer = Customer::findorfail($customerId);
            return response()->json($customer);
        }
    }
}
