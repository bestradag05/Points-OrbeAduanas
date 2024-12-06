@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra tu routing</h2>
        <div>
            <a href="{{ url('/routing') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')



<div class="mb-5 p-4">
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
            <form id="formRouting"  onsubmit="return false;" action="/routing" method="post" enctype="multipart/form-data" >

                @csrf
                @include ('routing.form-routing', ['formMode' => 'create'])

              
            </form>
        </div>
    </div>
</div>


    {{-- <form action="/routing" method="post" enctype="multipart/form-data">
        @csrf
        @include ('routing.form-routing', ['formMode' => 'create'])
    </form> --}}


@stop


{{-- @push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", (event) => {

        var form = document.getElementById('formRouting');

        if (form.querySelectorAll(".is-invalid").length > 0) {

            var invalidInputs = form.querySelectorAll(".is-invalid");
            if (form.querySelectorAll(".is-invalid")) {
                // Encuentra el contenedor del paso que contiene el campo de entrada inválido
                var stepContainer = invalidInputs[0].parentNode.parentNode.closest('.bs-stepper-pane')
                /*  console.log(invalidInputs[0].parentNode.parentNode.closest('.bs-stepper-pane')); */

                // Encuentra el índice del paso correspondiente
                var stepIndex = Array.from(stepContainer.parentElement.children).indexOf(stepContainer);

                // Cambia el stepper al paso correspondiente
                stepper.to(stepIndex);

                // Enfoca el primer campo de entrada inválido
                invalidInputs[0].focus();
            }


        }
    });


    var stepper1Node = document.querySelector('#stepper');
    var stepper = new Stepper(document.querySelector('#stepper'));


    function submitForm() {
        var form = document.getElementById('formRouting');


        if (form.checkValidity()) {
            // Aquí puedes enviar el formulario si la validación pasa
            form.submit();
        } else {


            var invalidInputs = form.querySelectorAll(":invalid");
            if (form.querySelectorAll("invalid")) {
                // Encuentra el contenedor del paso que contiene el campo de entrada inválido
                var stepContainer = invalidInputs[0].closest('.content');

                // Encuentra el índice del paso correspondiente
                var stepIndex = Array.from(stepContainer.parentElement.children).indexOf(stepContainer);

                // Cambia el stepper al paso correspondiente
                stepper.to(stepIndex);

                // Enfoca el primer campo de entrada inválido
                invalidInputs[0].focus();
            }
        }
    }


    function validarInputNumber(input) {
        if (input.value < 0) {
            input.value = '';
        }
    }
</script>
@endpush --}}
