<?php

/**
 * A controller that displays the menu of the day.
 * 
 * @author Max Vogler
 */
class DailyMenuController extends BaseController {

	/**
	 * Displays today's menu.
	 */
	public function today() {
		return $this->date(\Carbon::today());
	}

	/**
	 * Displays the menu for a given date.
	 */
	public function date($date) {
		$specials = [];
		$nospecials = [];
		$hasMeals = Meal::count() > 0;

		$date = new \Carbon($date);
		$dateYesterday = $date->copy()->subDay();
		$dateTomorrow = $date->copy()->addDay();
		$showUntilDate = Config::get('view.max_date');

		foreach(Restaurant::all() as $restaurant) {
			$meals = $restaurant->meals()
				->where('date', $date)
				->where('featured', true)
				->orderBy('info')
				->orderBy('name')
				->groupBy('name')->distinct()
				->get();

			if($meals->count() > 0) {
				$specials[] = [
					'restaurant' => $restaurant,
					'meals' => $meals
				];
			} else {
				$nospecials[] = $restaurant;
			}
		}

		if($hasMeals) {
			$earliestDate = \Meal::orderBy('date', 'asc')->first()->date;
			$latestDate = \Meal::orderBy('date', 'desc')->first()->date;

			if($dateYesterday->lt($earliestDate)) {
				$dateYesterday = null;
			}

			if($dateTomorrow->gt($latestDate) || $dateTomorrow->gt($showUntilDate)) {
				$dateTomorrow = null;
			}
		} else {
			$dateYesterday = null;
			$dateTomorrow = null;
		}

		// if ?print=1 is provided, use a special template
		$template = Input::get('print') ? 'dailymenu-print' : 'dailymenu';

		return Response::view($template, [
			'date' => $date,
			'dateYesterday' => $dateYesterday,
			'dateTomorrow' => $dateTomorrow,
			'specials' => $specials,
			'nospecials' => $nospecials
		]);
	}

}
