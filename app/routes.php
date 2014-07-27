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
*/
/*
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

Route::get('ask', array('as'=>'ask', 'before'=>'user', 'uses'=>'PitanjaController@postNew'));
Route::post('ask', array('as'=>'ask_post', 'before'=>'user|csrf', 'uses'=>'PitanjaController@postNew'));

Route::get('question/{id}/{title}', array(
    'as'=>'question_details',
    'uses'=>'PitanjaController@getDetails'))
        ->where(array('id'=>'[0-9]+', 'title'=>'[0-9a-zA-Z\-\_]+'));

Route::get('question/vote/{direction}/{id}', array('as'=>
        'vote', 'before'=>'user', 'uses'=>'PitanjaController@getvote'))
        ->where(array('direction'=>'(up|down)', 'id'=>'[0-9]+'));
Route::get('question/tagged/{tag}', array('as'=>
        'tagged', 'uses'=>'PitanjaController@getTaggedWith'))
        ->where('tag', '[0-9a-zA-Z\-\_]+');

Route::post('question/{id}/{title}', array('as'=>
        'question_replay', 'before'=>'csrf|user',
        'uses'=>'OdgovoriController@postReply'))
        ->where(array('id'=>'[0-9]+', 'title'=>'[0-9a-zA-Z\-\_]+' ));
Route::get('question/delete/{id}', array('as'=>
        'delete_question', 'before'=>'access_check:admin',
        'uses'=>'PitanjaController@getDelete'))
        ->where('id', '[0-9]+');

Route::get('answers/vote/{direction}/{id}', array(
        'as'=>'vote_answers', 'before'=>'users', 
        'uses'=>'OdgovoriController@getVote'))
        ->where(array('direction'=>'(up|down)', 
        'id'=>'[0-9]+'));

Route::get('answer/delete/{id}',array('as'=>
        'delete_answer', 'before'=>'user', 'uses'=>
        'OdgovoriController@getDelete'))->where('id','[0-9]+');

