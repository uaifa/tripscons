<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Brackets\AdminAuth\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'activated' => true,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'last_login_at' => $faker->dateTime,

    ];
});/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'type' => $faker->randomNumber(5),
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'phone' => $faker->sentence,
        'pin_code' => $faker->sentence,
        'country_code' => $faker->sentence,
        'postal_code' => $faker->sentence,
        'address' => $faker->sentence,
        'service_provider_type' => $faker->sentence,
        'gender' => $faker->sentence,
        'country' => $faker->sentence,
        'state' => $faker->sentence,
        'city' => $faker->sentence,
        'currency' => $faker->sentence,
        'lng' => $faker->randomFloat,
        'lat' => $faker->randomFloat,
        'social_platform' => $faker->sentence,
        'social_platform_id' => $faker->sentence,
        'device_type' => $faker->sentence,
        'device_token' => $faker->sentence,
        'about' => $faker->text(),
        'role_id' => $faker->randomNumber(5),
        'verified' => $faker->randomNumber(5),
        'date_of_birth' => $faker->date(),
        'is_mate' => $faker->boolean(),
        'is_host' => $faker->randomNumber(5),
        'is_traveler' => $faker->randomNumber(5),
        'api_token' => $faker->text(),
        'is_profile_complete' => $faker->boolean(),
        'role_profile_id' => $faker->randomNumber(5),
        'rating' => $faker->randomFloat,
        'no_of_reviews' => $faker->randomNumber(5),
        'is_phone_verified' => $faker->randomNumber(5),
        'email_verified_at' => $faker->dateTime,
        'phone_verified_at' => $faker->dateTime,
        'languages' => $faker->sentence,
        'image' => $faker->sentence,
        'status' => $faker->randomNumber(5),
        'user_module_type' => $faker->text(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'stripe_id' => $faker->sentence,
        'pm_type' => $faker->sentence,
        'pm_last_four' => $faker->sentence,
        'trial_ends_at' => $faker->dateTime,


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Activity::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'image' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Facility::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'module_type' => $faker->sentence,
        'status' => $faker->sentence,
        'image' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\MealType::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'status' => $faker->sentence,
        'active' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\TripType::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'category_id' => $faker->randomNumber(5),


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\VehicleType::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'type' => $faker->sentence,


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\TripFacility::class, static function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->text(),
        'image' => $faker->sentence,
        'trip_id' => $faker->randomNumber(5),
        'is_included' => $faker->randomNumber(5),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\TripCategory::class, static function (Faker\Generator $faker) {
    return [


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\RipActivity::class, static function (Faker\Generator $faker) {
    return [


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\MealIngrediant::class, static function (Faker\Generator $faker) {
    return [


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\AccommodationSubType::class, static function (Faker\Generator $faker) {
    return [
        'type_id' => $faker->randomNumber(5),
        'name' => $faker->firstName,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\AccommodationType::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\TripActivity::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'image' => $faker->sentence,
        'trip_id' => $faker->randomNumber(5),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */

 $factory->define(Brackets\AdminAuth\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'activated' => true,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'last_login_at' => $faker->dateTime,

    ];
});/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Booking::class, static function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->randomNumber(5),
        'provider_id' => $faker->randomNumber(5),
        'module_name' => $faker->sentence,
        'module_id' => $faker->randomNumber(5),
        'price' => $faker->randomNumber(5),
        'start_date' => $faker->dateTime,
        'end_date' => $faker->dateTime,
        'no_of_nights' => $faker->sentence,
        'total' => $faker->randomFloat,
        'discount' => $faker->randomFloat,
        'grand_total' => $faker->randomFloat,
        'status' => $faker->randomNumber(5),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'deleted_at' => null,
        'payment_status' => $faker->randomNumber(5),
        'sub_total' => $faker->randomNumber(5),
        'booking_number' => $faker->sentence,
        'partial_amt' => $faker->randomFloat,
        'partial_amt_in_percentage' => $faker->randomNumber(5),
        'provider_name' => $faker->sentence,
        'booking_type' => $faker->sentence,
        'bookable' => $faker->sentence,


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
  $factory->define(App\Models\Role::class, static function (Faker\Generator $faker) {
     return [
        'name' => $faker->firstName,
        'guard_name' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,


    ];
});
 /** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Permission::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'guard_name' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\BookingActivityLog::class, static function (Faker\Generator $faker) {
    return [
        'booking_id' => $faker->randomNumber(5),
        'admin_user_id' => $faker->randomNumber(5),
        'status' => $faker->randomNumber(5),
        'comments' => $faker->text(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\TripMate::class, static function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->sentence,
        'trip_id' => $faker->randomNumber(5),
        'image_ids' => $faker->sentence,
        'pick_up' => $faker->text(),
        'destination' => $faker->text(),
        'lat' => $faker->sentence,
        'lng' => $faker->sentence,
        'city' => $faker->sentence,
        'country' => $faker->sentence,
        'date_from' => $faker->sentence,
        'date_to' => $faker->sentence,
        'activities' => $faker->text(),
        'description' => $faker->text(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'deleted_at' => null,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\TripMateDestination::class, static function (Faker\Generator $faker) {
    return [
        'trip_id' => $faker->randomNumber(5),
        'destination' => $faker->text(),
        'lat' => $faker->sentence,
        'lng' => $faker->sentence,
        'city' => $faker->sentence,
        'country' => $faker->sentence,
        'type' => $faker->randomNumber(5),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'deleted_at' => null,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\TripMateInvitation::class, static function (Faker\Generator $faker) {
    return [
        'trip_id' => $faker->randomNumber(5),
        'request_user_id' => $faker->sentence,
        'to_user_id' => $faker->text(),
        'status' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'deleted_at' => null,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'type' => $faker->randomNumber(5),
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'phone' => $faker->sentence,
        'pin_code' => $faker->sentence,
        'country_code' => $faker->sentence,
        'postal_code' => $faker->sentence,
        'address' => $faker->sentence,
        'service_provider_type' => $faker->sentence,
        'gender' => $faker->sentence,
        'country' => $faker->sentence,
        'state' => $faker->sentence,
        'city' => $faker->sentence,
        'currency' => $faker->sentence,
        'lng' => $faker->randomFloat,
        'lat' => $faker->randomFloat,
        'social_platform' => $faker->sentence,
        'social_platform_id' => $faker->sentence,
        'device_type' => $faker->sentence,
        'device_token' => $faker->sentence,
        'about' => $faker->text(),
        'role_id' => $faker->randomNumber(5),
        'verified' => $faker->randomNumber(5),
        'date_of_birth' => $faker->date(),
        'is_mate' => $faker->boolean(),
        'is_host' => $faker->randomNumber(5),
        'is_traveler' => $faker->randomNumber(5),
        'api_token' => $faker->text(),
        'is_profile_complete' => $faker->boolean(),
        'role_profile_id' => $faker->randomNumber(5),
        'rating' => $faker->randomFloat,
        'no_of_reviews' => $faker->randomNumber(5),
        'is_phone_verified' => $faker->randomNumber(5),
        'email_verified_at' => $faker->dateTime,
        'phone_verified_at' => $faker->dateTime,
        'languages' => $faker->sentence,
        'image' => $faker->sentence,
        'user_module_type' => $faker->sentence,
        'status' => $faker->randomNumber(5),
        'countryIso' => $faker->sentence,
        'is_company' => $faker->randomNumber(5),
        'switchProfile' => $faker->randomNumber(5),
        'expert_consultancy' => $faker->text(),
        'nationality' => $faker->sentence,
        'tagline' => $faker->text(),
        'is_individual' => $faker->randomNumber(5),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'stripe_id' => $faker->sentence,
        'pm_type' => $faker->sentence,
        'pm_last_four' => $faker->sentence,
        'trial_ends_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Reservation::class, static function (Faker\Generator $faker) {
    return [
        'reference_no' => $faker->sentence,
        'bookable' => $faker->sentence,
        'bookable_id' => $faker->sentence,
        'room_id' => $faker->sentence,
        'provider_user_id' => $faker->randomNumber(5),
        'user_id' => $faker->sentence,
        'date_from' => $faker->date(),
        'date_to' => $faker->date(),
        'booking_detail' => $faker->text(),
        'subtotal' => $faker->randomNumber(5),
        'discounttotal' => $faker->randomNumber(5),
        'grandtotal' => $faker->randomNumber(5),
        'minimum_payable_amount' => $faker->randomNumber(5),
        'status' => $faker->sentence,
        'updated_at' => $faker->dateTime,
        'created_at' => $faker->dateTime,
        'reservation_type' => $faker->sentence,
        'remaining_amount' => $faker->randomNumber(5),
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\UserDocument::class, static function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->randomNumber(5),
        'type' => $faker->sentence,
        'front' => $faker->sentence,
        'back' => $faker->sentence,
        'expiry' => $faker->date(),
        'status' => $faker->randomNumber(5),
        'updated_at' => $faker->dateTime,
        'created_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Notification::class, static function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->randomNumber(5),
        'message' => $faker->text(),
        'uri' => $faker->text(),
        'seen' => $faker->boolean(),
        'status' => $faker->boolean(),
        'type' => $faker->sentence,
        'ref_id' => $faker->randomNumber(5),
        'user_role' => $faker->randomNumber(5),
        'updated_at' => $faker->dateTime,
        'created_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\DeviceDetail::class, static function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->randomNumber(5),
        'device_id' => $faker->sentence,
        'device_token' => $faker->sentence,
        'device_type' => $faker->sentence,
        'status' => $faker->sentence,
        'updated_at' => $faker->dateTime,
        'created_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\DeviceBadge::class, static function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->randomNumber(5),
        'type' => $faker->sentence,
        'count' => $faker->randomNumber(5),
        'status' => $faker->sentence,
        'updated_at' => $faker->dateTime,
        'created_at' => $faker->dateTime,
        
        
    ];
});
