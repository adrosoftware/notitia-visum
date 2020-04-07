@extends('notitia-visum::master')

@section('title', 'Browse')

@section('content')
<div class="row">
    <div class="col">
        @if ($browser->total() === 0)
        No data found!
        @else
        <table class="table">
            <thead>
                <tr>
                    @foreach ($browser->rowHeaders() as $column)
                    <th scope="row">{{ $column }}</th>
                    @endforeach
                    @if ($browser->hasEditRoute())
                    <th scope="col">edit</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @php
                $properities = $browser->getColumns();
                @endphp
                @foreach ($browser->records() as $item)
                <tr>
                    @foreach ($properities as $column)
                    <th scope="row">{{ $item->{$column} }}</th>
                    @endforeach
                    @if ($browser->hasEditRoute())
                    <td><a href="{{ $item->editUrl }}">edit</a></td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

    </div>
</div>

@if ($browser->total() > 0)
<div class="row">
    <div class="col align-self-end">
        {{ $browser->paginator()->links() }}
    </div>
</div>
@endif


@endsection