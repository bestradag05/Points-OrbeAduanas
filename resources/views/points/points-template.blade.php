@extends('home')

@section('content_header')


@stop


@section('dinamic-content')

    <div class="d-flex justify-content-center mb-5">
        <h2>{{ $title }}</h2>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center align-items-center flex-column ">

            <div class="col-4 text-center">

                {{-- LG size with some config and add-ons --}}
                @php
                    $config = [
                        'showDropdowns' => true,
                        'startDate' => 'js:moment().startOf("month")',
                        'endDate' => 'js:moment().endOf("month")',
                        'minYear' => 2010,
                        'maxYear' => "js:parseInt(moment().format('YYYY'),10)",
                        'locale' => [
                            'format' => 'DD/MM/YYYY',
                            "separator" => " - ",
                            'applyLabel' => 'Aplicar',
                            'cancelLabel' => 'Cancelar',
                            'fromLabel' => 'Desde',
                            'toLabel' => 'Hasta',
                            'customRangeLabel' => 'Personalizado',
                            'weekLabel' => 'S',
                            'daysOfWeek' => ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                            'monthNames' => [
                                'Enero',
                                'Febrero',
                                'Marzo',
                                'Abril',
                                'Mayo',
                                'Junio',
                                'Julio',
                                'Agosto',
                                'Septiembre',
                                'Octubre',
                                'Noviembre',
                                'Diciembre',
                            ],
                            'firstDay' => 1, // 0 es domingo, 1 es lunes
                        ],
                        'opens' => 'center',
                    ];
                @endphp
                <x-adminlte-date-range name="points_date_range" igroup-size="md" :config="$config">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-indigo">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </x-slot>
                    <x-slot name="appendSlot">
                        <x-adminlte-button theme="outline-indigo" id="searchPoint" label="Search" icon="fas fa-search" />
                    </x-slot>
                </x-adminlte-date-range>


            </div>


            <div class="col-8 my-5 ">
                <canvas id="{{ $chart }}"></canvas>
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
                                {{ $personalPoint['personal']['name'] . ' ' . $personalPoint['personal']['last_name'] }}
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
