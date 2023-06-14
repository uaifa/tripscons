<?php

use App\Http\Controllers\Admin\BookingsController;
use App\Http\Controllers\Api\DestinationsController;
use App\Http\Controllers\Api\InquiriesController;
use App\Http\Controllers\Api\PaymentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/authenticated', function () {
    return auth()->user();
});
Route::post('saveLog', 'Api\LogsController@create');
Route::get('teststripe', 'Api\BookingsController@teststripe');
Route::post('addData', 'Api\TripsconController@add');
Route::delete('deleteData/{module}', 'Api\HelperController@deleteData');
Route::post('setExchangeRates', 'Api\HelperController@setExchangeRates');

Route::get('getAccommodationFacilities/{accommodation_id}', 'Api\HelperController@getAccommodationFacilities');
Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');
Route::post('byPassAuth', 'Api\AuthController@byPassAuth');

Route::post('loginWithPhone', 'Api\AuthController@loginWithPhone');
Route::post('verifyPhoneCodeWithPhone', 'Api\AuthController@verifyPhoneCodeWithPhone');
Route::post('sendEmailForResetPassword', 'Api\AuthController@sendEmailForResetPassword');
Route::post('updateForgotPassword', 'Api\AuthController@updateForgotPassword');

// google social login
Route::any('auth/google', 'Api\AuthController@redirectToGoogle');
Route::get('auth/google/callback','Api\AuthController@handleGoogleCallback');

// facebook social login
Route::any('auth/facebook', 'Api\AuthController@redirectToFacebook');
Route::get('auth/facebook/callback','Api\AuthController@handleFacebookCallback');

Route::post('auth/google/getUserInfo','Api\AuthController@getGoogleUserInfo');

Route::post('socialRegister', 'Api\AuthController@socialRegister');

Route::get('getAllFacilities', 'Api\HelperController@getAllFacilities');
Route::get('getAllActivities', 'Api\HelperController@getAllActivities');
Route::post('stripeListen', 'Api\HelperController@stripeListen');
Route::get('getPackageAllActivities', 'Api\HelperController@getPackageAllActivities');
Route::get('getPackageAllServices', 'Api\HelperController@getPackageAllServices');

//Route::get('abc', [HelperController::class, 'abcd']);
//Route::get('getAllActivities', 'Api\HelperController@getAllActivities');

Route::post('accommodation', 'Api\AccommodationController@index');
Route::get('getAccommodationDetail/{id}', 'Api\AccommodationController@AccommodationDetail');
Route::get('delete-service/{id}', 'Api\AccommodationController@deleteAccomodationService');
Route::get('delete-service/{module}/{id}', 'Api\AccommodationController@deleteService');

Route::get('getAccommodationSubType/{id}', 'Api\AccommodationController@getAccommodationSubType');
Route::get('transportFacilities', 'Api\VehicleController@facilities');

//get main dashboard
Route::any('getDashboard', 'Api\HomeController@index');
Route::post('getDashboardData', 'Api\HomeController@getDashboardData');

// send app links
Route::post('sendAppLink', 'Api\HomeController@postAppLinks');
// Route::get('install-app', 'Api\HomeController@getAppLink');


/*
@Host Routes */
Route::post('host', 'Api\HostController@index');
Route::get('getHostDetail/{id}', 'Api\HostController@detail');
Route::post('getQuote', 'Api\HomeController@getQuote')->name('home.getQuote');
Route::post('sendInquiry', 'Api\HomeController@sendInquiry')->name('home.sendInquiry')->middleware("auth:api");

//trip mates
Route::post('mates', 'Api\UserController@index');
Route::get('getMateDetail/{id}', 'Api\UserController@detail');

/*@Vechile  Routes */
Route::post('vechile', 'Api\VehicleController@index');
Route::get('vechileDetail/{id}', 'Api\VehicleController@detail');

/*@Activity Routes */
Route::post('experiences', 'Api\ExperienceController@index');
Route::get('experienceDetail/{id}', 'Api\ExperienceController@detail');
Route::post('experienceAdd', 'Api\ExperienceController@store');
Route::post('experienceUpdate/{id}', 'Api\ExperienceController@update');

