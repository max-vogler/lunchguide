@extends('layouts.minimal')

@section('styles')
  <link rel="stylesheet" href="/css/admin.css">
@stop

@section('body')
  <div class="container">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-3" style="position: fixed">
        <div>
          <div class="list-group">
            <a href="{{{action('AdminController@dashboard')}}}" class="list-group-item">Dashboard</a>
            <a href="{{{action('AdminController@facebook')}}}" class="list-group-item">Facebookseiten</a>
            <a href="{{{action('ScraperController@updateDate')}}}" class="list-group-item">Tageskarten aktualisieren</a>
          </div>

          {{ Form::open(['action' => 'AuthenticationController@logout']) }}
            {{ Form::submit('Abmelden', ['class' => 'btn btn-link']) }}
          {{ Form::close() }}
        </div>
      </div>
      <div class="col-md-9">
        <div class="admin-content">
          @yield('content')
        </div>
      </div>
    </div>
  </div>
@stop