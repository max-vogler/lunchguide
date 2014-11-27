<?php

class MenuUpdateCommandTest extends TestCase {

    public function testRunSimpleScraper() {
        $this->createRestaurant();
        $this->assertEquals(Config::get('scrapers.run'), ['Example\\SimpleScraper']);
        
        Artisan::call('menu:update');
        $this->assertEquals(1, Meal::count());
        $this->assertStringStartsWith('SimpleScraper', Meal::first()->source);
    }

    public function testMultipleRunSimpleScraper() {
        $this->createRestaurant();
        $this->assertEquals(Config::get('scrapers.run'), ['Example\\SimpleScraper']);
        
        // Multiple execution ensures that removeMealsForDate functionality is working!

        Artisan::call('menu:update');
        Artisan::call('menu:update');
        Artisan::call('menu:update');

        $this->assertEquals(1, Meal::count());
        $this->assertStringStartsWith('SimpleScraper', Meal::first()->source);
    }

    public function testRunWithoutScrapers() {
        // Seems like Config::set() is persisted for all tests of this class
        // and influences later tests! >:-(
        Config::set('scrapers.run', []);
        Artisan::call('menu:update');

        $this->assertEquals(0, Meal::count());
    }

}