@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Detalle del cotizacion</h2>
        <div>
            <button class="btn btn-primary"> Atras </button>
        </div>
    </div>

@stop
@section('dinamic-content')

    <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'detail' ? 'active' : '' }}"
                        href="{{ url('/commercial/quote/' . $comercialQuote->id . '/detail') }}">
                        Detalle</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'quote' ? 'active' : '' }}"
                        href="{{ url('/commercial/quote/' . $comercialQuote->id . '/quotes') }}">
                        Cotizaciones ({{$comercialQuote->quote_freight()->count() + $comercialQuote->quote_transport()->count()}})</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'document' ? 'active' : '' }}"
                        href="{{ url('/commercial/quote/' . $comercialQuote->id . '/documents') }}">
                        Documentos
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-four-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-four-detail" role="tabpanel"
                    aria-labelledby="custom-tabs-four-detail-tab">

                    {{--                     @if ($tab == 'detail')
                        @include('commercial_quote/templates/template-detail-commercial-quote')
                    @else
                        @include('commercial/quote/templates/template-documents-commercial-quote')
                    @endif
 --}}
                    @switch($tab)
                        @case('detail')
                            @include('commercial_quote/templates/template-detail-commercial-quote')
                        @break

                        @case('quote')
                            @include('commercial_quote/templates/template-quote-commercial-quote')
                        @break

                        @case('document')
                            @include('commercial_quote/templates/template-documents-commercial-quote')
                        @break

                        @default
                    @endswitch

                </div>

            </div>
        </div>

    </div>
@stop
