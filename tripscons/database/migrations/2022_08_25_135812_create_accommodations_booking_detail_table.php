<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccommodationsBookingDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodations_booking_detail', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('booking_id');
            $table->integer('no_of_adults');
            $table->integer('no_of_childs');
            $table->integer('breakfast_price');
            $table->integer('lunch_price');
            $table->integer('dinner_price');
            $table->integer('service_fee');
            $table->integer('cleaning_fee');
            $table->integer('module_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accommodations_booking_detail');
    }
}
