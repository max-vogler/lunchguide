@extends('layouts.admin')

@section('content')
    @if(Session::has('error'))
        <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
    @endif

    @if(Session::has('success'))
        <div class="alert alert-success">{{{ Session::get('success') }}}</div>
    @endif

    <div class="panel panel-default">
        <div class="panel-heading">
            Zu aktualisierende Facebookseiten
            <a href="{{{ $fb_login_url }}}" class="btn btn-default pull-right">Hinzufügen</a>
        </div>
        
        @if($pages->isEmpty())
            <div class="panel-body">
                Keine Seiten vorhanden. <a href="{{{ $fb_login_url }}}" >Hinzufügen</a>.
            </div>
        @else
            <ul class="list-group">
            @foreach($pages as $page)
                <li class="list-group-item">{{{ $page->getName() }}}</li>
            @endforeach
            </ul>
        @endif
    </div>
@stop