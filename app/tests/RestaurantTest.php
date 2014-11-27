<?php

class RestaurantTest extends TestCase {

    public function testEmpty() {
        $this->assertEmpty(Restaurant::all());
        $this->assertEquals(Restaurant::count(), 0);
    }

    public function testCreate() {
        $restaurant = $this->createRestaurant();

        $this->assertNotNull($restaurant->id);
        $this->assertEquals(Restaurant::count(), 1);
        $this->assertEquals(Restaurant::first(), $restaurant);

        return $restaurant;
    }

    /**
     * @depends testCreate
     */
    public function testDelete($restaurant) {
        $restaurant->delete();
        $this->testEmpty();
    }

}