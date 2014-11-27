<?php

class AuthenticationControllerTest extends TestCase {

    public function testLoginPageOk() {
        $this->assertNull(Auth::user());

        $this->action('GET', 'AuthenticationController@login');
        $this->assertResponseOk();
    }

    public function testLogoutPageOk() {
        $this->assertNull(Auth::user());

        $this->action('POST', 'AuthenticationController@logout');
        $this->assertResponseOkOrRedirect();
    }

    public function testLoginFail() {
        $this->action('POST', 'AuthenticationController@postLogin', [
            'email' => 'wrong', 
            'password' => 'wrong'
        ]);

        $this->assertNull(Auth::user());
    }

    public function testLoginFailEmail() {
        $email = 'tester@example.com';
        $password = 'testing101';
        $this->assertNull(User::where('email', $email)->first());

        $user = new User(['email' => $email, 'password' => Hash::make($password)]);
        $user->save();
        $this->assertNotNull(User::where('email', $email)->first());

        $this->action('POST', 'AuthenticationController@postLogin', [
            'email' => $email, 
            'password' => 'wrong!'
        ]);

        $this->assertNull(Auth::user());
        $this->assertFalse(Auth::check());
        return $user;
    }

    public function testLoginFailPassword() {
        $email = 'tester@example.com';
        $password = 'testing101';
        $this->assertNull(User::where('email', $email)->first());

        $user = new User(['email' => $email, 'password' => Hash::make($password)]);
        $user->save();
        $this->assertNotNull(User::where('email', $email)->first());

        $this->action('POST', 'AuthenticationController@postLogin', [
            'email' => 'wrong@example.com', 
            'password' => $password
        ]);

        $this->assertNull(Auth::user());
        $this->assertFalse(Auth::check());
        return $user;
    }

    public function testLoginSuccess() {
        $email = 'tester@example.com';
        $password = 'testing101';
        $this->assertNull(User::where('email', $email)->first());

        $user = new User(['email' => $email, 'password' => Hash::make($password)]);
        $user->save();
        $this->assertNotNull(User::where('email', $email)->first());

        $this->action('POST', 'AuthenticationController@postLogin', [
            'email' => $email, 
            'password' => $password
        ]);
        $this->assertResponseOkOrRedirect();

        $this->assertNotNull(Auth::user());
        $this->assertTrue(Auth::check());
        return $user;
    }

    public function testLogoutSuccess() {
        // @depends in docblock seems to not retain the authentication and only provide the
        // return values -- you seem to have to call testLoginSuccess() manually!
        $this->testLoginSuccess();

        $this->assertTrue(Auth::check());
        $this->action('POST', 'AuthenticationController@logout');

        $this->assertResponseOkOrRedirect();
        $this->assertNull(Auth::user());
        $this->assertFalse(Auth::check());
    }

}