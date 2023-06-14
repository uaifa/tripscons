<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('full_name')->nullable();
            $table->string('phone', 25)->nullable();
            $table->string('email', 30)->nullable();
            $table->string('city')->nullable();
            $table->string('buissness_name')->nullable();
            $table->string('facebook', 45)->nullable();
            $table->string('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partner_details');
    }
}
