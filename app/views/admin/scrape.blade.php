@extends('layouts.admin')

@section('content')

  <h3>{{{ count($updates) }}} Restaurant(s) wurden abgefragt.</h3>

  @foreach($updates as $index => $update)
    <div class="panel panel-default">
      <div class="panel-heading"><span class="badge">#{{{ $index + 1 }}}</span> {{{ $update->scraper->getRestaurant()->name }}}</div>

      <table class="table">
        @foreach($update->meals as $meal)
          <tr>
            <td>{{{ $meal->date->formatLocalized('%a, %d.%m.%Y') }}}</td>
            <td>
              {{ $meal->featured ? '<b>' : '' }}
              {{{ $meal->name }}}
              {{ $meal->featured ? '</b>' : '' }}
            </td>
            <td>{{{ $meal->info }}}</td>
            <td>{{{ readable_price($meal->price) }}}</td>
          </tr>
      @endforeach
      </table>

    </div>

  @endforeach

@stop