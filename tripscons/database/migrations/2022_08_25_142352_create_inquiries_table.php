<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->integer('ref_id')->nullable();
            $table->string('inquiry_type')->nullable();
            $table->integer('client_id')->nullable();
            $table->string('client_name')->nullable();
            $table->integer('service_provider_id')->nullable();
            $table->string('service_provider_name')->nullable();
            $table->string('date')->nullable();
            $table->integer('no_of_people')->nullable();
            $table->longText('inquiry')->nullable();
            $table->string('status')->nullable();
            $table->boolean('active')->nullable();
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
        Schema::dropIfExists('inquiries');
    }
}
