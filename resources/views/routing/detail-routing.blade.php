@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Detalle del Routing</h2>
        <div>
            <button class="btn btn-primary"> Atras </button>
        </div>
    </div>

@stop
@section('dinamic-content')

    <div class="row mt-3">
        <div class="col-6">

            <h5 class="text-indigo mb-2 text-center py-3">
                <i class="fa-regular fa-circle-info"></i>
                Información de la operacion
            </h5>
            <table class="table">
                <tbody>
                    <tr>
                        <td class="text-secondary text-bold text-uppercase">Nro Operacion</td>
                        <td>{{ $routing->nro_operation }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary text-bold text-uppercase">Origen</td>
                        <td>{{ $routing->origin }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary text-bold text-uppercase">Destino</td>
                        <td>{{ $routing->destination }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary text-bold text-uppercase">Valor de la Carga</td>
                        <td>$ {{ $routing->load_value }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary text-bold text-uppercase">Cliente</td>
                        <td>{{ $routing->customer->name_businessname }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary text-bold text-uppercase">Proveedor del Cliente</td>
                        <td>{{ $routing->shipper->name_businessname }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary text-bold text-uppercase">Tipo de embarque</td>
                        <td>{{ $routing->type_shipment->description }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary text-bold text-uppercase">Regimen</td>
                        <td>{{ $routing->regime->description }}</td>
                    </tr>
                </tbody>
            </table>



        </div>
        <div class="col-6 px-5">

            <h5 class="text-indigo mb-2 text-center py-3">
                <i class="fa-duotone fa-gear"></i>
                Servicios
            </h5>

            <x-adminlte-select2 name="type_service" igroup-size="md" data-placeholder="Seleccione una opcion..."
                onchange="openModalForm()">
                <option />
                @foreach ($type_services as $type_service)
                    <option> {{ $type_service->name }} </option>
                @endforeach
            </x-adminlte-select2>


            <hr>
            <p class="text-indigo text-bold">Lista de Servicios: </p>
            <table class="table">
                <tbody>

                </tbody>
            </table>


            {{-- Minimal --}}
            <x-adminlte-modal id="modalFlete" title="Minimal" size='lg'>

                <div class="form-group">
                    <label for="freight_value">Valor del Flete</label>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text text-bold">
                                $
                            </span>
                        </div>
                        <input type="text" class="form-control CurrencyInput" name="freight_value" data-type="currency"
                            placeholder="Ingrese valor del flete">

                        @error('freight_value')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                {{-- 
                <div class="row">
                    <div class="col-6">
                        <x-adminlte-select2 name="type_insurance" label="Tipo de seguro" igroup-size="md"
                            data-placeholder="Seleccione una opcion...">
                            <option />
                            <option>Seguro A</option>
                            <option>Seguro B</option>
                        </x-adminlte-select2>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="load_value">Valor del seguro</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-bold @error('value_insurance') is-invalid @enderror">
                                        $
                                    </span>
                                </div>
                                <input type="text"
                                    class="form-control CurrencyInput @error('value_insurance') is-invalid @enderror "
                                    name="value_insurance" data-type="currency" placeholder="Ingrese valor de la carga"
                                    value="{{ isset($routing->value_insurance) ? $routing->value_insurance : old('value_insurance') }}">
                            </div>
                            @error('value_insurance')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                    </div>
                </div> --}}


                <div class="row">
                    <div class="col-4">

                        <div class="form-group">
                            <label for="nro_operation">Concepto</label>
                            <input type="text" class="form-control" id="nro_operation" name="nro_operation"
                                placeholder="Ingrese el numero de operacion">
                        </div>

                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="nro_operation">Valor del Concepto</label>
                            <input type="text" class="form-control" id="nro_operation" name="nro_operation"
                                placeholder="Ingrese el numero de operacion">
                        </div>

                    </div>
                    <div class="col-4 d-flex align-items-center pt-3">
                        <button class="btn btn-indigo">
                            Agregar
                        </button>

                    </div>
                </div>

            </x-adminlte-modal>


        </div>
    </div>



    <table>

    </table>

@stop

@push('scripts')
    <script>
        function openModalForm() {
            $('#modalFlete').modal('show');
        }
    </script>
@endpush
