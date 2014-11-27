@extends('layouts.admin')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Seite auswählen</div>
        <div class="panel-body">
            {{ BootForm::openHorizontal(2, 10)->action(action('AdminController@facebookSelectPage')) }}
            {{ Form::csrf() }}
            {{ BootForm::select('Seite', 'fb_access_token')->options($pages) }}

            @if($unselectablePages)
            <div class="form-group">
                <label class="col-sm-2 control-label">Nicht auswählbar:</label>
                <div class="col-sm-10">
                    <p class="form-control-static">{{{ implode(', ', $unselectablePages) }}}</p>
                </div>
            </div>
            @endif

            {{ BootForm::submit('Auf dieser Seite veröffentlichen', 'btn-primary') }}
            {{ BootForm::close() }}
        </div>
    </div>
@stop