@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra un Flete</h2>
        <div>
            <a href="{{ url('/quote/freight') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')


    @if ($acceptedResponse)
        <div class="row">
            <div class="col-12">
                <div class="accordion bg-indigo" id="accordionAcceptedResponse">
                    <div class="card mt-2 bg-indigo">
                        <div class="card-header p-2" id="headingAcceptedResponse">
                            <h6 class=" mb-0 d-flex justify-content-between align-items-center">
                                <span class="text-uppercase">
                                    Resumen de Respuesta Aceptada: {{ $acceptedResponse->nro_response }}
                                </span>
                                <button class="text-white btn btn-link p-0" type="button" data-toggle="collapse"
                                    data-target="#collapseAcceptedResponse" aria-expanded="true"
                                    aria-controls="collapseAcceptedResponse">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </h6>
                        </div>

                        <div id="collapseAcceptedResponse" class="collapse" aria-labelledby="headingAcceptedResponse"
                            data-parent="#accordionAcceptedResponse">
                            <div class="card-body ">
                                <div class="row text-sm text-muted text-white">
                                    <div class="col-md-4">
                                        <p class="mb-1">Proveedor:
                                            <strong
                                                class="d-block">{{ $acceptedResponse->supplier->name_businessname ?? '-' }}</strong>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1">Validez:
                                            <strong
                                                class="d-block">{{ $acceptedResponse->validity_date_formatted ?? '-' }}</strong>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1">Servicio:
                                            <strong class="d-block">{{ $acceptedResponse->service ?? '-' }}</strong>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1">Frecuencia:
                                            <strong class="d-block">{{ $acceptedResponse->frequency ?? '-' }}</strong>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1">Tiempo en tránsito:
                                            <strong class="d-block">{{ $acceptedResponse->transit_time ?? '-' }}</strong>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1">Tipo de cambio:
                                            <strong class="d-block">{{ $acceptedResponse->exchange_rate ?? '-' }}</strong>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="mb-1">Total respuesta:
                                            <strong class="d-block text-warning">$
                                                {{ number_format($acceptedResponse->total, 2) }}</strong>
                                        </p>
                                    </div>
                                </div>

                                <hr class="my-2">

                                <p class="mb-0 text-sm text-muted text-white">
                                    Para crear el flete, asegúrese de que el <strong class="text-warning">total de los
                                        conceptos agregados</strong> supere este total de respuesta.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <form action="/freight" method="post" id="formFreight" enctype="multipart/form-data">
        @csrf
        @include ('freight.form-freight', ['formMode' => 'create'])
    </form>


@stop
