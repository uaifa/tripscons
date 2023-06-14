<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealBookingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_booking_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('booking_id')->nullable();
            $table->integer('module_id')->nullable();
            $table->string('unit', 45)->nullable()->comment('this column save the unit type of meal booking detail');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->date('require_date')->nullable();
            $table->string('require_time', 11)->nullable();
            $table->float('delivery_charges', 10, 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meal_booking_details');
    }
}
