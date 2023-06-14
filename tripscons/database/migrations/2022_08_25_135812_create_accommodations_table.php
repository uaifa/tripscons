<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccommodationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->default(0);
            $table->string('title')->nullable()->default('');
            $table->integer('no_of_rooms')->nullable()->default(0);
            $table->integer('no_of_people')->nullable()->default(0)->comment('this is staying capacity in all types of accommodations');
            $table->longText('description')->nullable();
            $table->double('lat', 15, 8)->nullable()->default(0);
            $table->double('lng', 15, 8)->nullable()->default(0);
            $table->float('per_night', 10)->nullable()->default(0);
            $table->integer('type_id')->nullable()->default(0);
            $table->string('type_name')->nullable()->default('');
            $table->integer('sub_type_id')->nullable()->default(0);
            $table->string('sub_type_name')->nullable()->default('');
            $table->float('discount')->nullable()->default(0);
            $table->string('phone')->nullable()->default('');
            $table->float('taxes_fees', 10)->nullable()->default(0);
            $table->string('location')->nullable()->default('');
            $table->string('city', 200)->nullable()->default('');
            $table->string('country', 200)->nullable()->default('');
            $table->string('main_features', 200)->nullable()->default('');
            $table->string('entire_accomodation', 200)->nullable()->default('');
            $table->string('is_property', 30)->nullable()->default('Entire');
            $table->time('check_in_time')->nullable()->default('09:00:00');
            $table->time('check_out_time')->nullable()->default('12:00:00');
            $table->enum('is_flexiable_check_in', ['true', 'false'])->nullable()->default('true');
            $table->integer('is_flexiable_check_in_value')->nullable()->default(0);
            $table->enum('is_enquiry_before_reservation', ['true', 'false'])->nullable()->default('true');
            $table->integer('is_enquiry_before_reservation_value')->nullable()->default(0);
            $table->integer('is_pre_arrival_notice_value')->nullable()->default(0);
            $table->integer('no_of_share_bath')->nullable()->default(0);
            $table->integer('no_of_attach_bath')->nullable()->default(0);
            $table->text('places_allow_for_use_guest')->nullable();
            $table->float('cleaning_fee', 10)->nullable()->default(0);
            $table->float('service_fee', 10)->nullable()->default(0);
            $table->enum('breakfast_included', ['Yes', 'No'])->nullable()->default('No');
            $table->float('breakfast_price', 10)->nullable()->default(0);
            $table->longText('breakfast_description')->nullable()->default('');
            $table->enum('lunch_included', ['Yes', 'No'])->nullable()->default('No');
            $table->float('lunch_price', 10)->nullable()->default(0);
            $table->longText('lunch_description')->nullable()->default('');
            $table->enum('dinner_included', ['Yes', 'No'])->nullable()->default('No');
            $table->float('dinner_price', 10)->nullable()->default(0);
            $table->longText('dinner_description')->nullable()->default('');
            $table->text('personal_belongings_assets')->nullable();
            $table->integer('payment_mode')->nullable()->default(0)->comment('this column used for which payment mode used customer 
0 means pay check in later 
1 means partial payment 
2 full payment ');
            $table->integer('payment_partial_value')->nullable()->default(0);
            $table->text('cancellation_policy')->nullable();
            $table->text('important_info')->nullable();
            $table->float('discount_for_one_week', 10)->nullable()->default(0);
            $table->float('discount_for_two_week', 10)->nullable()->default(0);
            $table->float('discount_for_monthly', 10)->nullable()->default(0);
            $table->integer('age_limit_for_child')->nullable()->default(0);
            $table->integer('age_limit_for_child_free')->nullable()->default(0);
            $table->float('child_discount')->nullable()->default(0);
            $table->integer('stars')->nullable()->default(0)->comment('in case of hotels only you need to add else just pass N/A');
            $table->float('rating', 2, 1)->nullable()->default(5);
            $table->integer('no_of_reviews')->nullable()->default(0);
            $table->integer('status')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->string('guest_limit_price', 45)->nullable();
            $table->integer('no_of_rooms_created')->nullable();
            $table->enum('isProvideBreakfast', ['true', 'false'])->nullable();
            $table->enum('isProvideLunch', ['true', 'false'])->nullable();
            $table->enum('isProvideDinner', ['true', 'false'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accommodations');
    }
}
