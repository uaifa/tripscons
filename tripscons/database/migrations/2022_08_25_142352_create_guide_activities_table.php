<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuideActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guide_activities', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('guide_id', 11)->nullable();
            $table->string('name')->default('N/A');
            $table->string('image');
            $table->enum('type', ['services', 'activities', 'trip_mate'])->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guide_activities');
    }
}
