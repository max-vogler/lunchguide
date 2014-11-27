<?php

use Symfony\Component\DomCrawler\Crawler;

abstract class HtmlWebScraper extends WebScraper {

    protected $fileSuffix = 'html';

    public function runFromFile($file) {
        $urlContents = new Crawler;
        $urlContents->addHTMLContent(file_get_contents($file), 'UTF-8');

        $meals = $this->scrape($urlContents);
        $urlContents->clear();

        return $meals;
    }

    protected abstract function scrape($crawler);

}