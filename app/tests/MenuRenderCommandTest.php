<?php

use Symfony\Component\Console\Output\BufferedOutput;

class MenuRenderCommandTest extends TestCase {

    public function testPhantomJsExists() {
        $this->assertFileExists(app_path() . '/phantomjs/phantomjs');
    }

    public function testEmptyRender() {
        $output = new BufferedOutput;

        Artisan::call('menu:render', ['date' => '1970-01-01'], $output);

        $file = trim($output->fetch());
        $this->assertFileExists($file);
        unlink($file);
    }

    public function testRegularRender() {
        $date = Carbon::createFromDate(1970, 01, 01);
        $output = new BufferedOutput;
        $restaurant = $this->createRestaurant();
        $meal = $this->createMeal(['restaurant_id' => $restaurant->id, 'date' => $date]);

        Artisan::call('menu:render', ['date' => '1970-01-01'], $output);
        
        $file = trim($output->fetch());
        $this->assertFileExists($file);
        unlink($file);
    }

}