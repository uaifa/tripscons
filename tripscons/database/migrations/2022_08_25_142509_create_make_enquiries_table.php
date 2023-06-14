<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMakeEnquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('make_enquiries', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 200)->nullable();
            $table->string('email', 200)->nullable();
            $table->string('phone_number', 200)->nullable();
            $table->text('enquiry_detail')->nullable();
            $table->integer('user_id')->nullable();
            $table->enum('status', ['SUBMITTED', 'REPLIED', 'PENDING', 'IGNORED'])->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrent();
            $table->enum('user_module_type', ['accommodations', 'experiences', 'guides', 'meals', 'movie_makers', 'transports', 'trips', 'visa_consultants', 'events', 'photographers', 'restaurants', 'trip_mates', 'trip_operators', 'home_cheff', 'travel_agency'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('make_enquiries');
    }
}
