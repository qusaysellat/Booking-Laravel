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

Route::group(['middleware' => ['web']], function () {

    Route::get('/lang/{lang}', [
        'uses' => 'UserController@lang',
        'as' => 'lang'
    ]);

    Route::get('/', [
        'uses' => 'UserController@dashboard',
        'as' => 'dashboard'
    ]);

    Route::get('/configureddashboard/{category_id}/{city_id}', [
        'uses' => 'UserController@configureddashboard',
        'as' => 'configureddashboard',
    ]);

    Route::get('/login', [
        'uses' => 'UserController@login',
        'as' => 'login'
    ]);

    Route::post('/signin', [
        'uses' => 'UserController@signin',
        'as' => 'signin'
    ]);

    Route::get('/presignup', [
        'uses' => 'UserController@presignup',
        'as' => 'presignup'
    ]);

    Route::post('/postsignup', [
        'uses' => 'UserController@postsignup',
        'as' => 'postsignup'
    ]);

    Route::get('/signout', [
        'uses' => 'UserController@signout',
        'as' => 'signout',
        'middleware' => 'auth'
    ]);

    Route::get('/profileimage/{id}', [
        'uses' => 'UserController@profileimage',
        'as' => 'profileimage',
    ]);

    Route::get('/publicimage/{id}', [
        'uses' => 'UserController@publicimage',
        'as' => 'publicimage',
    ]);

    Route::post('/addImage', [
        'uses' => 'UserController@addImage',
        'as' => 'addImage',
        'middleware' => 'auth'
    ]);

    Route::get('/deleteimage/{id}', [
        'uses' => 'UserController@deleteimage',
        'as' => 'deleteimage',
        'middleware' => 'auth'
    ]);

    Route::get('/registerationmail/{token}', [
        'uses' => 'UserController@registerationmail',
        'as' => 'registerationmail'
    ]);


    Route::get('/adimage/{id}', [
        'uses' => 'AdminController@adimage',
        'as' => 'adimage',
    ]);


    Route::get('/getuser/{username}', [
        'uses' => 'ProfileController@getuser',
        'as' => 'getuser',
    ]);

    Route::post('/newbookable', [
        'uses' => 'ProfileController@newbookable',
        'as' => 'newbookable',
        'middleware' => 'auth'
    ]);

    Route::get('/seebookable/{id}', [
        'uses' => 'ProfileController@seebookable',
        'as' => 'seebookable',
        'middleware' => 'auth'
    ]);

    Route::get('/deletebookable/{id}', [
        'uses' => 'ProfileController@deletebookable',
        'as' => 'deletebookable',
        'middleware' => 'auth'
    ]);

    Route::post('/book', [
        'uses' => 'ProfileController@book',
        'as' => 'book',
        'middleware' => 'auth'
    ]);

    Route::get('/managebookable/{id}', [
        'uses' => 'ProfileController@managebookable',
        'as' => 'managebookable',
        'middleware' => 'auth'
    ]);

    Route::get('/editbookable/{id}', [
        'uses' => 'ProfileController@editbookable',
        'as' => 'editbookable',
        'middleware' => 'auth'
    ]);

    Route::post('/posteditbookable', [
        'uses' => 'ProfileController@posteditbookable',
        'as' => 'posteditbookable',
        'middleware' => 'auth'
    ]);

    Route::get('/acceptbook/{id}/{username}/{date}', [
        'uses' => 'ProfileController@acceptbook',
        'as' => 'acceptbook',
        'middleware' => 'auth'
    ]);

    Route::get('/rejectbook/{id}/{username}/{date}', [
        'uses' => 'ProfileController@rejectbook',
        'as' => 'rejectbook',
        'middleware' => 'auth'
    ]);

    Route::get('/newoffer/{id}', [
        'uses' => 'ProfileController@newoffer',
        'as' => 'newoffer',
        'middleware' => 'auth'
    ]);

    Route::post('/makeoffer', [
        'uses' => 'ProfileController@makeoffer',
        'as' => 'makeoffer',
        'middleware' => 'auth'
    ]);

    Route::get('/editoffer/{id}', [
        'uses' => 'ProfileController@editoffer',
        'as' => 'editoffer',
        'middleware' => 'auth'
    ]);

    Route::post('/posteditoffer', [
        'uses' => 'ProfileController@posteditoffer',
        'as' => 'posteditoffer',
        'middleware' => 'auth'
    ]);

    Route::get('/deleteoffer/{id}', [
        'uses' => 'ProfileController@deleteoffer',
        'as' => 'deleteoffer',
        'middleware' => 'auth'
    ]);

    Route::get('/activateoffer/{id}', [
        'uses' => 'ProfileController@activateoffer',
        'as' => 'activateoffer',
        'middleware' => 'auth'
    ]);

    Route::get('/seenotifications', [
        'uses' => 'ProfileController@seenotifications',
        'as' => 'seenotifications',
        'middleware' => 'auth'
    ]);

    Route::get('/newcontactus', [
        'uses' => 'AdminController@newcontactus',
        'as' => 'newcontactus',
        'middleware' => 'auth'
    ]);

    Route::post('/makecontactus', [
        'uses' => 'AdminController@makecontactus',
        'as' => 'makecontactus',
        'middleware' => 'auth'
    ]);

    Route::get('/search', [
        'uses' => 'UserController@search',
        'as' => 'search',
    ]);

    Route::post('/searchAjax', [
        'uses' => 'UserController@searchAjax',
        'as' => 'searchAjax',
    ]);

    Route::group(['middleware' => ['admin']], function () {

        Route::get('/adminpanel', [
            'uses' => 'AdminController@adminpanel',
            'as' => 'adminpanel',
            'middleware' => 'auth'

        ]);

        Route::get('/managecategories', [
            'uses' => 'AdminController@managecategories',
            'as' => 'managecategories',
            'middleware' => 'auth'
        ]);

        Route::get('/managecities', [
            'uses' => 'AdminController@managecities',
            'as' => 'managecities',
            'middleware' => 'auth'
        ]);


        Route::post('/newcategory', [
            'uses' => 'AdminController@newcategory',
            'as' => 'newcategory',
            'middleware' => 'auth'

        ]);


        Route::post('/newcity', [
            'uses' => 'AdminController@newcity',
            'as' => 'newcity',
            'middleware' => 'auth'
        ]);

        Route::get('/editcategory/{id}', [
            'uses' => 'AdminController@editcategory',
            'as' => 'editcategory',
            'middleware' => 'auth'
        ]);

        Route::post('/posteditcategory', [
            'uses' => 'AdminController@posteditcategory',
            'as' => 'posteditcategory',
            'middleware' => 'auth'
        ]);


        Route::get('/editcity/{id}', [
            'uses' => 'AdminController@editcity',
            'as' => 'editcity',
            'middleware' => 'auth'
        ]);

        Route::post('/posteditcity', [
            'uses' => 'AdminController@posteditcity',
            'as' => 'posteditcity',
            'middleware' => 'auth'
        ]);


        Route::get('/manageusers', [
            'uses' => 'AdminController@manageusers',
            'as' => 'manageusers',
            'middleware' => 'auth'
        ]);

        Route::get('/activateuser/{username}', [
            'uses' => 'AdminController@activateuser',
            'as' => 'activateuser',
            'middleware' => 'auth'
        ]);

        Route::get('/newadvertisement', [
            'uses' => 'AdminController@newadvertisement',
            'as' => 'newadvertisement',
            'middleware' => 'auth'
        ]);

        Route::post('/makeadvertisement', [
            'uses' => 'AdminController@makeadvertisement',
            'as' => 'makeadvertisement',
            'middleware' => 'auth'
        ]);

        Route::get('/editadvertisement/{id}', [
            'uses' => 'AdminController@editadvertisement',
            'as' => 'editadvertisement',
            'middleware' => 'auth'
        ]);


        Route::post('/posteditadvertisement', [
            'uses' => 'AdminController@posteditadvertisement',
            'as' => 'posteditadvertisement',
            'middleware' => 'auth'
        ]);

        Route::get('/deleteadvertisement/{id}', [
            'uses' => 'AdminController@deleteadvertisement',
            'as' => 'deleteadvertisement',
            'middleware' => 'auth'
        ]);

        Route::get('/activatead/{id}', [
            'uses' => 'AdminController@activatead',
            'as' => 'activatead',
            'middleware' => 'auth'
        ]);

        Route::get('/readcontactus', [
            'uses' => 'AdminController@readcontactus',
            'as' => 'readcontactus',
            'middleware' => 'auth'
        ]);

        Route::get('/replycontactus/{id}', [
            'uses' => 'AdminController@replycontactus',
            'as' => 'replycontactus',
            'middleware' => 'auth'
        ]);

        Route::post('/editcontactus', [
            'uses' => 'AdminController@editcontactus',
            'as' => 'editcontactus',
            'middleware' => 'auth'
        ]);

    });

});

Route::get('/cron', [
        'uses' => 'SchedulingController@cron',
        'as' => 'cron',
    ]);



