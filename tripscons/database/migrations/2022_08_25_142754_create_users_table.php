<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 100)->nullable()->default('');
            $table->integer('type')->nullable()->default(0);
            $table->string('email', 50)->nullable()->default('');
            $table->string('password')->nullable()->default('');
            $table->string('phone', 20)->nullable()->default('');
            $table->string('pin_code', 10)->nullable()->default('');
            $table->string('country_code', 10)->nullable()->default('');
            $table->string('postal_code', 50)->nullable()->default('');
            $table->string('address')->nullable()->default('');
            $table->string('service_provider_type', 50)->nullable()->default('');
            $table->string('gender', 10)->nullable()->default('');
            $table->string('country', 100)->nullable()->default('');
            $table->string('state', 50)->nullable()->default('');
            $table->string('city', 100)->nullable()->default('');
            $table->string('currency', 100)->nullable()->default('');
            $table->double('lng', 15, 8)->nullable()->default(0);
            $table->double('lat', 15, 8)->nullable()->default(0);
            $table->string('social_platform', 100)->nullable()->default('');
            $table->string('social_platform_id', 100)->nullable()->default('');
            $table->string('device_type', 100)->nullable()->default('');
            $table->string('device_token')->nullable()->default('');
            $table->text('about')->nullable();
            $table->integer('role_id')->nullable()->default(0);
            $table->integer('verified')->nullable()->default(1);
            $table->date('date_of_birth')->nullable();
            $table->boolean('is_mate')->nullable()->default(false);
            $table->integer('is_host')->nullable()->default(0);
            $table->integer('is_traveler')->nullable()->default(0);
            $table->text('api_token')->nullable();
            $table->tinyInteger('is_profile_complete')->nullable()->default(0);
            $table->integer('role_profile_id')->nullable();
            $table->float('rating', 2, 1)->nullable()->default(5);
            $table->integer('no_of_reviews')->nullable()->default(0);
            $table->integer('is_phone_verified')->nullable()->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('languages', 100)->nullable()->default('');
            $table->string('image', 250)->nullable()->default('default.png');
            $table->unsignedInteger('status')->nullable()->default(0);
            $table->enum('user_module_type', ['accommodations', 'experiences', 'guides', 'meals', 'movie_makers', 'transports', 'trips', 'visa_consultants', 'events', 'photographers', 'restaurants', 'trip_mates', 'trip_operators', 'home_cheff', 'travel_agency'])->nullable();
            $table->timestamps();
            $table->string('countryIso', 11)->nullable();
            $table->integer('is_company')->nullable()->default(0);
            $table->integer('switchProfile')->nullable();
            $table->text('expert_consultancy')->nullable();
            $table->string('nationality')->nullable();
            $table->text('tagline')->nullable();
            $table->integer('is_individual')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
