@extends('adminlte::page')


@section('content_header')

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mt-2">
                <div class="card-body">
                    @yield('dinamic-content')
                </div>
            </div>
        </div>
    </div>
@stop
