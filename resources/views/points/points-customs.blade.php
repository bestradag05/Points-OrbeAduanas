@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Puntos de Aduanas</h2>
    </div>

@stop

@vite(['resources/js/app.js', 'resources/js/chart.js'])

@section('dinamic-content')

    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-12 row">

                @foreach ($personalPoints as $personalPoint)
                <x-adminlte-profile-widget name="{{ $personalPoint['personal']->name }}"
                    desc="{{ $personalPoint['personal']->user->getRoleNames()->first() }}" class="col-3" theme="indigo"
                    img="{{ asset('/fotos-de-usuarios/' . $personalPoint['personal']->img_url) }}">
                    <x-adminlte-profile-col-item class="text-primary border-right" icon="fa-solid fa-coins"
                        title="Puntos de aduana" text="{{ $personalPoint['puntos'] }}" size=12 badge="primary" />
                </x-adminlte-profile-widget>
            @endforeach

            </div>


            <div class="col-10 mt-5 ">
                <canvas id="customChart"></canvas>
            </div>

            

        </div>





    </div>


@stop


@push('scripts')


 
@endpush
