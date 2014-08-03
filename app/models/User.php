<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Cartalyst\Sentry\Users\Eloquent\User {

    
        
    public static $signup_rules = array(
        'first_name'=>'required|min:3',
        'last_name'=>'required|min:3',
        'email'=>'required|email|unique:users,email',
        'password'=>'required|min:6',
        're_password'=>'required|same:password'
    );
    
    public static $login_rules = array(
        'email'=>'required|email|exists:users,email',
        'password'=>'required|min:5'
    );
    
    public function questions() {
        return $this->hasMany('Question', 'userID');   
    }
}
