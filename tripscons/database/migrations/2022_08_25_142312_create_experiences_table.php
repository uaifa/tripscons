<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->nullable()->default(0);
            $table->string('title', 200)->nullable()->default('');
            $table->string('type', 100)->nullable()->default('');
            $table->integer('suitable_age')->nullable()->default(0);
            $table->integer('enquiry_response')->nullable()->default(0);
            $table->string('category', 100)->nullable()->default('');
            $table->string('video')->nullable()->default('');
            $table->string('language', 100)->nullable()->default('');
            $table->text('cancellation_policy')->nullable();
            $table->text('important_info')->nullable();
            $table->text('payment_term')->nullable();
            $table->text('things_to_know')->nullable();
            $table->text('about')->nullable();
            $table->integer('no_of_reviews')->nullable()->default(1);
            $table->integer('rating')->nullable()->default(0);
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
        Schema::dropIfExists('experiences');
    }
}
