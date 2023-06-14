<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->integer('user_id')->nullable()->default(0);
            $table->string('title')->nullable();
            $table->string('trip_type')->nullable();
            $table->string('level')->nullable();
            $table->integer('group_size')->nullable()->default(0);
            $table->integer('travelers_age')->nullable()->default(12);
            $table->boolean('enquiry_allow')->nullable()->default(true);
            $table->integer('enquiry_response')->nullable()->default(1);
            $table->string('location', 100)->nullable();
            $table->text('included')->nullable();
            $table->text('excluded')->nullable();
            $table->text('highlights')->nullable();
            $table->text('about_trip')->nullable();
            $table->text('instructions')->nullable();
            $table->float('price', 11)->nullable()->default(0);
            $table->integer('free_age')->nullable();
            $table->float('rating', 2, 1)->nullable()->default(4);
            $table->integer('no_of_reviews')->nullable()->default(0);
            $table->integer('min_members')->nullable()->default(1);
            $table->timestamp('trip_start_date')->nullable();
            $table->timestamp('trip_end_date')->nullable()->useCurrent();
            $table->string('brand')->nullable();
            $table->string('video')->nullable();
            $table->integer('guide_id')->nullable()->default(0);
            $table->text('terms_rule')->nullable();
            $table->text('cancellation_policy')->nullable();
            $table->text('payment_term')->nullable();
            $table->text('things_to_know')->nullable();
            $table->integer('status')->nullable()->default(1);
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
        Schema::dropIfExists('trips');
    }
}
