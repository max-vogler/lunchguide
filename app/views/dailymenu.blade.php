@extends('layouts.main')

@section('head')
  <title>
    {{{ trans('lunchguide.heading', ['date' => readable_date($date)]) }}} – 
    {{{ trans('lunchguide.subheading') }}}
  </title>

  <link rel="canonical" href="{{{ action('DailyMenuController@date', url_date($date)) }}}">
@stop

@section('header')
  <h1>{{{ trans('lunchguide.heading', ['date' => readable_date($date)]) }}}</h1>
  <h2>
    {{{ trans('lunchguide.subheading') }}}<br>

    @if($dateYesterday)
      @if($dateYesterday->isToday())
        <a href="{{{ action('DailyMenuController@today') }}}">&laquo; {{{ trans('lunchguide.today') }}}</a>
      @else
        <a href="{{{ action('DailyMenuController@date', url_date($dateYesterday)) }}}">&laquo; {{{ $dateYesterday->formatLocalized('%A') }}}</a>
      @endif
    @endif
    @if($dateTomorrow)
      //
      @if($dateTomorrow->isToday())
        <a href="{{{ action('DailyMenuController@today') }}}">{{{ trans('lunchguide.today') }}} &raquo;</a>
      @else
        <a href="{{{ action('DailyMenuController@date', url_date($dateTomorrow)) }}}">{{{ $dateTomorrow->formatLocalized('%A') }}} &raquo;</a>
      @endif
    @endif

    @if(!$date->isToday() && (!$dateYesterday || !$dateYesterday->isToday()) && (!$dateTomorrow || !$dateTomorrow->isToday()))
    //
    <a href="{{{ action('DailyMenuController@today') }}}"{{{ trans('lunchguide.menu-of-today') }}}</a>
    @endif
  </h2>
@stop

@section('content')
  @foreach($specials as $entry)
  <section class="restaurant">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <h3 class="restaurant-name">{{{$entry['restaurant']->name}}}</h3>
        </div>

        <div class="col-md-9">
          @foreach($entry['meals'] as $meal)
            <div class="meal">
              <div class="meal-details">
                @if($meal->info)
                <span class="meal-info hidden-xs">({{{ $meal->info }}})</span>
                @endif

                <span class="meal-price">{{{ readable_price($meal->price) }}}</span>
              </div>

              <div class="meal-name">
                {{{ $meal->name }}}

                @if($meal->info)
                <span class="meal-info hidden-sm hidden-md hidden-lg">({{{ $meal->info }}})</span>
                @endif
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>
  @endforeach

  @if($nospecials)
    <section class="content no-specials no-specials-{{{ count($nospecials) }}}">
      <div class="container">
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-9">
            <h3>{{{ trans('lunchguide.no-meals-found', ['restaurants' => implode(', ', $nospecials)]) }}}
          </div>
        </div>
      </div>
    </section>
  @endif
@stop
