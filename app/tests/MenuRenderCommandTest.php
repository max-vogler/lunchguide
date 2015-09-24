<?php

use Symfony\Component\Console\Output\BufferedOutput;

class MenuRenderCommandTest extends TestCase {

    /**
     * Renders the given url to a temporary file.
     * @param $url
     * @param $params
     * @return string the file name, which contains the rendered website
     */
    private function renderActionToTemporaryFile($url, $params) {
        $response = $this->call('GET', $url, $params);
        $content = $response->getContent();
        $file = sys_get_temp_dir() . '/temp-'.uniqid().'.html';

        file_put_contents($file, $content);

        return $file;
    }

    private function renderMenuAndCheck($dateString = '1970-01-01') {
        $output = new BufferedOutput;
        $date = Carbon::createFromFormat('Y-m-d', $dateString);
        $action = action('DailyMenuController@date', url_date($date));
        $sourceFile = $this->renderActionToTemporaryFile($action, ['print' => 1]);
        $returnCode = Artisan::call('menu:render', ['file' => $sourceFile], $output);
        unlink($sourceFile);

        if($returnCode != 0) {
            $this->fail($output->fetch());
        }

        $file = trim($output->fetch());
        $this->assertFileExists($file);
        unlink($file);
    }

    public function testEmptyRender() {
        $this->renderMenuAndCheck();
    }

    public function testRegularRender() {
        $date = Carbon::createFromDate(1970, 01, 01);
        $restaurant = $this->createRestaurant();
        $meal = $this->createMeal(['restaurant_id' => $restaurant->id, 'date' => $date]);

        $this->renderMenuAndCheck();
    }

}