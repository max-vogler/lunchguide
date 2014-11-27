<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MenuUpdateCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'menu:update';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Scrape the restaurant websites and update the meals table.';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire() {
		$scraperCtrl = new ScraperController;
		$updates = $scraperCtrl->update($this->argument('date'));

		foreach ($updates as $update) {
			$this->info($update->scraper->getRestaurant()->name . ': ' . count($update->meals) . ' meals scraped.');
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments() {
		return array([
            'date', 
            InputArgument::OPTIONAL, 
            'Specifies a date for the daily menu.', 
            'today'
        ]);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions() {
		return array();
	}

}
