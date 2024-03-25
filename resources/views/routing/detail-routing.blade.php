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

    <div class="row mt-3">
        <div class="col-6">

            <h5 class="text-indigo mb-2 text-center py-3">
                <i class="fa-regular fa-circle-info"></i>
                Información de la operacion
            </h5>
            <table class="table">
                <tbody>
                    <tr>
                        <td class="text-secondary text-bold text-uppercase">Nro Operacion</td>
                        <td>{{ $routing->nro_operation }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary text-bold text-uppercase">Origen</td>
                        <td>{{ $routing->origin }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary text-bold text-uppercase">Destino</td>
                        <td>{{ $routing->destination }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary text-bold text-uppercase">Valor de la Carga</td>
                        <td>$ {{ $routing->load_value }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary text-bold text-uppercase">Cliente</td>
                        <td>{{ $routing->customer->name_businessname }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary text-bold text-uppercase">Proveedor del Cliente</td>
                        <td>{{ $routing->shipper->name_businessname }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary text-bold text-uppercase">Tipo de embarque</td>
                        <td>{{ $routing->type_shipment->description }}</td>
                    </tr>
                    <tr>
                        <td class="text-secondary text-bold text-uppercase">Regimen</td>
                        <td>{{ $routing->regime->description }}</td>
                    </tr>
                </tbody>
            </table>



        </div>
        <div class="col-6 px-5">

            <h5 class="text-indigo mb-2 text-center py-3">
                <i class="fa-duotone fa-gear"></i>
                Servicios
            </h5>

            <x-adminlte-select2 name="type_service" igroup-size="md" data-placeholder="Seleccione una opcion..."
                onchange="openModalForm(this)">
                <option />
                @foreach ($type_services as $type_service)
                    <option value="{{ $type_service->id }}"> {{ $type_service->name }} </option>
                @endforeach
            </x-adminlte-select2>


            <hr>
            <p class="text-indigo text-bold">Lista de Servicios: </p>
            <table class="table">
                <tbody>

                </tbody>
            </table>


            @include('routing/modals/modalsServices')



        </div>
    </div>



    <table>

    </table>

@stop

@push('scripts')
    <script>
        let conceptsArray = {};
        let TotalConcepts = 0;
        let total = 0;
        let flete = 0;
        let seguro = 0;

        $('.modal').on('hidden.bs.modal', function(e) {
            conceptsArray = {};
            TotalConcepts = 0;
            total = 0;
            flete = 0;
            seguro = 0;

            updateTable(conceptsArray, e.target.id);

            $(`#${e.target.id}`).find('form')[0].reset();
            $('.contentInsurance').addClass('d-none').removeClass('d-flex');

        });

        function enableInsurance(checkbox) {

            const contenedorInsurance = $(`#content_${checkbox.id}`);

            if (checkbox.checked) {
                contenedorInsurance.addClass('d-flex').removeClass('d-none');
            } else {
                contenedorInsurance.addClass('d-none').removeClass('d-flex');
                contenedorInsurance.find("input").val('');
                contenedorInsurance.find('select').val('');
            }
        }


        function openModalForm(element) {
            let selected = element.options[element.selectedIndex].text;
            $(`#modal${selected}`).modal('show');
            console.log(element.value);
            element.value = '';

        }


        function updateFleteTotal(element) {

            console.log(element);

            if (element.value === "") {
                flete = 0;
            } else {
                flete = parseFloat(element.value);
            }

            let content = getModal(element.id);

            calcTotal(TotalConcepts, flete, seguro, content.id);
        }


        function updateInsuranceTotal(element) {
            if (element.value === "") {
                seguro = 0;
            } else {
                seguro = parseFloat(element.value);
            }

            let content = getModal(element.id);

            calcTotal(TotalConcepts, flete, seguro, content.id);
        }


        function addConcept(buton) {

            let divConcepts = $(`#${buton.id}`).closest('.formConcepts');

            const inputs = divConcepts.find('input');

            // Busca todos los campos de entrada dentro del formulario
            inputs.each(function(index, input) {
                // Verifica si el campo de entrada está vacío
                if ($(this).val() === '') {
                    // Si está vacío, agrega la clase 'is-invalid'
                    $(this).addClass('is-invalid');

                } else {
                    // Si no está vacío, remueve la clase 'is-invalid' (en caso de que esté presente)
                    $(this).removeClass('is-invalid');

                }
            });


            // Verifica si hay algún campo con la clase 'is-invalid'
            var camposInvalidos = divConcepts.find('.is-invalid').length;

            if (camposInvalidos === 0) {
                // Si no hay campos inválidos, envía el formulario

                conceptsArray[inputs[0].value] = inputs[1].value;

                let content = getModal(divConcepts[0].id);

                updateTable(conceptsArray, content.id);

                inputs[0].value = '';
                inputs[1].value = '';
            }
        };


        function updateTable(conceptsArray, idContent) {

            let tbodyRouting = $(`#${idContent}`).find('tbody')[0];

            tbodyRouting.innerHTML = '';
            TotalConcepts = 0;


            var contador = 0;

            for (var clave in conceptsArray) {
                if (conceptsArray.hasOwnProperty(clave)) {
                    contador++; // Incrementar el contador en cada iteración

                    // Crear una nueva fila
                    var fila = tbodyRouting.insertRow();

                    // Insertar el número de iteración en la primera celda de la fila
                    var celdaNumero = fila.insertCell(0);
                    celdaNumero.textContent = contador;

                    // Insertar la clave en la segunda celda de la fila
                    var celdaClave = fila.insertCell(1);
                    celdaClave.textContent = clave;

                    // Insertar el valor en la tercera celda de la fila
                    var celdaValor = fila.insertCell(2);
                    celdaValor.textContent = conceptsArray[clave];


                    // Insertar un botón para eliminar la fila en la cuarta celda de la fila
                    var celdaEliminar = fila.insertCell(3);
                    var botonEliminar = document.createElement('a');
                    botonEliminar.href = '#';
                    botonEliminar.innerHTML = '<i class="fa-solid fa-ban text-danger"></i>';
                    botonEliminar.addEventListener('click', function() {

                        // Eliminar la fila correspondiente al hacer clic en el botón
                        var fila = this.parentNode.parentNode;
                        var indice = fila.rowIndex -
                            1; // Restar 1 porque el índice de las filas en tbody comienza en 0
                        delete conceptsArray[Object.keys(conceptsArray)[indice]];
                        updateTable(conceptsArray, idContent);
                    });
                    celdaEliminar.appendChild(botonEliminar);

                    TotalConcepts += parseFloat(conceptsArray[clave]);

                }
            }

            calcTotal(TotalConcepts, flete, seguro, idContent);

        }


        function calcTotal(TotalConcepts, flete, seguro, idContent) {

            total = TotalConcepts + flete + seguro;



            //Buscamos dentro del contenedor el campo total

            let inputTotal = $(`#${idContent}`).find('#total');

            inputTotal.val(total.toFixed(2));

        }


        function getModal(idElement) {
            return $(`#${idElement}`).closest('.modal')[0];
        }
    </script>
@endpush
