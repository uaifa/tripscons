<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->integer('user_id')->nullable();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('location')->nullable();
            $table->integer('no_of_people')->nullable();
            $table->integer('price')->nullable();
            $table->integer('days')->nullable();
            $table->integer('nights')->nullable();
            $table->longText('images')->nullable();
            $table->string('status')->nullable();
            $table->boolean('active')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('date_from')->nullable();
            $table->string('date_to')->nullable();
            $table->string('agenda_type')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('trip_type_id')->nullable();
            $table->string('physical_level')->nullable();
            $table->tinyInteger('everything_excluded')->nullable();
            $table->text('excluded')->nullable();
            $table->text('terms')->nullable();
            $table->text('video_urls')->nullable();
            $table->integer('child_age_limit_discount')->nullable();
            $table->integer('child_discount_percentage')->nullable();
            $table->integer('discount_age_limit_for_free')->nullable();
            $table->tinyInteger('allow_group_discount')->nullable();
            $table->integer('group_limit_discount')->nullable();
            $table->integer('group_discount_amount')->nullable();
            $table->integer('age_min')->nullable();
            $table->integer('age_max')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
