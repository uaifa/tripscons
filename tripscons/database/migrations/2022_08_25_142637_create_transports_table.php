<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->default(0);
            $table->string('title')->nullable()->default('');
            $table->string('vechile_type')->nullable()->default('');
            $table->integer('no_of_people')->nullable()->default(0);
            $table->text('description')->nullable();
            $table->float('per_day_price', 10)->nullable()->default(0);
            $table->boolean('airport_pick_drop')->nullable()->default(false);
            $table->float('airport_pick_and_drop_charges', 10)->nullable()->default(0);
            $table->boolean('out_of_city')->nullable()->default(false);
            $table->integer('free_km')->nullable()->default(0);
            $table->float('extra_km_rate', 10)->nullable()->default(0);
            $table->float('hourly_price', 10)->nullable()->default(0);
            $table->string('transmission', 50)->nullable()->default('');
            $table->string('assembly', 100)->nullable()->default('');
            $table->string('engine', 100)->nullable()->default('');
            $table->integer('provide_self_drive')->nullable()->default(0);
            $table->integer('insured')->nullable()->default(0);
            $table->integer('tracker')->nullable()->default(0);
            $table->string('registration_no', 100)->nullable()->default('');
            $table->string('category', 100)->nullable()->default('');
            $table->string('company')->nullable()->default('');
            $table->integer('cc')->nullable()->default(0);
            $table->text('accessories')->nullable();
            $table->string('video_url')->nullable()->default('');
            $table->date('insurance_expire_date')->nullable();
            $table->string('insurance_document', 100)->nullable()->default('');
            $table->integer('model')->nullable()->default(0);
            $table->string('location', 500)->nullable()->default('');
            $table->string('city', 200)->nullable()->default('');
            $table->string('country', 200)->nullable()->default('');
            $table->double('lat', 15, 8)->nullable()->default(0);
            $table->double('lng', 15, 8)->nullable()->default(0);
            $table->text('cancellation_policy')->nullable();
            $table->text('important_info')->nullable();
            $table->float('rating', 2, 1)->nullable()->default(0);
            $table->string('no_of_reviews', 15)->nullable()->default('0');
            $table->string('brand', 250)->nullable()->default('');
            $table->integer('status')->nullable()->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('is_free_pick_drop')->nullable();
            $table->string('is_intercity_allow', 5)->nullable();
            $table->float('intercity_per_day_price', 10, 0)->nullable();
            $table->integer('intercity_per_day_milage')->nullable();
            $table->integer('intercity_per_day_extra_milage')->nullable();
            $table->float('intercity_per_day_extra_milage_price', 10, 0)->nullable();
            $table->float('intercity_multiple_day_price', 10, 0)->nullable();
            $table->integer('intercity_multiple_day_milage')->nullable();
            $table->integer('intercity_multiple_day_extra_milage')->nullable();
            $table->float('intercity_multiple_day_extra_milage_price', 10, 0)->nullable();
            $table->string('is_outofcity_allow', 5)->nullable();
            $table->float('outofcity_per_day_price', 10, 0)->nullable();
            $table->integer('outofcity_per_day_milage')->nullable();
            $table->integer('outofcity_per_day_extra_milage')->nullable();
            $table->float('outofcity_per_day_extra_milage_price', 10, 0)->nullable();
            $table->float('outofcity_multiple_day_price', 10, 0)->nullable();
            $table->integer('outofcity_multiple_day_milage')->nullable();
            $table->integer('outofcity_multiple_day_extra_milage')->nullable();
            $table->float('outofcity_multiple_day_extra_milage_price', 10, 0)->nullable();
            $table->longText('self_drive_rules')->nullable();
            $table->string('list_for', 35)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transports');
    }
}
