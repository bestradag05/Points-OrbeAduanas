@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>{{$title}}</h2>
    </div>

@stop


@section('dinamic-content')

    <div class="container-fluid">
        <div class="row justify-content-center ">

            <div class="col-10 my-5 ">
                <canvas id="{{$chart}}"></canvas>
            </div>


            <div class="col-10 row justify-content-center ">

                <h2 class="text-center mb-3">Detalle de puntos</h2>

                {{-- Setup data for datatables --}}
                @php
                    $heads = ['#', 'Asesor', 'Nombre', 'Puntos'];

                @endphp

                {{-- Minimal example / fill data using the component slot --}}
                <x-adminlte-datatable id="table1" :heads="$heads">
                    @foreach ($personalPoints as $personalPoint)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img src="{{ asset('/fotos-de-usuarios/' . $personalPoint['personal']->img_url) }}"
                                    width="50px" /></td>
                            <td>
                                {{ $personalPoint['personal']['name']. ' ' . $personalPoint['personal']['last_name']  }}
                            </td>

                            <td class="{{ $personalPoint['puntos'] < 15 ? 'text-secondary' : 'text-success' }}">
                                {{ $personalPoint['puntos'] }}
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>




            </div>

        </div>


    </div>


@stop


@push('scripts')


@endpush
