@extends('notitia-visum::master')

@section('title', 'Browse')

@section('content')
<div class="table-container">
    <div class="card card-default">

        <div class="card-body">
            <h3 class="card-title">
                {{ $browser->title() }}
            </h3>
            <div class="col-sm-12">
                <div class="table-responsive">
                    @if ($browser->total() === 0)
                    No data found!
                    @else
                    <table class="table table-bordered table-striped table-condensed">
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
                <div class="col-sm-6 col-md-6 col-xs-12">
                    &nbsp;
                </div>
                <div class="col-sm-6 col-md-6 col-xs-12">
                    {{ $browser->paginator()->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection