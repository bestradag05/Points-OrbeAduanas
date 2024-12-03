@extends('home')
@section('dinamic-content')
    <div class="d-flex justify-content-center">
        <h3 class="text-bold">Detalle de cotizacion para Nro de operacion : <span
                class="text-indigo">{{ $quote->nro_operation }}</span> </h3>
    </div>
    <div class="container">

        <div class="row">
            <div class="col-12 my-5 text-center">
                <button class="btn btn-indigo mx-2" data-toggle="modal" data-target="#modalQuoteResponse"> <i
                        class="fa-regular fa-check-double"></i> Dar respuesta</button>
                <button class="btn btn-secondary mx-2"><i class="fa-sharp-duotone fa-regular fa-xmark"></i> Dar
                    observaciones</button>
            </div>
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
                                value="{{ isset($quote->routing->customer) ? $quote->routing->customer->name_businessname : old('customer') }}">
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
                        <input type="text" class="form-control CurrencyInput" data-type="currency"
                            name="modal_transport_cost" id="modal_transport_cost"
                            placeholder="Ingrese costo de flete de transporte..">

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


@stop

@push('scripts')
    <script>
        $('#sendTransportCost').on('submit', (e) => {

            e.preventDefault();

            const transport_cost = $('#modal_transport_cost').val().trim();

            if (transport_cost === '') {

                $('#modal_transport_cost').addClass('is-invalid');
                $('#error_transport_cost').removeClass('d-block').addClass('d-none');

            } else {
                $('#modal_transport_cost').removeClass('is-invalid');

                e.target.submit();
            }

        });
    </script>
@endpush
