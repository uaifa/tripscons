<?php

use App\AboutAccommodationLink;
use App\AccommodationSubType;
use App\AccommodationType;
use App\BedsTypesLink;
use App\FacilityLink;
use App\PhotographerSkillLink;
use App\PhotographerTypeLink;
use App\SafetyAmenityLink;
use App\ShareAccommodationLink;
use App\UserAccommodation;
use App\UserCountry;
use App\UserLanguage;
use App\UserMeal;
use App\UserTransport;
use App\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 10)->create()->each(function ($user) {
            \App\ActivityLink::create([
                'active' => 1,
                'type' => 'users',
                'ref_id' => $user->id,
                'activity_id' => rand(6, 10)
            ]);
            UserLanguage::create([
                'active' => 1,
                'user_id' => $user->id,
                'ref_type' => 'users',
                'language_id' => rand(3, 11)
            ]);

            // if user is host then add host dummy data
            if ($user->is_host == 1) {
                // image link with http://localhost:8000
//                $accommodationImageJson = "[{\"primary\":1,\"fileName\":\"YuaukXyNTXi57AE13cJT08Pu9CjsB4orGNrnSdBN.png\",\"path\":\"basic\/images\/accommodations\/\",\"url\":\"http:\/\/localhost:8000\/basic\/images\/accommodations\/YuaukXyNTXi57AE13cJT08Pu9CjsB4orGNrnSdBN.png\",\"mimeType\":\"png\"},{\"primary\":0,\"fileName\":\"BkqXbjUBJA5XYJycFQ6jxEfqWNf211BdjXGq27Mx.png\",\"path\":\"basic\/images\/accommodations\/\",\"url\":\"http:\/\/localhost:8000\/basic\/images\/accommodations\/BkqXbjUBJA5XYJycFQ6jxEfqWNf211BdjXGq27Mx.png\",\"mimeType\":\"png\"},{\"primary\":0,\"fileName\":\"j5inDLUu3bTTcHEFfrNr9KwhmtMhVhNkeQLQMgxE.png\",\"path\":\"basic\/images\/accommodations\/\",\"url\":\"http:\/\/localhost:8000\/basic\/images\/accommodations\/j5inDLUu3bTTcHEFfrNr9KwhmtMhVhNkeQLQMgxE.png\",\"mimeType\":\"png\"}] ";
//                $mealImageJson='[{"primary":1,"fileName":"Er2VEN727Bn3hdPnS2YlXbuPp0iGz5wPgZHSiCwT.png","path":"basic\/images\/meals\/","url":"http:\/\/localhost:8000\/basic\/images\/meals\/Er2VEN727Bn3hdPnS2YlXbuPp0iGz5wPgZHSiCwT.png","mimeType":"png"},{"primary":0,"fileName":"2QDcEfRCYM2lJseg27o9WFhiEj9sSECpbd0057hu.png","path":"basic\/images\/meals\/","url":"http:\/\/localhost:8000\/basic\/images\/meals\/2QDcEfRCYM2lJseg27o9WFhiEj9sSECpbd0057hu.png","mimeType":"png"}]';
//                $transportImageJson = '[{"primary":1,"fileName":"9Yx13yCi6DJrmjQwEl1vwtMhfbgGSncaNInQfDCk.png","path":"basic\/images\/transports\/","url":"http:\/\/localhost:8000\/basic\/images\/transports\/9Yx13yCi6DJrmjQwEl1vwtMhfbgGSncaNInQfDCk.png","mimeType":"png"}]';

                // image link with http://tripsconpro.wantechsolutions.com
                $accommodationImageJson = '[{"primary":1,"fileName":"GoTxRfPLKxf2VK9VRaOhtVx3CZc77aV3UuOEaewF.png","path":"basic\/images\/accommodations\/","url":"http:\/\/tripsconpro.wantechsolutions.com\/basic\/images\/accommodations\/GoTxRfPLKxf2VK9VRaOhtVx3CZc77aV3UuOEaewF.png","mimeType":"png"},{"primary":0,"fileName":"2W1KVECmOz8rgsTwCNtjnHYvAWu2j5jfbRo93dYv.png","path":"basic\/images\/accommodations\/","url":"http:\/\/tripsconpro.wantechsolutions.com\/basic\/images\/accommodations\/2W1KVECmOz8rgsTwCNtjnHYvAWu2j5jfbRo93dYv.png","mimeType":"png"}]';
                $mealImageJson = '[{"primary":1,"fileName":"wxWKQIA5xYjXdUprDVHYB3K1y5gU0iTivJCCspWi.png","path":"basic\/images\/meals\/","url":"https:\/\/tripsconpro.wantechsolutions.com\/basic\/images\/meals\/wxWKQIA5xYjXdUprDVHYB3K1y5gU0iTivJCCspWi.png","mimeType":"png"}]';
                $transportImageJson = '[{"primary":1,"fileName":"HIx7pUD8ouOUFjACikhrCpZtYYXDI0qxVBQ2w422.png","path":"basic\/images\/transports\/","url":"http:\/\/tripsconpro.wantechsolutions.com\/basic\/images\/transports\/HIx7pUD8ouOUFjACikhrCpZtYYXDI0qxVBQ2w422.png","mimeType":"png"}]';
                $accommodationTypeId = (int)rand(1,5);
                $accommodationSubType = AccommodationSubType::where('type_id',$accommodationTypeId)->first();
                $propertyTypes = ['shared','private','entire'];

                $accommodation = UserAccommodation::create([
                    'user_id' => $user->id,
                    'title' => 'Very Nice Accommodation '.(string)Str::random(5),
                    'type' => 'room',
                    'images' => $accommodationImageJson,
                    'rules' => '[{"text":"cigrette not allowed"},{"text":"vap not allowed"}]',
                    'no_of_people' => rand(1, 20),
                    'description' => 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete accountt of the system.But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete accountt of the system.But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete accountt of the system.But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete accountt of the system.',
                    'per_day' => rand(5, 100),
                    'per_night' => rand(10, 50),
                    'check_in' => '01:00',
                    'check_out' => '04:00',
                    'latitude' => 31.5259927,
                    'longitude' => 74.2567839,
                    'active' => true,
                    'type_id' => $accommodationTypeId,
                    'type_name' => AccommodationType::find((int)$accommodationTypeId)['name'],
                    'sub_type_id' => (int)$accommodationSubType->id,
                    'sub_type_name' => $accommodationSubType->name,
                    'property_type' => (string)$propertyTypes[rand(0,2)],
                    'smart_pricing' => (int)rand(0,1),
                    'min_price' => (int)rand(1,50),
                    'max_price' => (int)rand(50,100),
                    'notice_before_in_days' => (int)rand(1,10),
                    'can_stay_max' => (int)rand(1,30),
                    'can_stay_min' => (int)rand(1,5),
                    'private_bath' => (int)rand(0,1),
                    'personal_setup' => (int)rand(0,1),
                    'listing_as_company' => (int)rand(0,1),
                    'discount_week_1' => (int)rand(0,2),
                    'discount_week_2' => (int)rand(3,5),
                    'discount_week_3' => (int)rand(5,10),
                    'discount_week_4' => (int)rand(10,20),
                    'use_profile_number' => rand(0,1),
                    'phone' => (string)rand(9000000,90000000),
                    'guest_can_contact' => (int)rand(0,1),
                    'clean_fee'=> (int)rand(1,10),
                    'service_fee'=> (int)rand(1,100),
                    'taxes_fees'=> (int)rand(1,100),
                    'limit_people'=> (int)rand(1,5),
                    'extra_price'=> (int)rand(1,20)
                ]);
                for ($x = 0; $x <= 6; $x++) {
                    FacilityLink::create([
                        'user_id' => $user->id,
                        'ref_id' => $accommodation->id,
                        'ref_type' => 'host:accommodation',
                        'facility_id' => rand(1, 116)
                    ]);

                    $bedTypeId = rand(1,17);
                    BedsTypesLink::create([
                        'user_id' => $user->id,
                        'accommodation_id' => $accommodation->id,
                        'bed_type_id' => $bedTypeId,
                        'bed_name' => \App\BedsType::find($bedTypeId)['name'],
                        'total' => rand(1,10),
                    ]);

                    $aboutAccId = rand(1,9);
                    AboutAccommodationLink::create([
                        'user_id' => $user->id,
                        'accommodation_id' => $accommodation->id,
                        'question_id' => $aboutAccId,
                        'question' => \App\AboutAccommodation::find($aboutAccId)['question'],
                        'description' => (string)Str::random(32),
                    ]);

                    $shareId = rand(1,8);
                    ShareAccommodationLink::create([
                        'user_id' => $user->id,
                        'accommodation_id' => $accommodation->id,
                        'share_id' => $shareId,
                        'share_name' => \App\ShareAccommodation::find($shareId)['name']
                    ]);

                    $safeAmenityId = rand(1,5);
                    SafetyAmenityLink::create([
                        'user_id' => $user->id,
                        'accommodation_id' => $accommodation->id,
                        'safety_amenity_id' => $safeAmenityId,
                        'safety_amenity_title' => \App\SafetyAmenity::find($safeAmenityId)['title']
                    ]);
                }
                UserMeal::create([
                    'user_id' => $user->id,
                    'title' => 'Bread and egg '.(string)Str::random(5),
                    'meal_id' => rand(1, 5),
                    'price' => rand(10, 500),
                    'images' => $mealImageJson,
                    'description' => 'Very Nice Meal for whenever you want to eat, Very Nice Meal for whenever you want to eat, Very Nice Meal for whenever you want to eat, Very Nice Meal for whenever you want to eat, Very Nice Meal for whenever you want to eat',
                    'rules' => '[{"text":"cigrette not allowed"},{"text":"vap not allowed"}]',
                    'active' => true,
                    'ingredients' => '[{"text":"8 ounces of macaroni"},{"text":"2 eggs, beaten"},{"text":"1 large can of evaporated milk"},{"text":"1 1\/4 cup milk"},{"text":"4 tbsp butter"},{"text":"2 cups of sharp cheese"},{"text":"2 cups of medium cheddar"},{"text":"Salt or season salt (to taste)"}]',
                ]);

                $vehicleId = rand(1,7);
                $transmissions = ['auto','manual'];
                $assembly =['local','imported'];
                $engine =['petrol','cng','desiel','hybird','lpg'];
                UserTransport::create([
                    'user_id' => $user->id,
                    'title' => 'Black Car BMW '.(string)Str::random(5),
                    'images' => $transportImageJson,
                    'no_of_people' => rand(2, 4),
                    'description' => 'This is very nice Car and also i will pick up from you location and very comfortable.This is very nice Car and also i will pick up from you location and very comfortable.This is very nice Car and also i will pick up from you location and very comfortable.',
                    'per_day_price' => rand(50, 500),
                    'hourly_price' => rand(50, 150),
                    'airport_pick_drop' => rand(0, 1),
                    'free_km' => rand(1, 5),
                    'extra_km_rate' => rand(5, 50),
                    'out_of_city' => rand(0, 1),
                    'active' => true,
                    'vehicle_id' => (int)$vehicleId,
                    'vehicle_name' => Vehicle::find((int)$vehicleId)['name'],
                    'specs' => (string)Str::random(15),
                    'transmission' => $transmissions[rand(0,1)],
                    'assembly' => $assembly[rand(0,1)],
                    'engine' => $engine[rand(0,4)],
                    'with_my_diver' => (int)rand(0,1),
                    'provide_self_drive' => (int)rand(0,1),
                    'insured' => (int)rand(0,1),
                    'tracker' => (int)rand(0,1),
                    'registration_no' => rand(10000,1000000),
                    'owner_nic' => rand(100000,10000000),
                ]);
            }

            // photographer and movie maker
            if ($user->role_id == 5 || $user->role_id == 9) {
                for ($x = 0; $x <= 2; $x++) {
                    PhotographerSkillLink::create([
                        'active' => 1,
                        'user_id' => $user->id,
                        'skill_id' => $x + 1
                    ]);
                    PhotographerTypeLink::create([
                        'active' => 1,
                        'user_id' => $user->id,
                        'type_id' => $x + 1
                    ]);
                }
            } elseif ($user->role_id == 6) {
                for ($x = 0; $x <= 6; $x++) {
                    UserCountry::create([
                        'user_id' => $user->id,
                        'country_id' => $x + 1,
                        'ref_type' => 'visa_consultant',
                    ]);
                }
            }

        });
    }
}
