<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingPaymentGatewayDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_payment_gateway_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('booking_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('transaction_id', 45)->nullable();
            $table->string('fingerprint_id', 45)->nullable();
            $table->integer('status')->nullable()->comment('save the status of transaction its succesfull or fail.');
            $table->string('payment_method', 45)->nullable()->comment('this column save the payment method of transaction for future purpose ');
            $table->double('paid_amount')->nullable();
            $table->string('charged_id', 45)->nullable();
            $table->string('created_at', 45)->nullable();
            $table->string('updated_at', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_payment_gateway_details');
    }
}
