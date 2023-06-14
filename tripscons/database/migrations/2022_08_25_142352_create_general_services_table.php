<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->nullable();
            $table->string('image', 100)->nullable();
            $table->string('module', 100)->nullable();
            $table->integer('module_id')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->integer('sort_order')->nullable();
            $table->text('description')->nullable();
            $table->string('type', 200)->nullable();
            $table->enum('user_module_type', ['accommodations', 'experiences', 'guides', 'meals', 'movie_makers', 'transports', 'trips', 'visa_consultants', 'events', 'photographers', 'restaurants', 'trip_mates', 'trip_operators', 'hosts', 'vehicles', 'home_cheff', 'travel_agency'])->nullable();
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
        Schema::dropIfExists('general_services');
    }
}
