<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageItineraryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_itinerary', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('time', 20)->nullable();
            $table->text('destination')->nullable();
            $table->integer('package_id')->nullable();
            $table->date('created_at')->useCurrent();
            $table->date('updated_at')->nullable()->useCurrent();
            $table->text('activity')->nullable();
            $table->string('date', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_itinerary');
    }
}
