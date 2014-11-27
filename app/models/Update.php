<?php

/**
 * An update, being processed/returned by Scrapers.
 * 
 * @property Carbon $date the date, which should be scraped
 * @property Scraper $scraper the scraper, which executed the update
 * @property Exception|null $error the error, if occurred
 * @property array $files all source files (html, pdf, ...) used by the Scraper
 * @property array $meals all meals created by the scraper
 * @property array $removeMealsForDaes all dates for whom meals should be removed
 */
class Update {

    public $date = null;

    public $scraper = null;

    public $error = null;

    public $files = [];

    public $meals = [];

    public $removeMealsForDates = [];

    public function __construct($values = []) {
        foreach($values as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function getFileUrls() {
        return array_map(function ($file) {
            return action('ScraperController@getScrapeFile', [$this->scraper->getRestaurant()->name, $file]); 
        }, $this->files);
    }

}