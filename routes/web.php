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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

$this->get('/verify-user/{code}', 'Auth\RegisterController@activateUser')->name('activate.user');

Route::get('/settings', 'SettingsController@index')->name('settings');

Route::post('/settings', 'SettingsController@set');

Route::get('/article', 'ArticleController@index')->name('articles');

Route::get('/article/{id}', 'ArticleController@get');

Route::get('/category', 'CategoryController@index')->name('categories');

Route::get('/category/{id}', 'CategoryController@articles');

Route::post('/article/{id}', 'ArticleController@postComment');

Route::get('/user', 'UserController@index')->name('users');

Route::get('/user/{id}', 'UserController@get');

Route::get('/settings/notifications', 'SettingsController@getNotifications')->name('notifications');

Route::get('/settings/notifications/{id}', 'SettingsController@removeNotification');

Route::get('/articles/new', 'ArticleController@createArticlePage');

Route::post('/articles/new', 'ArticleController@createArticle');
