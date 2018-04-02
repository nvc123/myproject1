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

Route::get('/settings/remove_all_notifications', 'SettingsController@removeAllNotifications')->name('remove_all_notifications');

Route::get('/settings/notifications/{id}', 'SettingsController@removeNotification');

Route::get('/articles/new', 'ArticleController@createArticlePage')->name('article_create');

Route::post('/articles/new', 'ArticleController@createArticle');

Route::get('/articles/moderated/{id}', 'ArticleController@statusModerated')->name('moderated');

Route::get('/moderator', 'ModeratorController@index')->name('moderator');

Route::get('/moderator/published/{id}', 'ModeratorController@statusPublished')->name('published');

Route::get('/moderator/not_published/{id}', 'ModeratorController@statusNotPublished')->name('not_published');

Route::get('/moderator/locked/{id}', 'ModeratorController@statusLocked')->name('locked');

Route::get('/articles/edit/{id}', 'ArticleController@editArticlePage')->name('article_edit');

Route::post('/articles/edit/{id}', 'ArticleController@postArticle');

Route::get('/articles/remove/{id}', 'ArticleController@removeArticle')->name('article_remove');

Route::get('/settings/articles', 'UserController@myArticles')->name('my_articles');
