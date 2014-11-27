<?php

class ScraperController extends BaseController {
    
    public function updateDate($date = 'today') {
        return Response::view('admin.scrape', ['updates' => $this->update($date)]);
    }

    public function update($date = 'today') {
        $updates = [];
        $date = new \Carbon($date);
        $scrapers = Config::get('scrapers.run');

        $updates = array_map(function ($scraperName) use ($date) {
            $update = new \Update(['date' => $date]);
            $update->scraper = new $scraperName($update);
            
            try {
                $update->scraper->update();
            } catch(\Exception $e) {
                if(App::environment('production')) {
                    // don't quit & stop other scrapers from running on error!
                    Log::error($e);
                } else {
                    throw $e;
                }
                
                $update->error = $e;
            }

            return $update;
        }, $scrapers);

        return $updates;
    }

}
