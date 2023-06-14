<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripActivityLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_activity_links', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->integer('activity_id')->nullable();
            $table->integer('ref_id')->nullable();
            $table->string('ref_type')->nullable();
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
        Schema::dropIfExists('trip_activity_links');
    }
}
