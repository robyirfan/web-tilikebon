<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TemperatureController;
use App\Http\Controllers\RelayController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');

    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');

    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [App\Http\Controllers\AuthController::class, 'profile'])->name('profile');
 
});


Route::get('/send-event', function () {
    $text ="Hallo ini event";
    broadcast(new \App\Events\HelloEvent($text));
});

Route::get('/cek', [App\Http\Controllers\MqttController::class, 'index']);

Route::get('/relay/on', [RelayController::class, 'turnOnRelay']);
Route::get('/relay/off', [RelayController::class, 'turnOffRelay']);

