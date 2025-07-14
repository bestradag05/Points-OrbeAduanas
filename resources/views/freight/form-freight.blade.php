<div class="row p-4">


    {{-- <input type="hidden" name="nro_operation"
        value="{{ isset($routing->nro_operation) ? $routing->nro_operation : '' }}">
    <input type="hidden" name="id_quote_freight" value="{{ isset($quote->id) ? $quote->id : '' }}"> --}}

    <input type="hidden" name="nro_quote_commercial"
        value="{{ isset($commercial_quote->nro_quote_commercial) ? $commercial_quote->nro_quote_commercial : '' }}">
    <input type="hidden" name="id_quote_freight" value="{{ isset($quote->id) ? $quote->id : '' }}">
    <input type="hidden" name="accepted_answer_value"
        value="{{ isset($acceptedResponse->total) ? $acceptedResponse->total : '' }}">

    {{-- <input type="hidden" name="typeService" id="typeService"> --}}


    <div class="col-6 offset-3">

        <div class="form-group">
            <label for="value_utility">Utilidad Orbe</label>

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text text-bold">
                        $
                    </span>
                </div>
                {{-- Utilizamos el if solo por que podemos crear flete desde una cotizacion como no. --}}

                <input type="text" class="form-control CurrencyInput" id="value_utility" name="value_utility"
                    data-type="currency" placeholder="Ingrese valor de la utilidad"
                    value="{{ isset($freight->value_utility) ? $freight->value_utility : old('value_utility') }}"
                    data-required="true">
            </div>

        </div>
    </div>


    <div class=" col-12 form-group">
        <div class="custom-control custom-switch">
            <input type="checkbox" name="state_insurance" class="custom-control-input" id="seguroFreight"
                onchange="enableInsurance(this)" {{ isset($insurance) ? 'checked' : '' }}>
            <label class="custom-control-label" for="seguroFreight">Agregar Seguro</label>
        </div>
    </div>

    <hr>
    <div class="col-12 row {{ isset($insurance) ? '' : 'd-none' }} justify-content-center " id="content_seguroFreight">
        <div class="col-4">
            <label for="type_insurance">Tipo de seguro</label>
            <select name="type_insurance" class="{{ isset($insurance) ? '' : 'd-none' }} form-control"
                label="Tipo de seguro" igroup-size="md" data-placeholder="Seleccione una opcion..."
                data-required="true">
                <option />
                @foreach ($type_insurace as $type)
                    <option value="{{ $type->id }}"
                        {{ isset($insurance) && $insurance->id_type_insurance === $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="load_value">Valor del seguro</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-bold">
                            $
                        </span>
                    </div>
                    <input type="text" class="form-control CurrencyInput {{ isset($insurance) ? '' : 'd-none' }} "
                        name="value_insurance" data-type="currency" placeholder="Ingrese valor de la carga"
                        value="{{ isset($insurance) ? $insurance->insurance_value : '' }}"
                        onchange="updateInsuranceTotal(this)" data-required="true">
                </div>

            </div>
        </div>


    </div>

    <div class="col-12">
        <hr>
    </div>

    <div id="formConceptsFlete" class="formConcepts row justify-content-center w-100">
        <div class="col-4">

            <x-adminlte-select2 name="concept" id="concept_flete" label="Conceptos"
                data-placeholder="Seleccione un concepto...">
                <option />
                @foreach ($concepts as $concept)
                    @if ($concept->typeService->name == 'Flete' && $commercial_quote->type_shipment->id == $concept->id_type_shipment)
                        <option value="{{ $concept->id }}">{{ $concept->name }}</option>
                    @endif
                @endforeach
            </x-adminlte-select2>

        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="value_concept">Valor ha agregar</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-bold">
                            $
                        </span>
                    </div>
                    <input type="text" class="form-control CurrencyInput " name="value_concept" data-type="currency"
                        placeholder="Ingrese valor del concepto" value="">
                </div>
            </div>

        </div>

        <div class="col-4 d-flex align-items-center pt-3 mb-2">
            <button class="btn btn-indigo" type="button" id="btnAddConcept" onclick="addConcept(this)">
                Agregar
            </button>

        </div>

        <table class="table">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Concepto</th>
                    <th>Valor del concepto</th>
                    <th>x</th>
                </tr>
            </thead>
            <tbody id="tbodyFlete">


            </tbody>
        </table>

    </div>


    <div class="row w-100 justify-content-end mt-2">

        <div class="col-4 row">
            <label for="total_answer_utility" class="col-sm-6 col-form-label">Total Flete: </label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="total_answer_utility" id="total_answer_utility"
                    value="{{ isset($freight) ? $freight->total_answer_utility : '0.00' }}" @readonly(true)>
            </div>
        </div>

    </div>

    <div class="row w-100 justify-content-end mt-2">

        <div class="col-4 row">
            <label for="total" class="col-sm-6 col-form-label">Total conceptos:</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="total_freight_value" id="total_freight_value"
                    value="0.00" @readonly(true)>
            </div>
        </div>

    </div>
    <div class="row w-100 justify-content-end mt-2">
        <div class="col-4 row">
            <label class="col-sm-6 col-form-label">Ganancia:</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="profit_on_freight" name="profit_on_freight"
                    value="0.00" readonly>
            </div>
        </div>
    </div>
    {{-- <div class="row w-100 justify-content-end mt-2">
        <div class="col-4 row align-items-center">
            <label class="col-sm-6 col-form-label">Maximo de Adicionales:</label>
            <div class="col-sm-6" id="puntosUsadosTexto">
                0
            </div>

            <input type="hidden" class="form-control" id="puntosPosibles" name="total_additional_points"
                value="0" readonly>
            <input type="hidden" class="form-control" id="total_additional_points_used"
                name="total_additional_points_used" value="0" readonly>
        </div>
    </div> --}}



    <div class="container text-center mt-5">
        <input class="btn btn-primary" type="submit" id="btnGuardarFreight"
            value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
    </div>

</div>

@php
    $totalAcceptedAnswer = isset($acceptedResponse) ? $acceptedResponse->total : 0;
@endphp

@push('scripts')
    <script>
        let conceptsArray = [];
        let TotalConcepts = 0;
        let total = 0;
        let flete = 0;
        let value_insurance = 0;
        let countConcepts = 0;
        let value_ocean_freight = 0;
        let puntosPosiblesPrevios = 0;


        //PAra editar, verificamos si tiene conceptos el flete: 

        @if (isset($formMode) && $formMode === 'edit')

            conceptFreight = @json($conceptFreight);
            //Obtenemos los valores del seguro para sumarlo al total

            @if ($freight->insurance)
                value_insurance = parseFloat(@json($freight->insurance->insurance_value));
            @endif

            @if (isset($freight->concepts))


                let concepts = @json($freight->concepts);

                concepts.forEach((concept, index) => {

                    if (concept.name != "SEGURO") {

                        conceptsArray.push({
                            'id': concept.id,
                            'name': concept.name,
                            'value': formatValue(concept.pivot.value_concept)
                        });

                    }

                });
            @endif

            calcTotal(TotalConcepts, value_insurance);
        @endif


        updateTable(conceptsArray);



        function enableInsurance(checkbox) {

            const contenedorInsurance = $(`#content_seguroFreight`);
            if (checkbox.checked) {
                contenedorInsurance.addClass('d-flex').removeClass('d-none');
                contenedorInsurance.find("input").removeClass('d-none');
                contenedorInsurance.find('select').removeClass('d-none');

            } else {
                contenedorInsurance.addClass('d-none').removeClass('d-flex');
                contenedorInsurance.find("input").val('').addClass('d-none').removeClass('is-invalid');
                contenedorInsurance.find('select').val('').addClass('d-none').removeClass('is-invalid');

                contenedorInsurance.find('.invalid-feedback').remove();

                value_insurance = 0;
                valuea_added_insurance = 0;

                calcTotal(TotalConcepts, value_insurance);

            }
        }

        function updateInsuranceTotal(element) {
            if (element.value === '') {
                value_insurance = 0;
            } else {
                value_insurance = parseFloat(element.value.replace(/,/g, ''));
            }

            calcTotal(TotalConcepts, value_insurance);
        }


        /* function updateInsuranceAddedTotal(element) {

            if (element.value === '') {
                valuea_added_insurance = 0;
            } else {
                valuea_added_insurance = parseFloat(element.value.replace(/,/g, ''));
            }

            calcTotal(TotalConcepts, value_insurance);
        } */


        function calcTotal(TotalConcepts, value_insurance) {
            total = TotalConcepts + value_insurance;

            let inputTotal = $('#total_freight_value');
            inputTotal.val(total.toFixed(2));
            const totalAcceptedAnswer = parseFloat(@json($totalAcceptedAnswer));
            let utilidad = parseFloat($('#value_utility').val().replace(/,/g, '')) || 0;

            let btnGuardar = $('#btnGuardarFreight');

            if (total >= (totalAcceptedAnswer + utilidad) && totalAcceptedAnswer > 0) {
                btnGuardar.prop('disabled', false);
            } else {
                btnGuardar.prop('disabled', true);
            }

            let ganancia = total - (totalAcceptedAnswer + utilidad);
            if (ganancia < 0) ganancia = 0;

            $('#profit_on_freight').val(ganancia.toFixed(2));

            $('#total_answer_utility').val((totalAcceptedAnswer + utilidad).toFixed(2));

            /*  // Puntos posibles por ganancia neta
             let puntosPorGanancia = 0;
             if (ganancia >= 45) {
                 puntosPorGanancia = Math.floor(ganancia / 45);
             }


             let puntosPosibles = puntosPorGanancia;
             $('#puntosPosibles').val(puntosPosibles);
             $('#puntosUsadosTexto').text(`${puntosPosibles}`);

             if (puntosPosibles !== puntosPosiblesPrevios) {
                 // Reset puntos de conceptos
                 conceptsArray.forEach(c => c.pa = 0);
                 $('input[name="pa"]').val(0);

                 // Reset puntos de seguro
                 $('#insurance_points').val(0);

                 puntosPosiblesPrevios = puntosPosibles;
             } */
        }



        $('#value_utility').on('change', function() {
            calcTotal(TotalConcepts, value_insurance);
        });



        function addConcept(buton) {

            let divConcepts = $('.formConcepts');
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

                //Verificamos si el concepto ya existe en el array 

                const index = conceptsArray.findIndex(item => item.id === parseInt(inputs[0].value));

                if (index !== -1) {

                    conceptsArray[index] = {
                        'id': parseInt(inputs[0].value),
                        'name': inputs[0].options[inputs[0].selectedIndex].text,
                        'value': formatValue(inputs[1].value),
                    };

                } else {

                    conceptsArray.push({
                        'id': parseInt(inputs[0].value),
                        'name': inputs[0].options[inputs[0].selectedIndex].text,
                        'value': formatValue(inputs[1].value),
                    });
                }



                updateTable(conceptsArray);

                inputs[0].value = '';
                inputs[1].value = '';
            }
        };




        function updateTable(conceptsArray) {

            let tbodyRouting = $(`#formConceptsFlete`).find('tbody')[0];

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

                    //TODO: Los puntos adicionales se calcularan desde el modulo comisiones
                    /* let celdaPA = fila.insertCell(3);
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
                        const allowedKeys = ['ArrowUp', 'ArrowDown', 'Tab', 'Enter'];
                        if (!allowedKeys.includes(e.key)) {
                            e.preventDefault();
                        }
                    });


                    inputPA.addEventListener('input', (e) => {
                        let val = parseInt(e.target.value) || 0;
                        validateAndAdjustPointsOnInput(e.target);
                    }); */


                    // Insertar un botón para eliminar la fila en la cuarta celda de la fila
                    let celdaEliminar = fila.insertCell(3);
                    let botonEliminar = document.createElement('a');
                    botonEliminar.href = '#';
                    botonEliminar.innerHTML = '<p class="text-danger">X</p>';
                    botonEliminar.addEventListener('click', function(event) {
                        event.preventDefault();
                        // Eliminar la fila correspondiente al hacer clic en el botón
                        let fila = this.parentNode.parentNode;
                        let indice = fila.rowIndex -
                            1; // Restar 1 porque el índice de las filas en tbody comienza en 0
                        conceptsArray.splice(indice, 1); // Eliminar el elemento en el índice correspondiente
                        updateTable(conceptsArray);
                    });
                    celdaEliminar.appendChild(botonEliminar);

                    TotalConcepts += parseFloat(item.value);
                }
            }

            calcTotal(TotalConcepts, value_insurance);



        }


        function calculateTotal(conceptsArray) {
            return Object.values(conceptsArray).reduce((acc, concept) => {
                return acc + parseFloat(concept.value || 0) + parseFloat(concept.added || 0);
            }, 0);
        }


        $('#insurance_points').on('input', function() {
            validateAndAdjustPointsOnInput(this);
        });

        //TODO: ahora la validacion de puntos adicionales se hara desde su modulo
        /* function validateAndAdjustPointsOnInput(element) {
            const puntosMaximos = parseInt($('#puntosPosibles').val()) || 0;
            let sumaActual = 0;

            // Sumar puntos en conceptos
            $('input[name="pa"]').each(function() {
                sumaActual += parseInt($(this).val()) || 0;
            });

            // Sumar puntos en seguro
            sumaActual += parseInt($('#insurance_points').val()) || 0;

            if (sumaActual > puntosMaximos) {
                let exceso = sumaActual - puntosMaximos;
                let valorActual = parseInt($(element).val()) || 0;
                let nuevoValor = valorActual - exceso;

                if (nuevoValor < 0) nuevoValor = 0;

                $(element).val(nuevoValor);

                let index = $(element).closest('tr').index();
                if ($(element).attr('id') !== 'insurance_points') {
                    conceptsArray[index].pa = nuevoValor;
                }

                toastr.warning(
                    `El máximo de puntos permitidos es ${puntosMaximos}. Ajustado automáticamente para evitar exceder este límite.`
                );
            } else {
                let index = $(element).closest('tr').index();
                if ($(element).attr('id') !== 'insurance_points') {
                    conceptsArray[index].pa = parseInt($(element).val()) || 0;
                }
            }


            // ✅ Actualiza visualización de puntos usados
            $('#puntosUsadosTexto').text(`${Math.min(sumaActual, puntosMaximos)} / ${puntosMaximos}`);
            $('#total_additional_points_used').val(Math.min(sumaActual, puntosMaximos));
        } */


        /*  function validateTotalPoints() {
             const puntosMaximos = parseInt($('#puntosPosibles').val()) || 0;
             let sumaActual = 0;

             // Sumar puntos de conceptos
             $('input[name="pa"]').each(function() {
                 let val = parseInt($(this).val()) || 0;
                 sumaActual += val;
             });

             // Sumar puntos de seguro
             let puntosSeguro = parseInt($('#insurance_points').val()) || 0;
             sumaActual += puntosSeguro;

             if (sumaActual > puntosMaximos) {
                 toastr.warning(
                     `El máximo de puntos adicionales es ${puntosMaximos}. Ha ingresado ${sumaActual}. Ajuste los valores.`
                 );
                 return false;
             }

             return true;
         } */

        //TODO:: Fin


        function validateForm(inputs) {
            inputs.forEach(input => {
                if (input.closest('.d-none')) return;

                const value = input.value?.trim();
                if (!value || value === '') {
                    input.classList.add('is-invalid');
                    showError(input, 'Debe completar este campo');
                    return;
                } else {
                    input.classList.remove('is-invalid');
                    hideError(input);
                }
            });
        }


        // Mostrar mensaje de error
        function showError(input, message) {
            let container = input;

            // Si es un SELECT2
            if (input.tagName === 'SELECT' && $(input).hasClass('select2-hidden-accessible')) {
                container = $(input).next('.select2')[0];
            }

            let errorSpan = container.nextElementSibling;

            if (!errorSpan || !errorSpan.classList.contains('invalid-feedback')) {
                errorSpan = document.createElement('span');
                errorSpan.classList.add('invalid-feedback', 'd-block'); // Asegura visibilidad
                container.after(errorSpan);
            }

            errorSpan.textContent = message;
            errorSpan.style.display = 'block';
        }

        function hideError(input) {
            let container = input;

            if (input.tagName === 'SELECT' && $(input).hasClass('select2-hidden-accessible')) {
                container = $(input).next('.select2')[0];
            }

            let errorSpan = container.nextElementSibling;

            if (errorSpan && errorSpan.classList.contains('invalid-feedback')) {
                errorSpan.classList.remove('d-block');
                errorSpan.style.display = 'none';
            }
        }


        function formatValue(value) {
            return value.replace(/,/g, '');
        }




        $('#formFreight').on('submit', (e) => {
            e.preventDefault(); // 🚩 Detiene el envío del formulario

            let form = $('#formFreight');
            let isValid = true;

            const requiredInputs = form.find('[data-required="true"]').toArray();
            validateForm(requiredInputs);

            if ($('#seguroFreight').is(':checked')) {
                const insuranceInputs = $('#content_seguroFreight').find(
                    'input[data-required="true"], select[data-required="true"]').toArray();
                console.log(insuranceInputs);
                validateForm(insuranceInputs);
            }

            if (form.find('.is-invalid').length > 0) {
                return;
            }

            let conceptops = JSON.stringify(conceptsArray);
            form.append(`<input type="hidden" name="concepts" value='${conceptops}' />`);

            form[0].submit();
        });
    </script>
@endpush
