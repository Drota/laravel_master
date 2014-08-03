<?php

class AuthController extends \BaseController {

    public function getSignup() {
	return View::make('po.signup')
		->with('title', 'Uloguj se!');
    }

    public function postSignup(){
        $validation=Validator::make(Input::all(),User::$signup_rules);
        if($validation->passes()) {
            $user=Sentry::getUserProvider()->create(array(
                'email'=>Input::get('email'),
                'password'=>Input::get('password'),
                'first_name'=>Input::get('first_name'),
                'last_name'=>Input::get('last_name'),
                'activated'=>1
            ));
            $login=Sentry::authenticate(array(
                'email'=>Input::get('email'),
                'password'=>Input::get('password')
            ));
            return Redirect::route('index')
                ->with('success', 'Uspesno ste se registrovali');
        }else{
            return Redirect::route('signup_form')
                ->withInput(Input::except('password','re_password'))
                ->with('error', $validation->errors()->first());
        }
    }

    public function postLogin() {
        $validation=Validator::make(Input::all(), User::$login_rules);
        if($validation->fails()) {
            return Redirect::route('index')
                ->withInput(Input::except('password'))
                ->with('topError',$validation->errors()->first());
        }else{
            try {
                $credentials = array(
                    'email'=>Input::get('email'),
                    'password'=>Input::get('password'),
                );
                $user=Sentry::authenticate ($credentials, false);
                return Redirect::route('index')
                        ->with('success', 'Uspesno ste se ulogovali!');
            }catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
                return Redirect::route('index')
                        ->withInput(Input::except('password'))
                        ->with('topError','Potrebno je polje Login');
            }catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
                return Redirect::route('index')
                        ->withInput(Input::except('password'))
                        ->with('topError','Potrebno je polje lozinka');
            }catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
                return Redirect::route('index')
                        ->withInput(Input::except('password'))
                        ->with('topError','Pogresna lozinka, probajte ponovo');
            }catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                return Redirect::route('index')
                        ->withInput(Input::except('password'))
                        ->with('topError','Korisnik nije pronadjen');
            }catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
                return Redirect::route('index')
                        ->withInput(Input::except('password'))
                        ->with('topError','Korisnik nije aktiviran');
            
            
            // samo ako se koristi Throttling     
            }catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
                return Redirect::route('index')
                        ->withInput(Input::except('password'))
                        ->with('topError','Korisnik je suspendovan.');
            }catch (Cartalyst\Sentry\Throttlink\UserBannedException $e) {
                return Redirect::route('index')
                        ->withInput(Input::except('password'))
                        ->with('topError','Korisnik je banovan.');
            }
        }
    }
    
    public function getLogout() {
        Sentry::logout();
        return Redirect::route('index')
                ->with('success', 'Uspesno ste se izlogovali');
    }
}
