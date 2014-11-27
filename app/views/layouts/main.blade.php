<!doctype html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  
  <link rel="stylesheet" href="{{{ asset('css/min.css') }}}">

  <!-- Favicon fun -->
  <link rel="shortcut icon" href="/img/favicon/favicon.ico">
  <link rel="apple-touch-icon" sizes="57x57" href="/img/favicon/apple-touch-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="114x114" href="/img/favicon/apple-touch-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="72x72" href="/img/favicon/apple-touch-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="144x144" href="/img/favicon/apple-touch-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="60x60" href="/img/favicon/apple-touch-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="120x120" href="/img/favicon/apple-touch-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="76x76" href="/img/favicon/apple-touch-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="152x152" href="/img/favicon/apple-touch-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-touch-icon-180x180.png">
  <meta name="apple-mobile-web-app-title" content="LunchGuide">
  <link rel="icon" type="image/png" href="/img/favicon/favicon-192x192.png" sizes="192x192">
  <link rel="icon" type="image/png" href="/img/favicon/favicon-160x160.png" sizes="160x160">
  <link rel="icon" type="image/png" href="/img/favicon/favicon-96x96.png" sizes="96x96">
  <link rel="icon" type="image/png" href="/img/favicon/favicon-16x16.png" sizes="16x16">
  <link rel="icon" type="image/png" href="/img/favicon/favicon-32x32.png" sizes="32x32">
  <meta name="msapplication-TileColor" content="#b37d75">
  <meta name="msapplication-TileImage" content="/img/favicon/mstile-144x144.png">
  <meta name="msapplication-config" content="/img/favicon/browserconfig.xml">
  <meta name="application-name" content="LunchGuide">

  @yield('head')
</head>
<body>
  <header class="header">
    <div class="container">
      <div class="row">
        <div class="col-sm-3 hidden-xs col-logo">
          <div class="logo"></div>
        </div>
        <div class="col-sm-9">
          @yield('header')
        </div>
      </div>
    </div>
  </header>

  @yield('content')

  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-9">
          <p>
            {{{ trans('lunchguide.disclaimer') }}} – 
            {{ trans('lunchguide.footer-links') /* don't escape here, <a> tags required! */ }}
          </p>
        </div>
      </div>
    </div>
  </footer>

  @if(Config::get('services.google.analytics.id'))
    <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', '{{{ Config::get("services.google.analytics.id") }}}', 'auto');
    ga('send', 'pageview');
    </script>
  @endif

  <script src="{{{ asset('bower_components/instantclick/instantclick.js') }}}" data-no-instant></script>
  <script data-no-instant>InstantClick.init();</script>
</body>
</html>
