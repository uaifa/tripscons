<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsconeSurveyJsonDataViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tripscone_survey_json_data_view', function (Blueprint $table) {
            $table->unsignedInteger('id')->nullable();
            $table->mediumText('user')->nullable();
            $table->string('module', 100)->nullable();
            $table->mediumText('data')->nullable();
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
        Schema::dropIfExists('tripscone_survey_json_data_view');
    }
}
