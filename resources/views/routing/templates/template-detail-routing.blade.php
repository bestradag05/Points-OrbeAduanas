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
                    <td>{{ $routing->supplier->name_businessname }}</td>
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

        <select name="type_service" id="type_service" class="form-control" onchange="openModalForm(this)">
            <option></option>
            @foreach ($type_services as $type_service)
                @php
                    $disabled = false;
                    foreach ($services as $index => $service) {
                        if ($type_service->name == $index) {
                            $disabled = true;
                            break;
                        }
                    }
                @endphp
                <option value="{{ $type_service->id }}" {{ $disabled ? 'disabled' : '' }}>
                    {{ $type_service->name }}
                </option>
            @endforeach
        </select>


        <hr>
        {{-- <p class="text-indigo text-bold">Lista de Servicios: </p> --}}
        <table class="table text-center">
            <thead>
                <th class="text-indigo text-bold">Servicios</th>
                <th class="text-indigo text-bold">Seguro</th>
                <th class="text-indigo text-bold">Estado para punto</th>
                <th class="text-indigo text-bold">Acciones</th>
            </thead>
            <tbody>

                @foreach ($services as $index => $service)
                    <tr>
                        <td>
                            <a class="btn btn-indigo w-100">
                                {{ $index }}
                            </a>
                        </td>

                        <td class="text-bold  {{ $service->insurance ? 'text-success' : 'text-danger' }}">
                            @if ($service->insurance)
                                Tiene seguro
                            @else
                                Sin seguro
                                <button type="button" class="btn text-indigo"
                                    onclick="openModalInsurance('{{ $service }}', '{{ $index }}')">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            @endif
                        </td>
                        <td class="text-bold  {{ $service->state == 'Pendiente' ? 'text-danger' : 'text-success' }}">
                            {{ $service->state }}
                        </td>


                        <td>
                            <a href="#"></a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        @include('routing/modals/modalsServices')

    </div>
</div>


