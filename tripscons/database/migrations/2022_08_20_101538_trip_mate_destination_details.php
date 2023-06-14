<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TripMateDestinationDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_mate_destinations', function (Blueprint $table) {
            $table->integer('id');
            $table->integer("trip_id")->nullable();
            $table->string("type")->nullable();
            $table->text("destination")->nullable();
            $table->string("lat",100)->nullable();
            $table->string("lng",100)->nullable();
            $table->string("city",100)->nullable();
            $table->string("country",100)->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_mate_destinations');
    }
}
