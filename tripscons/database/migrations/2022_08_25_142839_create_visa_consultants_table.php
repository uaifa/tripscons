<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisaConsultantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_consultants', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->integer('user_id')->nullable();
            $table->string('title')->nullable();
            $table->text('about')->nullable();
            $table->float('price', 10)->nullable();
            $table->integer('no_of_reviews')->nullable()->default(1);
            $table->float('rating', 2, 1)->nullable()->default(5);
            $table->string('experties', 200)->nullable();
            $table->integer('status')->nullable()->default(0);
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
        Schema::dropIfExists('visa_consultants');
    }
}
