@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Puntos de Aduanas</h2>
    </div>

@stop
@section('dinamic-content')

    <div class="container">
        <div class="row flex-row">
            
                @foreach ($personalPoints as $personalPoint)
                    <x-adminlte-profile-widget name="{{$personalPoint->name}}" desc="{{$personalPoint->user->getRoleNames()->first()}}" class="col-4" theme="indigo"
                        img="{{asset('/fotos-de-usuarios/'. $personalPoint->img_url)}}">
                        <x-adminlte-profile-col-item class="text-primary border-right" icon="fas fa-lg fa-gift" title="Sales"
                            text="25" size=6 badge="primary" />
                        <x-adminlte-profile-col-item class="text-danger" icon="fas fa-lg fa-users" title="Dependents"
                            text="10" size=6 badge="danger" />
                    </x-adminlte-profile-widget>
                @endforeach

        </div>

    </div>


@stop
