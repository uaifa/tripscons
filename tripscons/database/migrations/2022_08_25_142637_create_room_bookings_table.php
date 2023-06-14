<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_bookings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('booking_id')->nullable();
            $table->integer('no_of_rooms')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('start_date', 45)->nullable()->comment('check in date ');
            $table->string('end_date', 45)->nullable()->comment('check out date ');
            $table->integer('room_id')->nullable();
            $table->integer('no_of_extra_guest')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->string('subtotal', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_bookings');
    }
}
