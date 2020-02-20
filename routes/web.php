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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

/* API XNF */
Route::any('/api/getCoupon', 'ApiController@getCoupon');
Route::post('/api/get_token', 'ApiController@getToken');
Route::post('/api/search', 'ApiController@search');
Route::post('/api/add_like', 'ApiController@addLike');
Route::post('/api/add_dislike', 'ApiController@addDislike');
Route::any('/api/studios/map', 'ApiController@studios_map');
Route::any('/api/avatar', 'ApiController@avatar');

/* API */
Route::post('/api/login', 'ApiController@login');
Route::post('/api/signup/{step}', 'ApiController@signup');
Route::get('/api/profile', 'ApiController@profile');
Route::post('/api/profile_update', 'ApiController@profile_update');
Route::any('/api/studios', 'ApiController@studios');
Route::get('/api/studio_info/{id}', 'ApiController@studio');
Route::get('/api/st/add', 'ApiController@studio_add1');
Route::get('/api/studio/edit/{id}', 'ApiController@studio_edit');
Route::get('/api/studio/{id}/services', 'ApiController@studio_services');
Route::get('/api/studio/{id}/services/add', 'ApiController@studio_services_add');
Route::get('/api/studio/{id}/services/delete/{sid}', 'ApiController@studio_services_delete');
Route::get('/api/studio/{id}/services/calendar', 'ApiController@studio_services_calendar');
Route::get('/api/studio/{id}/book', 'ApiController@studio_services_book');

Route::get('/bookings/payment/{id}', function() {

	echo '<p>Форма оплаты будет тут!</p>';

});

Route::get('/api/reviews/{id}', 'ApiController@studio_reviews');
Route::any('/api/send_review/{id}', 'ApiController@send_review');
Route::get('/api/bonus_list', 'ApiController@bonus_list');
Route::post('/api/bonus/{type}', 'ApiController@bonus_do');
Route::post('/api/bonus/{type}', 'ApiController@bonus_do');
Route::get('/api/get_users', 'ApiController@get_users');
Route::get('/api/push_list', 'ApiController@push_list');
Route::get('/api/push_info/{id}', 'ApiController@push_info');
Route::get('/api/get_categories', 'ApiController@get_categories');
Route::get('/api/get_category', 'ApiController@get_categories');

/* Удаление записей */
Route::get('/admin/delete_record/{table}/{id}', 'AdminController@delete')->name('admin_delete');

/* Пользователи */
Route::get('/admin/users', 'AdminUsersController@index')->name('admin_users');
Route::get('/admin/users/add', 'AdminUsersController@add')->name('admin_uadd');
Route::post('/admin/users/add', 'AdminUsersController@add')->name('admin_uadd');
Route::get('/admin/users/edit/{id}', 'AdminUsersController@edit')->name('admin_uedit');
Route::post('/admin/users/edit/{id}', 'AdminUsersController@edit')->name('admin_uedit');
Route::get('/admin/users/info/{id}', 'AdminUsersController@info')->name('admin_uedit1');

/* Категории студий */
Route::get('/admin/categories', 'AdminCatController@index')->name('admin_categories');
Route::get('/admin/categories/add', 'AdminCatController@add')->name('admin_catadd');
Route::post('/admin/categories/add', 'AdminCatController@add')->name('admin_catadd');
Route::get('/admin/categories/edit/{id}', 'AdminCatController@edit')->name('admin_catedit');
Route::post('/admin/categories/edit/{id}', 'AdminCatController@edit')->name('admin_catedit');

/* Студии */
Route::get('/admin/studios', 'AdminStudioController@index')->name('admin_studios');
Route::get('/admin/studios/add', 'AdminStudioController@add')->name('admin_sadd');
Route::post('/admin/studios/add', 'AdminStudioController@add')->name('admin_sadd');
Route::get('/admin/studios/edit/{id}', 'AdminStudioController@edit')->name('admin_sedit');
Route::post('/admin/studios/edit/{id}', 'AdminStudioController@edit')->name('admin_sedit');
Route::get('/admin/studios/info/{id}', 'AdminStudioController@info')->name('admin_sedit1');

/* Услуги студий */
Route::get('/admin/studios/services/{studio_id}', 'AdminServiceController@index')->name('admin_services');
Route::get('/admin/studios/services/{studio_id}/add', 'AdminServiceController@add')->name('admin_seadd');
Route::post('/admin/studios/services/{studio_id}/add', 'AdminServiceController@add')->name('admin_seadd');
Route::get('/admin/studios/services/{studio_id}/edit/{id}', 'AdminServiceController@edit')->name('admin_seedit');
Route::post('/admin/studios/services/{studio_id}/edit/{id}', 'AdminServiceController@edit')->name('admin_seedit');

/* Календарь */
Route::get('/admin/studios/calendar/{studio_id}/{date}', 'AdminServiceController@ajax_events')->name('ajax_c_events');
Route::post('/admin/studios/calendar/{studio_id}/add', 'AdminServiceController@ajax_add')->name('ajax_add');
Route::get('/admin/studios/cdelete/{calendar_id}', 'AdminServiceController@delete_event');

/* Отзывы */
Route::get('/admin/reviews', 'AdminReviewController@index')->name('admin_reviews');
Route::get('/admin/reviews/add', 'AdminReviewController@add')->name('admin_radd');
Route::post('/admin/reviews/add', 'AdminReviewController@add')->name('admin_radd');
Route::get('/admin/reviews/edit/{id}', 'AdminReviewController@edit')->name('admin_redit');
Route::post('/admin/reviews/edit/{id}', 'AdminReviewController@edit')->name('admin_redit');

/* Каталог бонусов */
Route::get('/admin/bonus', 'AdminBonusController@index')->name('admin_bonus');
Route::get('/admin/bonus/add', 'AdminBonusController@add')->name('admin_badd');
Route::post('/admin/bonus/add', 'AdminBonusController@add')->name('admin_badd');
Route::get('/admin/bonus/edit/{id}', 'AdminBonusController@edit')->name('admin_bedit');
Route::post('/admin/bonus/edit/{id}', 'AdminBonusController@edit')->name('admin_bedit');

/* Бонусы */
Route::get('/admin/bon', 'AdminBonController@index')->name('admin_bon');
Route::get('/admin/bon/add', 'AdminBonController@add')->name('admin_boadd');
Route::post('/admin/bon/add', 'AdminBonController@add')->name('admin_boadd');
Route::get('/admin/bon/edit/{id}', 'AdminBonController@edit')->name('admin_boedit');
Route::post('/admin/bon/edit/{id}', 'AdminBonController@edit')->name('admin_boedit');

/* Пуши */
Route::get('/admin/pushes', 'AdminPushController@index')->name('admin_pushes');
Route::get('/admin/pushes/add', 'AdminPushController@add')->name('admin_puadd');
Route::post('/admin/pushes/add', 'AdminPushController@add')->name('admin_puadd');
Route::get('/admin/pushes/edit/{id}', 'AdminPushController@edit')->name('admin_puedit');
Route::post('/admin/pushes/edit/{id}', 'AdminPushController@edit')->name('admin_puedit');
