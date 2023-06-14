<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips_properties', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('trip_type', 200)->nullable();
            $table->string('group_size', 200)->nullable();
            $table->string('activity_level', 200)->nullable();
            $table->string('suitable_age', 200)->nullable();
            $table->float('group_discount', 10, 0)->nullable()->default(0);
            $table->float('couple_discount', 10, 0)->nullable()->default(0);
            $table->float('child_discount', 10, 0)->nullable()->default(0);
            $table->integer('package_id')->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrent();
            $table->integer('booked_counter')->nullable();
            $table->date('departure_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips_properties');
    }
}