@push('scripts')
    <script>
        $('#type_service').select2({
            width: 'resolve',
            placeholder: "Seleccione una opcion...",
            allowClear: true
        });

        let conceptsArray = {};
        let TotalConcepts = 0;
        let total = 0;
        let flete = 0;
        let value_insurance = 0;
        let valuea_added_insurance = 0;
        let containerResult = '';
        let container = '';
        let typeService = '';

        $('.modal').on('hidden.bs.modal', function(e) {
            conceptsArray = {};
            TotalConcepts = 0;
            total = 0;
            flete = 0;
            value_insurance = 0;
            valuea_added_insurance = 0;

            updateTable(conceptsArray, e.target.id);

            $(`#${e.target.id}`).find('form')[0].reset();
            $('.contentInsurance').addClass('d-none').removeClass('d-flex');

        });

        function enableInsurance(checkbox) {

            const contenedorInsurance = $(`#content_${checkbox.id}`);
            console.log();
            if (checkbox.checked) {
                contenedorInsurance.addClass('d-flex').removeClass('d-none');
                contenedorInsurance.find("input").removeClass('d-none');
                contenedorInsurance.find('select').removeClass('d-none');

            } else {
                contenedorInsurance.addClass('d-none').removeClass('d-flex');
                contenedorInsurance.find("input").val('').addClass('d-none').removeClass('is-invalid');
                contenedorInsurance.find('select').val('').addClass('d-none').removeClass('is-invalid');

                value_insurance = 0;
                valuea_added_insurance = 0;

                calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, container.id);

            }
        }


        function openModalForm(element) {
            let selected = element.options[element.selectedIndex].text;
            containerResult = $(`#modal${selected}`).modal('show');
            container = containerResult[0];
            typeService = element.value;
            $(`#${container.id}`).find('#typeService').val(typeService);
            element.value = '';
        }


        function updateFleteTotal(element) {

            if (element.value === "") {
                flete = 0;
            } else {
                flete = parseFloat(formatValue(element.value));
            }

            calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, container.id);
        }


        function updateInsuranceTotal(element) {
            console.log(element);
            if (element.value === "") {
                value_insurance = 0;
            } else {
                value_insurance = parseFloat(element.value);
            }

            console.log(value_insurance);

            calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, container.id);
        }


        function updateInsuranceAddedTotal(element) {
            if (element.value === "") {
                valuea_added_insurance = 0;
            } else {
                valuea_added_insurance = parseFloat(element.value);
            }

            //Cada que actualicemos el insurance_add borramos los puntos para poder volver a generar un maximo.
            $(`#${container.id} #insurance_points`).val("");

            calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, container.id);
        }


        function addConcept(buton) {

            let divConcepts = containerResult.find('.formConcepts');
            const inputs = divConcepts.find('input:not(.points), select');

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

                conceptsArray[inputs[0].value] = {
                    'id': inputs[0].value,
                    'name': inputs[0].options[inputs[0].selectedIndex].text,
                    'value': formatValue(inputs[1].value),
                    'added': formatValue(inputs[2].value),
                }

                updateTable(conceptsArray, container.id);

                inputs[0].value = '';
                inputs[1].value = '';
                inputs[2].value = '';
            }
        };

        function updateTable(conceptsArray, idContent) {

            let tbodyRouting = $(`#${idContent}`).find('tbody')[0];

            if (tbodyRouting) {

                tbodyRouting.innerHTML = '';
            }
            TotalConcepts = 0;

            let contador = 0;

            for (let clave in conceptsArray) {

                let item = conceptsArray[clave];

                if (conceptsArray.hasOwnProperty(clave)) {
                    contador++; // Incrementar el contador en cada iteración
                    // Crear una nueva fila
                    let fila = tbodyRouting.insertRow();

                    // Insertar el número de iteración en la primera celda de la fila
                    let celdaNumero = fila.insertCell(0);
                    celdaNumero.textContent = contador;

                    // Insertar la clave en la segunda celda de la fila
                    let celdaClave = fila.insertCell(1);
                    celdaClave.textContent = item.name;

                    // Insertar el valor en la tercera celda de la fila
                    let celdaValor = fila.insertCell(2);
                    celdaValor.textContent = item.value;

                    // Insertar el valor en la cuarta celda de la fila
                    let celdaAdded = fila.insertCell(3);
                    celdaAdded.textContent = item.added;


                    let celdaPA = fila.insertCell(4);
                    celdaPA.style.width = '15%';
                    let inputPA = document.createElement('input');
                    inputPA.type = 'number';
                    inputPA.value = (conceptsArray[clave].pa) ? conceptsArray[clave].pa : '';
                    inputPA.name = 'pa';
                    inputPA.classList.add('form-control', 'points');
                    inputPA.classList.remove('is-invalid');
                    inputPA.min = 0;
                    celdaPA.appendChild(inputPA);

                    inputPA.addEventListener('keydown', (e) => {
                        preventeDefaultAction(e);
                    });

                    if (Math.floor(item.added / 45) === 0) {

                        inputPA.max = 0;
                    } else {
                        inputPA.addEventListener('input', (e) => {
                            // Indicamos cual es el maximo de puntos que puede asignarle
                            inputPA.max = Math.floor(item.added / 45);
                            // Agregamos este valor del punto al objeto, para que cuando dibujemos la tabla nuevamente, no se eliminen
                            conceptsArray[clave].pa = e.target.value
                        })
                    }




                    // Insertar un botón para eliminar la fila en la cuarta celda de la fila
                    let celdaEliminar = fila.insertCell(5);
                    let botonEliminar = document.createElement('a');
                    botonEliminar.href = '#';
                    botonEliminar.innerHTML = '<p class="text-danger">X</p>';
                    botonEliminar.addEventListener('click', function() {

                        // Eliminar la fila correspondiente al hacer clic en el botón
                        let fila = this.parentNode.parentNode;
                        let indice = fila.rowIndex -
                            1; // Restar 1 porque el índice de las filas en tbody comienza en 0
                        delete conceptsArray[Object.keys(conceptsArray)[indice]];
                        updateTable(conceptsArray, idContent);
                    });
                    celdaEliminar.appendChild(botonEliminar);

                    TotalConcepts += parseFloat(item.value) + parseFloat(item.added);
                }
            }

            calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, container.id);

        }


        function calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, idContent) {

            total = TotalConcepts + flete + value_insurance + valuea_added_insurance;

            //Buscamos dentro del contenedor el campo total

            let inputTotal = $(`#${idContent}`).find('#total');

            inputTotal.val(total.toFixed(2));

        }

        function formatValue(value) {
            return value.replace(/,/g, '');
        }

        const preventeDefaultAction = (e) => {
            e.preventDefault();
        }


        const addPointsInsurance = (input) => {

            let value_added = 0;

            if (container != '') {
                value_added = $(`#${container.id} #insurance_added`).val();
            } else {
                value_added = $(`#content_seguro #insurance_added`).val();
            }

            //Indicamos el modal donde estemos trabajando y luego seleccionamos el campo.


            if (Math.floor(value_added / 45) === 0) {
                input.value = 0;
                input.max = 0;

            } else {
                input.max = Math.floor(value_added / 45);
            }
        }

        // Asegúrate de que la función se ejecute cada vez que el valor de #insurance_added cambie
        $('#insurance_added').on('input', function() {

            let insurancePointsInput = $('#insurance_points')[
                0]; // Obtén el elemento de entrada de puntos de value_insurance
            addPointsInsurance(insurancePointsInput); // Llama a la función con el elemento de entrada
        });


        function submitForm() {

            let form = $(`#${container.id}`).find('form');
            const inputs = form.find('input, select').not('.formConcepts  input, .formConcepts select, input.d-none');


            inputs.each(function(index, input) {

                if (!$(this).hasClass('d-none')) {

                    // Verifica si el campo de entrada está vacío
                    if ($(this).val() === '') {
                        // Si está vacío, agrega la clase 'is-invalid'
                        $(this).addClass('is-invalid');

                    } else {
                        // Si no está vacío, remueve la clase 'is-invalid' (en caso de que esté presente)
                        $(this).removeClass('is-invalid');

                    }
                }

            });


            var camposInvalidos = form.find('.is-invalid').length;

            if (camposInvalidos == 0) {

                let conceptops = JSON.stringify(conceptsArray);

                form.append(`<input type="hidden" name="concepts" value='${conceptops}' />`);
                form[0].submit();
            }
        }


        function submitFormInsurance() {

            let form = $('#form_insurance');
            const inputs = form.find('input, select').not('');

            inputs.each(function(index, input) {

                if (!$(this).hasClass('d-none')) {

                    // Verifica si el campo de entrada está vacío
                    if ($(this).val() === '') {
                        // Si está vacío, agrega la clase 'is-invalid'
                        $(this).addClass('is-invalid');

                    } else {
                        // Si no está vacío, remueve la clase 'is-invalid' (en caso de que esté presente)
                        $(this).removeClass('is-invalid');

                    }
                }

            });


            var camposInvalidos = form.find('.is-invalid').length;

            if (camposInvalidos == 0) {

                let conceptops = JSON.stringify(conceptsArray);

                form.append(`<input type="hidden" name="concepts" value='${conceptops}' />`);
                form[0].submit();
            }
        }



        //Modal de seguro

        var modalInsurance = new bootstrap.Modal(document.getElementById("modalSeguro"), {});

        function openModalInsurance(service, index) {

            modalInsurance.show();

            $('#modalSeguro #typeService').val("seguro");
            $('#modalSeguro #service_insurance').val(index);


        }


        $('#modalSeguro').on('hidden.bs.modal', function() {

            const formInsurance = $('#modalSeguro form')[0];
            formInsurance.reset();
        })
    </script>
@endpush
