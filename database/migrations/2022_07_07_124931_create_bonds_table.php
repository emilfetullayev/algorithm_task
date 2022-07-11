<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBondsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonds', function (Blueprint $table) {
            $table->id();
            $table->integer('nominal_price');
            $table->integer('payment_frequency');
            $table->integer('calculation_period');
            $table->integer('coupon_rate');
            $table->string('interest_payment_date')->nullable();
            $table->timestamp('turnover_date')->nullable();
            $table->timestamp('issue_date')->default(DB::raw('CURRENT_TIMESTAMP'));

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bonds');
    }
}
