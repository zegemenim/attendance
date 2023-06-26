<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('reports');
    Route::get('/prayer-attendance/{floor?}', 'AttendanceController@prayer')->name('attendance.prayer');
    Route::post('/prayer-attendance/{floor?}', 'AttendanceController@prayer')->name('attendance.prayer.post');
    Route::get('/study-attendance/{study_room?}', 'AttendanceController@study')->name('attendance.study');
    Route::post('/study-attendance/{study_room?}', 'AttendanceController@study')->name('attendance.study.post');
    Route::get('/sleep-attendance/{floor?}/{room?}', 'AttendanceController@sleep')->name('attendance.sleep');
    Route::post('/sleep-attendance/{floor?}/{room?}', 'AttendanceController@sleep')->name('attendance.sleep.post');
});


//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
