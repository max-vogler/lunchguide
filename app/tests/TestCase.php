<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	/**
	 * Creates the application.
	 *
	 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication() {
		$unitTesting = true;
		$testEnvironment = 'testing';

		return require __DIR__.'/../../bootstrap/start.php';
	}

	/**
	 * Default preparation for each test
	 */
	public function setUp() {
	    parent::setUp();
	 
	    Artisan::call('migrate');
        Mail::pretend(true);
        Route::enableFilters();
	}

    public function assertResponseOkOrRedirect() {
        $this->assertContains($this->client->getResponse()->getStatusCode(), [200, 302]);
    }

    public function assertResponseRedirect() {
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

	protected function createRestaurant($data = []) {
		$restaurant = new Restaurant;
        $restaurant->name = "Testaurant";

		foreach ($data as $key => $value) {
        	$restaurant->{$key} = $value;
        }

        $restaurant->save();
        $this->assertNotNull($restaurant->id);
        
        return $restaurant;
	}

    protected function createMeal($data = []) {
        $meal = new Meal;
        $meal->restaurant_id = 0;
        $meal->date = \Carbon::today();
        $meal->name = "Tasty test meal";
        $meal->price = 4200;
        $meal->info = "100% code covered";
        $meal->featured = true;
        $meal->source = "TestCase";

        foreach ($data as $key => $value) {
            $meal->{$key} = $value;
        }

        $meal->save();
        $this->assertNotNull($meal->id);

        return $meal;
    }

}
