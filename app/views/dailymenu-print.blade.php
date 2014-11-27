<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

  <title>{{{ trans('lunchguide.heading', ['date' => readable_date($date)]) }}} – {{{ trans('lunchguide.subheading') }}}</title>
  <link rel="stylesheet" href="{{{ asset('css/min.css') }}}">
  <link rel="stylesheet" href="/css/style-print.css" media="all">
</head>
<body>
  <div class="print-container">
  <header class="header">
    <img src="/img/logo.png" class="logo">
    <div class="title">
      <h1>{{{ trans('lunchguide.heading', ['date' => readable_date($date)]) }}}</h1>
      <h2>{{{ trans('lunchguide.subheading') }}}</h2>
    </div>
  </header>

  @foreach($specials as $entry)
  <section class="restaurant">
    <h3 class="restaurant-name">{{{$entry['restaurant']->name}}}</h3>

    @foreach($entry['meals'] as $meal)
    <div class="meal">
      <div class="meal-details">
        @if($meal->info)
        <span class="meal-info">({{{ $meal->info }}})</span>
        @endif

        <span class="meal-price">{{{ readable_price($meal->price) }}}</span>
      </div>

      <div class="meal-name">
        {{{ $meal->name }}}
      </div>
    </div>
    @endforeach

  </section>
  @endforeach

  @if($nospecials)
    <div class="well text-center">{{{ trans('lunchguide.no-meals-found', ['restaurants' => implode(', ', $nospecials)]) }}}</div>
  @endif

  <div class="well text-center">{{{ trans('lunchguide.read-more') }}} – {{{ trans('lunchguide.disclaimer') }}}</div>
  </div>
</body>
</html>
