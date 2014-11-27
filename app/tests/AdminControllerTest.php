<?php

class AdminControllerTest extends TestCase {

    public function testDashboardPage() {
        $this->be(new User(['email' => 'tester@example.com']));
        $this->action('GET', 'AdminController@dashboard');
        $this->assertResponseOk();
    }

    public function testFacebookPage() {
        $this->be(new User(['email' => 'tester@example.com']));
        $this->action('GET', 'AdminController@facebook');
        $this->assertResponseOk();
    }

    public function testUpdateMenuPage() {
        $this->be(new User(['email' => 'tester@example.com']));
        $this->createRestaurant();

        $this->action('GET', 'ScraperController@updateDate');
        
        $this->assertResponseOk();
        $this->assertEquals(1, Meal::count());
        $this->assertStringStartsWith('SimpleScraper', Meal::first()->source);
    }

}