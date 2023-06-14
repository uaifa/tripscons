<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slots', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('experience_id')->nullable()->default(0);
            $table->integer('class_size')->nullable()->default(1);
            $table->float('price', 10)->nullable()->default(0);
            $table->date('date')->nullable();
            $table->time('start_time')->nullable();
            $table->string('duration', 50)->nullable()->default('');
            $table->string('location')->nullable()->default('');
            $table->double('lat', 15, 8)->nullable()->default(0);
            $table->double('lng', 15, 8)->nullable()->default(0);
            $table->string('city', 100)->nullable()->default('');
            $table->string('country', 100)->nullable()->default('');
            $table->integer('status')->nullable()->default(0);
            $table->timestamps();
            $table->integer('booked_counter')->nullable()->comment('this column save the slot booked counter ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slots');
    }
}
