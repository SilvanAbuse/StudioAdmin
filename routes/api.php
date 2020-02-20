<?php

use Illuminate\Http\Request;

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

Route::post('register', 'API\TokenAuthController@register');
Route::post('authenticate', 'API\TokenAuthController@authenticate');
Route::get('get_ads', 'API\TokenAuthController@get_ads');


Route::get('user/getUserList', 'UserApiController@getUserList');
Route::get('user/userAdd', 'UserApiController@userAdd');
Route::get('user/getGroupList', 'UserApiController@getGroupList');
Route::get('user/addGroup', 'UserApiController@addGroup');
Route::get('user/getEmpList', 'UserApiController@getEmpList');
Route::get('user/addEmp', 'UserApiController@addEmp');
Route::get('user/getPlayList', 'UserApiController@getPlayList');
Route::get('user/addPlayList', 'UserApiController@addPlayList');

Route::get('sound/getSoundList', 'SoundApiController@getSoundList');
Route::get('sound/addSoundList', 'addSoundList@getSoundList');

Route::get('course/getCourseList', 'CourseApiController@getCourseList');
Route::get('course/addCourse', 'CourseApiController@addCourse');

Route::get('coupon/getCouponList', 'CouponApiController@getCouponList');

Route::get('cat/getCateoryList', 'CatApiController@getCateoryList');

