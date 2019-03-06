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

// Home
Route::get('/', 'HomeController@index')->name('home');

// Category
Route::get('/stories/{slug}', 'MetaController@stories')->name('meta');
Route::get('/stories/{slug}/new', 'MetaController@newStories')->name('meta_new_stories');
// Story details
Route::get('/story/{id}-{slug}', 'StoryController@story')->name('story');
// Story chapters
Route::get('/{id}-{slug}', 'ChapterController@index')->name('read_chapter');
Route::get('/chapter/{id}/comments', 'ChapterController@comments')->name('chapter_comments');
// Saved stories
Route::group(['middleware' => 'auth'], function () {
    Route::get('/library', 'LibraryController@library')->name('library');
    Route::get('/archive', 'LibraryController@archive')->name('archive');
    Route::get('/lists', 'LibraryController@lists')->name('lists');
    Route::post('/lists', 'LibraryController@createList')->name('create_list')->middleware('verified');
    Route::get('/lists/{list}', 'LibraryController@list')->name('list');
    Route::post('/lists/{list}', 'LibraryController@update');
    Route::delete('/lists/{list}', 'LibraryController@delete')->name('delete_list');
});
// profile
Route::get('/user/{user_name}', 'UserController@index')->name('user_about');
Route::get('/user/{user_name}/activity', 'UserController@conversations')->name('user_conversations');
Route::get('/user/{user_name}/following', 'UserController@following')->name('user_following');

Route::group(array('namespace' => 'Admin'), function () {
    Route::get('admin/users', 'UserController@index')->name('user');
    Route::get('admin/user/{id?}/update', 'UserController@edit')->name('update_user');
    Route::post('admin/user/{id?}/update', 'UserController@update');
    Route::get('admin/users/create', 'UserController@create')->name('add_user');
    Route::post('admin/users/create', 'UserController@store');
    Route::get('admin/user/delete/{id}', 'UserController@destroy')->name('delete_user');

    Route::get('admin/categories', 'CategoryController@index')->name('categories');
    Route::post('admin/categories', 'CategoryController@store');
    Route::get('admin/categories/{id?}', 'CategoryController@edit')->name('update_cate');
    Route::post('admin/categories/{id?}', 'CategoryController@update');
    Route::get('admin/categories/{id}/delete', 'CategoryController@destroy')->name('delete_cate');
    
    Route::get('admin/stories', 'StoryController@index')->name('story_admin');
    Route::get('admin/story/{id}/info', 'StoryController@show')->name('story_info');
    Route::post('admin/story/{id}/info', 'StoryController@update')->name('story_update');
    Route::get('admin', 'StoryController@admin')->name('admin');
    Route::get('admin/story/{id}/delete', 'StoryController@destroy')->name('delete_story');
    Route::get('admin/reviews', 'StoryController@review')->name('review');

    Route::get('admin/story/{id}/detail', 'ChapterController@show')->name('story_detail');
    Route::get('admin/story/chapter/{id}', 'ChapterController@chapterDetail')->name('chapter');
    Route::get('admin/story/chapter/{id}/delete', 'ChapterController@destroy')->name('delete_chapter');
});

Route::group(['middleware' => 'locale'], function() {
    Route::get('change-language/{language}', 'LanguageController@changeLanguage')
        ->name('change-language');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index');
