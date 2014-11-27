<?php

class MealTest extends TestCase {

    public function testEmpty() {
        $this->assertEmpty(Meal::all());
        $this->assertEquals(Meal::count(), 0);
    }

    public function testCreate() {
        $meal = $this->createMeal(['restaurant_id' => 0]);

        $this->assertNotNull($meal->id);
        $this->assertEquals(Meal::count(), 1);
        $this->assertEquals(Meal::first(), $meal);

        return $meal;
    }

    /**
     * @depends testCreate
     */
    public function testDelete($meal) {
        $meal->delete();
        $this->testEmpty();
    }

}