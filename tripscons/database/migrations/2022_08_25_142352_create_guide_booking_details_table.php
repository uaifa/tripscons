<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuideBookingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guide_booking_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('booking_id')->nullable();
            $table->integer('module_id')->nullable();
            $table->string('booking_type', 45)->nullable();
            $table->integer('no_of_traveller')->nullable();
            $table->longText('destination')->nullable();
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
        Schema::dropIfExists('guide_booking_details');
    }
}
