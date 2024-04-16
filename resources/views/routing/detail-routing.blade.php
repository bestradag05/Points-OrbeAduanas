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

    <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'detail' ? 'active' : '' }}" href="{{ url('/routing/' . $routing->id . '/detail') }}">
                        Detalle</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'detail' ? '' : 'active' }}" href="{{ url('/routing/' . $routing->id . '/documents') }}">
                        Documentos
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-four-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-four-detail" role="tabpanel"
                    aria-labelledby="custom-tabs-four-detail-tab">

                    @if ($tab == 'detail')
                        @include('routing/templates/template-detail-routing')
                    @else
                        @include('routing/templates/template-documents-routing')
                    @endif

                </div>

            </div>
        </div>

    </div>
@stop
