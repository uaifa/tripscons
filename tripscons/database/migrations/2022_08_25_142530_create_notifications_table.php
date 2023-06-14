<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->integer('user_id')->nullable();
            $table->integer('sender_user')->nullable();
            $table->text('message')->nullable();
            $table->text('body')->nullable();
            $table->string('type')->nullable();
            $table->text('actions')->nullable();
            $table->tinyInteger('seen')->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
