<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->nullable()->default(1);
            $table->string('meal_type', 100)->nullable()->default('');
            $table->string('title')->nullable()->default('');
            $table->text('description')->nullable();
            $table->float('price', 11)->nullable()->default(0);
            $table->integer('persons')->nullable()->default(0);
            $table->string('brand', 100)->nullable()->default('');
            $table->string('delivery_time', 100)->nullable()->default('45');
            $table->float('delivery_charges', 10)->nullable()->default(0);
            $table->integer('free_delivery')->nullable()->default(0);
            $table->float('free_delivery_value', 10)->nullable()->default(0);
            $table->float('discount', 10)->nullable()->default(0);
            $table->time('opening_time')->nullable()->default('00:00:00');
            $table->time('closing_time')->nullable()->default('00:00:00');
            $table->string('food_preparation', 200)->nullable()->default('');
            $table->text('cancellation_policy')->nullable();
            $table->text('important_info')->nullable();
            $table->enum('unit', ['per Kg', 'Whole'])->nullable()->default('per Kg');
            $table->string('specialities')->nullable()->default('');
            $table->text('ingredients')->nullable()->default('');
            $table->string('location', 200)->nullable()->default('');
            $table->string('city', 150)->nullable()->default('');
            $table->string('country', 150)->nullable()->default('');
            $table->double('lat', 15, 7)->nullable()->default(0);
            $table->double('lng', 15, 7)->nullable()->default(0);
            $table->float('rating', 2, 1)->nullable()->default(5);
            $table->integer('no_of_reviews')->nullable()->default(0);
            $table->integer('status')->nullable()->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meals');
    }
}
