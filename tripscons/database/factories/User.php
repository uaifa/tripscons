<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'role_id' => 1,
        'role_status' => 1,
        'is_host' => 1,
        'hourly_rate' => rand(1, 1000),
        'per_day_rate' => rand(1, 1000),
        'status' => 'active',
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt('1122'),
        'username' => $faker->userName,
        'phone' => $faker->phoneNumber,
        'gender' => rand(0, 1) ? 'male' : 'female',
        'postal_code' => $faker->postcode,
        'address' => $faker->address,
        'additional_address' => $faker->address,
        'country_id' => 231,
        'city_id' => 43929,
        'country' => 'United States',
        'state' => 'GA',
        'city' => 'Atlanta',
        'about' => $faker->sentence(2200, true),
//        'expertise' => $faker->sentence(1200,  true),
//        'interest' => $faker->sentence(1200,  true),
        'tag_line' => $faker->title,
        'avatar' => json_encode([
            'fileName' => 'g9Ny7ikdXugI7NtEdZU3y5RQaGFRjIdohZKO3bqA.png',
            'path' => 'basic/images/uploads/',
            'url' => $faker->imageUrl(500, 500),
            'mimeType' => 'png'
        ])
    ];
});




// 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password