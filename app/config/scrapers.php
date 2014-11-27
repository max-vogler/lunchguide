<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Scrapers to run
    |--------------------------------------------------------------------------
    |
    | Specifies all scrapers to be executed.
    |
    */

    'run' => [],


    /*
    |--------------------------------------------------------------------------
    | Web scraper configuration
    |--------------------------------------------------------------------------
    */

    'web' => [
        'retry' => [
            // the numer of retries in case of HTTP errors
            'times' => 3,

            // the delay between retries [seconds]
            'delay' => 2
        ],

        // the User-Agent for HTTP requests
        'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.36 Safari/537.36'
    ],

];
