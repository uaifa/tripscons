<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripMateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_mate', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('user_id', 50)->nullable();
            $table->integer('trip_id')->nullable();
            $table->longText('pick_up')->nullable();
            $table->longText('destination')->nullable();
            $table->longText('lat')->nullable();
            $table->longText('lng')->nullable();
            $table->longText('city')->nullable();
            $table->longText('state')->nullable();
            $table->longText('country')->nullable();
            $table->string('date_from')->nullable();
            $table->string('date_to')->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('trip_mate');
    }
}
