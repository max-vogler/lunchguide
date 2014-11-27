<?php

namespace Example;

class SimpleScraper extends \Scraper {

    public function __construct(\Update $update) {
        // Assign the meals to whatever restaurant is the first in the DB
        $this->name = \Restaurant::first()->name;
        parent::__construct($update);
    }

    protected function run() {
        $meal = new \Meal([
            'name' => 'Tasty Test Meal w/ Fries',
            'info' => '100% delicious',
            'price' => 4200,
            'featured' => true,
            'date' => $this->update->date,
            'source' => 'SimpleScraper @ ' . date('Y-m-d H:i:s')
        ]);

        $this->update->meals = [$meal];
        $this->update->removeMealsForDates[] = $this->update->date;
    }

}