<?php
/**
 * @see https://github.com/Edujugon/PushNotification
 */

return [
    'gcm' => [
        'priority' => 'normal',
        'dry_run' => false,
        'apiKey' => 'My_ApiKey',
    ],
    'fcm' => [
        'priority' => 'normal',
        'dry_run' => false,
        'apiKey' => env('FCM_KEY', 'My_ApiKey'),
    ],
    'apn' => [
        'certificate' => __DIR__ . '/iosCertificates/apns-dev-cert.pem',
//        'passPhrase' => 'secret', //Optional
//        'passFile' => __DIR__ . '/iosCertificates/yourKey.pem', //Optional
        'dry_run' => false,
    ],

    'titles' => [
        'account_activated'                 => 'Account Activated',
        'account_verification'              => 'Account Verified',
        'user_reported'                     => 'You are Reported',
        'cancellation'                      => 'Booking Canceled',
        'booking_review'                    => 'Booking Reviewed',
        'review_received'                   => 'Review Received',
        'new_booking'                       => 'New Booking',
    ],
    'type_title' => [
        'user:activation'                   => 'User Activation',
        'user:approved'                     => 'User Approved',
        'booking:received'                  => 'New Booking',
        'user:report'                       => 'You are Reported',
    ]
];
