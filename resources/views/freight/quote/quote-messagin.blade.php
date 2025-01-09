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
                            <div class="direct-chat-msg {{($message->sender_id != auth()->user()->id) ? 'right' : ''}}">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left text-indigo text-bold">{{ $message->sender->personal->names }}</span>
                                    <span class="direct-chat-timestamp float-right text-bold">{{ $message->created_at }}</span>
                                </div>
                                @if ($message->sender->personal->img_url !== null)
                                    <img src="{{ asset('storage/' . $message->sender->personal->img_url) }}"
                                        class="direct-chat-img" alt="User Image">
                                @else
                                    <img src="{{ asset('storage/personals/user_default.png') }}"
                                        class="direct-chat-img" alt="User Image">
                                @endif
                                <div class="direct-chat-text">
                                    {!! $message->message !!}
                                </div>
                            </div>
                        @endforeach
                        {{--                         <div class="direct-chat-msg right">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-right">Sarah Bullock</span>
                                <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                            </div>
                            <img class="direct-chat-img" src="/docs/3.0/assets/img/user3-128x128.jpg"
                                alt="message user image">
                            <div class="direct-chat-text">
                                You better believe it!
                            </div>
                        </div>
                        <div class="direct-chat-msg">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-left">Alexander Pierce</span>
                                <span class="direct-chat-timestamp float-right">23 Jan 5:37 pm</span>
                            </div>
                            <img class="direct-chat-img" src="/docs/3.0/assets/img/user1-128x128.jpg"
                                alt="message user image">
                            <div class="direct-chat-text">
                                Working with AdminLTE on a great new app! Wanna join?
                            </div>
                        </div>
                        <div class="direct-chat-msg right">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-right">Sarah Bullock</span>
                                <span class="direct-chat-timestamp float-left">23 Jan 6:10 pm</span>
                            </div>
                            <img class="direct-chat-img" src="/docs/3.0/assets/img/user3-128x128.jpg"
                                alt="message user image">
                            <div class="direct-chat-text">
                                I would love to.
                            </div>
                        </div> --}}
                    </div>
                    <!--/.direct-chat-messages-->
                    <div class="direct-chat-contacts">
                        <ul class="contacts-list">
                            <li>
                                <a href="#">
                                    <img class="contacts-list-img" src="/docs/3.0/assets/img/user1-128x128.jpg">
                                    <div class="contacts-list-info">
                                        <span class="contacts-list-name">
                                            Count Dracula
                                            <small class="contacts-list-date float-right">2/28/2015</small>
                                        </span>
                                        <span class="contacts-list-msg">How have you been? I was...</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img class="contacts-list-img" src="/docs/3.0/assets/img/user7-128x128.jpg">
                                    <div class="contacts-list-info">
                                        <span class="contacts-list-name">
                                            Sarah Doe
                                            <small class="contacts-list-date float-right">2/23/2015</small>
                                        </span>
                                        <span class="contacts-list-msg">I will be waiting for...</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img class="contacts-list-img" src="/docs/3.0/assets/img/user3-128x128.jpg">
                                    <div class="contacts-list-info">
                                        <span class="contacts-list-name">
                                            Nadia Jolie
                                            <small class="contacts-list-date float-right">2/20/2015</small>
                                        </span>
                                        <span class="contacts-list-msg">I'll call you back at...</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img class="contacts-list-img" src="/docs/3.0/assets/img/user5-128x128.jpg">
                                    <div class="contacts-list-info">
                                        <span class="contacts-list-name">
                                            Nora S. Vans
                                            <small class="contacts-list-date float-right">2/10/2015</small>
                                        </span>
                                        <span class="contacts-list-msg">Where is your new...</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img class="contacts-list-img" src="/docs/3.0/assets/img/user6-128x128.jpg">
                                    <div class="contacts-list-info">
                                        <span class="contacts-list-name">
                                            John K.
                                            <small class="contacts-list-date float-right">1/27/2015</small>
                                        </span>
                                        <span class="contacts-list-msg">Can I take a look at...</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img class="contacts-list-img" src="/docs/3.0/assets/img/user8-128x128.jpg">
                                    <div class="contacts-list-info">
                                        <span class="contacts-list-name">
                                            Kenneth M.
                                            <small class="contacts-list-date float-right">1/4/2015</small>
                                        </span>
                                        <span class="contacts-list-msg">Never mind I found...</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-footer">
                    <form action="/quote/freight/message" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <textarea id="quote-text" name="message"></textarea>
                                <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                            </div>
                            <div class="col-12 row align-items-center justify-content-center mt-2">
                                <button type="submit" class="btn btn-indigo">Enviar</button>
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
                        <a href="{{ $file['url'] }}" target="_blank" class="btn-link text-secondary"><i
                                class="far fa-fw fa-file-pdf"></i> {{ $file['name'] }}</a>
                    </li>
                @endforeach
            </ul>
            <div class="text-center mt-5 mb-3">
                <a href="#" class="btn btn-sm btn-indigo">Enviar Cotización</a>
                <a href="#" class="btn btn-sm btn-secondary">Editar Cotización</a>
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
    </script>
@endpush
