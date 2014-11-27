<!doctype html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  
  <link rel="stylesheet" href="{{{ asset('css/min.css') }}}">
  @yield('styles')

  <link rel="shortcut icon" href="/img/favicon/favicon.ico">

  @yield('head')
</head>
<body>

  @yield('body')

  <script src="/bower_components/bootflat/js/jquery-1.10.1.min.js"></script>
  <script src="/bower_components/bootflat/js/jquery.icheck.js"></script>
  <script src="/bower_components/bootflat/js/bootstrap.min.js"></script>

  @if(Config::get('app.analytics_id'))
    <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', '{{{ Config::get("app.analytics_id") }}}', 'auto');
    ga('send', 'pageview');
    </script>
  @endif
</body>
</html>