/*@Meal Routes */
Route::post('meal', 'Api\MealController@index');
Route::get('mealDetail/{id}', 'Api\MealController@detail');
Route::post('mealAdd', 'Api\MealController@store');
Route::post('mealUpdate/{id}', 'Api\MealController@update');
/*@Guide Routes */
Route::post('getAllServiceProviderForGuide', 'Api\GuideController@index');
Route::get('getGuidePackageDetail/{id}', 'Api\GuideController@detail');
Route::post('getGuidePackages/{id}', 'Api\GuideController@guiderDetail');
Route::post('getGuideDetail/{id}', 'Api\GuideController@getGuideDetail');
Route::post('getActivePastPackages/{id}', 'Api\GuideController@getActivePastPackages');

/*@ServiceProviders Routes */
Route::get('getServiceProviderDetail/{id}', 'Api\ServicesProviderController@detail');

/*@Trip Routes */
Route::post('trip', 'Api\TripController@index');
Route::get('tripDetail/{id}', 'Api\TripController@detail');
Route::post('tripAdd', 'Api\TripController@store');
Route::post('tripUpdate/{id}', 'Api\TripController@update');

/*@Visa Consultant Routes */
Route::post('visaConsultant', 'Api\VisaConsultantController@index');
Route::get('visaConsultantDetail/{id}', 'Api\VisaConsultantController@detail');
Route::post('visaConsultantAdd', 'Api\VisaConsultantController@store');
Route::post('visaConsultantUpdate/{id}', 'Api\VisaConsultantController@update');
/*@Movie Maker Routes */
Route::post('movieMaker', 'Api\MediaController@index');
Route::get('movieMakerDetail/{id}', 'Api\MediaController@detail');
Route::post('movieMakerAdd', 'Api\MediaController@store');
Route::post('movieMakerUpdate/{id}', 'Api\MediaController@update');
/*@Trip Operator Routes */
Route::post('tripOperator', 'Api\TripOeratorController@index');
Route::get('tripOperatorDetail/{id}', 'Api\TripOeratorController@detail');

/*@Restaurants Routes */
Route::post('restaurant', 'Api\RestaurantController@index');
Route::get('restaurantDetail/{id}', 'Api\RestaurantController@detail');
Route::get('getSlots', 'Api\HostController@getSlots');

//for accommodation booking
Route::post('checkAccommodationAvailability', 'Api\AccommodationController@checkAccommodationAvailability');
//Route::post('checkAvailability', 'Api\BookingsController@checkAvailability');
Route::post('checkVehicleAvailability', 'Api\VehicleController@checkAvailability');
Route::post('checkMealAvailability', 'Api\MealController@checkAvailability');
Route::post('checkExperienceAvailability', 'Api\ExperienceController@checkAvailability');
Route::get('getRules', 'Api\HostController@getRules');
Route::get('getPaymentGateWayDetails', 'Api\HelperController@getPaymentGateWayDetails');

Route::post('checkServiceProviderAvailability', 'Api\ServiceProviderBookingsController@checkServiceProviderAvailability');
Route::post('getHostAccommodation', 'Api\HostController@host_accommodation');
Route::get('getUserProfile', 'Api\UserController@getUserProfile');
Route::post('getHostExperiencies', 'Api\HostController@experiencies');
Route::post('getHostTransports', 'Api\HostController@transports');
Route::post('getHostMeals', 'Api\HostController@meals');
Route::get('getRooms/{accommodation_id}', 'Api\HostController@getRooms');
Route::post('getAvailableRooms', 'Api\HostController@getAvailableRooms');

Route::get('getRoomDetail/{room_id}', 'Api\HostController@getRoomDetail');
Route::post('checkRoomAvailability', 'Api\AccommodationController@checkRoomAvailability');

