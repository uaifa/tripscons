<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOurTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('our_teams', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 250);
            $table->string('image', 250)->nullable();
            $table->text('about')->nullable();
            $table->string('designation', 250);
            $table->string('skills', 250)->nullable();
            $table->string('contact', 250)->nullable();
            $table->string('email', 250)->nullable();
            $table->date('dob');
            $table->integer('status')->nullable()->default(1);
            $table->integer('user_id')->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('our_teams');
    }
}
