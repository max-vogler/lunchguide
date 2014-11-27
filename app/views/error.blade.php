@extends('layouts.minimal')

@section('head')
  <style>
    body {
      background: transparent url(/img/bg-404.jpg) no-repeat center center;
      background-size: cover;
    }

    .main-error {
      text-align: center;
    }

    .main-error h1 {
      font-size: 10em;
    }
  </style>
@stop

@section('body')
  <div class="main-error">
    <h1>{{{ $error }}}</h1>
    <h2>{{{ $description }}}</h2>

    <h2><a href="{{{ action('DailyMenuController@today') }}}">← LunchGuide</a></h2>
  </div>
@stop