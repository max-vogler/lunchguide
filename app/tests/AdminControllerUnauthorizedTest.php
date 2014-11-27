<?php

class AdminControllerUnauthorizedTest extends TestCase {

    /*
    ░░░░░░░░░░░░░░░▄▄▄▄▄▄▄▄░░░░░░░░░░░░░░░░░
    ░░░░░░░░░▄▄█████████████▄░░░░░░░░░░░░░░░
    ░░░░░░░▄██████████████████░░░░░░░░░░░░░░
    ░░░░░▄██████████████▀▀▀░▀██░░░░░░░░░░░░░
    ░░░░▄██████▀▀▀▀▀▀░░░░░░░░▀██░░░░░░░░░░░░
    ░░░░████████░░░░░░░░░░░░░░▀█░░░░░░░░░░░░
    ░░░░████████░░░░░░░░░░░░░░▄█▄░░░░░░░░░░░
    ░░░░████████░░░░░░░░░░▄░░███▀░░░░░░░░░░░
    ░░░░░██████░░░░░█▀███▀▀░░░░░░░░░░░░░░░░░
    ░░░░░███████░░░░░▀▀▀░░░░░░░░░░░░░░░░░░░░
    ░░░░░▀█░░▀██░░░░░░░░░░▄░░░░▀░░░░░░░░░░░░
    ░░░░░░▀▄░░▄▀░░░░░░░░░░░▄████▀░░░░░░░░░░░
    ░░░░░░░░░░░░▄░░░░░░░░██▀█▄██░░░░░░░░░░░░
    ░░░░░░░░░░░▀░░░░░░░░░░░▀▀▀▀▀░▀░░░░░░░░░░
    ░░░░░░▄▄▄███░░░░░░░░░░░░░░░░░█▄░░░░░░░░░
    ▄▄▄█████████▀░░░░░░░░▄▄░░░░▄▄█████▄▄▄░░░
    ████████████░░░░░░░░░░██████████████████
    █████████████░░░▀░░░░░▄█████████████████
    ██████████████░░░▄█▀▀█▀▀████████████████

    Seriously?

    Filters seem to be never called in TestCases, despite
    Route::enableFilters being called! Authentication has
    been tested manually for now.

    public function testDashboardPage() {
        $this->assertFalse(Auth::check());
        $this->assertNull(Auth::user());
        $this->assertTrue(Auth::guest());

        $response = $this->action('GET', 'AdminController@dashboard');
        $this->assertRedirectedToAction('AuthenticationController@login');
    }

    public function testFacebookPage() {
        $this->action('GET', 'AdminController@facebook');
        $this->assertRedirectedToAction('AuthenticationController@login');
    }

    public function testUpdateMenuPage() {
        $this->action('GET', 'ScraperController@updateDate');
        $this->assertRedirectedToAction('AuthenticationController@login');
    }

    */

    public function testNoop() {}

}