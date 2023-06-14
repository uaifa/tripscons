<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_receipts', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->integer('user_id')->nullable();
            $table->integer('order_id')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('card_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('percentage_amount')->nullable();
            $table->string('status')->nullable();
            $table->boolean('active')->nullable();
            $table->timestamps();
            $table->double('advance_amount')->nullable();
            $table->string('advance_status')->nullable();
            $table->text('errors')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_receipts');
    }
}
