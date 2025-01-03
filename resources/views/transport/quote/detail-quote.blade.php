@extends('home')
@section('dinamic-content')
    <div class="d-flex justify-content-center">
        <h3 class="text-bold">Cotizacion : {{ $quote->nro_quote }} <span
                class="text-indigo">{{ $quote->nro_operation }}</span> </h3>
    </div>
    <div class="container">

        <div class="row">
            <div class="col-12 my-4 text-center">
                @can('transporte.quote.response')
                    <button class="btn btn-indigo mx-2 {{ $quote->state != 'Pendiente' ? 'd-none' : '' }}" data-toggle="modal"
                        data-target="#modalQuoteResponse"><i class="fas fa-check-double"></i> Dar respuesta</button>

                    <button class="btn btn-secondary mx-2 {{ $quote->state != 'Pendiente' ? 'd-none' : '' }}"
                        data-toggle="modal" data-target="#modalQuoteObservation"><i class="fas fa-eye"></i> Dar
                        observaciones</button>
                @endcan

                <button class="btn btn-secondary mx-2 {{ $quote->state != 'Reajuste' ? 'd-none' : '' }}" data-toggle="modal"
                    data-target="#modalQuoteReajust"><i class="fas fa-money-check-alt"></i> Reajustar </button>

                <a href="{{ url('/quote/transport/cost/keep/' . $quote->id) }}"
                    class="btn btn-danger mx-2 {{ $quote->state != 'Reajuste' ? 'd-none' : '' }}"><i
                        class="fas fa-hand-holding-usd"></i> Mantener precio </a>

            </div>

            @if ($files->isNotEmpty())
                <div class="col-12 mb-2 row">
                    <h6 class="text-bold text-secondary ml-2">Documentos:</h6>
                    @foreach ($files as $file)
                        <div class="mx-2">
                            <a href="{{ $file['url'] }}" class="mx-1" target="_blank">{{ $file['name'] }}</a>
                            <i class="fas fa-file-archive"></i>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-bold text-secondary ml-2">No hay archivos adjuntos disponibles para esta cotizacion.</p>
            @endif

            <div class="col-12">

                <div class="head-quote mb-2">
                    <h5 id="title_quote" class="text-center text-uppercase bg-indigo p-2">Formato <span></span></h5>
                </div>
                <div class="body-detail-customer p-2">
                    <div class="form-group row">
                        <label for="customer" class="col-sm-2 col-form-label">Cliente</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('customer') is-invalid @enderror"
                                id="customer" name="customer" placeholder="Ingresa el cliente" @readonly(true)
                                value="{{ isset($quote->customer) ? $quote->customer->name_businessname : old('customer') }}">
                        </div>
                        @error('customer')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group row {{ $quote->lcl_fcl === 'LCL' ? '' : 'd-none' }}">
                        <label for="pick_up" class="col-sm-2 col-form-label">Direccion de recojo</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('pick_up') is-invalid @enderror" id="pick_up"
                                name="pick_up" placeholder="Ingrese la direccion de recojo" @readonly(true)
                                value="{{ isset($quote->pick_up) ? $quote->pick_up : old('pick_up') }}">
                            @error('pick_up')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>

                    <div class="form-group row  {{ $quote->lcl_fcl === 'FCL' ? '' : 'd-none' }}">
                        <label for="pick_up" class="col-sm-2 col-form-label">Puerto / Almacen</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('pick_up') is-invalid @enderror" id="pick_up"
                                name="pick_up" placeholder="Ingrese la direccion de recojo" @readonly(true)
                                value="{{ isset($quote->pick_up) ? $quote->pick_up : old('pick_up') }}">
                            @error('pick_up')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="delivery" class="col-sm-2 col-form-label">Direccion de entrega</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('delivery') is-invalid @enderror"
                                id="delivery" name="delivery" placeholder="Ingrese la direccion de entrega"
                                @readonly(true)
                                value="{{ isset($quote->delivery) ? $quote->delivery : old('delivery') }}">
                            @error('delivery')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $quote->lcl_fcl === 'FCL' ? '' : 'd-none' }}">
                        <label for="container_return" class="col-sm-2 col-form-label">Devolucion de contenedor</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('container_return') is-invalid @enderror"
                                id="container_return" name="container_return"
                                placeholder="Ingrese donde se hara la devolucion" @readonly(true)
                                value="{{ isset($quote->container_return) ? $quote->container_return : old('container_return') }}">

                            @error('container_return')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="contact_name" class="col-sm-2 col-form-label">Nombre del contacto</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('contact_name') is-invalid @enderror"
                                id="contact_name" name="contact_name" placeholder="Ingresa el nombre del contacto"
                                @readonly(true)
                                value="{{ isset($quote->contact_name) ? $quote->contact_name : old('contact_name') }}">
                        </div>
                        @error('contact_name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="contact_phone" class="col-sm-2 col-form-label">Telefono del contacto</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('contact_phone') is-invalid @enderror"
                                id="contact_phone" name="contact_phone"
                                placeholder="Ingresa el numero de celular del contacto" @readonly(true)
                                value="{{ isset($quote->contact_phone) ? $quote->contact_phone : old('contact_phone') }}">
                        </div>
                        @error('contact_phone')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="max_attention_hour" class="col-sm-2 col-form-label">Hora maxima de entrega</label>
                        @php
                            $config = ['format' => 'LT'];
                        @endphp
                        <x-adminlte-input-date name="max_attention_hour" :config="$config" disabled
                            placeholder="Ingrese la hora maxima de entrega"
                            value="{{ isset($quote->max_attention_hour) ? $quote->max_attention_hour : old('max_attention_hour') }}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-indigo">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-date>

                    </div>
                    <div class="form-group row">
                        <label for="gang" class="col-sm-2 col-form-label">Cuadrilla</label>
                        <div class="col-sm-10">
                            <div class="form-check d-inline">
                                <input type="radio" id="radioLclFcl" name="gang" value="SI"
                                    class="form-check-input @error('gang') is-invalid @enderror"
                                    {{ $quote->gang === 'SI' ? 'checked ' : 'disabled' }}>
                                <label for="radioLclFcl" class="form-check-label">
                                    SI
                                </label>
                            </div>
                            <div class="form-check d-inline">
                                <input type="radio" id="radioLclFcl" name="gang" value="NO"
                                    class="form-check-input @error('gang') is-invalid @enderror"
                                    {{ $quote->gang === 'NO' ? 'checked' : 'disabled' }}>
                                <label for="radioLclFcl" class="form-check-label">
                                    NO
                                </label>
                            </div>

                            @error('gang')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                    </div>
                    <div class="form-group row  {{ $quote->lcl_fcl === 'FCL' ? '' : 'd-none' }}">
                        <label for="guard" class="col-sm-2 col-form-label">Resguardo</label>
                        <div class="col-sm-10">
                            <div class="form-check d-inline">
                                <input type="radio" id="radioGuard" name="guard" value="SI"
                                    class="form-check-input @error('guard') is-invalid @enderror"
                                    {{ $quote->guard === 'SI' ? 'checked' : 'disabled' }}>
                                <label for="radioGuard" class="form-check-label">
                                    SI
                                </label>
                            </div>
                            <div class="form-check d-inline">
                                <input type="radio" id="radioGuard" name="guard" value="NO"
                                    class="form-check-input @error('guard') is-invalid @enderror"
                                    {{ $quote->guard === 'NO' ? 'checked' : 'disabled' }}>
                                <label for="radioGuard" class="form-check-label">
                                    NO
                                </label>
                            </div>

                            @error('guard')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="customer_detail" class="col-sm-2 col-form-label">Detalles</label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('customer_detail') is-invalid @enderror" id="customer_detail"
                                name="customer_detail" placeholder="Ingresa un detalle o alguna observacion" @readonly(true)>{{ isset($quote->customer_detail) ? $quote->customer_detail : '' }}</textarea>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-12">

                <div class="head-quote mb-2">
                    <h5 id="title_quote" class="text-center text-uppercase bg-indigo p-2">Detalle de carga <span></span>
                    </h5>
                </div>
                <div class="body-detail-product p-2">
                    <div class="form-group row">
                        <label for="load_type" class="col-sm-2 col-form-label">Tipo de Carga</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('load_type') is-invalid @enderror"
                                id="load_type" name="load_type" placeholder="Ingrese el tipo de carga" @readonly(true)
                                value="{{ isset($quote->load_type) ? $quote->load_type : old('load_type') }}">
                        </div>
                        @error('load_type')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="commodity" class="col-sm-2 col-form-label">Descripcion</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('commodity') is-invalid @enderror"
                                id="commodity" name="commodity" placeholder="Ingrese descripcion del producto"
                                @readonly(true)
                                value="{{ isset($quote->commodity) ? $quote->commodity : old('commodity') }}">
                        </div>
                        @error('commodity')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group row  {{ $quote->lcl_fcl === 'FCL' ? '' : 'd-none' }}">
                        <label for="container_type" class="col-sm-2 col-form-label">Tipo de contenedor</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('container_type') is-invalid @enderror"
                                id="container_type" name="container_type" placeholder="Ingrese el tipo de contenedor"
                                @readonly(true)
                                value="{{ isset($quote->container_type) ? $quote->container_type : old('container_type') }}">


                            @error('container_type')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                    </div>
                    <div class="form-group row  {{ $quote->lcl_fcl === 'FCL' ? '' : 'd-none' }}">
                        <label for="ton_kilogram" class="col-sm-2 col-form-label">Toneladas / KG</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('ton_kilogram') is-invalid @enderror"
                                id="ton_kilogram" name="ton_kilogram" placeholder="Ingrese el preso de carga"
                                @readonly(true)
                                value="{{ isset($quote->ton_kilogram) ? $quote->ton_kilogram : old('ton_kilogram') }}">

                            @error('ton_kilogram')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="packaging_type" class="col-sm-2 col-form-label">Tipo de embalaje</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('packaging_type') is-invalid @enderror"
                                id="packaging_type" name="packaging_type" placeholder="Ingrese el tipo de embalaje"
                                @readonly(true)
                                value="{{ isset($quote->packaging_type) ? $quote->packaging_type : old('packaging_type') }}">
                        </div>
                        @error('packaging_type')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group row {{ $quote->lcl_fcl === 'LCL' ? '' : 'd-none' }}">
                        <label for="stackable" class="col-sm-2 col-form-label">Apilable</label>
                        <div class="col-sm-10">
                            <div class="form-check d-inline">
                                <input type="radio" id="radioStackable" name="stackable" value="SI"
                                    class="form-check-input @error('stackable') is-invalid @enderror"
                                    {{ $quote->stackable === 'SI' ? 'checked' : 'disabled' }}>
                                <label for="radioStackable" class="form-check-label">
                                    SI
                                </label>
                            </div>
                            <div class="form-check d-inline">
                                <input type="radio" id="radioStackable" name="stackable" value="NO"
                                    class="form-check-input  @error('stackable') is-invalid @enderror"
                                    {{ $quote->stackable === 'NO' ? 'checked' : 'disabled' }}>
                                <label for="radioStackable" class="form-check-label">
                                    NO
                                </label>
                            </div>
                            @error('stackable')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                    </div>
                    <div class="form-group row {{ $quote->lcl_fcl === 'LCL' ? '' : 'd-none' }}">
                        <label for="cubage_kgv" class="col-sm-2 col-form-label">Cubicaje/KGV</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('cubage_kgv') is-invalid @enderror"
                                id="cubage_kgv" name="cubage_kgv" placeholder="Ingresa el cubicaje / kgv"
                                @readonly(true)
                                value="{{ isset($quote->cubage_kgv) ? $quote->cubage_kgv : old('cubage_kgv') }}">
                            @error('cubage_kgv')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row {{ $quote->lcl_fcl === 'LCL' ? '' : 'd-none' }}">
                        <label for="total_weight" class="col-sm-2 col-form-label">Peso total</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('total_weight') is-invalid @enderror"
                                id="total_weight" name="total_weight"
                                placeholder="Ingresa la hora maxima de recojo del cliente" @readonly(true)
                                value="{{ isset($quote->total_weight) ? $quote->total_weight : old('total_weight') }}">
                        </div>
                        @error('total_weight')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="packages" class="col-sm-2 col-form-label">Bultos</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('packages') is-invalid @enderror"
                                id="packages" name="packages" placeholder="Ingresa el valor de los bultos"
                                @readonly(true)
                                value="{{ isset($quote->packages) ? $quote->packages : old('packages') }}">
                        </div>
                        @error('packages')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <label for="cargo_detail" class="col-sm-2 col-form-label">Detalles</label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('cargo_detail') is-invalid @enderror" id="cargo_detail" name="cargo_detail"
                                placeholder="Ingresa un detalle o alguna observacion" @readonly(true)> {{ isset($quote->cargo_detail) ? $quote->cargo_detail : '' }}</textarea>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-12">

                <div class="head-quote mb-2">
                    <h5 class="text-center text-uppercase bg-indigo p-2">Medidas</h5>
                </div>
                <div class="body-detail-product p-2">

                    <table id="table_measures" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Cantidad</th>
                                <th>Ancho (cm)</th>
                                <th>Largo (cm)</th>
                                <th>Alto (cm)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (json_decode($quote->measures) as $measure)
                                <td>{{ $measure->amount }}</td>
                                <td>{{ $measure->height }}</td>
                                <td>{{ $measure->length }}</td>
                                <td>{{ $measure->width }}</td>
                            @endforeach
                        </tbody>

                    </table>

                    <input type="hidden" id="measures" name="measures">
                    <input type="hidden" id="nro_operation" name="nro_operation"
                        value="{{ isset($quote->nro_operation) ? $quote->nro_operation : old('nro_operation') }}">
                    <input type="hidden" id="lcl_fcl" name="lcl_fcl">

                </div>

            </div>


        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modalQuoteResponse" tabindex="-1" aria-labelledby="modalQuoteResponseLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action={{ url('/quote/transport/cost/' . $quote->id) }} id="sendTransportCost" method="POST"
                    enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalQuoteResponseLabel">PRECIO DE FLETE DE TRANSPORTE</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="pounds" class="col-sm-4 col-form-label">Costo transporte: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control CurrencyInput" data-type="currency"
                                    name="modal_transport_cost" id="modal_transport_cost"
                                    placeholder="Ingrese costo de flete de transporte..">
                            </div>
                        </div>
                        <div id="container_gang"
                            class="form-group row {{ isset($quote->gang) && $quote->gang === 'SI' ? '' : 'd-none' }}">
                            <label for="pounds" class="col-sm-4 col-form-label">Costo de Cuadrilla: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control CurrencyInput" data-type="currency"
                                    name="cost_gang" id="cost_gang" placeholder="Ingrese costo de cuadrilla..">
                            </div>
                        </div>
                        <div id="container_guard"
                            class="form-group row {{ isset($quote->guard) && $quote->guard === 'SI' ? '' : 'd-none' }}">
                            <label for="pounds" class="col-sm-4 col-form-label">Costo de Resguardo: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control CurrencyInput" data-type="currency"
                                    name="cost_guard" id="cost_guard" placeholder="Ingrese costo de resguardo..">
                            </div>
                        </div>

                        <span id="error_transport_cost" class="invalid-feedback d-none" role="alert">
                            <strong id="texto_transport_cost"></strong>
                        </span>

                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-primary">Enviar costo</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalQuoteReajust" tabindex="-1" aria-labelledby="modalQuoteReajustLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action={{ url('/quote/transport/cost/responsereajust/' . $quote->id) }} id="sendTransportReajust"
                    method="POST" enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalQuoteReajustLabel">REAJUSTE DE PRECIO DE FLETE DE TRANSPORTE</h5>
                    </div>
                    <div class="modal-body">

                        <div class="form-group row">
                            <label for="pounds" class="col-sm-4 col-form-label">Observacion : </label>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" name="readjustment_reason" id="readjustment_reason"
                                    @readonly(true)>{{ isset($quote->readjustment_reason) ? $quote->readjustment_reason : '' }}</textarea>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pounds" class="col-sm-4 col-form-label">Costo de transporte: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control CurrencyInput" data-type="currency"
                                    name="modal_transport_readjustment_cost" id="modal_transport_readjustment_cost"
                                    placeholder="Ingrese costo de flete de transporte.."
                                    value="{{ isset($quote->cost_transport) ? $quote->cost_transport : '' }}">

                                {{-- Costo antiguo --}}
                                <input type="hidden" id="modal_transport_old_cost" name="modal_transport_old_cost"
                                    value="{{ isset($quote->cost_transport) ? $quote->cost_transport : '' }}">
                            </div>
                        </div>
                        <div
                            class="form-group row {{ isset($quote->cost_gang) && $quote->cost_gang != null ? '' : 'd-none' }}">
                            <label for="pounds" class="col-sm-4 col-form-label">Costo de cuadrilla: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control CurrencyInput" data-type="currency"
                                    name="modal_gang_cost" id="modal_gang_cost"
                                    placeholder="Ingrese costo de flete de transporte.."
                                    value="{{ isset($quote->cost_gang) ? $quote->cost_gang : '' }}">

                                {{-- Costo antiguo --}}
                                <input type="hidden" id="modal_gang_old_cost" name="modal_gang_old_cost"
                                    value="{{ isset($quote->cost_gang) ? $quote->cost_gang : '' }}">
                            </div>
                        </div>
                        <div
                            class="form-group row {{ isset($quote->cost_guard) && $quote->cost_guard != null ? '' : 'd-none' }}">
                            <label for="pounds" class="col-sm-4 col-form-label">Costo de resguardo: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control CurrencyInput" data-type="currency"
                                    name="modal_guard_cost" id="modal_guard_cost"
                                    placeholder="Ingrese costo de flete de transporte.."
                                    value="{{ isset($quote->cost_guard) ? $quote->cost_guard : '' }}">

                                <input type="hidden" id="modal_guard_old_cost" name="modal_guard_old_cost"
                                    value="{{ isset($quote->cost_guard) ? $quote->cost_guard : '' }}">
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <label for="pounds" class="col-sm-4 col-form-label">Costo reajustado: </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control CurrencyInput" data-type="currency"
                                    name="modal_transport_readjustment_cost" id="modal_transport_readjustment_cost"
                                    placeholder="Ingrese costo de flete de transporte..">

                                <span id="required_reajust_transport_cost" class="invalid-feedback d-none"
                                    role="alert">
                                    <strong id="texto_reajust_transport_cost">Complete el campo de costo de
                                        reajuste</strong>
                                </span>

                                <span id="value_reajust_transport_cost" class="invalid-feedback d-none" role="alert">
                                    <strong id="texto_reajust_transport_cost">El costo de reajuste no puede ser mayor o
                                        igual que el costo actual</strong>
                                </span>

                            </div>

                        </div> --}}



                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-primary">Enviar costo</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalQuoteObservation" tabindex="-1" aria-labelledby="modalQuoteObservationLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action={{ url('/quote/transport/cost/observation/' . $quote->id) }} id="sendTransportObservation"
                    method="POST" enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalQuoteObservationLabel">Observaciones de cotización
                        </h5>
                    </div>
                    <div class="modal-body">


                        <div class="form-group row flex-column">
                            <label for="obse" class="col-sm-6 col-form-label">Observacion :</label>
                            <div class="col-sm-12">
                                <textarea type="text" class="form-control" name="observations" id="observations" rows="5"></textarea>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-primary">Enviar observaciones</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalQuoteObservationMessage" tabindex="-1"
        aria-labelledby="modalQuoteObservationMessage" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action={{ url('/quote/transport/cost/observation/' . $quote->id) }} id="sendTransportObservation"
                    method="POST" enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalQuoteObservationMessage">Observaciones de cotización
                        </h5>
                    </div>
                    <div class="modal-body">


                        <div class="form-group row flex-column">
                            <label for="obse" class="col-sm-6 col-form-label">Observacion :</label>
                            <div class="col-sm-12">
                                <textarea type="text" class="form-control" name="observations" id="observations" rows="5"
                                    @readonly(true)>{{ $quote->observations }}</textarea>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@stop

