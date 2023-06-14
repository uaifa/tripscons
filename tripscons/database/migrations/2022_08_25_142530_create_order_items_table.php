<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->integer('order_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('provider_id')->nullable();
            $table->integer('ref_id')->nullable();
            $table->string('ref_type')->nullable();
            $table->integer('price')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('total')->nullable();
            $table->string('status')->nullable();
            $table->boolean('active')->nullable();
            $table->timestamps();
            $table->string('date_from')->nullable();
            $table->string('date_to')->nullable();
            $table->string('in_city')->nullable();
            $table->string('day_or_hourly')->nullable();
            $table->string('time')->nullable();
            $table->string('pick_up_location')->nullable();
            $table->text('detail_in_json')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
