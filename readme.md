LunchGuide
==========
An automatized guide to local restaurants


Set up
------
1. Clone this repo.
2. Copy `/app/config/local.example/` to `/app/config/local/` and edit the configuration files for your development installation.
3. Run `php artisan migrate` to create the database tables.
4. [Build](http://squallssck.github.io/blog/2013/03/07/about-how-to-make-phantomjs-support-google-web-fonts/) or [download](http://arunoda.me/blog/phantomjs-webfonts-build.html) PhantomJS with WebFont support. Then copy or link the binary to `/app/phantomjs/phantomjs`.
5. Create your scrapers in `/app/scrapers/` and reference them in `/app/config/local/scrapers.php`.