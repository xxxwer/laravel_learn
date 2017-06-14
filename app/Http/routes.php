<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
// 基本




/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/', ['uses' => 'Admin\IndexController@showKeywordList'] );
    Route::post('doAddKeyword', ['uses' => 'Admin\IndexController@doAddKeyword'] );
    Route::get('index', ['uses' => 'Admin\IndexController@showKeywordList'] );
    Route::get('addKeyword', ['uses' => 'Admin\IndexController@addKeyword'] );
    Route::get('detail', ['uses' => 'Admin\IndexController@showKeywordDetail'] );
    Route::post('updateKeyword', ['uses' => 'Admin\IndexController@updateKeyword'] );
    Route::post('search/keyword', ['uses' => 'Admin\IndexController@searchKeyword']);
    Route::post('fulltextSearch/keyword', ['uses' => 'Admin\IndexController@fullTextSearchSphinx']);
    Route::post('esFulltextSearch/keyword', ['uses' => 'Admin\IndexController@fullTextSearchES']);
    Route::post('ajax_search/keyword', ['uses' => 'Admin\IndexController@ajaxSearchKeyword']);
    Route::post('addParentKeyword', ['uses' => 'Admin\IndexController@addParentKeyword']);
    Route::any('deleteKeywordLink', ['uses' => 'Admin\IndexController@deleteKeywordLink']);
    Route::get('rootKeyword', ['uses' => 'Admin\IndexController@rootKeywordList']);

    Route::get('otherFunction', ['uses' => 'Admin\IndexController@otherFunction']);
    Route::get('otherFunction/{param}', ['uses' => 'Admin\IndexController@otherFunction']);

    Route::get('ESindexALL', ['uses' => 'Admin\IndexController@ESindexALL']);
    Route::get('ESseeHealth', ['uses' => 'Admin\IndexController@ESseeHealth']);
    Route::get('ESIndexStatus', ['uses' => 'Admin\IndexController@ESIndexStatus']);
    Route::post('ESQueryJson', ['uses' => 'Admin\IndexController@ESQueryJson']);
    Route::post('garbageInfoFilter', ['uses' => 'Admin\IndexController@garbageInfoFilter']);
    Route::post('trainGarbageInfoFilter', ['uses' => 'Admin\IndexController@trainGarbageInfoFilter']);
    Route::post('clearGarbageInfoFilterDB', ['uses' => 'Admin\IndexController@clearGarbageInfoFilterDB']);
});
