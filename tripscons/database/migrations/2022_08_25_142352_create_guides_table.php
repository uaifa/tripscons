<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->nullable();
            $table->string('title')->nullable();
            $table->text('about')->nullable();
            $table->double('price')->nullable();
            $table->timestamps();
            $table->integer('status')->nullable();
            $table->text('country')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('rating', 11)->nullable();
            $table->integer('no_of_reviews')->nullable();
            $table->text('terms_rule')->nullable();
            $table->text('cancellation_policy')->nullable();
            $table->text('payment_terms')->nullable();
            $table->text('things_to_know')->nullable();
            $table->longText('skills')->nullable();
            $table->longText('languages')->nullable();
            $table->string('expert', 250)->nullable();
            $table->text('location')->nullable();
            $table->decimal('lng', 15, 8)->default(0);
            $table->decimal('lat', 15, 8)->default(0);
            $table->tinyInteger('is_free_guide')->default(0);
            $table->float('price_per_hour_rate', 10, 0)->nullable()->default(0);
            $table->float('price_per_day_rate', 10, 0)->nullable()->default(0);
            $table->enum('user_module_type', ['accommodations', 'experiences', 'guides', 'meals', 'movie_makers', 'transports', 'trips', 'visa_consultants', 'events', 'photographers', 'restaurants', 'trip_mates', 'trip_operators', 'home_cheff', 'travel_agency'])->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('duration', 200)->nullable();
            $table->text('package_type')->nullable();
            $table->integer('estimated_no_days')->nullable()->default(0);
            $table->integer('is_copy_document')->nullable()->default(0);
            $table->text('document_note')->nullable();
            $table->integer('no_copies')->nullable()->default(0);
            $table->text('documents_filled_by_applicant')->nullable();
            $table->text('location_to')->nullable();
            $table->text('country_to')->nullable();
            $table->text('city_to')->nullable();
            $table->string('latitude_to', 200)->nullable();
            $table->string('longitude_to', 200)->nullable();
            $table->integer('number_of_days')->nullable();
            $table->integer('is_day_wise_trip')->nullable();
            $table->float('child_discount', 10, 0)->default(0);
            $table->string('movie_making_equipment', 250)->nullable();
            $table->integer('video_length_minutes')->nullable()->default(0);
            $table->integer('no_of_videos')->nullable()->default(0);
            $table->string('no_of_days', 45)->nullable()->default('0');
            $table->string('video_quality', 50)->nullable();
            $table->integer('coverage_hours')->nullable()->default(0);
            $table->string('trip_category', 250)->nullable()->default('');
            $table->integer('no_of_photography')->nullable()->default(0);
            $table->string('resolution', 250)->nullable()->default('');
            $table->string('photo_size', 250)->nullable()->default('');
            $table->integer('final_collection_usb')->nullable()->default(0);
            $table->integer('photo_book')->nullable()->default(0);
            $table->integer('is_published')->nullable()->default(0);
            $table->integer('payment_mode')->nullable()->default(0);
            $table->integer('payment_partial_value')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guides');
    }
}
