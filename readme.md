LunchGuide
==========
[![Build Status](https://travis-ci.org/mr-max/lunchguide.svg)](https://travis-ci.org/mr-max/lunchguide)  
An automatized guide to local restaurants, aggregating and summarizing the daily menus of different restaurants.

![](public/img/screenshot.png)

This web application consists of 3 major parts:

1. **Scraper**  
   Downloads, parses and interprets the menu of the day multiple times per day. Scrapers may get their data from APIs, plain HTML websites and PDF files. Based on simple rules, the scraper extracts and saves meal names, prices and other information.
2. **Website** (www.lunchguide.org)  
   A simple, responsive, website that shows the summarized menu of the day.
3. **Publication**  
   A rendered version of the summarized menu of the day is posted daily to Facebook.

Technology
----------
This web application is based on PHP and Laravel 4.2. The scrapers use Symfonys DomCrawler for HTML and Smalot's PdfParser for PDF files. Publications are rendered with PhantomJS.

Set up
------
1. Clone this repo.
2. Copy `/app/config/local.example/` to `/app/config/local/` and edit the configuration files for your development installation.
3. Run `php artisan migrate` to create the database tables.
4. Install [PhantomJS](http://phantomjs.org/)
5. Create your scrapers in `/app/scrapers/` and reference them in `/app/config/local/scrapers.php`.

License
-------
> LunchGuide  
> Copyright (C) 2015 Max Vogler
>  
> This program is free software: you can redistribute it and/or modify
> it under the terms of the GNU General Public License as published by
> the Free Software Foundation, either version 3 of the License, or
> (at your option) any later version.
> 
> This program is distributed in the hope that it will be useful,
> but WITHOUT ANY WARRANTY; without even the implied warranty of
> MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
> GNU General Public License for more details.
>  
> You should have received a copy of the GNU General Public License
> along with this program.  If not, see <http://www.gnu.org/licenses/>.
