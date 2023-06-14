<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterestTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interest_trips', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->integer('user_id')->nullable();
            $table->string('location')->nullable();
            $table->integer('is_mate')->nullable();
            $table->string('mate_gender')->nullable();
            $table->longText('description')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('status')->nullable();
            $table->boolean('active')->nullable();
            $table->double('longitude')->nullable();
            $table->double('latitude')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('category_id')->nullable();
            $table->integer('trip_type_id')->nullable();
            $table->text('images')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interest_trips');
    }
}
