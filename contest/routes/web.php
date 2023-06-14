<?php

use App\Http\Controllers\EntriesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StreamsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialController;
use App\Http\Livewire\LiveHomeComponent;
use App\Http\Livewire\LiveRulesComponent;
use App\Http\Livewire\LiveSingleEntryComponent;
use App\Http\Livewire\LiveSubmitEntryComponent;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', LiveHomeComponent::class);
Route::get('/media/{filePath}', [StreamsController::class, 'index'])->name('stream');
Route::get('/view/{entry}/{title?}', LiveSingleEntryComponent::class)->name('entry');
Route::get('auth/facebook', [SocialController::class, 'facebookRedirect']);
Route::get('auth/facebook/callback', [SocialController::class, 'loginWithFacebook']);
Route::get('auth/google', [SocialController::class, 'googleRedirect']);
Route::get('auth/google/callback', [SocialController::class, 'loginWithGoogle']);
Route::get('entry/submit/{contest}', LiveSubmitEntryComponent::class)->name('submit-entry');
Route::get('rules', LiveRulesComponent::class);
Route::get('stream/{filename}', [\App\Http\Controllers\VideoStreamsController::class, 'index']);


Route::get('/logout', function(){
    Auth::logout();
    return redirect('/');
});
