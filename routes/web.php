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

Route::get('/wechat/index','EventController@index');
// Route::get('/wechat/doindex','EventController@doindex');
Route::get('/wechat/event','EventController@event');
Route::get('/wechat/code','EventController@code');
Route::get('/wechat/login','EventController@login');
Route::get('/wechat/curl','EventController@curl');
//标签
Route::post('/wechat/label_add','EventController@label_add');
Route::get('/wechat/list_add','EventController@list_add');
Route::get('/wechat/label_list','EventController@label_list');
Route::get('/wechat/label_del','EventController@label_del');
Route::get('/wechat/label_update','EventController@label_update');
Route::post('/wechat/do_update','EventController@do_update');
Route::get('/wechat/label_index','EventController@label_index');

