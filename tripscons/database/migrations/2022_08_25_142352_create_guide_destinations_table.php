<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuideDestinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guide_destinations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('guide_id')->nullable();
            $table->string('name', 100)->nullable();
            $table->double('lat', 15, 7)->nullable();
            $table->double('lng', 15, 7)->nullable();
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
        Schema::dropIfExists('guide_destinations');
    }
}
