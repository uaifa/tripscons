<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('module_id')->nullable()->default(0);
            $table->string('module', 50)->nullable()->default('accommodation');
            $table->string('type', 100)->nullable()->default('Hotel');
            $table->string('title', 200)->nullable();
            $table->double('lat', 15, 8)->nullable()->default(0);
            $table->double('lng', 15, 8)->nullable()->default(0);
            $table->double('distance', 10, 2)->nullable()->default(0);
            $table->integer('status')->nullable()->default(1);
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
        Schema::dropIfExists('places');
    }
}
