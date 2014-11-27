@extends('layouts.minimal')

@section('styles')
  <link rel="stylesheet" href="/css/admin.css">
@stop

@section('body')

    <div class="container">
      {{ BootForm::open()->action(action('AuthenticationController@postLogin'))->addClass('form-signin') }}
      {{ Form::csrf() }}
        <h2 class="form-signin-heading">LunchGuide</h2>
        {{ Form::email('email', null, ['placeholder' => 'E-Mail-Adresse', 'class' => 'form-control', 'required', 'autofocus']) }}
        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Passwort', 'required']) }}
        {{ BootForm::submit('Anmelden', 'btn-lg btn-primary btn-block') }}
      {{ BootForm::close() }}

    </div>
@stop
