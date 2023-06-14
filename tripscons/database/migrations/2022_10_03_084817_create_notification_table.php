<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->integer('user_id')->nullable();
            $table->text('message')->nullable();
            $table->text('uri')->nullable();
            $table->tinyInteger('seen')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('type')->nullable();
            $table->integer('ref_id')->nullable();
            $table->integer('user_role')->nullable();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification');

    }
}
