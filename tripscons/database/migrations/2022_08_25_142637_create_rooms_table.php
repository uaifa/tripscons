<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('accommodation_id')->nullable()->default(0);
            $table->string('title')->nullable();
            $table->integer('qty')->nullable()->default(1)->comment('how many basically quantity of rooms ');
            $table->float('extra_guest_price', 10, 0)->nullable()->default(0);
            $table->integer('guest_limit')->nullable()->default(0);
            $table->float('price', 10)->nullable();
            $table->timestamps();
            $table->string('room_type', 45)->nullable();
            $table->longText('room_facilities')->nullable();
            $table->longText('bed_types')->nullable();
            $table->longText('description')->nullable();
            $table->string('is_attach_bath', 45)->nullable();
            $table->string('room_size', 45)->nullable();
            $table->string('no_of_beds', 45)->nullable();
            $table->string('booked_room', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
