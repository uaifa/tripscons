<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->float('location_rating', 10, 0)->nullable()->default(0);
            $table->float('cleanliness_rating', 10, 0)->nullable()->default(0);
            $table->float('comfort_rating', 10, 0)->nullable()->default(0);
            $table->float('quality_rating', 10, 0)->nullable()->default(0);
            $table->float('average_rating', 10, 0)->nullable()->default(0);
            $table->text('comments')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('package_id')->nullable();
            $table->integer('provider_id')->nullable();
            $table->integer('booking_id')->nullable();
            $table->enum('status', ['active', 'inactive'])->nullable();
            $table->enum('type', ['profile', 'services'])->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrent();
            $table->enum('module_name', ['accommodations', 'experiences', 'guides', 'meals', 'movie_makers', 'transports', 'trips', 'visa_consultants', 'events', 'photographers', 'restaurants', 'trip_mates', 'trip_operators', 'hosts', 'vehicles', 'guideprofile'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}