Route::post('cancellation-policy/{accommodation_id}', 'Api\HelperController@getCancellationPolicy');
Route::get('getVehicleTypes/{type}', 'Api\HelperController@getVehicleTypes');
Route::get('getActivityTypes/{type}', 'Api\HelperController@getActivityTypes');
Route::post('verifyAccount', 'Api\AuthController@verifyAccount');
Route::post('trip-mate-list', 'Api\TripMateController@tripMateList');
Route::post('getTransportFeature', 'Api\HelperController@getTransportFeature');
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('leads', [InquiriesController::class, 'index']);
    Route::post('leads/find', [InquiriesController::class, 'byId']);

    
    // save inquiry proposal
    Route::post('postProposal', [InquiriesController::class,'saveProposal']);
    // 
    Route::get('getInquiries', [InquiriesController::class, 'getInquiries']);
    Route::get('getInquiryProposals', [InquiriesController::class, 'getInquiryProposals']);

    Route::post('proposal/detail', [InquiriesController::class, 'getProposalDetail']);

    // Route::post('create/inquiry/booking', [InquiriesController::class, 'createBooking']);


    Route::post('confirmationMail', 'Api\AuthController@confirmationMail');

    Route::post("pay", [PaymentsController::class, 'pay']);
    Route::patch('cancellation-policy/{bookable}', 'Api\HelperController@updateCancellationPolicy');
    Route::post('cancellation-policy', 'Api\HelperController@updateCancellationPolicyApi');
    Route::post('register-device-token', 'Api\AuthController@deviceTokenRegister');

    // for service-providers
    Route::get('guideEdit/{id}', 'Api\GuideController@detail');
    Route::post('guideAdd', 'Api\GuideController@store');
    Route::post('updateGuidePackage/{id?}', 'Api\GuideController@updateGuide');
    Route::post('getServicerProviderGuides', 'Api\GuideController@getGuidesForServiceProvider');
    Route::post('getPastPackages', 'Api\GuideController@getPastPackages');


    Route::post('createPaymentIntent', 'Api\BookingsController@createPaymentIntent');

    Route::post('createServiceProviderBooking', 'Api\ServiceProviderBookingsController@createServiceProviderBooking');
    Route::post('switchProfile', 'Api\HostController@switchProfile');
    Route::post('paymentMethodsCreateUpdate', 'Api\HostController@paymentMethodsCreateUpdate');
    Route::get('getPaymentMethodDetails', 'Api\HostController@getPaymentMethodDetails');

    Route::delete('deleteUser', 'Api\UserController@deleteUser');


    /**
     * @Description Api\AuthController
     * @Author Mubasher Hussain.
     */
    Route::post('logout', 'Api\AuthController@logout');
    Route::post('sendPhoneCode', 'Api\AuthController@sendPhoneCode');
    Route::post('verifyPhoneCode', 'Api\AuthController@verifyPhoneCode');
    Route::post('userImageUpdate', 'Api\HostController@Imagestore');
    Route::get('getUserActivities', 'Api\HelperController@getUserActivities');

    Route::post('userActivityAdd', 'Api\UserController@userActivityAdd');
    Route::get('getUserProfile', 'Api\UserController@getUserProfile');
    Route::post('AddUserDocument', 'Api\UserController@AddUserDocument');
    Route::delete('deleteDocument/{document_id}', 'Api\UserController@deleteDocument');
    Route::get('getUserDocuments', 'Api\UserController@getUserDocuments');
    Route::post('updateUser', 'Api\UserController@updateUser');
    // Pdf Download
    Route::get('/booking-invoice-pdf/{booking_id}','InvoiceController@bookingInvoice');

    /*Host Controller private apis Start Here*/
    Route::get('getHostDashboard', 'Api\HostController@host_dashboard');

    Route::post('accommodationAdd', 'Api\HostController@addAccommodation');
    Route::post('accommodationUpdate', 'Api\HostController@updateAccommodation');

    Route::post('accommodationFacilityAdd', 'Api\HostController@accommodationFacilityAdd');

    Route::post('accommodationFacilityAdd', 'Api\HostController@accommodationFacilityAdd');

    //for meal
    Route::post('addMeal', 'Api\HostController@addMeal');
    Route::post('updateMeal', 'Api\HostController@updateMeal');


    //for transport
    Route::post('addTransport', 'Api\HostController@addTransport');
    Route::post('updateTransport', 'Api\HostController@updateTransport');

    Route::post('addTransportAccessories', 'Api\HostController@addTransportAccessories');

    Route::post('removeTransportFeatures', 'Api\HelperController@removeTransportFeatures');

    //for transport
    Route::post('addExperience', 'Api\HostController@addExperience');
    Route::post('updateExperience', 'Api\HostController@updateExperience');

    Route::post('addSlot', 'Api\HostController@addSlot');
    Route::delete('deleteSlot/{id}', 'Api\HostController@deleteSlot');

    //for booking
    Route::post('createAccommodationBooking', 'Api\AccommodationController@createBooking');
    // for vechicle booking
    Route::post('createVehicleBooking', 'Api\VehicleController@createBooking');
    //for meals booking ...
    Route::post('createMealBooking', 'Api\MealController@createBooking');
    //for meals booking ...
    Route::post('createExperienceBooking', 'Api\ExperienceController@createBooking');
    Route::post('updateBooking', 'Api\BookingsController@updateBooking');
    Route::get('getMyBookings/{module?}', 'Api\BookingsController@index');
    Route::get('getMyBookingsForWeb/{module?}', 'Api\BookingsController@getMyBookingsForWeb');
    Route::any('client/bookings', 'Api\BookingsController@getClientBookings');
    Route::any('host/bookings', 'Api\BookingsController@getHostBookings');
    Route::any('host/bookings/accept', 'Api\BookingsController@accept');



    Route::post('cancelBooking', 'Api\PaymentsController@refund');
    Route::post('cancelBooking/details', 'Api\PaymentsController@refundDetails');
    Route::post('updateBookingStatus', 'Api\BookingsController@updateBookingStatus');

    Route::get('getProviderBookings/{module?}', 'Api\BookingsController@getProviderBookings');
    Route::get('getProviderBookingsForWeb/{module?}', 'Api\BookingsController@getProviderBookingsForWeb');
    Route::post('getBookingDetail', 'Api\BookingsController@detail');
    Route::post('checkout', 'Api\BookingsController@checkout');
    Route::get('getCards', 'Api\BookingsController@getCards');
    Route::get('getCard/{id}', 'Api\BookingsController@getCard');
    Route::delete('deleteCard', 'Api\BookingsController@deleteCard');



    Route::post('uploadImages', 'Api\HostController@uploadImages');
    Route::post('updateOrCreateRoom', 'Api\HostController@updateOrCreateRoom');
    Route::delete('deleteRoom/{room_id}', 'Api\HostController@deleteRoom');
    //host change password
    Route::post('changePassword', 'Api\AuthController@changePassword');

    Route::delete('deleteImage/{image_id}', 'Api\HostController@deleteImage');

    Route::post('addRule', 'Api\HostController@addRule');
    Route::delete('deleteRule/{module_id}', 'Api\HostController@deleteRule');
    // Route::get('getRules', 'Api\HostController@getRules');

    //places add
    Route::post('addPlace', 'Api\PlaceController@addPlace');
    Route::delete('deletePlace', 'Api\PlaceController@deletePlace');
    Route::get('getPlaces', 'Api\PlaceController@getPlaces');
    /*Host Controller private apis Ended Here*/
    /**
     * @Description Api\HelperController
     * @Author Mubasher Hussain.
     */

    Route::get('getAllLanguages', 'Api\HelperController@getAllLanguages');
    Route::get('getAllAmenities', 'Api\HelperController@getAllAmenities');

    // Route::get('getAllCountries', 'Api\HelperController@getAllCountries');
    Route::get('getAllPhotographerSkills', 'Api\HelperController@getAllPhotographerSkills');
    Route::get('getAllPhotographerTypes', 'Api\HelperController@getAllPhotographerTypes');
    Route::get('getAllVehicles', 'Api\HelperController@getAllVehicles');
    Route::get('getStatesByCountryId/{countryId}', 'Api\HelperController@getStatesByCountryId');
    Route::get('getCitiesByStateId/{stateId}', 'Api\HelperController@getCitiesByStateId');
    Route::get('getAllMeals', 'Api\HelperController@getAllMeals');
    Route::post('getCurrentUserData', 'Api\HelperController@getCurrentUserData');
    Route::get('getRoles', 'Api\HelperController@getRoles');
    Route::post('getAllKnowledgeCities', 'Api\HelperController@getAllKnowledgeCities');
    Route::get('getHostServices', 'Api\HelperController@getHostServices');

    Route::get('list/data', 'Api\HelperController@getListData');

    /**
     * @Description Api\ProfileController
     * @Author Khuram Qadeer.
     */
    Route::post('account/info/update', 'Api\ProfileController@accountInfoUpdate');
    Route::post('update/user/profile/image', 'Api\ProfileController@updateProfileImage');
    Route::post('update/user/professional/info', 'Api\ProfileController@updateProfessionalInfo');
    Route::post('update/role', 'Api\ProfileController@updateUserRole');

    // activities
    Route::post('addUpdateGuidePackageActivities/{id?}', 'Api\GuideController@updateActivity');
    Route::post('addUpdateGeneralServices', 'Api\GeneralServicesController@addUpdateGeneralService');
    Route::post('addGuidePackage', 'Api\GuideController@addGuide');
    Route::post('addPackage', 'Api\GuideController@addPackage');


    // Route::post('getMyGuidePackages', 'Api\GuideController@guiderDetail');
    Route::post('getMyGuidePackages/{package_id?}', 'Api\GuideController@getMyGuidePackages');

    // add trip facilities
    Route::post('addPackageFacilities', 'Api\PackageFacilitiesController@addPackageFacilities');
    Route::post('addPackageItinerary', 'Api\PackageFacilitiesController@addPackageItinerary');

    Route::post('addAndUpdateActivitiesWeDo', 'Api\UserController@addAndUpdateActivitiesWeDo');
    Route::post('addAndUpdateOurExpertise', 'Api\UserController@addAndUpdateOurExpertise');

    Route::post('addRating', 'Api\RatingController@addRating');
    Route::post('addVendorRating', 'Api\RatingController@addVendorRating');
    Route::post('getHostRating', 'Api\RatingController@getHostRating');

    Route::post('addUpdatePackagesCoveredEvents', 'Api\CoveredEventsController@addUpdatePackagesCoveredEvents');

    Route::get('getOurTeams', 'Api\OurTeamsController@getOurTeams');
    Route::post('addOurTeam', 'Api\OurTeamsController@addOurTeam');
    Route::get('getOurTeamDetail/{team_id}', 'Api\OurTeamsController@getOurTeamDetail');
    Route::post('updateOurTeam/{team_id}', 'Api\OurTeamsController@updateOurTeam');
    Route::delete('deleteOurTeam/{team_id}', 'Api\OurTeamsController@deleteOurTeam');
    Route::post('addCountries', 'Api\HelperController@addCountries');
    Route::post('uploadGallryImages', 'Api\GalleriesController@uploadGallryImages');
    Route::delete('deleteGalleryImage/{image_id}', 'Api\GalleriesController@deleteGalleryImage');
    Route::get('getGalleryImages', 'Api\GalleriesController@getGalleryImages');
    // cheff
    Route::post('getCheffs', 'Api\CheffsController@index');
    Route::post('addCheff', 'Api\CheffsController@addCheff');
    Route::post('uploadImageBase64', 'Api\HelperController@uploadImageBase64');
    Route::post('uploadRestaurantImage', 'Api\HelperController@uploadImageBase64');
    Route::post('uploadGalleryImageBase64', 'Api\GalleriesController@uploadGalleryImageBase64');

    Route::post('updateFeaturedImage', 'Api\HelperController@updateFeaturedImage');
    Route::post('addCompany','Api\CompanyController@addCompany');

    Route::post('uploadDocument','Api\HelperController@uploadDocument');

    Route::post('uploadVideo', 'Api\UploadVideosController@uploadVideo');
    Route::post('uploadVideoUrl', 'Api\UploadVideosController@uploadVideoUrl');


    Route::post('copyPackageRecord', 'Api\GuideController@copyPackageRecord');

    Route::post('is_published', 'Api\GuideController@is_published');

    Route::post('planned-trip', 'Api\PlannedTripsController@create');

    Route::post('updatePackageStatus', 'Api\GuideController@updatePackageStatus');
    Route::post('book', [BookingsController::class, 'book']);
    Route::post('booking-details', [BookingsController::class, 'details']);

