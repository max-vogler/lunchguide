<?php

class AuthenticationController extends BaseController {

    public function login() {
        if(Auth::check()) {
            return Redirect::action('AdminController@dashboard');
        } else {
            return Response::view('admin.login');
        }
    }

    public function postLogin() {
        if(Auth::attempt([
            'email' => Input::get('email'), 
            'password' => Input::get('password')
        ])) {
            return Redirect::intended(action('AdminController@dashboard'));
        } else {
            return Redirect::to(action('AuthenticationController@login'))
                ->withInput(Input::except('password'));
        }
    }

    public function logout() {
        Auth::logout();
        return Redirect::action('AuthenticationController@login');
    }

    public function requireLogin() { 
        if (Auth::guest()) {
            return Redirect::guest(action('AuthenticationController@login'));
        }
    }

}
