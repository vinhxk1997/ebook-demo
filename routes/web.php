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
Route::get('/comment/{id}/reply', 'CommentController@replies')->name('reply');
// Search
Route::get('/search', 'HomeController@search')->name('search');
// Saved stories
Route::get('/lists/{list}', 'LibraryController@list')->name('list'); // save list details
Route::group(['middleware' => 'auth'], function () {
    // create story
    Route::get('/works', 'WorkController@index')->name('works');
    Route::group(['middleware' => 'can:create,App\Models\Story'], function () {
        Route::get('/works/new', 'WorkController@createStoryForm')->name('story_create');
        Route::post('/works/new', 'WorkController@createStory')->middleware('ajax');
    });
    Route::get('/works/{story_id}', 'WorkController@editStoryForm')->name('story_edit');
    Route::post('/works/{story}', 'WorkController@editStory');
    Route::delete('/works/{story}', 'WorkController@deleteStory')->name('story_delete');
    Route::patch('/works/{story}', 'WorkController@updateStory')->name('story_unpublish');
    Route::post('/works/{story}/create_chapter', 'WorkController@createChapter')->name('chapter_create');
    Route::get('/works/{story}/write/{chapter}', 'WorkController@writeChapterForm')->name('chapter_write');
    Route::post('/works/{story}/write/{chapter}', 'WorkController@writeChapter');
    Route::patch('/works/{story}/write/{chapter}', 'WorkController@updateChapter')->name('chapter_unpublish');
    Route::delete('/works/{story}/write/{chapter}', 'WorkController@deleteChapter')->name('chapter_delete');
    // library
    Route::get('/library', 'LibraryController@library')->name('library'); // saved stories
    Route::get('/archive', 'LibraryController@archive')->name('archive'); // archived stories
    Route::get('/lists', 'LibraryController@lists')->name('lists'); // save lists
    Route::get('/notification/comment/{id}', 'NotificationController@whenComment')->name('notify');
    Route::get('/notification/story/{id}', 'NotificationController@whenCreateStory')->name('notify-story');

    // ajax
    Route::group(['middleware' => 'ajax'], function () {
        Route::post('/lists/{list}/sync', 'LibraryController@updateSync')->name('remove_list_stories'); // remove stories from list
        Route::post('/lists/{list}', 'LibraryController@update'); // update save list
        Route::post('/library', 'LibraryController@archiveStory'); // add story to saved
        Route::post('/archive', 'LibraryController@archiveStatus'); // change saved story status
        Route::post('/lists', 'LibraryController@createList')
            ->name('create_list')
            ->middleware('can:create,App\Models\SaveList'); // create list
        Route::post('/lists/{list}/stories', 'LibraryController@ajaxAddToList'); // add story to save list
        Route::delete('/lists/{list}', 'LibraryController@delete')->name('delete_list'); // delete save list

        Route::post('/chapter/{id}/comment', 'CommentController@addComment');
        Route::post('/comment/{id}/reply', 'CommentController@addReply');
        Route::delete('/chapter/comment/{id}/delete', 'CommentController@delete');

        Route::post('/user/{id}/follow', 'FollowController@follow');
        Route::post('/user/{id}/unfolow', 'FollowController@unFollow');
        Route::post('/notifications/read/{id}', 'NotificationController@read');

        Route::group(['prefix' => 'ajax', 'as' => 'ajax.'], function () {
            Route::get('/lists', 'LibraryController@ajaxLists')->name('lists'); // ajax get lists
        });
    });
});
// profile
Route::get('/user/{user}', 'UserController@index')->name('user_about');
Route::get('/user/{user}/activity', 'UserController@conversations')->name('user_conversations');
Route::get('/user/{user}/following', 'UserController@following')->name('user_following');

// Social login
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider')->name('social_login');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::group(['namespace' => 'Admin', 'middleware' => 'admin'], function () {
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
    Route::get('admin/story/{id}/delete', 'StoryController@destroy')->name('delete_story');

    Route::get('admin/story/{id}/detail', 'ChapterController@show')->name('story_detail');
    Route::get('admin/story/chapter/{id}', 'ChapterController@chapterDetail')->name('chapter');
    Route::get('admin/story/chapter/{id}/delete', 'ChapterController@destroy')->name('delete_chapter');

    Route::get('admin/comment/story', 'CommentController@storyComment')->name('story_comment');
    Route::get('admin/comment/review', 'CommentController@reviewComment')->name('review_comment');
    Route::get('admin/comment/{id}/reply', 'CommentController@replyComment')->name('reply_comment');
    Route::get('admin/comment/delete/{id}', 'CommentController@destroy')->name('delete_comment');


    Route::get('admin/reviews', 'ReviewController@index')->name('review');
    Route::get('admin/review/delete/{id}', 'ReviewController@destroy')->name('delete_review');
    Route::get('admin', 'HomeController@index')->name('admin');

    Route::get('admin/reports', 'ReportController@index')->name('report');
    Route::get('admin/report/update/{id}', 'ReportController@edit')->name('update_report');
    Route::post('admin/report/update/{id}', 'ReportController@update');
    Route::get('admin/report/delete/{id}', 'ReportController@destroy')->name('delete_report');
});

Route::group(['middleware' => 'locale'], function() {
    Route::get('change-language/{language}', 'LanguageController@changeLanguage')
        ->name('change-language');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index');
