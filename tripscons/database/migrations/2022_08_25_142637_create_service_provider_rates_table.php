<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceProviderRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_provider_rates', function (Blueprint $table) {
            $table->integer('id', true);
            $table->double('price_per_hour_rate')->default(0);
            $table->double('price_per_day_rate')->default(0);
            $table->double('group_discount')->default(0);
            $table->text('destinations')->nullable();
            $table->text('languages')->nullable();
            $table->integer('user_id');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('updated_at', 25)->nullable();
            $table->string('created_at', 25)->nullable();
            $table->longText('skills')->nullable();
            $table->string('domestic_trip', 5)->nullable()->default('0');
            $table->string('international_trip', 5)->nullable()->default('0');
            $table->string('movie_making_equipment', 250)->nullable();
            $table->integer('video_length_minutes')->nullable()->default(0);
            $table->integer('no_of_videos')->nullable()->default(0);
            $table->integer('no_of_days')->nullable()->default(0);
            $table->string('video_quality', 50)->nullable();
            $table->integer('coverage_hours')->nullable()->default(0);
            $table->integer('is_free_service')->nullable()->default(0);
            $table->text('cuisines')->nullable();
            $table->text('special_diets')->nullable();
            $table->text('meals')->nullable();
            $table->text('restaurant_location')->nullable();
            $table->text('restaurant_name')->nullable();
            $table->text('restaurant_image')->nullable();
            $table->text('experties')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_provider_rates');
    }
}
