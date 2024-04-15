@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Puntos de Flete</h2>
    </div>

@stop
@section('dinamic-content')

    <div class="container">
        <div class="row flex-row">
                @foreach ($personalPoints as $personalPoint)
                    <x-adminlte-profile-widget name="{{$personalPoint['personal']->name}}" desc="{{$personalPoint['personal']->user->getRoleNames()->first()}}" class="col-4" theme="indigo"
                        img="{{asset('/fotos-de-usuarios/'. $personalPoint['personal']->img_url)}}">
                        <x-adminlte-profile-col-item class="text-primary border-right" icon="fa-solid fa-coins" title="Puntos de Flete"
                            text="{{$personalPoint['puntos']}}" size=12 badge="primary" />
                    </x-adminlte-profile-widget>
                @endforeach

        </div>

    </div>


@stop
