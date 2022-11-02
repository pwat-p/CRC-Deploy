<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RepairOrder;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    public function show($id)
    {
        $order = RepairOrder::findOrFail($id);

        return $order;
    }
}
