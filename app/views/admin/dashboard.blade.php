@extends('layouts.admin')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">LunchGuide Dashboard</div>
        <div class="panel-body">
            <strong>Restaurants:</strong> {{{ Restaurant::count() }}}<br>
            <strong>Meals:</strong> {{{ Meal::count() }}}<br>
            <strong>Featured Meals:</strong> {{{ Meal::where('featured', true)->count() }}}
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">User</div>
        <div class="panel-body">
            <strong>E-mail:</strong> {{{ Auth::user()->email }}}<br>
        </div>
    </div>
@stop