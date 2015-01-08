<?php

use Symfony\Component\DomCrawler\Crawler;

abstract class Scraper {

    protected $name;
    protected $restaurant;
    protected $update;

    public function __construct(\Update $update) {
        $this->restaurant = \Restaurant::where('name', $this->name)->first();
        
        if(!$this->restaurant) {
            throw new Exception("No restaurant found for {$this->name}");
        }

        $this->update = $update;
    }

    public final function update() {
        // run() assigns meals and files to $update
        $this->run();

        // Remove Meals for given dates
        $this->restaurant->meals()->whereIn('date', $this->update->removeMealsForDates)->delete();

        // Reset meal array keys
        $this->update->meals = array_values($this->update->meals);

        // Apply an optional post-filter to the meals
        $this->update->meals = $this->afterScrapeFilter($this->update->meals);

        // Save meals in the DB
        array_walk($this->update->meals, [$this, 'addMeal']);

        return $this->update;
    }

    protected abstract function run();

    protected function addMeal(\Meal $meal) {
        assert($this->restaurant);

        // Do some last minute polishing of the meal names
        // Use safe_ucfirst (see helpers.php) instead of ucfirst, because it does weird things to
        // strings starting with special charactes like "„foo bar“"
        $meal->name = safe_ucfirst($this->trim($meal->name));

        $meal->restaurant()->associate($this->restaurant);
        $meal->save();
    }

    protected function parsePrice($price) {
        // remove unneccessary currency symbols and white space
        $price = trim(str_replace('€', '', $price));

        // treat all punctuation marks equally
        $price = str_replace('.', ',', $price);

        // parse prices like "4,-" correctly
        $price = str_replace(',-', ',00', $price);

        // parse prices like "4 €" correctly
        if(strstr($price, ',') === false) {
            $price .= ',00';
        }

        // remove the decimal point, because we return prices as cents
        $price = str_replace(',', '', $price);

        return intval($price);
    }

    protected function parseDate($date) {
        // Carbon's parsing instantiation new \Carbon() has some weird
        // issues when parsing a date like 03.11.14, because it outputs
        // "today at 03:11:14" in this case!!

        $plain = preg_replace('/[^0-9\.]/', '', $date);

        if(!preg_match('/[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{2,4}/', $plain)) {
            if(!ends_with($plain, '.')) $plain .= '.';
            $plain .= date('Y');
        }

        list($d, $m, $y) = explode('.', $plain);

        // TODO: This isn't really suited to parse numbers in the 1900s
        if($y < 100) {
            $y += 2000;
        }

        return Carbon::create($y, $m, $d, 0, 0, 0);
    }

    protected function trim($text) {
        return trim(preg_replace("/\s+/", ' ', $text));
    }

    protected function afterScrapeFilter($meals) {
        return $meals;
    }

    public function getRestaurant() {
        return $this->restaurant;
    }

}