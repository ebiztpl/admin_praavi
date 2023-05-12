<?php

use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Config\MailTemplateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SignedMediaController;
use Illuminate\Support\Facades\Route;

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

// website route
Route::get('/', HomeController::class);

Route::get('/app/config/mail-template/{mail_template}', [MailTemplateController::class, 'detail'])
    ->name('config.mail-template.detail')
    ->middleware('permission:config:store');

Route::get('/media/{media}/{conversion?}', SignedMediaController::class)->name('media');

Route::get('/auth/{provider}/redirect', [OAuthController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [OAuthController::class, 'callback']);

// app route
Route::get('/app/{vue?}', function () {
    return view('app');
})->where('vue', '[\/\w\.-]*')->name('app');

// Fallback route
Route::fallback(function () {
    abort(404);
});