//   start tripmate routes private
    Route::post('add-trip-mate',                                'Api\TripMateController@createTrip');
    Route::post('trip-mate-list',                               'Api\TripMateController@tripMateList');
    Route::post('past-trips-list',                              'Api\TripMateController@pastTripsList');
    Route::post('send-tripmate-invitation',                     'Api\TripMateController@tripMateInvitation');
    Route::post('my-invitation-list',                           'Api\TripMateController@getInvitationList');
    Route::post('send-trip-request-list',                       'Api\TripMateController@getSendRequestList');
    Route::post('trip-request-accept',                          'Api\TripMateController@TripMateAccept');
    Route::post('trip-request-reject',                          'Api\TripMateController@TripMateReject');
    Route::delete('trip-mate-delete/{tripId}',                  'Api\TripMateController@TripMateDelete');
// end
    Route::post('send-booking-notification',                    'Api\AuthController@sendNotification');
    Route::post('device-badges-list',                           'Admin\DeviceBadgesController@deviceBadgesList');
    Route::post('device-badges-reset',                          'Admin\DeviceBadgesController@deviceBadgesReset');
    Route::get('message-notification-counts',                   'Admin\NotificationController@notificationCounter');
    Route::get('notification-clear/{type}',                     'Admin\NotificationController@notificationClear');
    Route::post('notification-list',                            'Admin\NotificationController@notificationList');

    // checkauthuser
    Route::post('checkAuthUser', 'Api\AuthController@checkAuthUser');


    //update user role
    Route::post('updateUserRole', 'Api\GeneralServicesController@updateUserRole');


});

