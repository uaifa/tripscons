<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name')->nullable();
            $table->enum('user_module_type', ['accommodations', 'experiences', 'guides', 'meals', 'movie_makers', 'transports', 'trips', 'visa_consultants', 'events', 'photographers', 'restaurants', 'trip_mates', 'trip_operators', 'home_cheff', 'travel_agency'])->nullable();
            $table->integer('user_id');
            $table->string('type', 200)->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('galleries');
    }
}