@push('scripts')
    <script>
        $('#sendTransportCost').on('submit', (e) => {

            e.preventDefault();

            const containerGangVisibility = !$('#container_gang').hasClass('d-none');
            const containerGuardVisibility = !$('#container_guard').hasClass('d-none');


            const transport_cost = $('#modal_transport_cost').val().trim();

            if (transport_cost === '') {

                $('#modal_transport_cost').addClass('is-invalid');
                $('#error_transport_cost').removeClass('d-block').addClass('d-none');

                return;

            } else {
                $('#modal_transport_cost').removeClass('is-invalid');
            }

            if (containerGangVisibility) {
                if ($('#container_gang').find('input').val().trim() === '') {
                    $('#container_gang').find('input').addClass('is-invalid');

                    return;
                } else {
                    $('#container_gang').find('input').removeClass('is-invalid');
                }
            }

            if (containerGuardVisibility) {
                if ($('#container_guard').find('input').val().trim() === '') {
                    $('#container_guard').find('input').addClass('is-invalid');

                    return;
                } else {
                    $('#container_guard').find('input').removeClass('is-invalid');
                }
            }


            e.target.submit();


        });


        $('#sendTransportReajust').on('submit', (e) => {

            e.preventDefault();


            let isValid = true; // Bandera para comprobar si el formulario es válido
            const form = event.target; // El formulario actual
            const inputs = form.querySelectorAll(
                'input:not([type="hidden"]), textarea'); // Selecciona inputs excepto los de tipo hidden y textareas

            inputs.forEach((input) => {
                // Ignorar campos ocultos (d-none)
                if (input.closest('.d-none')) {
                    return;
                }

                // Validar si el campo está vacío
                if (input.value.trim() === '') {
                    input.classList.add('is-invalid');
                    isValid = false; // Cambiar bandera si algún campo no es válido
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            // Comparar costos de transporte
            const transportCost = parseFloat(document.getElementById('modal_transport_readjustment_cost').value.replace(/,/g,
                '')) || 0;
            const transportOldCost = parseFloat(document.getElementById('modal_transport_old_cost').value.replace(
                /,/g, '')) || 0;

            if (transportCost > transportOldCost) {
                isValid = false;
                const input = document.getElementById('modal_transport_readjustment_cost');
                input.classList.add('is-invalid');
                showError(input, 'El costo de transporte no puede ser mayor que el costo actual.');
            } else {
                hideError(document.getElementById('modal_transport_readjustment_cost'));
            }

            // Comparar costos de gang
            const gangInput = document.getElementById('modal_gang_cost');
            if (gangInput && !gangInput.closest('.d-none')) {
                const gangCost = parseFloat(gangInput.value.replace(/,/g, '')) || 0;
                const gangOldCost = parseFloat(document.getElementById('modal_gang_old_cost').value.replace(/,/g,
                    '')) || 0;

                if (gangCost > gangOldCost) {
                    isValid = false;
                    gangInput.classList.add('is-invalid');
                    console.log("El precio es mayor que el antiguo");
                    showError(gangInput, 'El costo de cuadrilla no puede ser mayor que el costo actual.');
                } else {
                    hideError(gangInput);
                }
            }

            // Comparar costos de guard
            const guardInput = document.getElementById('modal_guard_cost');
            if (guardInput && !guardInput.closest('.d-none')) {
                const guardCost = parseFloat(guardInput.value.replace(/,/g, '')) || 0;
                const guardOldCost = parseFloat(document.getElementById('modal_guard_old_cost').value.replace(/,/g,
                    '')) || 0;

                if (guardCost > guardOldCost) {
                    isValid = false;
                    guardInput.classList.add('is-invalid');
                    showError(guardInput, 'El costo de resguardo no puede ser mayor que el costo actual.');
                } else {
                    hideError(guardInput);
                }
            }

            // Si todo es válido, enviar el formulario
            if (isValid) {
                form.submit();
            }


        });


        // Mostrar mensaje de error
        function showError(input, message) {
            let errorSpan = input.nextElementSibling;
            if (!errorSpan || !errorSpan.classList.contains('invalid-feedback')) {
                errorSpan = document.createElement('span');
                errorSpan.classList.add('invalid-feedback');
                input.after(errorSpan);
            }
            errorSpan.textContent = message;
            errorSpan.style.display = 'block';
        }


        // Ocultar mensaje de error
        function hideError(input) {
            let errorSpan = input.nextElementSibling;
            if (errorSpan && errorSpan.classList.contains('invalid-feedback')) {
                errorSpan.style.display = 'none';
            }
        }


        $('#sendTransportObservation').on('submit', (e) => {

            e.preventDefault();

            let observations = $('#observations').val().trim();


            if (observations === "") {
                $('#observations').addClass('is-invalid');
            } else {
                $('#modal_transport_readjustment_cost').removeClass('is-invalid');
                e.target.submit();
            }



        });
    </script>

    @if ($quote->observations)
        <script>
            $('#modalQuoteObservationMessage').modal('show');
        </script>
    @endif
@endpush