// Route::post('book', [BookingsController::class, 'book']);


Route::post('getReviews','Api\RatingController@getReviews');

Route::get('pages-list',                                                'Api\SeodataController@seoPagesList');
Route::get('pages-list/{type}',                                         'Api\SeodataController@seoPagesListType');
Route::post('add-seodata',                                              'Api\SeodataController@addSeodata');
Route::get('get-seodata/{page_type?}/{user_module_type?}/{package_id?}','Api\SeodataController@getSeodata');

//start tripmate public routes
Route::post('trip-mate-listings',                                       'Api\TripMateController@tripMateListing');
Route::post('past-trip-mate-listings',                                  'Api\TripMateController@pastTripMateListing');
Route::post('trip-mates',                                               'Api\TripMateController@tripMates');
Route::get('latest-trip-mates',                                         'Api\TripMateController@latestTripMates');
Route::get('trip-mate-detail/{id}',                                     'Api\TripMateController@TripMateDetails');
// end

Route::get('getTeams/{user_id}', 'Api\OurTeamsController@getTeams');
Route::get('guideDetail/{id}', 'Api\GuideController@detail');

Route::post('addPackageProperties', 'Api\PackageFacilitiesController@addPackageProperties')->middleware('auth:api');
Route::post('addPackageVideosUrl', 'Api\PackageFacilitiesController@addPackageVideosUrl')->middleware('auth:api');


