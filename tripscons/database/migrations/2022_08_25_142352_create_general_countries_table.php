<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_countries', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->string('name', 100)->nullable();
            $table->string('image', 100)->nullable();
            $table->string('module', 100)->nullable();
            $table->integer('module_id')->nullable();
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
        Schema::dropIfExists('general_countries');
    }
}
