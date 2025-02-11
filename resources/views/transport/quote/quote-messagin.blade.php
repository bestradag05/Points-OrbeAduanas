@extends('home')


@section('dinamic-content')

    <div class="row">

        {{-- <div class="col-12  mb-4 text-right">
            <a href="{{ url('/quote/freight') }}" class="btn btn-primary"> Atras </a>
        </div> --}}
        <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
            <div class="card direct-chat direct-chat-primary h-100">
                <div class="card-header bg-sisorbe-100 py-2">
                    <h5 class="text-center text-bold text-uppercase text-indigo">Cotizacion : {{ $quote->nro_quote }}</h5>
                </div>
                <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                    <div class="direct-chat-messages h-100">
                        @foreach ($messages as $message)
                            <div class="direct-chat-msg {{ $message->sender_id != auth()->user()->id ? 'right' : '' }}">
                                <div class="direct-chat-infos clearfix">
                                    <span
                                        class="direct-chat-name float-left text-indigo text-bold">{{ $message->sender->personal->names }}</span>
                                    <span
                                        class="direct-chat-timestamp float-right text-bold">{{ $message->created_at }}</span>
                                </div>
                                @if ($message->sender->personal->img_url !== null)
                                    <img src="{{ asset('storage/' . $message->sender->personal->img_url) }}"
                                        class="direct-chat-img" alt="User Image">
                                @else
                                    <img src="{{ asset('storage/personals/user_default.png') }}" class="direct-chat-img"
                                        alt="User Image">
                                @endif
                                <div class="direct-chat-text">
                                    {!! $message->message !!}
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="card-footer">
                    <form action="/quote/transport/message" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <textarea id="quote-text" name="message"></textarea>
                                <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                            </div>
                            <div class="col-12 row align-items-center justify-content-center mt-2">
                                <button type="submit" {{ $quote->state === 'Aceptada' ? 'disabled' : '' }}
                                    class="btn btn-indigo">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2 px-4">
            <h5 class="text-indigo text-center"><i class="fas fa-file-alt"></i> Detalle de carga</h5>

            <br>
            <div class="">
                <p class="text-sm">N° Cotizacion General :
                    <b class="d-block">{{ $quote->nro_quote_commercial }}</b>
                </p>
            </div>

            <div class="row text-muted">
                <div class="col-6">
                    <p class="text-sm">N° Cotizacion :
                        <b class="d-block">{{ $quote->nro_quote }}</b>
                    </p>
                </div>
                {{-- <div class="col-6">
                    <p class="text-sm">Cliente :
                        <b class="d-block">{{ $quote->routing->customer->name_businessname }}</b>
                    </p>
                </div> --}}
                <div class="col-6">
                    <p class="text-sm">Cliente :
                        <b class="d-block">{{ $quote->commercial_quote->customer_company_name }}</b>
                    </p>
                </div>
            </div>
            <div class="row text-muted">
                <div class="col-6">
                    <p class="text-sm">Origen :
                        <b class="d-block">{{ $quote->pick_up }}</b>
                    </p>
                </div>
                <div class="col-6">
                    <p class="text-sm">Destino :
                        <b class="d-block">{{ $quote->delivery }}</b>
                    </p>
                </div>
            </div>
            <div class="row text-muted">
                {{--  <div class="col-6">
                    <p class="text-sm">Tipo de embarque :
                        <b class="d-block">{{ $quote->routing->type_shipment->description }}
                            {{ $quote->routing->lcl_fcl != null ? '(' . $quote->routing->lcl_fcl . ')' : '' }}</b>
                    </p>
                </div> --}}
                <div class="col-6">
                    <p class="text-sm">Tipo de embarque :
                        <b class="d-block">{{ $quote->commercial_quote->type_shipment->description }}
                            {{ $quote->commercial_quote->lcl_fcl != null ? '(' . $quote->commercial_quote->lcl_fcl . ')' : '' }}</b>
                    </p>
                </div>
                <div class="col-6">
                    <p class="text-sm">Tipo de carga :
                        <b class="d-block">{{ $quote->load_type }}</b>
                    </p>
                </div>
            </div>
            <div class="row text-muted">
                <div class="col-6">
                    <p class="text-sm">Descripcion :
                        <b class="d-block">{{ $quote->commodity }}</b>
                    </p>
                </div>
                <div class="col-6">
                    <p class="text-sm">Tipo de embalaje :
                        <b class="d-block">{{ $quote->packaging_type }}</b>
                    </p>
                </div>
            </div>
            {{--  @if ($quote->routing->lcl_fcl === 'LCL' || $quote->routing->lcl_fcl === null)
                <div class="row text-muted">
                    <div class="col-6">
                        <p class="text-sm">Cubicaje/KGV :
                            <b class="d-block">{{ $quote->cubage_kgv }}</b>
                        </p>
                    </div>
                    <div class="col-6">
                        <p class="text-sm">Peso total :
                            <b class="d-block">{{ $quote->total_weight }}</b>
                        </p>
                    </div>
                </div>
            @else
                <div class="row text-muted">
                    <div class="col-6">
                        <p class="text-sm">Tipo de contenedor :
                            <b class="d-block">{{ $quote->container_type }}</b>
                        </p>
                    </div>
                    <div class="col-6">
                        <p class="text-sm">Toneladas/Kilogramos :
                            <b class="d-block">{{ $quote->ton_kilogram }}</b>
                        </p>
                    </div>
                </div>
            @endif --}}

            @if ($quote->commercial_quote->lcl_fcl === 'LCL' || $quote->commercial_quote->lcl_fcl === null)
                <div class="row text-muted">
                    <div class="col-6">
                        <p class="text-sm">Cubicaje/KGV :
                            <b class="d-block">{{ $quote->cubage_kgv }}</b>
                        </p>
                    </div>
                    <div class="col-6">
                        <p class="text-sm">Peso total :
                            <b class="d-block">{{ $quote->total_weight }}</b>
                        </p>
                    </div>
                </div>
                <div class="row text-muted">
                    <div class="col-6">
                        <p class="text-sm">Cuadrilla :
                            <b class="d-block">{{ $quote->gang }}</b>
                        </p>
                    </div>
                    <div class="col-6">
                        <p class="text-sm">Apilable :
                            <b class="d-block">{{ $quote->stackable }}</b>
                        </p>
                    </div>
                </div>
            @else
                <div class="row text-muted">
                    <div class="col-6">
                        <p class="text-sm">Tipo de contenedor :
                            <b class="d-block">{{ $quote->container_type }}</b>
                        </p>
                    </div>
                    <div class="col-6">
                        <p class="text-sm">Toneladas/Kilogramos :
                            <b class="d-block">{{ $quote->ton_kilogram }}</b>
                        </p>
                    </div>
                </div>

                <div class="row text-muted">
                    <div class="col-6">
                        <p class="text-sm">Cuadrilla :
                            <b class="d-block">{{ $quote->gang }}</b>
                        </p>
                    </div>
                    <div class="col-6">
                        <p class="text-sm">Resguardo :
                            <b class="d-block">{{ $quote->guard }}</b>
                        </p>
                    </div>
                </div>
            @endif



            <div class="row text-muted mt-3">
                <div class="col-6">
                    <p class="text-uppercase ">Estado :
                        <b class="status-{{ strtolower($quote->state) }}">{{ $quote->state }}</b>
                        <b class="status-{{ strtolower($quote->state) }}"><i class="fas fa-circle"></i></b>

                    </p>
                </div>

            </div>

            <hr>
            <h5 class="mt-3 text-muted">Archivos :</h5>
            <ul class="list-unstyled">
                @foreach ($files as $file)
                    <li>
                        <a href="{{ $file['url'] }}" target="_blank" class="btn-link text-secondary"><i
                                class="far fa-fw fa-file-pdf"></i> {{ $file['name'] }}</a>
                    </li>
                @endforeach
            </ul>

            <hr>
            @if ($quote->ocean_freight != null && $quote->state === 'Aceptada')
                <div class="row">

                    <div class="col-12">
                        <h6 class="text-indigo text-center mb-3 text-bold"><i class="fas fa-dollar-sign"></i> Detalle de
                            costos
                        </h6>
                    </div>

                    <div class="col-12 ml-4">

                        <div class="row text-muted">
                            <div class="col-4">
                                <p class="text-sm">Flete :
                                </p>
                            </div>
                            <div class="col-6">
                                <b class="d-inline">$ {{ $quote->ocean_freight }}</b>
                            </div>

                        </div>
                        <div class="row text-muted">
                            <div class="col-4">
                                <p class="text-sm"> Orbe (utilidad) :
                                </p>
                            </div>
                            <div class="col-6">
                                <b class="d-inline">$ {{ $quote->utility }}</b>
                            </div>

                        </div>
                        <div class="row text-muted">
                            <div class="col-4">
                                <p class="text-sm">Operaciones :
                                </p>
                            </div>
                            <div class="col-6">
                                <b class="d-inline">$ {{ $quote->operations_commission }}</b>
                            </div>

                        </div>
                        <div class="row text-muted">
                            <div class="col-4">
                                <p class="text-sm">Pricing :
                                </p>
                            </div>
                            <div class="col-6">
                                <b class="d-inline">$ {{ $quote->pricing_commission }}</b>
                            </div>

                        </div>

                        <div class="row text-muted mt-3 ">
                            <div class="col-12 row justify-content-center">
                                <p class="text-uppercase text-bold text-lg">Costo del Flete :
                                    <b class="status-{{ strtolower($quote->state) }}">$
                                        {{ $quote->total_ocean_freight }}</b>
                                </p>
                            </div>

                        </div>


                    </div>


                </div>
            @endif


            <div class="text-center mt-5 mb-3">
                <a href="{{ url('/quote/freight/sendQuote/' . $quote->id) }}"
                    class="btn btn-sm btn-indigo {{ $quote->state != 'Borrador' ? 'd-none' : '' }}">Enviar Cotización</a>
                <a href="{{ url('/quote/freight/message/' . $quote->id . '/edit') }}"
                    class="btn btn-sm btn-secondary {{ $quote->state != 'Borrador' ? 'd-none' : '' }}">Editar
                    Cotización</a>
                <button
                    class="btn btn-sm btn-success {{ $quote->state === 'Borrador' || $quote->state === 'Aceptada' ? 'd-none' : '' }}"
                    type="button" data-toggle="modal" data-target="#quote-transport">Cotización Aceptada</button>

                @if (!$quote->transport()->exists())
                    <a href="{{ url('/transport/create/' . $quote->id) }}"
                        class="btn btn-sm btn-indigo {{ $quote->state === 'Aceptada' ? '' : 'd-none' }}">Generar Transporte</a>
                @endif
            </div>
        </div>
    </div>


    <div id="quote-transport" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="quote-transport-title"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action={{ url('/quote/transport/cost/accept/' . $quote->id) }} id="sendTransportCost"
                    method="POST">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title" id="quote-transport-title">{{ $quote->nro_quote }}</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="cost_transport">Transporte</label>
                            <input id="cost_transport" data-type="currency" class="form-control CurrencyInput" type="text"
                                name="cost_transport">
                        </div>
                        @if ($quote->gang && $quote->gang === 'SI')
                            <div class="form-group">
                                <label for="cost_gang">Cuadrilla</label>
                                <input id="cost_gang" data-type="currency" class="form-control CurrencyInput"
                                    type="text" name="cost_gang">
                            </div>
                        @endif
                        @if ($quote->guard && $quote->guard === 'SI')
                            <div class="form-group">
                                <label for="cost_guard">Resguardo</label>
                                <input id="cost_guard" data-type="currency" class="form-control CurrencyInput"
                                    type="text" name="cost_guard">
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="cost_transport">Fecha de retiro</label>
                            <input type="date" class="form-control" id="withdrawal_date" name="withdrawal_date"
                                    placeholder="Ingrese el destino">
                        </div>

                       
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Cerrar Cotización</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop


@push('scripts')
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#quote-text').summernote();
        });


        $('#sendTransportCost').on('submit', (e) => {

            e.preventDefault();

            let isValid = true; // Bandera para comprobar si el formulario es válido
            let form = e.target;
            const inputs = form.querySelectorAll('input');


            inputs.forEach((input) => {
                // Ignorar campos ocultos (d-none)
                if (input.closest('.d-none')) {
                    return;
                }

                // Validar si el campo está vacío
                if (input.value.trim() === '') {
                    input.classList.add('is-invalid');
                    isValid = false; // Cambiar bandera si algún campo no es válido
                    showError(input, 'Debe completar este campo');
                } else {
                    input.classList.remove('is-invalid');
                    hideError(input);
                }
            });


            if (isValid) {
                form.submit();
            }

        })



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
    </script>
@endpush
