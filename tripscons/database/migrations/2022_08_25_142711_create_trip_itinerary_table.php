<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripItineraryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_itinerary', function (Blueprint $table) {
            $table->integer('id');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('trip_id')->nullable()->default(0);
            $table->string('location')->nullable();
            $table->double('from_lat', 15, 7)->nullable();
            $table->double('from_lng', 15, 7)->nullable();
            $table->double('to_lat', 15, 7)->nullable();
            $table->double('to_lng', 15, 7)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_itinerary');
    }
}
