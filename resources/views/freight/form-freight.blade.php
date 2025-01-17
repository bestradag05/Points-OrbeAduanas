<div class="row">

    <input type="hidden" name="nro_operation" value="{{ $quote->nro_operation }}">
    <input type="hidden" name="id_quote_freight" value="{{ $quote->id }}">
    {{-- <input type="hidden" name="typeService" id="typeService"> --}}


    <div class="col-6 offset-3">

        <div class="form-group">
            <label for="utility">Utilidad Orbe</label>

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text text-bold">
                        $
                    </span>
                </div>
                <input type="text" class="form-control CurrencyInput" id="utility" name="utility"
                    data-type="currency" @readonly(true) placeholder="Ingrese valor de la utilidad"
                    value="{{ isset($quote->utility) ? $quote->utility : old('utility') }}">

            </div>

        </div>
    </div>


    <div class=" col-12 form-group">
        <div class="custom-control custom-switch">
            <input type="checkbox" name="state_insurance" class="custom-control-input" id="seguroFreight"
                onchange="enableInsurance(this)">
            <label class="custom-control-label" for="seguroFreight">Agregar Seguro</label>
        </div>
    </div>

    <hr>
    <div class="col-12 row d-none justify-content-center" id="content_seguroFreight">
        <div class="col-3">
            <label for="type_insurance">Tipo de seguro</label>
            <select name="type_insurance" class="d-none form-control" label="Tipo de seguro" igroup-size="md"
                data-placeholder="Seleccione una opcion...">
                <option />
                @foreach ($type_insurace as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label for="load_value">Valor del seguro</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-bold">
                            $
                        </span>
                    </div>
                    <input type="text" class="form-control CurrencyInput d-none " name="value_insurance"
                        data-type="currency" placeholder="Ingrese valor de la carga"
                        onchange="updateInsuranceTotal(this)">
                </div>

            </div>
        </div>

        <div class="col-3">
            <div class="form-group">
                <label for="load_value">Valor ha agregar</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-bold">
                            $
                        </span>
                    </div>
                    <input type="text" class="form-control CurrencyInput d-none" id="insurance_added"
                        name="insurance_added" data-type="currency" value="0"
                        placeholder="Ingrese valor de la carga" onchange="updateInsuranceAddedTotal(this)">
                </div>

            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label for="load_value">Puntos</label>

                <div class="input-group">
                    <input type="number" class="form-control d-none" id="insurance_points" name="insurance_points"
                        min="0" onkeydown="preventeDefaultAction(event)" oninput="addPointsInsurance(this)">
                </div>

            </div>
        </div>
    </div>

    <div class="col-12">
        <hr>
    </div>

    <div id="formConceptsFlete" class="formConcepts row">
        <div class="col-4">

            <x-adminlte-select2 name="concept" id="concept_flete" label="Conceptos"
                data-placeholder="Seleccione un concepto...">
                <option />
                @foreach ($concepts as $concept)
                    @if ($concept->typeService->name == 'Flete' && $quote->routing->type_shipment->id == $concept->id_type_shipment)
                        @if ($conceptFreight->name != $concept->name)
                            <option value="{{ $concept->id }}">{{ $concept->name }}</option>
                        @endif
                    @endif
                @endforeach
            </x-adminlte-select2>

        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="value_concept">Valor del neto del concepto</label>
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

        <div class="col-4">
            <div class="form-group">
                <label for="value_concept">Valor ha agregar</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-bold">
                            $
                        </span>
                    </div>
                    <input type="text" class="form-control CurrencyInput " name="value_added"
                        data-type="currency" placeholder="Ingrese valor agregado" value="0">
                </div>
            </div>

        </div>
        <div class="col-12 d-flex justify-content-center align-items-center pt-3 mb-2">
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
                    <th>Valor agregado</th>
                    <th>Puntos Adicionales</th>
                    <th>x</th>
                </tr>
            </thead>
            <tbody id="tbodyFlete">


            </tbody>
        </table>


        <div class="row w-100 justify-content-end">

            <div class="col-4 row">
                <label for="total" class="col-sm-4 col-form-label">Total:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="total" id="total" value="0.00"
                        @readonly(true)>
                </div>
            </div>

        </div>

    </div>

    <x-slot name="footerSlot">
        <x-adminlte-button class="btn btn-indigo" id="btnSubmit" type="submit" onclick="submitForm(this)"
            label="Guardar" />
        <x-adminlte-button theme="secondary" label="Cerrar" data-dismiss="modal" />
    </x-slot>



    <div class="container text-center mt-5">
        <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
    </div>

    @push('scripts')
        <script>
            let conceptsArray = {};
            let TotalConcepts = 0;
            let total = 0;
            let flete = 0;
            let value_insurance = 0;
            let valuea_added_insurance = 0;
            let countConcepts = 0;

            let value_ocean_freight = @json($quote->total_ocean_freight);
            let conceptFreight = @json($conceptFreight);

            conceptsArray[countConcepts] = {
                'id': conceptFreight.id,
                'name': conceptFreight.name,
                'value': formatValue(value_ocean_freight),
                'added': 0,
            }

            countConcepts++
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

                    /*  value_insurance = 0;
                     valuea_added_insurance = 0; */

                    /*  calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, container.id); */

                }
            }

            function updateInsuranceTotal(element) {
                if (element.value === '') {
                    value_insurance = 0;
                } else {
                    value_insurance = parseFloat(element.value.replace(/,/g, ''));
                }

                calcTotal(TotalConcepts, value_insurance, valuea_added_insurance);
            }


            function updateInsuranceAddedTotal(element) {

                if (element.value === '') {
                    valuea_added_insurance = 0;
                } else {
                    valuea_added_insurance = parseFloat(element.value.replace(/,/g, ''));
                }

                console.log("Valor agregado : ", valuea_added_insurance);
                //Cada que actualicemos el insurance_add borramos los puntos para poder volver a generar un maximo.
                $(`#insurance_points`).val("");

                calcTotal(TotalConcepts, value_insurance, valuea_added_insurance);
            }


            function calcTotal(TotalConcepts, value_insurance, valuea_added_insurance) {

                console.log(valuea_added_insurance);

                total = TotalConcepts + value_insurance + valuea_added_insurance;

                //Buscamos dentro del contenedor el campo total

                let inputTotal = $('#total');

                inputTotal.val(total.toFixed(2));

            }


            const addPointsInsurance = (input) => {

                let value_added = 0;


                value_added = $(`#insurance_added`).val();


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

                    conceptsArray[countConcepts] = {
                        'id': parseInt(inputs[0].value),
                        'name': inputs[0].options[inputs[0].selectedIndex].text,
                        'value': formatValue(inputs[1].value),
                        'added': formatValue(inputs[2].value),
                    }

                    countConcepts++;

                    updateTable(conceptsArray);

                    inputs[0].value = '';
                    inputs[1].value = '';
                    inputs[2].value = '';
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

                        let celdaAdded = fila.insertCell(3);


                        if (item.name === "OCEAN FREIGHT") {
                            // Si ocean_freight existe, muestra un input editable
                            let inputAdded = document.createElement('input');
                            inputAdded.type = 'text';
                            inputAdded.value = item.added;
                            inputAdded.classList.add('form-control', 'CurrencyInput'); // Agregar clases
                            inputAdded.setAttribute('data-type', 'currency'); // Establecer el atributo data-type
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

                                calcTotal(TotalConcepts, value_insurance, valuea_added_insurance);

                            });
                        } else {
                            // Si ocean_freight no existe, muestra el valor como texto plano
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

                        inputPA.addEventListener('keydown', (e) => {
                            // Permitimos solo las flechas (arriba: 38, abajo: 40), Tab (9), Enter (13)
                            const allowedKeys = ['ArrowUp', 'ArrowDown', 'Tab', 'Enter'];
                            if (!allowedKeys.includes(e.key)) {
                                e.preventDefault();
                            }
                        });


                        inputPA.addEventListener('input', (e) => {



                            conceptsArray[clave].pa = e.target.value


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



                        if (item.name != "OCEAN FREIGHT") {

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
                                updateTable(conceptsArray);
                            });
                            celdaEliminar.appendChild(botonEliminar);

                        }



                        TotalConcepts += parseFloat(item.value) + parseFloat(item.added);
                    }
                }

                calcTotal(TotalConcepts, value_insurance, valuea_added_insurance);



            }


            function calculateTotal(conceptsArray) {
                return Object.values(conceptsArray).reduce((acc, concept) => {
                    return acc + parseFloat(concept.value || 0) + parseFloat(concept.added || 0);
                }, 0);
            }


            function formatValue(value) {
                return value.replace(/,/g, '');
            }


            $('#formFreight').on('submit', (e) => {

                e.preventDefault();

                let form = $('#formFreight');
                let conceptops = JSON.stringify(conceptsArray);

                form.append(`<input type="hidden" name="concepts" value='${conceptops}' />`);

                form[0].submit();

            });
        </script>
    @endpush
