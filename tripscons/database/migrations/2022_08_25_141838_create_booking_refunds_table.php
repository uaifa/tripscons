<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_refunds', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('booking_id', 45)->nullable();
            $table->string('charge_id', 95)->nullable();
            $table->string('refund_id', 90)->nullable();
            $table->string('refunded_amount', 15)->nullable();
            $table->date('created_at')->nullable();
            $table->date('updated_at')->nullable();
            $table->string('transaction_id', 95)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_refunds');
    }
}
