<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->nullable()->default(0);
            $table->integer('provider_id')->nullable()->default(0);
            $table->string('module_name', 50)->nullable()->default('');
            $table->integer('module_id')->nullable()->default(0);
            $table->integer('price')->nullable()->default(0);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('no_of_nights', 55)->nullable()->default('0');
            $table->float('total', 20)->nullable()->default(0);
            $table->float('discount', 10)->nullable()->default(0);
            $table->float('grand_total', 20)->nullable()->default(0);
            $table->integer('status')->nullable()->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('payment_status');
            $table->integer('sub_total');
            $table->string('booking_number', 25);
            $table->double('partial_amt')->nullable()->default(0)->comment('this column save the partial amount at receiving time ');
            $table->integer('partial_amt_in_percentage')->nullable()->default(0)->comment('this column used for real time checking how much partial amount charged in real time in case user update accommodation partial amount then we can track from that column ');
            $table->string('provider_name', 45)->nullable();
            $table->string('booking_type', 45)->nullable();
            $table->string('bookable')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
