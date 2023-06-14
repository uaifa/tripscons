<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInquiryPurposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiry_purposals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('purposedBudget');
            $table->integer('inquiry_id');
            $table->integer('user_id');
            $table->string('payment_term');
            $table->string('notes');
            $table->text('rules');
            $table->text('itinerary');
            $table->text('included');
            $table->text('excluded');
            $table->text('cancellation_policies');
            $table->text('activities');
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('inquiry_purposals');
    }
}
