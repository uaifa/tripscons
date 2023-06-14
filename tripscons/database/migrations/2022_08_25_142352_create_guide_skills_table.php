<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuideSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guide_skills', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->integer('user_id')->nullable();
            $table->integer('ref_id')->nullable();
            $table->integer('skill_id')->nullable();
            $table->string('skill_name')->nullable();
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
        Schema::dropIfExists('guide_skills');
    }
}
