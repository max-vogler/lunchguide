<?php

class DailyMenuControllerTest extends TestCase {

    private function showMealsForDateHelper($params = []) {
        $restaurant = $this->createRestaurant();
        $meal = $this->createMeal(['restaurant_id' => $restaurant->id]);

        $response = $this->call('GET', action('DailyMenuController@today'), $params);
        $content = $response->getContent();

        $this->assertResponseOk();
        $this->assertContains($restaurant->name, $content);
        $this->assertContains($meal->name, $content);
        $this->assertContains($meal->info, $content);
    }

    public function testShowsMealsForDate() {
        $this->showMealsForDateHelper();
    }

    public function testShowsMealsForDatePrint() {
        $this->showMealsForDateHelper(['print' => 1]);
    }

    public function testMealsEmpty() {
        Meal::truncate();

        $this->action('GET', 'DailyMenuController@today');
        $this->assertResponseOk();
    }

    public function testMealsEmptyPrint() {
        Meal::truncate();

        $this->call('GET', action('DailyMenuController@today'), ['print' => 1]);
        $this->assertResponseOk();
    }

    public function testRestaurantsEmpty() {
        Restaurant::truncate();

        $this->action('GET', 'DailyMenuController@today');
        $this->assertResponseOk();
    }

    public function testRestaurantsEmptyPrint() {
        Restaurant::truncate();

        $this->call('GET', action('DailyMenuController@today'), ['print' => 1]);
        $this->assertResponseOk();
    }

    public function testPastDate() {
        $this->call('GET', action('DailyMenuController@date', '1900/01/01'));
        $this->assertResponseOk();
    }

    public function testFutureDate() {
        $this->call('GET', action('DailyMenuController@date', '2100/01/01'));
        $this->assertResponseOk();
    }

}