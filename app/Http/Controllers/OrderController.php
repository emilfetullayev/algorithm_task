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
    public function store(Request $request){
        $mytime = Carbon::now();
        $mytimeConvert  = $mytime->toDateTimeString();
        $issue_value    = Bond::select('issue_date')->orderBy('issue_date', 'desc')->first();
        $turnover_value = Bond::select('turnover_date')->orderBy('turnover_date', 'desc')->first();

        $stringConvert  =  (string) $issue_value->issue_date;
        $stringConvert2 =  (string) $turnover_value->turnover_date;

        if($stringConvert < $mytimeConvert and $stringConvert2 > $mytimeConvert) {
              $orders = new Order();
              $orders->bond_number = $request->input('bond_number');
              $orders->save();
              return $orders;
        }
        else {
             echo "Alış tarixi Emissiya tarixindən az və Son tədavül tarixindən çox ola bilməz!";
        }
    }

    public function storePercent(Request $request, int $id) {
        $bonds = Bond::find($id);
        $order_find = Order::find($id);
        $order_payments = new OrderPayment();
        $result =  OrderPayment::all(['order_payment_date', 'amount']);

        $payment_date = OrderPayment::select('order_payment_date')->orderBy('order_payment_date', 'desc')->first();

        $order_date = strtotime($order_find->order_date);
        $interest_payment_date = strtotime($bonds->interest_payment_date);
        $startDate = Carbon::parse($order_date);
        $endDate   = Carbon::parse($interest_payment_date);
        $diff      = $endDate->diffInDays($startDate);

        if($payment_date != Null) {
           $stringConvert =  (string) $payment_date->order_payment_date;
           $check   = strtotime($stringConvert);
           if($check != Null) {
              $order_date = strtotime($order_find->order_date);
              $startDate = Carbon::parse($order_date);
              $endDate   = Carbon::parse($check);
              $diff      = $endDate->diffInDays($startDate);
           }
        }

        $rates = ($bonds->nominal_price / 100 * $bonds->coupon_rate) / $bonds->calculation_period * $diff * $order_find->bond_number;
        $order_payments->amount = $rates;
        $order_payments->save();

        return $order_payments;

    }

}

