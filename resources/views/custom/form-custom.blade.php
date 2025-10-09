<div class="row p-3">

    <input type="hidden" name="nro_quote_commercial" value="{{ $commercialQuote->nro_quote_commercial }}">
    <input type="hidden" name="value_utility" id="value_utility">


    <div class="col-12 px-0">
        <div class="accordion" id="accordionImpuestos">
            <div class="card" style="background: #dbdbe175">
                <div class="card-header m-0 p-1" id="headingImpuestos">
                    <h6 class=" pb-0 mb-0  pl-2 d-flex justify-content-between align-items-center">
                        <span class="text-uppercase">
                            Detalle de impuestos
                        </span>
                        <button class="btn btn-link" type="button" data-toggle="collapse"
                            data-target="#collapseImpuestos" aria-expanded="true" aria-controls="collapseImpuestos">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </h6>
                </div>

                <div id="collapseImpuestos" class="collapse show" aria-labelledby="headingImpuestos"
                    data-parent="#accordionImpuestos">
                    <div class="card-body">
                        <!-- Primer campo: Valor FOB -->
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="load_value">Valor FOB</label>
                                    <div class="input-group">
                                        <input type="text"
                                            class="form-control  @error('load_value') is-invalid @enderror "
                                            {{ isset($commercialQuote->load_value) ? 'readonly' : '' }}
                                            name="load_value" placeholder="Ingrese valor de la carga"
                                            value="{{ isset($commercialQuote->load_value) ? number_format($commercialQuote->load_value, 2) : old('load_value') }}">
                                    </div>
                                    @error('load_value')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Segundo campo: Valor CIF -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="cif_value">Valor CIF</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control CurrencyInput" name="cif_value"
                                            placeholder="Ingrese valor de la carga" data-type="currency"
                                            value="{{ isset($commercialQuote->cif_value) ? number_format($commercialQuote->cif_value, 2) : old('cif_value') }}">
                                    </div>
                                    @error('cif_value')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Tercer campo: Impuestos de Aduanas -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="customs_taxes">Impuestos de Aduanas</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control CurrencyInput" name="customs_taxes"
                                            placeholder="Ingrese valor de la carga" data-type="currency"
                                            value="{{ isset($custom->customs_taxes) ? $custom->customs_taxes : '' }}">
                                    </div>
                                    @error('customs_taxes')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Cuarto campo: Percepción Aduanas -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="customs_perception">Percepción Aduanas</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control CurrencyInput"
                                            name="customs_perception" placeholder="Ingrese valor de la carga"
                                            data-type="currency"
                                            value="{{ isset($custom->customs_perception) ? $custom->customs_perception : old('customs_perception') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-12">

        <x-adminlte-select2 name="modality" id="modality" label="Modalidad"
            data-placeholder="Seleccione un concepto...">
            <option />
            @foreach ($modalitys as $modality)
                <option value="{{ $modality->id }}" @if ($modality->id == $custom->id_modality) selected @endif>
                    {{ $modality->name }}
                </option>
            @endforeach
        </x-adminlte-select2>

    </div>

    <hr>
    <div id="formConceptsAduanas" class="formConcepts row">
        <div class="col-4">

            <label for="concept">Conceptos</label>
            <button class="btn btn-indigo btn-xs" type="button"
                onclick="openToModal('modalAddConcept')">
                <i class="fas fa-plus"></i>
            </button>
            :
            <x-adminlte-select2 name="concept" id="concept_aduana" data-placeholder="Seleccione un concepto...">
                <option />
                @foreach ($concepts as $concept)
                    @if ($concept->typeService->name == 'Aduanas' && $commercialQuote->type_shipment->id == $concept->id_type_shipment)
                        @if ($concept->name != 'AGENCIAMIENTO DE ADUANAS' && $concept->name != 'GASTOS OPERATIVOS')
                            <option value="{{ $concept->id }}">{{ $concept->name }}</option>
                        @endif
                    @endif
                @endforeach
            </x-adminlte-select2>

        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="value_concept">Valor del concepto</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-bold">
                            $
                        </span>
                    </div>
                    <input type="text" class="form-control CurrencyInput " name="value_concept"
                        data-type="currency" placeholder="Ingrese valor del concepto" value="">
                </div>
            </div>

        </div>

        <div class="col-4">
            <div class="form-group">
                <label for="value_concept">Valor venta</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-bold">
                            $
                        </span>
                    </div>
                    <input type="text" class="form-control CurrencyInput " name="value_sale" data-type="currency"
                        placeholder="Ingrese valor venta" value="0">
                </div>
            </div>

        </div>
        <div class="col-12 d-flex justify-content-center align-items-center pt-3 mb-2">
            <button class="btn btn-indigo" type="button" id="btnAddConcept" onclick="addConceptCustom(this)">
                Agregar
            </button>

        </div>

        <table class="table">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Concepto</th>
                    <th>Valor del concepto</th>
                    <th>Valor venta</th>
                    <th>x</th>
                </tr>
            </thead>
            <tbody id="tbodyAduanas">


            </tbody>
        </table>

        <div class="row w-100 mt-2">

            <div class="col-6 row justify-content-center align-items-center">

                <div class="row">
                    <label for="profit" class="col-sm-6 col-form-label text-success">Ganancia $$</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" id="profit" name="profit"
                            value="0.00" @readonly(true)>
                    </div>
                </div>

            </div>

            <div class="col-6 row flex-column">
                <div class="row">
                    <label for="custom_insurance" class="col-sm-6 col-form-label ">Total a cobrar:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" name="custom_insurance"
                            id="custom_insurance" value="0.00" @readonly(true)>
                    </div>
                </div>
                <div class="row">
                    <label for="sub_total_value_sale" class="col-sm-6 col-form-label">Total
                        venta / Sub Total:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" id="sub_total_value_sale"
                            name="sub_total_value_sale" value="0.00" @readonly(true)>
                    </div>
                </div>
                <div class="row">
                    <label for="igv" class="col-sm-6 col-form-label">IGV:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" id="igv" name="igv"
                            value="0.00" @readonly(true)>
                    </div>
                </div>
                <div class="row">
                    <label for="value_sale" class="col-sm-6 col-form-label">Total:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm" id="value_sale" name="value_sale"
                            value="0.00" @readonly(true)>
                    </div>
                </div>

            </div>

        </div>

    </div>


    <div class="col-12 text-center mt-5">
        <input class="btn btn-primary" onclick="submitCustomsForm(this)"
            value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
    </div>
