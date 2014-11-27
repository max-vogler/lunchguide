<?php

use \Smalot\PdfParser\Parser;

abstract class PdfWebScraper extends WebScraper {

    protected $fileSuffix = "pdf";

    public function runFromFile($file) {
        $parser = new Parser();
        $pdf = $parser->parseFile($file);

        return $this->scrape($pdf);
    }

    protected abstract function scrape($pdf);

}