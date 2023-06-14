<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilityAccommodationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility_accommodations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('accommodation_id')->nullable();
            $table->integer('room_id')->nullable()->default(0);
            $table->string('name', 200)->nullable();
            $table->string('facilityType', 100)->nullable()->default('accomodation');
            $table->string('icon', 200)->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facility_accommodations');
    }
}
