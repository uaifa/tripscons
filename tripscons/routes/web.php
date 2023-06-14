<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Conversion;
use App\Country;
use App\FacilityLink;
use App\GuideProfile;
use App\Order;
use App\PasswordReset;
use App\User;
use App\UserAccommodation;
use App\Host;
use App\Http\Controllers\Api\PaymentsController;
use App\Http\Controllers\SmsController;
use App\Libs\Firebase\Firebase;
use App\UserHostAvailability;
use App\UserMeal;
use App\UserTransport;
use App\VisaConsultantProfile;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
//use Config;


// auth routes
Auth::routes();
// Route::get('/{any}', function () {
//     return view('basic.index');
// })->where('any', '.*');

/*
Route::get('/', 'HomeController@index')->name('/');
Route::match(array('GET','POST'),'/accommodations', 'HomeController@nearByAccommodations');
Route::match(array('GET','POST'),'/accommodations', 'AccommodationController@index');
Route::get('accommodations/detail/{id}', 'AccommodationController@detail');

Route::match(array('GET','POST'),'/hosts', 'HostController@index');
Route::get('hosts/detail/{id}', 'HostController@detail');

Route::get('getAllActivities', 'HomeController@getAllActivities')->name('home.getAllActivities');
Route::post('/search', 'HomeController@search')->name('home.search');
Route::post('/search/filter/', 'HomeController@searchFilter')->name('home.searchFilter');
Route::get('getTopRated/{type}', 'HomeController@getTopRated')->name('home.getTopRated');
Route::post('getQuote', 'HomeController@getQuote')->name('home.getQuote');
Route::get('/hosts', 'HomeController@nearByHosts')->name('home.nearByHosts');

Route::get('map/view/accommodations/{activeAccommodationId}', 'HomeController@nearByMapViewAccommodations')->name('home.nearByMapViewAccommodations');
Route::get('map/view/activities/{activeId}', 'HomeController@nearByMapViewActivities')->name('home.nearByMapViewActivities');
*/




Route::get("testing", function(){
    dd("testing account ");
});

/**
 * @Description Testing Routes
 * @Author Khuram Qadeer.
 */
