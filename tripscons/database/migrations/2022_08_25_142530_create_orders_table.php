<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->integer('user_id')->nullable();
            $table->integer('provider_id')->nullable();
            $table->string('description')->nullable();
            $table->string('status')->nullable();
            $table->boolean('active')->nullable();
            $table->timestamps();
            $table->string('type')->nullable();
            $table->integer('ref_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
