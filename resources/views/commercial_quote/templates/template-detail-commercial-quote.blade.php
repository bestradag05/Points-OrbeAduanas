<div class="row mt-3">
    <div class="col-6">

        <h5 class="text-indigo mb-2 text-center py-3">
            <i class="fa-regular fa-circle-info"></i>
            Información de la operacion
        </h5>

        <div class="row">

            <div class="col-12 border-bottom border-bottom-2">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nro Cotización: </label>
                    <div class="col-sm-8">

                        <p class="form-control-plaintext text-indigo">{{ $comercialQuote->nro_quote_commercial }}</p>
                    </div>

                </div>
            </div>

            <div class="col-12 border-bottom border-bottom-2">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Origen : </label>
                    <div class="col-sm-8">

                        <p class="form-control-plaintext">{{ $comercialQuote->origin }}</p>
                    </div>

                </div>
            </div>
            <div class="col-12 border-bottom border-bottom-2">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Destino : </label>
                    <div class="col-sm-8">

                        <p class="form-control-plaintext">{{ $comercialQuote->destination }}</p>
                    </div>

                </div>
            </div>
            <div class="col-12 border-bottom border-bottom-2">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Cliente : </label>
                    <div class="col-sm-8">

                        <p class="form-control-plaintext">{{ $comercialQuote->customer_company_name }}</p>
                    </div>

                </div>
            </div>
            <div class="col-12 border-bottom border-bottom-2">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Producto / Mercancía : </label>
                    <div class="col-sm-8">

                        <p class="form-control-plaintext">{{ $comercialQuote->commodity }}</p>
                    </div>

                </div>
            </div>

            @if ($comercialQuote->type_shipment->description === 'Aérea')
                <div class="col-12 border-bottom border-bottom-2">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Peso KG : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">{{ $comercialQuote->kilograms }}</p>
                        </div>

                    </div>
                </div>
                <div class="col-12 border-bottom border-bottom-2">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">KGV : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">{{ $comercialQuote->kilogram_volumen }}</p>
                        </div>

                    </div>
                </div>
            @endif

            @if ($comercialQuote->type_shipment->description === 'Marítima')
                @if ($comercialQuote->lcl_fcl === 'FCL')
                    <div class="col-12 border-bottom border-bottom-2">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Contenedor : </label>
                            <div class="col-sm-8">

                                <p class="form-control-plaintext">{{ $comercialQuote->container_type }}</p>
                            </div>

                        </div>
                    </div>
                @endif
                <div class="col-12 border-bottom border-bottom-2">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Toneladas : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">{{ $comercialQuote->tons }}</p>
                        </div>

                    </div>
                </div>
                <div class="col-12 border-bottom border-bottom-2">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Volumen : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">{{ $comercialQuote->volumen }}</p>
                        </div>

                    </div>
                </div>
            @endif

            <div class="col-12" id="extraFieldsOpen">
                <a class="btn btn-link btn-block text-center" data-bs-toggle="collapse" data-bs-target="#extraFields">
                    <i class="fas fa-sort-down fa-lg"></i>
                </a>
            </div>

            <div class="col-12 row collapse mt-2" id="extraFields">

                <div class="col-12 border-bottom border-bottom-2">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Incoterm : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">{{ $comercialQuote->incoterm->code }}</p>
                        </div>

                    </div>
                </div>
                <div class="col-12 border-bottom border-bottom-2">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Tipo de carga : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">{{ $comercialQuote->type_load->name }}</p>
                        </div>

                    </div>
                </div>
                <div class="col-12 border-bottom border-bottom-2">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Valor de la Carga : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">$ {{ $comercialQuote->load_value }}</p>
                        </div>

                    </div>
                </div>
                <div class="col-12 border-bottom border-bottom-2">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Tipo de embarque : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">
                                {{ $comercialQuote->type_shipment->description . ' (' . ($comercialQuote->type_shipment->description === 'Marítima' ? $comercialQuote->lcl_fcl : '') . ')' }}
                            </p>
                        </div>

                    </div>
                </div>
                <div class="col-12 border-bottom border-bottom-2">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Régimen : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">{{ $comercialQuote->regime->description }}</p>
                        </div>

                    </div>
                </div>

                <div class="col-12 text-center mt-3">
                    <a class="btn btn-link text-center" data-bs-toggle="collapse" data-bs-target="#extraFields">
                        <i class="fas fa-sort-up"></i>
                    </a>
                </div>


            </div>
        </div>

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
                                @if ($index != 'Transporte')
                                    Sin seguro
                                    <button type="button" class="btn text-indigo"
                                        onclick="openModalInsurance('{{ $service }}', '{{ $index }}')">

                                        <i class="fa-solid fa-plus"></i>
                                    @else
                                        -
                                @endif
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




        {{--  @include('comercialQuote/modals/modalsServices') --}}

    </div>
    {{-- Tabla para cotizaciones de flete --}}
    @if ($comercialQuote->quote_freight()->exists())
        <div class="col-12 mt-4">
            <h6 class="text-indigo text-uppercase text-center text-bold">Cotizacion de flete</h6>

            <table class="table table-sm text-sm">
                <thead class="thead-dark">
                    <th>#</th>
                    <th>N° cotizacion</th>
                    <th>Cliente</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Producto</th>
                    <th>LCL / FCL</th>
                    <th>Cubicaje-KGV</th>
                    <th>Tonelada-KG</th>
                    <th>Asesor</th>
                    <th>N° de operacion</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </thead>
                <tbody>

                    @foreach ($comercialQuote->quote_freight as $quote)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $quote->nro_quote }}</td>
                            <td>{{ $quote->commercial_quote->customer_company_name }}</td>
                            <td>{{ $quote->origin }}</td>
                            <td>{{ $quote->destination }}</td>
                            <td>{{ $quote->commodity }}</td>
                            <td>{{ $quote->commercial_quote->lcl_fcl }}</td>
                            <td>{{ $quote->cubage_kgv }}</td>
                            <td>{{ $quote->ton_kilogram }}</td>
                            <td>{{ $quote->commercial_quote->personal->names }}</td>
                            <td>{{ $quote->nro_quote_commercial }}</td>
                            <td class="status-{{ strtolower($quote->state) }}">{{ $quote->state }}
                            </td>


                            <td>
                                <a href="{{ url('/quote/freight/' . $quote->id) }}"
                                    class="btn btn-outline-indigo btn-sm mb-2 ">
                                    Detalle
                                </a>
                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>
    @endif


    {{-- Tabla para cotizaciones de aduana --}}
    {{-- @if ($comercialQuote->quote_freight()->exists())
        <div class="col-12 mt-4">
            <h6 class="text-indigo text-uppercase text-center text-bold">Cotizacion de Aduana</h6>

            <table class="table table-sm text-sm">
                <thead class="thead-dark">
                    <th>#</th>
                    <th>N° cotizacion</th>
                    <th>Cliente</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Producto</th>
                    <th>LCL / FCL</th>
                    <th>Cubicaje-KGV</th>
                    <th>Tonelada-KG</th>
                    <th>Asesor</th>
                    <th>N° de operacion</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </thead>
                <tbody>

                    @foreach ($comercialQuote->quote_freight as $quote)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $quote->nro_quote }}</td>
                            <td>{{ $quote->commercial_quote->customer_company_name }}</td>
                            <td>{{ $quote->origin }}</td>
                            <td>{{ $quote->destination }}</td>
                            <td>{{ $quote->commodity }}</td>
                            <td>{{ $quote->commercial_quote->lcl_fcl }}</td>
                            <td>{{ $quote->cubage_kgv }}</td>
                            <td>{{ $quote->ton_kilogram }}</td>
                            <td>{{ $quote->commercial_quote->personal->names }}</td>
                            <td>{{ $quote->nro_quote_commercial }}</td>
                            <td class="status-{{ strtolower($quote->state) }}">{{ $quote->state }}
                            </td>


                            <td>
                                <a href="{{ url('/quote/freight/' . $quote->id) }}"
                                    class="btn btn-outline-indigo btn-sm mb-2 ">
                                    Detalle
                                </a>
                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>
    @endif --}}



    {{-- Tabla para cotizaciones de Transporte --}}
    @if($comercialQuote->quote_transport()->exists())
    <div class="col-12 mt-4">
        <h6 class="text-indigo text-uppercase text-center text-bold">Cotizacion de transporte</h6>

        <table class="table table-sm text-sm">
            <thead class="thead-dark">
                <th>#</th>
                <th>N° cotizacion</th>
                <th>Cliente</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Producto</th>
                <th>LCL / FCL</th>
                <th>Cubicaje-KGV</th>
                <th>Tonelada-KG</th>
                <th>Asesor</th>
                <th>N° de operacion</th>
                <th>Estado</th>
                <th>Acciones</th>
            </thead>
            <tbody>

                @foreach ($comercialQuote->quote_freight as $quote)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $quote->nro_quote }}</td>
                        <td>{{ $quote->commercial_quote->customer_company_name }}</td>
                        <td>{{ $quote->origin }}</td>
                        <td>{{ $quote->destination }}</td>
                        <td>{{ $quote->commodity }}</td>
                        <td>{{ $quote->commercial_quote->lcl_fcl }}</td>
                        <td>{{ $quote->cubage_kgv }}</td>
                        <td>{{ $quote->ton_kilogram }}</td>
                        <td>{{ $quote->commercial_quote->personal->names }}</td>
                        <td>{{ $quote->nro_quote_commercial }}</td>
                        <td class="status-{{ strtolower($quote->state) }}">{{ $quote->state }}
                        </td>


                        <td>
                            <a href="{{ url('/quote/freight/' . $quote->id) }}"
                                class="btn btn-outline-indigo btn-sm mb-2 ">
                                Detalle
                            </a>
                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>

    </div>
    @endif
   


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
        let countConcepts = 0;



        $('#extraFields').on("show.bs.collapse", () => {
            $('#extraFieldsOpen').addClass('d-none');
        });

        $('#extraFields').on("hidden.bs.collapse", () => {
            $('#extraFieldsOpen').removeClass('d-none');
        });

        $('.modal').on('hide.bs.modal', function(e) {
            conceptsArray = {};
            TotalConcepts = 0;
            total = 0;
            flete = 0;
            value_insurance = 0;
            valuea_added_insurance = 0;
            countConcepts = 0;

            updateTable(conceptsArray, e.target.id);

            $(`#${e.target.id}`).find('form')[0].reset();
            $('.contentInsurance').addClass('d-none').removeClass('d-flex');

        });

        function enableInsurance(checkbox) {

            const contenedorInsurance = $(`#content_${checkbox.id}`);
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

            if (element.value === '') {
                value_insurance = 0;
            } else {
                value_insurance = parseFloat(element.value.replace(/,/g, ''));
            }

            calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, container.id);
        }


        function updateInsuranceAddedTotal(element) {


            if (element.value === '') {
                valuea_added_insurance = 0;
            } else {
                valuea_added_insurance = parseFloat(element.value.replace(/,/g, ''));
            }


            //Cada que actualicemos el insurance_add borramos los puntos para poder volver a generar un maximo.
            $(`#${container.id} #insurance_points`).val("");

            calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, container.id);
        }

        function updateTransportTotal(element) {

            if (element.value === '') {
                value_insurance = 0;
            } else {
                value_insurance = parseFloat(element.value.replace(/,/g, ''));
            }

            calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, container.id);
        }

        function updateTransportAddedTotal(element) {


            if (element.value === '') {
                valuea_added_insurance = 0;
            } else {
                valuea_added_insurance = parseFloat(element.value.replace(/,/g, ''));
            }


            //Cada que actualicemos el insurance_add borramos los puntos para poder volver a generar un maximo.
            $(`#${container.id} #additional_points`).val("");

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

                conceptsArray[countConcepts] = {
                    'id': inputs[0].value,
                    'name': inputs[0].options[inputs[0].selectedIndex].text,
                    'value': formatValue(inputs[1].value),
                    'added': formatValue(inputs[2].value),
                }

                countConcepts++;

                updateTable(conceptsArray, container.id);

                inputs[0].value = '';
                inputs[1].value = '';
                inputs[2].value = '';
            }
        };

        function updateTable(conceptsArray, idContent, cost_transport = null) {

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
                    if (cost_transport) {
                        // Si cost_transport existe, muestra un input editable
                        let inputAdded = document.createElement('input');
                        inputAdded.type = 'number';
                        inputAdded.value = item.added;
                        inputAdded.min = 0;
                        inputAdded.classList.add('form-control');
                        celdaAdded.appendChild(inputAdded);

                        inputAdded.addEventListener('input', (e) => {
                            let newValue = parseFloat(e.target.value) || 0;

                            // Actualiza el valor en `conceptsArray`
                            conceptsArray[clave].added = newValue;

                            // Actualiza el máximo para `inputPA`
                            let maxPoints = Math.floor(newValue / 45);
                            inputPA.max = maxPoints;

                            // Ajusta el valor actual de `pa` si excede el nuevo máximo
                            if (conceptsArray[clave].pa > maxPoints) {
                                conceptsArray[clave].pa = maxPoints;
                                inputPA.value = maxPoints;
                            }


                            // Recalcula el total
                            TotalConcepts = calculateTotal(conceptsArray);
                            calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, container.id);

                        });
                    } else {
                        // Si cost_transport no existe, muestra el valor como texto plano
                        celdaAdded.textContent = item.added;
                    }



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


                    inputPA.addEventListener('input', (e) => {

                        if (cost_transport) {

                            conceptsArray[clave].pa = e.target.value

                        } else {

                            preventeDefaultAction(e);
                        }
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



                    if (!cost_transport) {

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

                    }


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

        function calculateTotal(conceptsArray) {
            return Object.values(conceptsArray).reduce((acc, concept) => {
                return acc + parseFloat(concept.value || 0) + parseFloat(concept.added || 0);
            }, 0);
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


            if (!value_added.trim()) {
                input.value = 0;
                input.max = 0;
            } else {

                //Indicamos el modal donde estemos trabajando y luego seleccionamos el campo.

                let value_added_number = parseFloat(value_added.replace(/,/g, ''));

                if (Math.floor(value_added_number / 45) === 0) {
                    input.value = 0;
                    input.max = 0;

                } else {
                    input.max = Math.floor(value_added_number / 45);
                }

            }

        }

        const addPointsTransport = (input) => {


            let value_added = $(`#${container.id} #transport_added`).val();

            if (!value_added.trim()) {
                input.value = 0;
                input.max = 0;
            } else {


                let value_added_number = parseFloat(value_added.replace(/,/g, ''));

                //Indicamos el modal donde estemos trabajando y luego seleccionamos el campo.

                if (Math.floor(value_added_number / 45) === 0) {
                    input.value = 0;
                    input.max = 0;

                } else {
                    input.max = Math.floor(value_added_number / 45);
                }


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

            $('#modalSeguro #typeService').val("Seguro");
            $('#modalSeguro #service_insurance').val(index);
            $('#modalSeguro #id_insurable_service').val(JSON.parse(service).id);


        }


        $('#modalSeguro').on('hidden.bs.modal', function() {

            const formInsurance = $('#modalSeguro form')[0];
            formInsurance.reset();
        })

        let cost_transport = @json($cost_transport ?? '');

        if (cost_transport && cost_transport != '') {
            var typeServices = @json($type_services);
            const selectElement = document.getElementById('type_service');

            typeServices.forEach(typeService => {

                if (typeService.name === 'Transporte') {
                    selectElement.value = typeService.id;
                }

            });

            const event = new Event('change');
            selectElement.dispatchEvent(event);


            $('#transport_value').val(cost_transport).prop('readonly', true);
            $('#origin').val("{{ $origin ?? '' }}").prop('readonly', true);
            $('#destination').val("{{ $destination ?? '' }}").prop('readonly', true);
            $('#id_quote_transport').val('{{ $id_quote_transport ?? '' }}')
            $('#withdrawal_date').val('{{ $withdrawal_date ?? '' }}').prop('readonly', true);


            let cost_gang = @json($cost_gang ?? null);
            let cost_guard = @json($cost_guard ?? null);

            @if (isset($cost_gang))

                if (cost_gang && cost_gang != '') {
                    let id_gang_concept = @json($id_gang_concept);

                    conceptsArray[id_gang_concept] = {
                        'id': id_gang_concept,
                        'name': 'CUADRILLA',
                        'value': formatValue("{{ $cost_gang }}"),
                        'added': 0,
                    }

                    updateTable(conceptsArray, container.id, cost_transport);

                }
            @endif


            @if (isset($cost_guard))

                if (cost_guard && cost_guard != '') {
                    let id_guard_concept = @json($id_guard_concept);

                    conceptsArray[id_guard_concept] = {
                        'id': id_guard_concept,
                        'name': 'RESGUARDO',
                        'value': formatValue("{{ $cost_guard }}"),
                        'added': 0,
                    }

                    updateTable(conceptsArray, container.id, cost_guard);

                }
            @endif




            value_insurance = parseFloat(cost_transport);

            calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, container.id);
        }
    </script>
@endpush
