<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bond;
use App\Models\Order;
use App\Models\OrderPayment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function store(Request $request, int $id){
        $bonds = Bond::find($id);
        $orders = new Order;
        $val = $bonds->interest_payment_date;
        $val2 =$bonds->issue_date;
        $orders->bond_number = $request->input('bond_number');


       $nbofsale = DB::table('orders')
              ->where('brand_id', $brandid)
              ->where('eodata', '>', Carbon::now()->startOfDay());
              ->get();

//         $orders->save();
        return $orders;
    }

    public function storePercent(Request $request, int $id){
        $bonds = Bond::find($id);
        $order_payment = Order::find($id);
        $order_payments = OrderPayment::find($id);

        $order_date = strtotime($order_payment->order_date);
        $order = strtotime($bonds->interest_payment_date);
        $startDate = Carbon::parse($order_date);
        $endDate   = Carbon::parse($order);
        $diff = $endDate->diffInDays($startDate);
        $faizler = ($bonds->nominal_price / 100 * $bonds->coupon_rate) / $bonds->calculation_period * $diff * $order_payment->bond_number;

        $order_payments->amount = $faizler;
        $order_payments->save();

        return $order_payments;

}

}