Route::post('submitEnquiery', 'Api\MakeEnquieryController@submitEnquiery');
Route::get('getOurExpertiseActivitiesWeDo', 'Api\HelperController@ourExpertiseActivitiesWeDo');

Route::post('getTripPackages', 'Api\GuideController@getTripPackages');

Route::get('getGeneralServices', 'Api\HelperController@getGeneralServices');
Route::get('getLanguagesAndDestinations', 'Api\HelperController@destinationsLanguages');

Route::get('available/hotels', 'Admin\HotelSearchApiController@searchAvailableHotels');
Route::get('available/hotel/detail/{id?}', 'Admin\HotelSearchApiController@getHotelDetail');
Route::get('available/hotel/details/info', 'Admin\HotelSearchApiController@hotelinfoDetail');

Route::get('getCoveredEvents', 'Api\CoveredEventsController@getCoveredEvents');

Route::get('getAllCountries', 'Api\HelperController@getAllCountries');
Route::get('getExchangeCurrency', 'Api\HelperController@getExchangeCurrency');

Route::get('getCountries', 'Api\HelperController@getCountries');

Route::post('device-details',               'Admin\DeviceDetailsController@deviceDetailCreate');
Route::post('device-badges-update',         'Admin\DeviceBadgesController@deviceBadgesUpdate');
Route::post('device-badges-create',         'Admin\DeviceBadgesController@deviceBadgesCreate');
Route::post('device-badges-remove',         'Admin\DeviceBadgesController@removeDeviceDetails');

Route::get('date', function () {
    $dt = new \DateTime();
    echo $dt->format('Y-m-d');
    die;
});

Route::post('refresh-cart', [BookingsController::class, 'refresh']);

Route::get('get-latlng', function(){
    $password = bcrypt('1');
    dd($password);
    // function unzip($source, $destination) {

    $destination = 'https://vendors-api.tripscon.com/tessst.php.zip';
    //@mkdir($destination, 0777, true);

    $path = 'https://alpha-api.tripscon.com/tessst.php.zip';

    if(file_exists($path)){
        File::copy($path, $destination);
    }
    echo 1;
});

Route::get('getVersion', 'Api\HelperController@getVersion');


Route::get('addThumbImage/{id}', 'Api\UserController@copyImageToThumb');

Route::get('getLatLong','Api\UserController@copiedRestaurantAddress');

Route::post('uploadImageFromAdmin', 'Api\HelperController@uploadImageBase64');

Route::get('check-booking', 'Api\HomeController@checkReservation');


Route::get('destinations', [DestinationsController::class, 'index']);

Route::get('copyImageToThumb/{type?}','Api\HelperController@copyImageToThumb');
Route::get('copyPackagesImageToThumb/{module_type}','Api\HelperController@copyPackagesImageToThumb');
Route::post('fixedFeatureImage/{module_type}','Api\HelperController@fixedFeatureImage');

Route::get('explore/{page_name?}','Api\DestinationsController@explorePageName');
Route::get('explore/{page_name}/{type}','Api\DestinationsController@serviceType');
