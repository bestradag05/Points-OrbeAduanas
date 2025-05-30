            {{-- Aduanas --}}
            <x-adminlte-modal id="modalAduanas" class="modal" title="Aduana" size='lg' scrollable>
                <form action="/routing_service" method="POST">
                    @csrf

                    <input type="hidden" name="nro_operation" value="{{ $routing->nro_operation }}">
                    <input type="hidden" name="typeService" id="typeService">

                    <div class="col-12">

                        <x-adminlte-select2 name="modality" id="modality" label="Modalidad"
                            data-placeholder="Seleccione un concepto...">
                            <option />
                            @foreach ($modalitys as $modality)
                                <option value="{{ $modality->id }}">{{ $modality->name }}</option>
                            @endforeach
                        </x-adminlte-select2>

                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="state_insurance" class="custom-control-input" id="seguroCustom"
                                onchange="enableInsurance(this)">
                            <label class="custom-control-label" for="seguroCustom">Agregar Seguro</label>
                        </div>
                    </div>
                    <hr>
                    <div class="row d-none justify-content-center" id="content_seguroCustom">
                        <div class="col-3">
                            <label for="type_insurance">Tipo de seguro</label>
                            <select name="type_insurance" class="d-none form-control" label="Tipo de seguro"
                                igroup-size="md" data-placeholder="Seleccione una opcion...">
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
                                    <input type="text" class="form-control CurrencyInput d-none "
                                        name="value_insurance" data-type="currency"
                                        placeholder="Ingrese valor de la carga" onchange="updateInsuranceTotal(this)">
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
                                        placeholder="Ingrese valor de la carga"
                                        onchange="updateInsuranceAddedTotal(this)">
                                </div>

                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="load_value">Puntos</label>

                                <div class="input-group">
                                    <input type="number" class="form-control d-none" id="insurance_points"
                                        name="insurance_points" min="0" onkeydown="preventeDefaultAction(event)"
                                        oninput="addPointsInsurance(this)">
                                </div>

                            </div>
                        </div>
                    </div>

                    <hr>
                    <div id="formConceptsAduanas" class="formConcepts row">
                        <div class="col-4">

                            <x-adminlte-select2 name="concept" id="concept_aduana" label="Conceptos"
                                data-placeholder="Seleccione un concepto...">
                                <option />
                                @foreach ($concepts as $concept)
                                    @if ($concept->typeService->name == 'Aduanas' && $routing->type_shipment->id == $concept->id_type_shipment)
                                        <option value="{{ $concept->id }}">{{ $concept->name }}</option>
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
                                    <input type="text" class="form-control CurrencyInput " name="value_concept"
                                        data-type="currency" placeholder="Ingrese valor del concepto" value="">
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
                            <button class="btn btn-indigo" type="button" id="btnAddConcept"
                                onclick="addConcept(this)">
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
                                    <th>x</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyAduanas">


                            </tbody>
                        </table>

                        <div class="row w-100 justify-content-end">

                            <div class="col-4 row">
                                <label for="total" class="col-sm-4 col-form-label">Total:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="total" name="totalCustom"
                                        value="0.00" @readonly(true)>
                                </div>
                            </div>

                        </div>


                    </div>

                    <x-slot name="footerSlot">
                        <x-adminlte-button class="btn btn-indigo" id="btnSubmit" type="submit"
                            onclick="submitForm(this)" label="Guardar" />
                        <x-adminlte-button theme="secondary" label="Cerrar" data-dismiss="modal" />
                    </x-slot>

                </form>
            </x-adminlte-modal>

            {{-- Flete --}}
            <x-adminlte-modal id="modalFlete" class="modal" title="Flete" size='lg' scrollable>
                <form action="/routing_service" method="POST">
                    @csrf

                    <input type="hidden" name="nro_operation" value="{{ $routing->nro_operation }}">
                    <input type="hidden" name="typeService" id="typeService">

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
                                    <input type="text" class="form-control CurrencyInput" id="utility"
                                        name="utility" data-type="currency"
                                        placeholder="Ingrese valor de la utilidad">

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="state_insurance" class="custom-control-input"
                                id="seguroFreight" onchange="enableInsurance(this)">
                            <label class="custom-control-label" for="seguroFreight">Agregar Seguro</label>
                        </div>
                    </div>

                    <hr>
                    <div class="row d-none justify-content-center" id="content_seguroFreight">
                        <div class="col-3">
                            <label for="type_insurance">Tipo de seguro</label>
                            <select name="type_insurance" class="d-none form-control" label="Tipo de seguro"
                                igroup-size="md" data-placeholder="Seleccione una opcion...">
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
                                    <input type="text" class="form-control CurrencyInput d-none "
                                        name="value_insurance" data-type="currency"
                                        placeholder="Ingrese valor de la carga" onchange="updateInsuranceTotal(this)">
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
                                    <input type="text" class="form-control CurrencyInput d-none"
                                        id="insurance_added" name="insurance_added" data-type="currency"
                                        value="0" placeholder="Ingrese valor de la carga"
                                        onchange="updateInsuranceAddedTotal(this)">
                                </div>

                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="load_value">Puntos</label>

                                <div class="input-group">
                                    <input type="number" class="form-control d-none" id="insurance_points"
                                        name="insurance_points" min="0"
                                        onkeydown="preventeDefaultAction(event)" oninput="addPointsInsurance(this)">
                                </div>

                            </div>
                        </div>
                    </div>

                    <hr>

                    <div id="formConceptsFlete" class="formConcepts row">
                        <div class="col-4">

                            <x-adminlte-select2 name="concept" id="concept_flete" label="Conceptos"
                                data-placeholder="Seleccione un concepto...">
                                <option />
                                @foreach ($concepts as $concept)
                                    @if ($concept->typeService->name == 'Flete' && $routing->type_shipment->id == $concept->id_type_shipment)
                                        <option value="{{ $concept->id }}">{{ $concept->name }}</option>
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
                                    <input type="text" class="form-control CurrencyInput " name="value_concept"
                                        data-type="currency" placeholder="Ingrese valor del concepto" value="">
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
                            <button class="btn btn-indigo" type="button" id="btnAddConcept"
                                onclick="addConcept(this)">
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
                                    <input type="text" class="form-control" name="total" id="total"
                                        value="0.00" @readonly(true)>
                                </div>
                            </div>

                        </div>

                    </div>

                    <x-slot name="footerSlot">
                        <x-adminlte-button class="btn btn-indigo" id="btnSubmit" type="submit"
                            onclick="submitForm(this)" label="Guardar" />
                        <x-adminlte-button theme="secondary" label="Cerrar" data-dismiss="modal" />
                    </x-slot>

                </form>

            </x-adminlte-modal>


            {{-- Transporte --}}
            <x-adminlte-modal id="modalTransporte" class="modal" title="Transporte" size='lg' scrollable>

                <form action="/routing_service" method="POST">
                    @csrf

                    <input type="hidden" name="nro_operation" value="{{ $routing->nro_operation }}">
                    <input type="hidden" name="typeService" id="typeService">
                    @if (isset($cost_transport))
                    <input type="hidden" name="quote_transport_id" id="quote_transport_id">
                    @endif

                    <div class="row">

                        <div class="col-4">
                            <div class="form-group">
                                <label for="transport_value">Valor del Transporte</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-bold">
                                            $
                                        </span>
                                    </div>
                                    <input type="text" class="form-control CurrencyInput" id="transport_value"
                                        name="transport_value" onchange="updateTransportTotal(this)"
                                        data-type="currency" placeholder="Ingrese valor del flete">

                                    @error('transport_value')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="load_value">Valor ha agregar</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-bold">
                                            $
                                        </span>
                                    </div>
                                    <input type="text" class="form-control CurrencyInput" id="transport_added"
                                        name="transport_added" data-type="currency"
                                        placeholder="Ingrese valor de la carga"
                                        onchange="updateTransportAddedTotal(this)">

                                </div>

                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="load_value">Puntos</label>

                                <div class="input-group">
                                    <input type="number" class="form-control" id="additional_points"
                                        name="additional_points" min="0"
                                        onkeydown="preventeDefaultAction(event)" oninput="addPointsTransport(this)">
                                </div>

                            </div>
                        </div>



                        <div class="col-4">

                            <div class="form-group">
                                <label for="origin">Recojo</label>
                                <input type="text" class="form-control" id="origin" name="origin"
                                    placeholder="Ingrese el origin">

                                @error('origin')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                            </div>

                        </div>
                        <div class="col-4">

                            <div class="form-group">
                                <label for="destination">Destino</label>

                                <input type="text" class="form-control" id="destination" name="destination"
                                    placeholder="Ingrese el destino">


                                @error('destination')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                            </div>

                        </div>
                        <div class="col-4">

                            <div class="form-group">
                                <label for="withdrawal_date">Fecha de retiro</label>

                                <input type="date" class="form-control" id="withdrawal_date" name="withdrawal_date"
                                    placeholder="Ingrese el destino">


                                @error('withdrawal_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                            </div>

                        </div>

                        <div id="formConceptsTransport" class="formConcepts row">

                            @if (!isset($cost_transport))
                                <div class="col-4">

                                    <x-adminlte-select2 name="concept" id="concept_transport" label="Conceptos"
                                        data-placeholder="Seleccione un concepto...">
                                        <option />
                                        @foreach ($concepts as $concept)
                                            @if ($concept->typeService->name == 'Transporte' && $routing->type_shipment->id == $concept->id_type_shipment)
                                                <option value="{{ $concept->id }}">{{ $concept->name }}</option>
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
                                            <input type="text" class="form-control CurrencyInput "
                                                name="value_concept" data-type="currency"
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
                                            <input type="text" class="form-control CurrencyInput "
                                                name="value_added" data-type="currency"
                                                placeholder="Ingrese valor agregado" value="0">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-12 d-flex justify-content-center align-items-center pt-3 mb-2">
                                    <button class="btn btn-indigo" type="button" id="btnAddConcept"
                                        onclick="addConcept(this)">
                                        Agregar
                                    </button>

                                </div>
                            @endif
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
                                        <input type="text" class="form-control" name="total" id="total"
                                            value="0.00" @readonly(true)>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                    <x-slot name="footerSlot">
                        <x-adminlte-button class="btn-indigo" label="Guardar" id="btnSubmit" type="submit"
                            onclick="submitForm(this)" />
                        <x-adminlte-button theme="secondary" label="cerrar" data-dismiss="modal" />
                    </x-slot>
                </form>
            </x-adminlte-modal>


            {{-- Seguro --}}
            <x-adminlte-modal id="modalSeguro" class="modal" title="Seguro" size='lg' scrollable>

                <form action="/routing_insurance" method="POST" id="form_insurance">
                    @csrf

                    <input type="hidden" name="typeService" id="typeService">
                    <input type="hidden" name="service_insurance" id="service_insurance">
                    <input type="hidden" name="id_insurable_service" id="id_insurable_service">

                    <div class="row justify-content-center" id="content_seguro">
                        <div class="col-3">
                            <label for="type_insurance">Tipo de seguro</label>
                            <select name="type_insurance" class="form-control" label="Tipo de seguro"
                                igroup-size="md" data-placeholder="Seleccione una opcion...">
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
                                    <input type="text" class="form-control CurrencyInput" name="value_insurance"
                                        data-type="currency" placeholder="Ingrese valor de la carga">
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
                                    <input type="text" class="form-control CurrencyInput" id="insurance_added"
                                        name="insurance_added" data-type="currency" value="0"
                                        placeholder="Ingrese valor de la carga"
                                        onchange="updateInsuranceAddedTotal(this)">
                                </div>

                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="load_value">Puntos</label>

                                <div class="input-group">
                                    <input type="number" class="form-control" id="insurance_points"
                                        name="insurance_points" min="0"
                                        onkeydown="preventeDefaultAction(event)" oninput="addPointsInsurance(this)">
                                </div>

                            </div>
                        </div>
                    </div>

                    <x-slot name="footerSlot">
                        <x-adminlte-button class="btn-indigo" label="Guardar" id="btnSubmit" type="submit"
                            onclick="submitFormInsurance(this)" />
                        <x-adminlte-button theme="secondary" label="cerrar" data-dismiss="modal" />
                    </x-slot>
                </form>
            </x-adminlte-modal>
