<div class="row">

{{--     <input type="hidden" name="nro_operation" value="{{ $routing->nro_operation }}">
    <input type="hidden" name="typeService" id="typeService"> --}}

    <div class="row">

        <div class="col-12">

            <div class="form-group">
                <label for="utility">Utilidad Orbe</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-bold">
                            $
                        </span>
                    </div>
                    <input type="text" class="form-control CurrencyInput" id="utility" name="utility"
                        data-type="currency" placeholder="Ingrese valor de la utilidad">

                </div>

            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="custom-control custom-switch">
            <input type="checkbox" name="state_insurance" class="custom-control-input" id="seguroFreight"
                onchange="enableInsurance(this)">
            <label class="custom-control-label" for="seguroFreight">Agregar Seguro</label>
        </div>
    </div>

    <hr>
    <div class="row d-none justify-content-center" id="content_seguroFreight">
        <div class="col-3">
            <label for="type_insurance">Tipo de seguro</label>
            {{-- <select name="type_insurance" class="d-none form-control" label="Tipo de seguro" igroup-size="md"
                data-placeholder="Seleccione una opcion...">
                <option />
                @foreach ($type_insurace as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select> --}}
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

    <hr>

    <div id="formConceptsFlete" class="formConcepts row">
        <div class="col-4">

           {{--  <x-adminlte-select2 name="concept" id="concept_flete" label="Conceptos"
                data-placeholder="Seleccione un concepto...">
                <option />
                @foreach ($concepts as $concept)
                    @if ($concept->typeService->name == 'Flete' && $routing->type_shipment->id == $concept->id_type_shipment)
                        <option value="{{ $concept->id }}">{{ $concept->name }}</option>
                    @endif
                @endforeach
            </x-adminlte-select2> --}}

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
            $('#reguralization').datetimepicker({
                format: 'L'
            });
        </script>
    @endpush
