@extends('home')

@section('content_header')


@stop


@section('dinamic-content')

    <div class="d-flex justify-content-center mb-5">
        <h2>{{ $title }}</h2>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center align-items-center flex-row ">

            <div class="col-4 text-center offset-4">

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
                        <x-adminlte-button theme="outline-indigo" id="searchPoint" label="Buscar" icon="fas fa-search" />
                    </x-slot>
                </x-adminlte-date-range>


            </div>

            <div class="col-4 row justify-content-center">
                <div class="mx-2 "><a href="" class="text-indigo" ><i class="fa-sharp fa-xl fa-solid fa-file-pdf"></i></a></div>
                <div class="mx-2"><a href="" class="text-indigo"> <i class="fa-sharp fa-xl fa-solid fa-file-excel"></i></a></div>
            </div>


            <div class="col-8 my-5 ">
                <canvas  id="{{ $chart }}"></canvas>
            </div>



            <div class="col-10 row justify-content-center mt-2 ">

                {{-- Setup data for datatables --}}
                @php
                    $heads = ['#', 'Asesor', 'Nombre', 'Puntos'];

                @endphp

                {{-- Minimal example / fill data using the component slot --}}
                <x-adminlte-datatable id="table-points" :heads="$heads">
                </x-adminlte-datatable>

            </div>

        </div>


    </div>


@stop
