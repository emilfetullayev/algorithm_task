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
        $bonds   =   Bond::all();
        $result =  Bond::all(['interest_payment_date']);

        foreach($bonds as $bond) {
           switch ($bond->calculation_period) {
              case 360:
                  $period = 12 / $bond->payment_frequency * 30;
              case 364:
                  $period = 364 / $bond->payment_frequency;
              case 365:
                  $period = 12 / $bond->payment_frequency;
          }
        $addDays=Carbon::parse($bond->issue_date)->addDays($period);
        $weekDay=Carbon::parse($bond->issue_date)->addDays($period)->format('D');

        if($weekDay == 'Sun') {
            $addDays=Carbon::parse($bond->issue_date)->addDays($period+1);
        }
         if($weekDay == 'Sat') {
            $addDays=Carbon::parse($bond->issue_date)->addDays($period+2);
         }

        $arrays[] = $addDays;

       }
        for($i = 0; $i < count($arrays); $i++) {
               $bonds[$i]->interest_payment_date = $arrays[$i];
               $bonds[$i]->save();
        }
        return $result;

     }

}
