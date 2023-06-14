<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->integer('contest_id');
            $table->string('user_id');
            $table->string('title');
            $table->string('media_path');
            $table->longText('description')->nullable();
            $table->integer('votes')->default(0);
            $table->string('status')->default('active');
            $table->boolean('winner')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
