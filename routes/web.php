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


Route::middleware(['auth'])->group(function () {

    Route::get('/prayer-attendance/{floor?}/{prayer_type?}', 'AttendanceController@prayer')->name('attendance.prayer');
    Route::post('/prayer-attendance/{floor?}/{prayer_type?}', 'AttendanceController@prayer')->name('attendance.prayer.post');
    Route::get('/study-attendance/{study_room?}', 'AttendanceController@study')->name('attendance.study');
    Route::post('/study-attendance/{study_room?}', 'AttendanceController@study')->name('attendance.study.post');
    Route::get('/sleep-attendance/{floor?}/{room?}', 'AttendanceController@sleep')->name('attendance.sleep');
    Route::post('/sleep-attendance/{floor?}/{room?}', 'AttendanceController@sleep')->name('attendance.sleep.post');

    Route::get('/admin/', 'AdminController@index')->name('admin.home');
    Route::get('/admin/users', 'AdminController@users')->name('admin.users');
    Route::get('/admin/edit_user/{user_id?}', 'AdminController@edit_user')->name('admin.edit_user');
});

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'HomeController@index')->name('reports');
    Route::get('/prayer', 'HomeController@index')->name('reports.prayer');
    Route::get('/study', 'HomeController@index')->name('reports.study');
    Route::get('/sleep', 'HomeController@index')->name('reports.sleep');
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

});