</div>


@push('scripts')
    <script>
        let conceptsCustomArray = [];
        let countCustomConcepts = 0;
        let value_insurance_custom = 0;
        let valuea_added_insurance_custom = 0;
        let concepts = @json($concepts);
        let filteredConcepts = @json($filteredConcepts);
        let totalUtilityCustom = null;
        let TotalCustomsConcepts = 0;
        let TotalCustomNetAmount = 0;
        let conceptsCustom = @json($custom->concepts);

        $(document).ready(function() {

            conceptsCustom.forEach(concept => {
                conceptsCustomArray.push({
                    'id': concept.id,
                    'name': concept.name,
                    'value': parseFloat(concept.pivot.value_concept).toFixed(2),
                    'value_sale': parseFloat(concept.pivot.value_sale).toFixed(2),
                });

            });

            //Agregamos la utilidad dejada para orbe, para enviarlo al formulario:

            totalUtilityCustom = filteredConcepts.reduce((acc, concept) => acc + concept.value, 0);
            $('#value_utility').val(totalUtilityCustom);

            updateTableCustom(conceptsCustomArray);


        });



        $('.modalAduanas').on('hide.bs.modal', function(e) {
            conceptsCustomArray = {};
            TotalCustomsConcepts = 0;
            TotalCustomNetAmount = 0;
            value_insurance_custom = 0;
            valuea_value_sale_insurance_custom = 0;
            countConcepts = 0;

            updateTable(conceptsArray, e.target.id);

            $(`#${e.target.id}`).find('form')[0].reset();
            $('.contentInsurance').addClass('d-none').removeClass('d-flex');

        });

        function openModalConcept(firstModal, secondModal) {
            $(`#${firstModal}`).modal('hide');
            $(`#${firstModal}`).on('hidden.bs.modal', function() {
                $(`#${secondModal}`).modal('show');
            });
        }

        function closeToModalAddConcept(firstModal, secondModal) {
            $(`#${secondModal}`).modal('hide');
            $(`#${secondModal}`).on('hidden.bs.modal', function() {
                $(`#${firstModal}`).modal('show');
            });
        }


        function openToModal(modalId) {
            $(`#${modalId}`).modal('show');
        }

        function closeToModal(modalId) {
            $(`#${modalId}`).modal('hide');
        }


        function saveConceptToDatabase(data) {

            if (validateModalAddConcept()) {
                let data = $('#formAddConcept').find('input, select'); // Obtener los datos del formulario

                // Enviar el concepto al backend (guardar en la base de datos)
                $.ajax({
                    url: '/concepts/async', // Reemplaza con la ruta de tu backend
                    type: 'POST',
                    data: data, // Enviar los datos del concepto
                    success: function(response) {

                        const newOption = new Option(response.name, response.id, true,
                            true); // 'true' selecciona el concepto
                        $('#concept_aduana').append(newOption).trigger('change');

                        toastr.success("Concepto agregado");

                        closeToModal('modalAddConcept');
                        $('#formAddConcept #name').val('');

                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 400) {
                            toastr.error(xhr.responseJSON.error); // Mostrar el error retornado desde el backend
                        } else {
                            toastr.error("Error al guardar el concepto en la base de datos");
                        }
                    }
                });
            }
        }

        function validateModalAddConcept() {
            let isValid = true; // Bandera para saber si todo es válido
            const inputs = $('#formAddConcept').find('input, select'); // Obtener todos los inputs y selects
            inputs.each(function() {
                const input = $(this);
                // Si el campo es obligatorio
                if (input.val().trim() === '' || (input.is('select') && input.val() == null)) {
                    input.addClass('is-invalid'); // Agregar clase para marcar como inválido
                    isValid = false; // Si algún campo no es válido, marcar como false
                } else {
                    input.removeClass('is-invalid'); // Eliminar la clase de error si es válido
                }
            });

            return isValid; // Si todo es válido, devuelve true; si no, false
        }




        function addConceptCustom(buton) {

            let divConcepts = $('#formConceptsAduanas');
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

                const index = conceptsCustomArray.findIndex(item => item.id === parseInt(inputs[0].value));

                if (index !== -1) {

                    conceptsCustomArray[index] = {
                        'id': parseInt(inputs[0].value),
                        'name': inputs[0].options[inputs[0].selectedIndex].text,
                        'value': formatValue(inputs[1].value),
                        'value_sale': formatValue(inputs[2].value),
                    };

                } else {

                    conceptsCustomArray.push({
                        'id': parseInt(inputs[0].value),
                        'name': inputs[0].options[inputs[0].selectedIndex].text,
                        'value': formatValue(inputs[1].value),
                        'value_sale': formatValue(inputs[2].value),
                    });
                }

                updateTableCustom(conceptsCustomArray);

                inputs[0].value = '';
                inputs[1].value = '';
                inputs[2].value = '';
            }
        };

        function updateTableCustom(conceptsCustomArray) {

            let tbodyRouting = $(`#formConceptsAduanas`).find('tbody')[0];

            if (tbodyRouting) {

                tbodyRouting.innerHTML = '';
            }
            TotalCustomsConcepts = 0;
            TotalCustomNetAmount = 0;

            let contador = 0;

            for (let clave in conceptsCustomArray) {

                let item = conceptsCustomArray[clave];

                if (conceptsCustomArray.hasOwnProperty(clave)) {
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
                    let celdaValueSale = fila.insertCell(3);
                    if (filteredConcepts.some(concept => concept.name === item.name)) {
                        // Si customAgency existe, muestra un input editable
                        let inputValueSale = document.createElement('input');
                        inputValueSale.type = 'number';
                        inputValueSale.value = item.value_sale;
                        inputValueSale.min = 0;
                        inputValueSale.classList.add('form-control');
                        celdaValueSale.appendChild(inputValueSale);

                        inputValueSale.addEventListener('input', (e) => {
                            let newValue = parseFloat(e.target.value) || 0;

                            // Actualiza el valor en `conceptsCustomArray`
                            conceptsCustomArray[clave].value_sale = newValue;

                            TotalCustomsConcepts = 0; // Resetear total antes de recalcular
                            for (let item of Object.values(conceptsCustomArray)) {
                                TotalCustomsConcepts += parseFloat(item.value_sale); // Sumar los nuevos valores
                            }

                            calcCustomTotal(TotalCustomNetAmount, TotalCustomsConcepts, value_insurance_custom,
                                valuea_added_insurance_custom);


                        });
                    } else {
                        celdaValueSale.textContent = item.value_sale;
                    }



                    if (!filteredConcepts.some(concept => concept.name === item.name)) {

                        // Insertar un botón para eliminar la fila en la cuarta celda de la fila
                        let celdaEliminar = fila.insertCell(4);
                        let botonEliminar = document.createElement('a');
                        botonEliminar.href = '#';
                        botonEliminar.innerHTML = '<p class="text-danger">X</p>';
                        botonEliminar.addEventListener('click', function(event) {
                            event.preventDefault();

                            // Eliminar la fila correspondiente al hacer clic en el botón
                            let fila = this.parentNode.parentNode;
                            let indice = fila.rowIndex -
                                1; // Restar 1 porque el índice de las filas en tbody comienza en 0
                            conceptsCustomArray.splice(indice, 1);
                            updateTableCustom(conceptsCustomArray);
                        });
                        celdaEliminar.appendChild(botonEliminar);

                    }

                    TotalCustomNetAmount += parseFloat(item.value);
                    TotalCustomsConcepts += parseFloat(item.value_sale);
                }
            }

            calcCustomTotal(TotalCustomNetAmount, TotalCustomsConcepts, value_insurance_custom,
                valuea_added_insurance_custom);
            $('#TotalCustomNetAmount').val(TotalCustomNetAmount);

        }


        function calcCustomTotal(TotalCustomNetAmount, TotalCustomsConcepts, value_insurance_custom,
            valuea_added_insurance_custom) {


            let totalReceivable = TotalCustomNetAmount;
            let totalSale = TotalCustomsConcepts + valuea_added_insurance_custom;

            let inputTotal = $('#sub_total_value_sale');
            let btnGuardar = $('#btnGuardarCustom');


            let insurance = value_insurance_custom;
            let customInsuranceReceivable = insurance + totalReceivable;


            if (totalSale >= customInsuranceReceivable && customInsuranceReceivable > 0) {
                btnGuardar.prop('disabled', false);
            } else {
                btnGuardar.prop('disabled', true);
                btnGuardar.removeClass('btn-default');
            }

            //Sacamos el IGV

            let igv = totalSale * 0.18;
            let totalValueSale = totalSale + igv;


            let ganancia = totalSale - customInsuranceReceivable;
            if (ganancia < 0) ganancia = 0;

            inputTotal.val(totalSale.toFixed(2));
            $('#igv').val(igv.toFixed(2));
            $('#value_sale').val(totalValueSale.toFixed(2));
            $('#profit').val(ganancia.toFixed(2));

            /*  $('#cost_receivable').val(totalReceivable.toFixed(2)); */

            /*  $('#insurance_value').val((insurance).toFixed(2)); */
            $('#custom_insurance').val((customInsuranceReceivable).toFixed(2));

        }


        function formatValue(value) {
            // Verifica si el valor es una cadena (string)
            if (typeof value === 'string') {
                return value.replace(/,/g, '');
            }
            // Si es un número, simplemente lo retorna tal cual
            return value;
        }

        const preventeDefaultAction = (e) => {
            e.preventDefault();
        }


        function submitCustomsForm() {
            let form = $('#formCustom');
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

            console.log(form.find('.is-invalid'));


            if (camposInvalidos == 0) {

                let conceptops = JSON.stringify(conceptsCustomArray);

                form.append(`<input type="hidden" name="concepts" value='${conceptops}' />`);
                form[0].submit();
            }
        }
    </script>
@endpush
