<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Enable CSRF protection for all POST requests
Route::when('*', 'csrf', ['post']);

Route::pattern('date', '[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}');
Route::pattern('page', '[a-zA-Z]+');

// Redirect the base url to the daily menu
Route::get('/', 'StaticPageController@index');

// Prefix all menu pages with a location - this is a temporary 
// solution until LunchGuides for different cities are implemented
Route::group(['prefix' => Config::get('app.url_prefix')], function () {
    Route::get('/', 'DailyMenuController@today');
    Route::get('/{date}', 'DailyMenuController@date');
});

// Login and logout should be accessible without Auth!
Route::get('/admin/login', 'AuthenticationController@login');
Route::post('/admin/login', 'AuthenticationController@postLogin');
Route::post('/admin/logout', 'AuthenticationController@logout');

// Protect admin pages with authentication
Route::group(['before' => 'auth'], function() {
    Route::get('/admin', 'AdminController@dashboard');
    Route::get('/admin/facebook', 'AdminController@facebook');
    Route::get('/admin/facebook-redirect', 'AdminController@facebookAfterRedirect');
    Route::post('/admin/facebook/select-page', 'AdminController@facebookSelectPage'); 
    Route::get('/admin/facebook/test', 'AdminController@facebookTest'); 

    Route::get('/admin/scraper-update', 'ScraperController@updateDate');
    Route::get('/admin/scraper-update/{date}', 'ScraperController@updateDate');
});

// GitHub pull hook for automatic updates
Route::post('/dev/update', 'GitHubController@pull');

// Deliver static pages, like imprint or privacy
Route::get('/{page}', 'StaticPageController@display');

