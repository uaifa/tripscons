<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCancellationPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancellation_policies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('bookable_id');
            $table->integer('cancellation_hour');
            $table->integer('refund_percentage');
            $table->timestamps();
            $table->string('module_name')->nullable();
            $table->string('bookable')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cancellation_policies');
    }
}
