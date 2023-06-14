<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsJsonExtractSurveyViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants_json_extract_survey_view', function (Blueprint $table) {
            $table->unsignedInteger('id')->nullable();
            $table->longText('about_restaurant')->nullable();
            $table->longText('about_your_meal')->nullable();
            $table->longText('free_delivery_km')->nullable();
            $table->longText('meal_type')->nullable();
            $table->longText('menu_title')->nullable();
            $table->longText('no_of_persons')->nullable();
            $table->longText('price')->nullable();
            $table->longText('free_home_delivery_no')->nullable();
            $table->longText('free_home_delivery_yes')->nullable();
            $table->longText('multiple_branches_no')->nullable();
            $table->longText('multiple_branches_yes')->nullable();
            $table->longText('restaurant_rules')->nullable();
            $table->longText('restaurant_address')->nullable();
            $table->longText('restaurant_location')->nullable();
            $table->longText('restaurant_name')->nullable();
            $table->longText('tagline')->nullable();
            $table->longText('address')->nullable();
            $table->longText('country')->nullable();
            $table->longText('date_of_birth')->nullable();
            $table->longText('email')->nullable();
            $table->longText('full_name')->nullable();
            $table->longText('gender')->nullable();
            $table->longText('is_host')->nullable();
            $table->longText('landline_number')->nullable();
            $table->longText('user_phone_Number')->nullable();
            $table->longText('state')->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants_json_extract_survey_view');
    }
}
