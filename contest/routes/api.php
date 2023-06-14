<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('get-contest', 'App\Http\Controllers\Api\HomeController@Contests')->name('get-contest');
Route::post('get-entries', 'App\Http\Controllers\Api\HomeController@Entries')->name('get-entries');
Route::post('social-register', 'App\Http\Controllers\Api\HomeController@socialRegister');
Route::post('share-contest', 'App\Http\Controllers\Api\HomeController@shareContest');
Route::post('entry-detail', 'App\Http\Controllers\Api\HomeController@EntryDetail');
Route::any('get-users', 'App\Http\Controllers\Api\UserController@getUsers');

// comment route
Route::post('getComments', 'App\Http\Controllers\Api\CommentController@getComments');
Route::get('get-comments-count/{entry_id}', 'App\Http\Controllers\Api\HomeController@getCommentsCount');


Route::group(['middleware' => 'auth:api'], function () {
    Route::post('contest-entry', 'App\Http\Controllers\Api\HomeController@submitEntry');
    Route::post('vote-cast', 'App\Http\Controllers\Api\HomeController@voteCast');
    Route::post('get-entry', 'App\Http\Controllers\Api\HomeController@getEntry');
    Route::post('delete-entry', 'App\Http\Controllers\Api\HomeController@deleteEntry');
    // comments api routes
    Route::post('comment-store', 'App\Http\Controllers\Api\CommentController@store');
    Route::post('reply-store', 'App\Http\Controllers\Api\CommentController@replyStore');
});