Route::get('test', function () {
    $firebase = new Firebase();
    $firebase->setTitle("Test");
    $firebase->setBody("Hi this is a test");
    $firebase->setToTokens("cg0z2a1ZZEpprSiCnu4ggo:APA91bGn4Oy1D_9gW7xAe-402tDZcK1j8Um3rvLLAgLAkZ4m3hgAAyPDX-J0uscQk7369RwJq9T_gSeY_Vdc-4J2ovcS4AbbKWN0GMcl1Z_rKtQ5k_sTZ-KgASjFxlwl9UvG8OJ3UIQf");

    return $firebase->send();
    // return SmsController::send('13072205075', "Thank you tripscon1234");
    //dd(\App\Package::getDateWisePackageAvailableDates(9));
    //    dd(getAllDatesBetween('2020-07-09','2020-07-20','m-d-Y'));
    //    guide
    //    $users = User::where('role_id', 4)->get();
    //    if ($users) {
    //        foreach ($users as $user) {
    //            if (!$user->role_profile_id) {
    //                $roleProfile = GuideProfile::create([
    //                    'user_id' => Auth::id(),
    //                    'tag_line' => $user->tag_line,
    //                    'about' => $user->about,
    //                    'hourly_rate' => rand(10, 1000),
    //                    'offer_free_service' => 0,
    //                    'multi_city_service' => 0,
    //                ]);
    //                $user->update([
    //                    'is_profile_complete' => 0,
    //                    'role_profile_id' => $roleProfile->id,
    //                ]);
    //            }
    //        }
    //    }


    //    $hosts =User::where('is_host',1)->get();
    //    if ($hosts){
    //        foreach ($hosts as $host) {
    //            if (!$host->longitude || !$host->latitude){
    //                $host->update([
    //                   'longitude'=>71.46700799999999,
    //                   'latitude'=>30.1826048 ,
    //                ]);
    //            }
    //        }
    //    }

});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('admin-users')->name('admin-users/')->group(static function () {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('users')->name('users/')->group(static function () {
            Route::get('/',                                             'UsersController@index')->name('index');
            Route::get('/create',                                       'UsersController@create')->name('create');
            Route::post('/',                                            'UsersController@store')->name('store');
            Route::get('/{user}/edit',                                  'UsersController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'UsersController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{user}',                                      'UsersController@update')->name('update');
            Route::delete('/{user}',                                    'UsersController@destroy')->name('destroy');
            Route::get('/user-document',                                'UsersController@userDocIndex')->name('userDocIndex');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('activities')->name('activities/')->group(static function () {
            Route::get('/',                                             'ActivitiesController@index')->name('index');
            Route::get('/create',                                       'ActivitiesController@create')->name('create');
            Route::post('/',                                            'ActivitiesController@store')->name('store');
            Route::get('/{activity}/edit',                              'ActivitiesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ActivitiesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{activity}',                                  'ActivitiesController@update')->name('update');
            Route::delete('/{activity}',                                'ActivitiesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('admin-users')->name('admin-users/')->group(static function () {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('facilities')->name('facilities/')->group(static function () {
            Route::get('/',                                             'FacilitiesController@index')->name('index');
            Route::get('/create',                                       'FacilitiesController@create')->name('create');
            Route::post('/',                                            'FacilitiesController@store')->name('store');
            Route::get('/{facility}/edit',                              'FacilitiesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'FacilitiesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{facility}',                                  'FacilitiesController@update')->name('update');
            Route::delete('/{facility}',                                'FacilitiesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('meal-types')->name('meal-types/')->group(static function () {
            Route::get('/',                                             'MealTypesController@index')->name('index');
            Route::get('/create',                                       'MealTypesController@create')->name('create');
            Route::post('/',                                            'MealTypesController@store')->name('store');
            Route::get('/{mealType}/edit',                              'MealTypesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'MealTypesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{mealType}',                                  'MealTypesController@update')->name('update');
            Route::delete('/{mealType}',                                'MealTypesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('trip-types')->name('trip-types/')->group(static function () {
            Route::get('/',                                             'TripTypesController@index')->name('index');
            Route::get('/create',                                       'TripTypesController@create')->name('create');
            Route::post('/',                                            'TripTypesController@store')->name('store');
            Route::get('/{tripType}/edit',                              'TripTypesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'TripTypesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{tripType}',                                  'TripTypesController@update')->name('update');
            Route::delete('/{tripType}',                                'TripTypesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('vehicle-types')->name('vehicle-types/')->group(static function () {
            Route::get('/',                                             'VehicleTypesController@index')->name('index');
            Route::get('/create',                                       'VehicleTypesController@create')->name('create');
            Route::post('/',                                            'VehicleTypesController@store')->name('store');
            Route::get('/{vehicleType}/edit',                           'VehicleTypesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'VehicleTypesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{vehicleType}',                               'VehicleTypesController@update')->name('update');
            Route::delete('/{vehicleType}',                             'VehicleTypesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('trip-facilities')->name('trip-facilities/')->group(static function () {
            Route::get('/',                                             'TripFacilitiesController@index')->name('index');
            Route::get('/create',                                       'TripFacilitiesController@create')->name('create');
            Route::post('/',                                            'TripFacilitiesController@store')->name('store');
            Route::get('/{tripFacility}/edit',                          'TripFacilitiesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'TripFacilitiesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{tripFacility}',                              'TripFacilitiesController@update')->name('update');
            Route::delete('/{tripFacility}',                            'TripFacilitiesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('trip-categories')->name('trip-categories/')->group(static function () {
            Route::get('/',                                             'TripCategoryController@index')->name('index');
            Route::get('/create',                                       'TripCategoryController@create')->name('create');
            Route::post('/',                                            'TripCategoryController@store')->name('store');
            Route::get('/{tripCategory}/edit',                          'TripCategoryController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'TripCategoryController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{tripCategory}',                              'TripCategoryController@update')->name('update');
            Route::delete('/{tripCategory}',                            'TripCategoryController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('meal-ingrediants')->name('meal-ingrediants/')->group(static function () {
            Route::get('/',                                             'MealIngrediantsController@index')->name('index');
            Route::get('/create',                                       'MealIngrediantsController@create')->name('create');
            Route::post('/',                                            'MealIngrediantsController@store')->name('store');
            Route::get('/{mealIngrediant}/edit',                        'MealIngrediantsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'MealIngrediantsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{mealIngrediant}',                            'MealIngrediantsController@update')->name('update');
            Route::delete('/{mealIngrediant}',                          'MealIngrediantsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('accommodation-sub-types')->name('accommodation-sub-types/')->group(static function () {
            Route::get('/',                                             'AccommodationSubTypesController@index')->name('index');
            Route::get('/create',                                       'AccommodationSubTypesController@create')->name('create');
            Route::post('/',                                            'AccommodationSubTypesController@store')->name('store');
            Route::get('/{accommodationSubType}/edit',                  'AccommodationSubTypesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'AccommodationSubTypesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{accommodationSubType}',                      'AccommodationSubTypesController@update')->name('update');
            Route::delete('/{accommodationSubType}',                    'AccommodationSubTypesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('accommodation-types')->name('accommodation-types/')->group(static function () {
            Route::get('/',                                             'AccommodationTypesController@index')->name('index');
            Route::get('/create',                                       'AccommodationTypesController@create')->name('create');
            Route::post('/',                                            'AccommodationTypesController@store')->name('store');
            Route::get('/{accommodationType}/edit',                     'AccommodationTypesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'AccommodationTypesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{accommodationType}',                         'AccommodationTypesController@update')->name('update');
            Route::delete('/{accommodationType}',                       'AccommodationTypesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function () {
        Route::prefix('trip-activities')->name('trip-activities/')->group(static function () {
            Route::get('/',                                             'TripActivitiesController@index')->name('index');
            Route::get('/create',                                       'TripActivitiesController@create')->name('create');
            Route::post('/',                                            'TripActivitiesController@store')->name('store');
            Route::get('/{tripActivity}/edit',                          'TripActivitiesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'TripActivitiesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{tripActivity}',                              'TripActivitiesController@update')->name('update');
            Route::delete('/{tripActivity}',                            'TripActivitiesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('admin-users')->name('admin-users/')->group(static function() {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('roles')->name('roles/')->group(static function() {
            Route::get('/',                                             'RolesController@index')->name('index');
            Route::get('/create',                                       'RolesController@create')->name('create');
            Route::post('/',                                            'RolesController@store')->name('store');
            Route::get('/{role}/edit',                                  'RolesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'RolesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{role}',                                      'RolesController@update')->name('update');
            Route::delete('/{role}',                                    'RolesController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('bookings')->name('bookings/')->group(static function() {
            Route::get('/',                                             'BookingsController@index')->name('index');
            Route::get('/booking-list',                                 'BookingsController@bookingList')->name('bookingList');
            Route::get('{booking}/detailed-view',                                'BookingsController@bookingDetail')->name('bookingDetail');
            Route::get('/create',                                       'BookingsController@create')->name('create');
            Route::post('/',                                            'BookingsController@store')->name('store');
            Route::get('/{booking}/edit',                               'BookingsController@edit')->name('edit');
            Route::post('/approve',                                     'BookingsController@approve')->name('approve');
            Route::post('/reject',                                      'BookingsController@reject')->name('reject');
            Route::post('/bulk-destroy',                                'BookingsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{booking}',                                   'BookingsController@update')->name('update');
            Route::delete('/{booking}',                                 'BookingsController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('permissions')->name('permissions/')->group(static function() {
            Route::get('/',                                             'PermissionsController@index')->name('index');
            Route::get('/create',                                       'PermissionsController@create')->name('create');
            Route::post('/',                                            'PermissionsController@store')->name('store');
            Route::get('/{permission}/edit',                            'PermissionsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'PermissionsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{permission}',                                'PermissionsController@update')->name('update');
            Route::delete('/{permission}',                              'PermissionsController@destroy')->name('destroy');
        });
    });
});
// Route::get('/booking-invoice-pdf/{booking_id}',              'InvoiceController@bookingInvoice')->name('index');


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('booking-activity-logs')->name('booking-activity-logs/')->group(static function() {
            Route::get('/',                                             'BookingActivityLogController@index')->name('index');
            Route::get('/create',                                       'BookingActivityLogController@create')->name('create');
            Route::post('/',                                            'BookingActivityLogController@store')->name('store');
            Route::get('/{bookingActivityLog}/edit',                    'BookingActivityLogController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'BookingActivityLogController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{bookingActivityLog}',                        'BookingActivityLogController@update')->name('update');
            Route::delete('/{bookingActivityLog}',                      'BookingActivityLogController@destroy')->name('destroy');
        });
    });
});

Route::get('payment/success/{handler}', [PaymentsController::class, 'success']);
Route::get('payment/iframe/{handler}/{reservation}', [PaymentsController::class, 'iframe']);


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('reservations')->name('reservations/')->group(static function() {
            Route::get('/',                                             'ReservationsController@index')->name('index');
            Route::get('/create',                                       'ReservationsController@create')->name('create');
            Route::post('/',                                            'ReservationsController@store')->name('store');
            Route::get('/{reservation}/edit',                           'ReservationsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ReservationsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{reservation}',                               'ReservationsController@update')->name('update');
            Route::delete('/{reservation}',                             'ReservationsController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('user-documents')->name('user-documents/')->group(static function() {
            Route::get('/',                                             'UserDocumentsController@index')->name('index');
            Route::get('/create',                                       'UserDocumentsController@create')->name('create');
            Route::post('/',                                            'UserDocumentsController@store')->name('store');
            Route::get('/{userDocument}/edit',                          'UserDocumentsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'UserDocumentsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{userDocument}',                              'UserDocumentsController@update')->name('update');
            Route::delete('/{userDocument}',                            'UserDocumentsController@destroy')->name('destroy');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('notifications')->name('notifications/')->group(static function() {
            Route::get('/',                                             'NotificationController@index')->name('index');
            Route::get('/create',                                       'NotificationController@create')->name('create');
            Route::post('/',                                            'NotificationController@store')->name('store');
            Route::get('/{notification}/edit',                          'NotificationController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'NotificationController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{notification}',                              'NotificationController@update')->name('update');
            Route::delete('/{notification}',                            'NotificationController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('device-details')->name('device-details/')->group(static function() {
            Route::get('/',                                             'DeviceDetailsController@index')->name('index');
            Route::get('/create',                                       'DeviceDetailsController@create')->name('create');
            Route::post('/',                                            'DeviceDetailsController@store')->name('store');
            Route::get('/{deviceDetail}/edit',                          'DeviceDetailsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'DeviceDetailsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{deviceDetail}',                              'DeviceDetailsController@update')->name('update');
            Route::delete('/{deviceDetail}',                            'DeviceDetailsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('device-badges')->name('device-badges/')->group(static function() {
            Route::get('/',                                             'DeviceBadgesController@index')->name('index');
            Route::get('/create',                                       'DeviceBadgesController@create')->name('create');
            Route::post('/',                                            'DeviceBadgesController@store')->name('store');
            Route::get('/{deviceBadge}/edit',                           'DeviceBadgesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'DeviceBadgesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{deviceBadge}',                               'DeviceBadgesController@update')->name('update');
            Route::delete('/{deviceBadge}',                             'DeviceBadgesController@destroy')->name('destroy');
        });
    });
});

Route::get('/cancellation-policy-data-insert-transports',                                 'TestingController@transports');
Route::get('/cancellation-policy-data-insert-accommodation',                              'TestingController@accommodation');
Route::get('/cancellation-policy-data-insert-user',                                       'TestingController@user');
Route::get('/cancellation-policy-data-insert-guide',                                      'TestingController@guide');
Route::get('/cancellation-policy-data-insert-meals',                                      'TestingController@meals');
Route::get('/cancellation-policy-data-insert-experiences',                                'TestingController@experiences');
Route::get('/cancellation-policy-data-remove-guides',                                     'TestingController@removeguides');
Route::get('/update-cancellation-policy-data',                                            'TestingController@updateCancelationpolicy');

Route::get('install-app','TestingController@getAppLink');



Route::get('send-mail', function () {
    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];
    \Mail::to('your_receiver_email@gmail.com')->send(new \App\Mail\MyTestMail($details));
    dd("Email is Sent.");
});