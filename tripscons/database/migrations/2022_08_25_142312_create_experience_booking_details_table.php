<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperienceBookingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experience_booking_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('booking_id')->nullable();
            $table->integer('slot_id')->nullable();
            $table->integer('no_of_childs')->nullable();
            $table->integer('no_of_adults')->nullable();
            $table->integer('module_id')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('experience_booking_details');
    }
}
