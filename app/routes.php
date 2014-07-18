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
/*
Route::get('create_user', function()
{
    $user = Sentry::getUserProvider()->create(array(
        'email'=>'admin@admin.com',
        'password'=>'admin',
        'first_name'=>'Mario',
        'last_name'=>'Dorotic',
        'activated'=>1,
        'permissions'=>array(
            'admin'=>1
        )
    ));
    return 'admin created with id of '.$user->id;
});

Route::get('/', function()
{
    return View::make('hello');
});

 */
Route::get('signup', array('as'=>'signup_form', 'before'=>'is_quest', 'uses'=>'AuthController@getSignup'));
Route::post('signup', array('as'=>'signup_form_post', 'before'=>'csrf|is_guest', 'uses'=>'AuthController@postSignup'));
Route::post('login', array('as'=>'login_post', 'before'=>'csrf|is_guest', 'uses'=>'AuthController@postLogin'));
Route::get('logout', array('as'=>'logout', 'before'=>'user', 'uses'=>'AuthController@getLogout'));

Route::get('/', array('as'=>'index', 'uses'=>'MainController@getIndex'));