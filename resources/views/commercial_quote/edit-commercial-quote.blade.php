@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar un Routing</h2>
        <div>
            <button class="btn btn-primary"> Atras </button>
        </div>
    </div>

@stop
@section('dinamic-content')

    <div id="stepper" class="bs-stepper linear">
        <div class="bs-stepper-header" role="tablist">
            <div class="step active" data-target="#test-l-1">
                <button type="button" class="step-trigger" role="tab" id="stepper1trigger1"
                    aria-controls="test-l-1" aria-selected="true">
                    <span class="bs-stepper-circle">1</span>
                    <span class="bs-stepper-label">Informacion</span>
                </button>
            </div>
            <div class="bs-stepper-line"></div>
            <div class="step" data-target="#test-l-2">
                <button type="button" class="step-trigger" role="tab" id="stepper1trigger2"
                    aria-controls="test-l-2" aria-selected="false" disabled="disabled">
                    <span class="bs-stepper-circle">2</span>
                    <span class="bs-stepper-label">Detalle del Producto</span>
                </button>
            </div>
            
        </div>
        <div class="bs-stepper-content">
            <form onsubmit="return false;" action={{'/routing/'. $routing->id}} id="formRouting" method="POST" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}
                @include ('routing.form-routing', ['formMode' => 'edit'])
            </form>
        </div>
    </div>

   
@stop

