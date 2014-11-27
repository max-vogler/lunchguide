<?php

abstract class WebScraper extends Scraper {

    protected $url;
    protected $updateFiles = [];
    protected $fileSuffix = "html";

    protected function getUrls() {
        return [$this->url];
    }

    protected function getStorageBasePath() {
        return storage_path() . '/scrapes';
    }

    protected function getStoragePath() {
        $packageAndClassNames = str_replace('\\', '/', get_class($this));
        return $this->getStorageBasePath() . "/$packageAndClassNames";
    }

    public function getStorageFile($index, $date = "today") {
        $dateString = (new \Carbon($date))->toDateString();
        $suffix = $this->fileSuffix;
        return $this->getStoragePath() . "/$dateString-$index.$suffix";
    }

    protected function retry(callable $func) {
        return retry(
            $func, 
            Config::get('scraper.web.retry.delay'), 
            Config::get('scraper.web.retry.times')
        );
    }

    protected function run() {
        if($this->update->date->isToday()) {
            // For today: Download the file, elsewise use a local version
            $ua = Config::get('scrapers.web.user-agent');
            $context = stream_context_create([ 'http' => [ 'header' => "User-Agent:$ua\r\n" ]]);
            
            $this->update->files = array_map(function ($url, $index) use ($context) {
                // retry downloading multiple times,
                // some webhosts throw random errors
                $html = $this->retry(function () use ($url, $context) { 
                    return file_get_contents($url, false, $context);
                });
                $file = $this->getStorageFile($index);
                $dir = dirname($file);

                if(!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }

                file_put_contents($file, $html);
                return $file;      
            }, $this->getUrls(), array_keys($this->getUrls()));
        } else {
            $fileprefix = $this->update->date->toDateString();
            $this->update->files = glob($this->getStoragePath() . "/$fileprefix*");
        }

        // Scrape aaaaaall the files!
        $this->update->meals = array_map([$this, 'runFromFile'], $this->update->files);

        // Scrapers may returns multi-dimensional arrays
        $this->update->meals = array_flatten($this->update->meals);

        // Scrapers may return null, false or other invalid data in case of scraping errors
        $this->update->meals = array_filter($this->update->meals, function ($meal) {
            return $meal instanceof \Meal;
        });
    }

    public abstract function runFromFile($file);

    public function getFilesOfLastUpdate() {
        return $this->updateFiles;
    }

}