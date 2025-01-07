@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Detalle de cotizaciónn</h2>
        <div>
            <a href="{{ url('/quote') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')

    <div class="row">
        <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
            <div class="row">
                <div class="col-12 col-sm-4">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">Estimated budget</span>
                            <span class="info-box-number text-center text-muted mb-0">2300</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">Total amount spent</span>
                            <span class="info-box-number text-center text-muted mb-0">2000</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">Estimated project duration</span>
                            <span class="info-box-number text-center text-muted mb-0">20</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h4>Recent Activity</h4>
                    <div class="post">
                        <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
                            <span class="username">
                                <a href="#">Jonathan Burke Jr.</a>
                            </span>
                            <span class="description">Shared publicly - 7:45 PM today</span>
                        </div>
                        <!-- /.user-block -->
                        <p>
                            Lorem ipsum represents a long-held tradition for designers,
                            typographers and the like. Some people hate it and argue for
                            its demise, but others ignore.
                        </p>

                        <p>
                            <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 1 v2</a>
                        </p>
                    </div>

                    <div class="post clearfix">
                        <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg" alt="User Image">
                            <span class="username">
                                <a href="#">Sarah Ross</a>
                            </span>
                            <span class="description">Sent you a message - 3 days ago</span>
                        </div>
                        <!-- /.user-block -->
                        <p>
                            Lorem ipsum represents a long-held tradition for designers,
                            typographers and the like. Some people hate it and argue for
                            its demise, but others ignore.
                        </p>
                        <p>
                            <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 2</a>
                        </p>
                    </div>

                    <div class="post">
                        <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
                            <span class="username">
                                <a href="#">Jonathan Burke Jr.</a>
                            </span>
                            <span class="description">Shared publicly - 5 days ago</span>
                        </div>
                        <!-- /.user-block -->
                        <p>
                            Lorem ipsum represents a long-held tradition for designers,
                            typographers and the like. Some people hate it and argue for
                            its demise, but others ignore.
                        </p>

                        <p>
                            <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Demo File 1 v1</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
            <h5 class="text-indigo text-center"><i class="fas fa-file-alt"></i> Detalle de carga</h5>

            <br>
            <div class="">
                <p class="text-sm">N° Operacion :
                    <b class="d-block">{{ $quote->nro_operation }}</b>
                </p>
            </div>

            <div class="row text-muted">
                <div class="col-6">
                    <p class="text-sm">N° Cotizacion :
                        <b class="d-block">{{ $quote->nro_quote }}</b>
                    </p>
                </div>
                <div class="col-6">
                    <p class="text-sm">Cliente :
                        <b class="d-block">{{ $quote->routing->customer->name_businessname }}</b>
                    </p>
                </div>
            </div>
            <div class="row text-muted">
                <div class="col-6">
                    <p class="text-sm">Origen :
                        <b class="d-block">{{ $quote->origin }}</b>
                    </p>
                </div>
                <div class="col-6">
                    <p class="text-sm">Destino :
                        <b class="d-block">{{ $quote->destination }}</b>
                    </p>
                </div>
            </div>
            <div class="row text-muted">
                <div class="col-6">
                    <p class="text-sm">Tipo de embarque :
                        <b class="d-block">{{ $quote->routing->type_shipment->description }}
                            ({{ $quote->routing->lcl_fcl }}) </b>
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
            @if ($quote->routing->lcl_fcl === 'LCL' || $quote->routing->lcl_fcl === null)
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
            @endif

            <h5 class="mt-5 text-muted">Archivos :</h5>
            <ul class="list-unstyled">
                @foreach ($files as $file)
                    
                <li>
                    <a href="{{$file['url']}}" target="_blank" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i> {{$file['name']}}</a>
                </li>
                @endforeach
            </ul>
            <div class="text-center mt-5 mb-3">
                <a href="#" class="btn btn-sm btn-primary">Add files</a>
                <a href="#" class="btn btn-sm btn-warning">Report contact</a>
            </div>
        </div>
    </div>

@stop
