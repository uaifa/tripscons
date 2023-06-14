<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',

            //Belongs to many relations
            'roles' => 'Roles',

        ],
    ],

    'user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'email' => 'Email',
            'password' => 'Password',
            'phone' => 'Phone',
            'pin_code' => 'Pin code',
            'country_code' => 'Country code',
            'postal_code' => 'Postal code',
            'address' => 'Address',
            'service_provider_type' => 'Service provider type',
            'gender' => 'Gender',
            'country' => 'Country',
            'state' => 'State',
            'city' => 'City',
            'currency' => 'Currency',
            'lng' => 'Lng',
            'lat' => 'Lat',
            'social_platform' => 'Social platform',
            'social_platform_id' => 'Social platform',
            'device_type' => 'Device type',
            'device_token' => 'Device token',
            'about' => 'About',
            'role_id' => 'Role',
            'verified' => 'Verified',
            'date_of_birth' => 'Date of birth',
            'is_mate' => 'Is mate',
            'is_host' => 'Is host',
            'is_traveler' => 'Is traveler',
            'api_token' => 'Api token',
            'is_profile_complete' => 'Is profile complete',
            'role_profile_id' => 'Role profile',
            'rating' => 'Rating',
            'no_of_reviews' => 'No of reviews',
            'is_phone_verified' => 'Is phone verified',
            'email_verified_at' => 'Email verified at',
            'phone_verified_at' => 'Phone verified at',
            'languages' => 'Languages',
            'image' => 'Image',
            'status' => 'Status',
            'user_module_type' => 'User module type',
            'stripe_id' => 'Stripe',
            'pm_type' => 'Pm type',
            'pm_last_four' => 'Pm last four',
            'trial_ends_at' => 'Trial ends at',

        ],
    ],

    'activity' => [
        'title' => 'Activities',

        'actions' => [
            'index' => 'Activities',
            'create' => 'New Activity',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'image' => 'Image',

        ],
    ],

    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',

            //Belongs to many relations
            'roles' => 'Roles',

        ],
    ],

    'facility' => [
        'title' => 'Facilities',

        'actions' => [
            'index' => 'Facilities',
            'create' => 'New Facility',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'module_type' => 'Module type',
            'status' => 'Status',
            'image' => 'Image',

        ],
    ],

    'meal-type' => [
        'title' => 'Meal Types',

        'actions' => [
            'index' => 'Meal Types',
            'create' => 'New Meal Type',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
            'active' => 'Active',

        ],
    ],

    'trip-type' => [
        'title' => 'Trip Types',

        'actions' => [
            'index' => 'Trip Types',
            'create' => 'New Trip Type',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'category_id' => 'Category',

        ],
    ],

    'vehicle-type' => [
        'title' => 'Vehicle Types',

        'actions' => [
            'index' => 'Vehicle Types',
            'create' => 'New Vehicle Type',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',

        ],
    ],

    'trip-facility' => [
        'title' => 'Trip Facilities',

        'actions' => [
            'index' => 'Trip Facilities',
            'create' => 'New Trip Facility',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'image' => 'Image',
            'trip_id' => 'Trip',
            'is_included' => 'Is included',

        ],
    ],

    'trip-category' => [
        'title' => 'Trip Category',

        'actions' => [
            'index' => 'Trip Category',
            'create' => 'New Trip Category',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',

        ],
    ],

    'rip-activity' => [
        'title' => 'Rip Activities',

        'actions' => [
            'index' => 'Rip Activities',
            'create' => 'New Rip Activity',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',

        ],
    ],

    'meal-ingrediant' => [
        'title' => 'Meal Ingrediants',

        'actions' => [
            'index' => 'Meal Ingrediants',
            'create' => 'New Meal Ingrediant',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',

        ],
    ],

    'accommodation-sub-type' => [
        'title' => 'Accommodation Sub Types',

        'actions' => [
            'index' => 'Accommodation Sub Types',
            'create' => 'New Accommodation Sub Type',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'type_id' => 'Type',
            'name' => 'Name',

        ],
    ],

    'accommodation-type' => [
        'title' => 'Accommodation Types',

        'actions' => [
            'index' => 'Accommodation Types',
            'create' => 'New Accommodation Type',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',

        ],
    ],

    'trip-activity' => [
        'title' => 'Trip Activities',

        'actions' => [
            'index' => 'Trip Activities',
            'create' => 'New Trip Activity',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'image' => 'Image',
            'trip_id' => 'Trip',

        ],
    ],

    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',

            //Belongs to many relations
            'roles' => 'Roles',

        ],
    ],
    'role' => [
        'title' => 'Roles',

        'actions' => [
            'index' => 'Roles',
            'create' => 'New Role',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'guard_name' => 'Guard name',

        ],
    ],
    'booking' => [
        'title' => 'Bookings',

        'actions' => [
            'index' => 'Bookings',
            'create' => 'New Booking',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'user_id' => 'User',
            'provider_id' => 'Provider',
            'module_name' => 'Module name',
            'module_id' => 'Module',
            'price' => 'Price',
            'start_date' => 'Start date',
            'end_date' => 'End date',
            'no_of_nights' => 'No of nights',
            'total' => 'Total',
            'discount' => 'Discount',
            'grand_total' => 'Grand total',
            'status' => 'Status',
            'payment_status' => 'Payment status',
            'sub_total' => 'Sub total',
            'booking_number' => 'Booking number',
            'partial_amt' => 'Partial amt',
            'partial_amt_in_percentage' => 'Partial amt in percentage',
            'provider_name' => 'Provider name',
            'booking_type' => 'Booking type',
            'bookable' => 'Bookable',

        ],
    ],
    'reservation' => [
        'title' => 'Reservations',

        'actions' => [
            'index' => 'Reservations',
            'create' => 'New Reservation',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'user_id' => 'User',
            'reference_no' => 'Reference_no',
            'room_id' => 'Room ID',
            'provider_user_id' => 'Provider',
            'date_from' => 'Start date',
            'date_to' => 'End date',
            'bookable_id' => 'Bookable ID',
            'subtotal' => 'Sub Total',
            'discounttotal' => 'Discount Total',
            'grandtotal' => 'Grand total',
            'status' => 'Status',
            'payment_status' => 'Payment status',
            'minimum_payable_amount' => 'Minimum Payment',
            'remaining_amount' => 'Remaining Amount',
            'reservation_type' => 'Reservation Type',
            'partial_amt_in_percentage' => 'Partial amt in percentage',
            'provider_name' => 'Provider name',
            'booking_type' => 'Booking type',
            'bookable' => 'Bookable',

        ],
    ],
    'permission' => [
        'title' => 'Permissions',

        'actions' => [
            'index' => 'Permissions',
            'create' => 'New Permission',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'guard_name' => 'Guard name',

        ],
    ],
    'user-document' => [
        'title' => 'User Documents',

        'actions' => [
            'index' => 'User Document',
            'create' => 'New User Document',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'user_id' => 'User',
            'type' => 'Type',
            'front' => 'Front',
            'back' => 'Back',
            'expiry' => 'expiry',
            'status' => 'Status',

        ],
    ],
    // Do not delete me :) I'm used for auto-generation
];
