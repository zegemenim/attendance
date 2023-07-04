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
    Route::post('/admin/edit_user/{user_id?}', 'AdminController@edit_user')->name('admin.edit_user.post');
    Route::get('/admin/delete_user/{user_id?}', 'AdminController@delete_user')->name('admin.delete_user');
    Route::get('/admin/add_user/', 'AdminController@add_user')->name('admin.add_user');
    Route::post('/admin/add_user/', 'AdminController@add_user')->name('admin.add_user.post');
    Route::get('/admin/rooms', 'AdminController@rooms')->name('admin.rooms');
    Route::get('/admin/add_room/', 'AdminController@add_room')->name('admin.add_room');
    Route::post('/admin/add_room/', 'AdminController@add_room')->name('admin.add_room.post');
    Route::get('/admin/edit_room/{room_id?}', 'AdminController@edit_room')->name('admin.edit_room');
    Route::post('/admin/edit_room/{room_id?}', 'AdminController@edit_room')->name('admin.edit_room.post');
    Route::get('/admin/delete_room/{room_id?}', 'AdminController@delete_room')->name('admin.delete_room');
    Route::post('/admin/delete_room/{room_id?}', 'AdminController@delete_room')->name('admin.delete_room.post');
    Route::get('/admin/floors', 'AdminController@floors')->name('admin.floors');
    Route::get('/admin/add_floor/', 'AdminController@add_floor')->name('admin.add_floor');
    Route::post('/admin/add_floor/', 'AdminController@add_floor')->name('admin.add_floor.post');
    Route::get('/admin/edit_floor/{floor_id?}', 'AdminController@edit_floor')->name('admin.edit_floor');
    Route::post('/admin/edit_floor/{floor_id?}', 'AdminController@edit_floor')->name('admin.edit_floor.post');
    Route::get('/admin/delete_floor/{floor_id?}', 'AdminController@delete_floor')->name('admin.delete_floor');
    Route::post('/admin/delete_floor/{floor_id?}', 'AdminController@delete_floor')->name('admin.delete_floor.post');
    Route::get('/admin/study_rooms', 'AdminController@study_rooms')->name('admin.study_rooms');
    Route::get('/admin/add_study_room/', 'AdminController@add_study_room')->name('admin.add_study_room');
    Route::post('/admin/add_study_room/', 'AdminController@add_study_room')->name('admin.add_study_room.post');
    Route::get('/admin/edit_study_room/{study_room_id?}', 'AdminController@edit_study_room')->name('admin.edit_study_room');
    Route::post('/admin/edit_study_room/{study_room_id?}', 'AdminController@edit_study_room')->name('admin.edit_study_room.post');
    Route::get('/admin/delete_study_room/{study_room_id?}', 'AdminController@delete_study_room')->name('admin.delete_study_room');
    Route::post('/admin/delete_study_room/{study_room_id?}', 'AdminController@delete_study_room')->name('admin.delete_study_room.post');
    Route::get('/admin/settings', 'AdminController@settings')->name('admin.settings');
    Route::get('/admin/delete_attendances', 'DeleteController@attendances')->name('admin.delete_attendances');
    Route::get('/admin/delete_floors', 'DeleteController@floors')->name('admin.delete_floors');
    Route::get('/admin/delete_rooms', 'DeleteController@rooms')->name('admin.delete_rooms');
    Route::get('/admin/delete_study_rooms', 'DeleteController@study_rooms')->name('admin.delete_study_rooms');
    Route::get('/admin/delete_users', 'DeleteController@users')->name('admin.delete_users');
    Route::get('/admin/delete_sessions', 'DeleteController@sessions')->name('admin.delete_sessions');
});

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'HomeController@index')->name('reports');
    Route::get('/prayer', 'HomeController@index')->name('reports.prayer');
    Route::get('/study', 'HomeController@index')->name('reports.study');
    Route::get('/sleep', 'HomeController@index')->name('reports.sleep');
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

});
