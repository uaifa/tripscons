<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('reference_no')->nullable();
            $table->string('bookable')->nullable();
            $table->bigInteger('bookable_id')->nullable();
            $table->bigInteger('room_id')->nullable();
            $table->integer('provider_user_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->longText('booking_detail')->nullable();
            $table->integer('subtotal')->nullable();
            $table->integer('discounttotal')->nullable();
            $table->integer('grandtotal')->nullable();
            $table->integer('minimum_payable_amount')->nullable();
            $table->string('status')->nullable();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->string('reservation_type');
            $table->integer('remaining_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
