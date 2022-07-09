<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bond;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Scheduling\Schedule;
use Carbon\Carbon;

class BondController extends Controller
{
   public function index(int $id) {
        $bonds =   Bond::find($id);
        $bond[] =  Bond::find($id, ['issue_date','interest_payment_date','turnover_date']);
        $orders = Order::all();
        $period =  $bonds->calculation_period;
        $payment_frequency =  $bonds->payment_frequency;
        $ad = $bonds->turnover_date;

        switch ($period) {
           case 360:
               $period = 12 / $payment_frequency * 30;
               break;
           case 364:
               $period = 364 / $payment_frequency;
               break;
           case 365:
               $period = 12 / $payment_frequency;
               break;
        }

        $addDays=Carbon::parse($bonds->issue_date)->addDays($period);
        $weekDay=Carbon::parse($bonds->issue_date)->addDays($period)->format('D');

        if($weekDay == 'Sun') {
           $addDays=Carbon::parse($bonds->issue_date)->addDays($period+1);
        }

        $bonds->interest_payment_date = $addDays;
        $bonds->save();
        return $bond;

     }

}
