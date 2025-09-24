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


    <div class="col-12 form-group">
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
            <select name="type_insurance" onchange="selectInsurance(this)"
                class="{{ isset($insurance) ? '' : 'd-none' }} form-control" label="Tipo de seguro" igroup-size="md"
                data-placeholder="Seleccione una opcion..." data-required="true">
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
                        id="value_insurance" name="value_insurance" data-type="currency" @readonly(true)
                        placeholder="Ingrese valor del seguro"
                        value="{{ isset($insurance) ? $insurance->insurance_value : '' }}"
                        onchange="updateInsuranceTotal(this)" data-required="true">
                </div>

            </div>
        </div>


        <div class="col-4">
            <div class="form-group">
                <label for="load_value">Valor venta</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-bold">
                            $
                        </span>
                    </div>
                    <input type="text" class="form-control CurrencyInput {{ isset($insurance) ? '' : 'd-none' }} "
                        id="insurance_sales_value" name="insurance_sales_value" data-type="currency"
                        placeholder="Ingrese valor del seguro adicional"
                        value="{{ isset($insurance) ? $insurance->insurance_sales_value : '' }}"
                        onchange="updateInsuranceSalesValue(this)" data-required="true">
                </div>

            </div>
        </div>


    </div>

    <div class="col-12">
        <hr>
    </div>

    <div id="formConceptsFlete" class="formConcepts row justify-content-center w-100">
        <div class="col-3">

            <x-adminlte-select2 name="concept" id="concept_flete" label="Conceptos"
                data-placeholder="Seleccione un concepto...">
                <option />
                @foreach ($concepts as $concept)
                    @if ($concept->typeService->name === 'Flete' && $commercial_quote->type_shipment->id == $concept->id_type_shipment)
                        <option value="{{ $concept->id }}">{{ $concept->name }}</option>
                    @endif
                @endforeach
            </x-adminlte-select2>

        </div>
        <div class="col-3">
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

        <div class="col-3 form-group d-flex align-items-center justify-content-center">
            <div class="custom-control custom-switch">
                <input type="checkbox" name="hasIgv" class="custom-control-input" id="hasIgv">
                <label class="custom-control-label" for="hasIgv">Incluido Igv</label>
            </div>
        </div>

        <div class="col-3 d-flex align-items-center pt-3 mb-2">
            <button class="btn btn-indigo" type="button" id="btnAddConcept" onclick="addConcept(this)">
                Agregar
            </button>

        </div>

        <div class="col-12 my-3">
            <h5 class="text-center text-indigo mb-3">Conceptos sin IGV</h5>
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

        <div class="col-12 my-3">
            <h5 class="text-center text-indigo mb-3">Conceptos sin IGV</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Concepto</th>
                        <th>Valor del concepto</th>
                        <th>x</th>
                    </tr>
                </thead>
                <tbody id="tbodyFleteWithIgv">


                </tbody>
            </table>
        </div>


    </div>


    <div class="row w-100 justify-content-end mt-2">

        <div class="col-4 row">
            <label for="total_answer_utility" class="col-sm-6 col-form-label text-secondary">Costo Pricing: </label>
            <div class="col-sm-6">
                <input type="text" class="form-control form-control-sm" name="total_answer_utility"
                    id="total_answer_utility" value="{{ isset($freight) ? $freight->total_answer_utility : '0.00' }}"
                    @readonly(true)>
            </div>
        </div>

    </div>

    <div class="row w-100 justify-content-end mt-2">

        <div class="col-4 row">
            <label for="insurance_value" id="insurance-detail-label"
                class="col-sm-6 col-form-label text-secondary">Seguro:</label>
            <div class="col-sm-6">
                <input type="text" class="form-control form-control-sm" name="insurance_value"
                    id="insurance_value" value="0.00" @readonly(true)>
            </div>
        </div>

    </div>

    <div class="row w-100 justify-content-end mt-2">

        <div class="col-4 row">
            <label for="freight_insurance" class="col-sm-6 col-form-label ">Total a cobrar:</label>
            <div class="col-sm-6">
                <input type="text" class="form-control form-control-sm" name="freight_insurance"
                    id="freight_insurance" value="0.00" @readonly(true)>
            </div>
        </div>

    </div>

    <div class="row w-100 justify-content-end mt-2">

        <div class="col-4 row">
            <label for="total" class="col-sm-6 col-form-label text-primary">Total venta:</label>
            <div class="col-sm-6">
                <input type="text" class="form-control form-control-sm" name="value_sale" id="value_sale"
                    value="0.00" @readonly(true)>
            </div>
        </div>

    </div>
    <div class="row w-100 justify-content-end mt-2">
        <div class="col-4 row">
            <label class="col-sm-6 col-form-label text-success">Ganancia:</label>
            <div class="col-sm-6">
                <input type="text" class="form-control form-control-sm" id="profit" name="profit"
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
        let insurance_sales_value = 0;
        let countConcepts = 0;
        let value_ocean_freight = 0;
        let puntosPosiblesPrevios = 0;


        //PAra editar, verificamos si tiene conceptos el flete: 

        @if (isset($formMode) && $formMode === 'edit')
            //Obtenemos los valores del seguro para sumarlo al total

            @if ($freight->insurance)
                value_insurance = parseFloat(@json($freight->insurance->insurance_value));
                insurance_sales_value = parseFloat(@json($freight->insurance->insurance_sales_value));
            @endif

            @if (isset($freight->concepts))


                let concepts = @json($freight->concepts);

                concepts.forEach((concept, index) => {

                    if (concept.name != "SEGURO") {

                        conceptsArray.push({
                            'id': concept.id,
                            'name': concept.name,
                            'value': formatValue(concept.pivot.value_concept),
                            'hasIgv': concept.pivot.has_igv
                        });

                    }

                });
            @endif

            calcTotal(TotalConcepts, value_insurance, insurance_sales_value);
        @endif


        updateTable(conceptsArray, value_insurance, insurance_sales_value);



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
                insurance_sales_value = 0;

                calcTotal(TotalConcepts, value_insurance);

            }
        }

        function selectInsurance(select) {

            let typesInsurance = @json($type_insurace);
            let fobValue = parseFloat(@json($commercial_quote->load_value));
            let typeShipment = @json($commercial_quote->type_shipment);
            let selectValue = parseInt(select.value);

            let insurance = typesInsurance.find(type => type.id === selectValue);
            let rate = insurance.insurance_rate.find(rate => rate.shipment_type_description === typeShipment.description);

            let minValue = parseFloat(rate.min_value);

            if (!rate) {
                Swal.fire({
                    title: "No existe tarifa registrada para calcular el seguro",
                    text: "Por favor comunicate con el administrador, para que pueda registrar las tarifas de los seguros.",
                    icon: "info"
                });
                return;
            }

            let total = 0;

            if (fobValue <= minValue) {
                total = parseFloat(rate.fixed_cost);
            } else {
                total = (fobValue * (rate.percentage / 100));
            }

            $('#insurance-detail-label').text(insurance.name);
            $('#value_insurance').val(total.toFixed(2));

            value_insurance = total;


            calcTotal(TotalConcepts, value_insurance);



        }

        function updateInsuranceTotal(element) {
            if (element.value === '') {
                value_insurance = 0;
            } else {
                value_insurance = parseFloat(element.value.replace(/,/g, ''));
            }

            calcTotal(TotalConcepts, value_insurance);
        }


        function updateInsuranceSalesValue(element) {

            if (element.value === '') {
                insurance_sales_value = 0;
            } else {
                insurance_sales_value = parseFloat(element.value.replace(/,/g, ''));
            }

            calcTotal(TotalConcepts, value_insurance, insurance_sales_value);
        }


        function calcTotal(TotalConcepts, value_insurance, insurance_sales_value = 0) {
            total = TotalConcepts + insurance_sales_value;

            let inputTotal = $('#value_sale');
            inputTotal.val(total.toFixed(2));
            const totalAcceptedAnswer = parseFloat(@json($totalAcceptedAnswer));
            let utilidad = parseFloat($('#value_utility').val().replace(/,/g, '')) || 0;
            let btnGuardar = $('#btnGuardarFreight');

            /* Calculamos las sumas */

            let freightPricing = totalAcceptedAnswer + utilidad;
            let insurance = value_insurance;
            let freightInsurance = insurance + freightPricing;



            if (total >= freightInsurance && totalAcceptedAnswer > 0) {
                btnGuardar.prop('disabled', false);
            } else {
                btnGuardar.prop('disabled', true);
            }

            let ganancia = total - freightInsurance;
            if (ganancia < 0) ganancia = 0;


            $('#profit').val(ganancia.toFixed(2));

            $('#total_answer_utility').val((freightPricing).toFixed(2));

            $('#insurance_value').val((insurance).toFixed(2));
            $('#freight_insurance').val((freightInsurance).toFixed(2));


        }



        $('#value_utility').on('change', function() {
            calcTotal(TotalConcepts, value_insurance, insurance_sales_value);
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
                        'hasIgv': inputs[2].checked
                    };

                } else {

                    conceptsArray.push({
                        'id': parseInt(inputs[0].value),
                        'name': inputs[0].options[inputs[0].selectedIndex].text,
                        'value': formatValue(inputs[1].value),
                        'hasIgv': inputs[2].checked
                    });
                }



                updateTable(conceptsArray);

                inputs[0].value = '';
                $(inputs[0]).trigger('change');
                inputs[1].value = '';
                inputs[2].checked = false; // Desmarcar el checkbox o switch
                $(inputs[2]).trigger('change');
            }
        };



        function renderConceptRow(item, tbody, contador) {

            // Crear una nueva fila
            let fila = tbody.insertRow();

            if (item.hasIgv) {

                fila.style.backgroundColor = '#f8d7da';
            }

            // Insertar el número de iteración en la primera celda de la fila
            let celdaNumero = fila.insertCell(0);
            celdaNumero.textContent = contador;

            // Insertar la clave en la segunda celda de la fila
            let celdaClave = fila.insertCell(1);
            celdaClave.textContent = item.name;

            // Insertar el valor en la tercera celda de la fila
            let celdaValor = fila.insertCell(2);
            celdaValor.textContent = item.value;

            // Insertar un botón para eliminar la fila en la cuarta celda de la fila
            let celdaEliminar = fila.insertCell(3);
            let botonEliminar = document.createElement('a');
            botonEliminar.href = '#';
            botonEliminar.innerHTML = '<p class="text-danger">X</p>';
            botonEliminar.addEventListener('click', function(event) {
                event.preventDefault();
                // Eliminar la fila correspondiente al hacer clic en el botón
                let fila = this.parentNode.parentNode;
                let indice = fila.getAttribute('data-index');

                conceptsArray.splice(indice, 1); // Eliminar el elemento en el índice correspondiente
                updateTable(conceptsArray);
            });
            celdaEliminar.appendChild(botonEliminar);

            fila.setAttribute('data-index', contador - 1);

            TotalConcepts += parseFloat(item.value);
        }

        function updateTable(conceptsArray) {

            let tbodyFreight = $(`#formConceptsFlete`).find('tbody#tbodyFlete')[0];
            let tbodyFreightWithIgv = $(`#formConceptsFlete`).find('tbody#tbodyFleteWithIgv')[0];

            if (tbodyFreight) {

                tbodyFreight.innerHTML = '';
            }

            if (tbodyFreightWithIgv) {

                tbodyFreightWithIgv.innerHTML = '';
            }

            TotalConcepts = 0;

            let contador = 0;

            for (let clave in conceptsArray) {


                let item = conceptsArray[clave];

                if (conceptsArray.hasOwnProperty(clave)) {
                    if (!item.hasIgv) {

                        contador++;
                        renderConceptRow(item, tbodyFreight, contador);

                    } else {
                        contador++;
                        renderConceptRow(item, tbodyFreightWithIgv, contador);
                    }

                }
            }

            calcTotal(TotalConcepts, value_insurance, insurance_sales_value);



        }

/* 
        function calculateTotal(conceptsArray) {
            return Object.values(conceptsArray).reduce((acc, concept) => {
                return acc + parseFloat(concept.value || 0) + parseFloat(concept.added || 0);
            }, 0);
        } */


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
