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

                    <div id="formConceptsAduanas" class="formConcepts row">
                        
                        <div class="col-4">

                            <div class="form-group">

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

                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="value_concept">Valor del Concepto</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-bold">
                                            $
                                        </span>
                                    </div>
                                    <input type="text" class="form-control CurrencyInput " name="value_concept"
                                        data-type="currency" placeholder="Ingrese valor de la carga" value="">
                                </div>
                            </div>

                        </div>
                        <div class="col-4 d-flex align-items-center pt-3">
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
                            <tbody id="tbodyAduanas">


                            </tbody>
                        </table>

                        <div class="row w-100 justify-content-end">

                            <div class="col-4 row">
                                <label for="total" class="col-sm-4 col-form-label">Total:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="total" value="0.00"
                                        @readonly(true)>
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

                        {{-- <div class="col-6">
                            <div class="form-group">

                                @if ($routing->type_shipment->code == 235)
                                    <label for="air_freight">Air Freight</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text text-bold">
                                                $
                                            </span>
                                        </div>
                                        <input type="text" class="form-control CurrencyInput" id="air_freight"
                                            name="air_freight" onchange="updateFleteTotal(this)" data-type="currency"
                                            placeholder="Ingrese valor del flete">
                                    </div>
                                @elseif($routing->type_shipment->code == 118)
                                    <label for="ocean_freight">Ocean Freight</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text text-bold">
                                                $
                                            </span>
                                        </div>
                                        <input type="text" class="form-control CurrencyInput" id="freight_value"
                                            name="freight_value" onchange="updateFleteTotal(this)" data-type="currency"
                                            placeholder="Ingrese valor del flete">

                                        @error('freight_value')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif
                            </div>

                        </div> --}}

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
                                        name="utility" data-type="currency" placeholder="Ingrese valor de la utilidad">

                                </div>

                            </div>
                        </div>
                    </div>



                    <div id="formConceptsFlete" class="formConcepts row">
                        <div class="col-4">

                            <x-adminlte-select2 name="concept" id="concept_flete" label="Conceptos"
                                data-placeholder="Seleccione un concepto...">
                                <option />
                                @foreach ($concepts as $concept)
                                    @if($concept->typeService->name == 'Flete' && $routing->type_shipment->id == $concept->id_type_shipment)
                                        <option value="{{ $concept->id }}">{{ $concept->name }}</option>
                                    @endif
                                @endforeach
                            </x-adminlte-select2>

                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="value_concept">Valor del Concepto</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-bold">
                                            $
                                        </span>
                                    </div>
                                    <input type="text" class="form-control CurrencyInput " name="value_concept"
                                        data-type="currency" placeholder="Ingrese valor de la carga" value="">
                                </div>
                            </div>

                        </div>
                        <div class="col-4 d-flex align-items-center pt-3">
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

            {{-- Seguro --}}
            <x-adminlte-modal id="modalSeguro" class="modal" title="Seguro" size='lg' scrollable>

                <div class="form-group">
                    <label for="insurance_value">Valor del Seguro</label>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text text-bold">
                                $
                            </span>
                        </div>
                        <input type="text" class="form-control CurrencyInput" id="insurance_value"
                            name="insurance_value" onchange="updateFleteTotal(this)" data-type="currency"
                            placeholder="Ingrese valor del flete">

                        @error('insurance_value')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="seguroSwitch1"
                            onchange="enableInsurance(this)">
                        <label class="custom-control-label" for="seguroSwitch1">Agregar Seguro</label>
                    </div>
                </div>

                <div class="row d-none" id="content_seguroSwitch1">
                    <div class="col-6">
                        <x-adminlte-select2 name="type_insurance" label="Tipo de seguro" igroup-size="md"
                            data-placeholder="Seleccione una opcion...">
                            <option />
                            <option>Seguro A</option>
                            <option>Seguro B</option>
                        </x-adminlte-select2>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="load_value">Valor del seguro</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span
                                        class="input-group-text text-bold @error('value_insurance') is-invalid @enderror">
                                        $
                                    </span>
                                </div>
                                <input type="text"
                                    class="form-control CurrencyInput @error('value_insurance') is-invalid @enderror "
                                    name="value_insurance" data-type="currency"
                                    placeholder="Ingrese valor de la carga" onchange="updateInsuranceTotal(this)">
                            </div>
                            @error('value_insurance')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                    </div>
                </div>


                <form id="formConceptsSeguro" class="formConcepts row">
                    <div class="col-4">

                        <div class="form-group">
                            <label for="concept">Concepto</label>
                            <input type="text" class="form-control" id="concept" name="concept"
                                placeholder="Ingrese el concept">
                        </div>

                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="value_concept">Valor del Concepto</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-bold">
                                        $
                                    </span>
                                </div>
                                <input type="text" class="form-control CurrencyInput " name="value_concept"
                                    data-type="currency" placeholder="Ingrese valor de la carga" value="">
                            </div>
                        </div>

                    </div>
                    <div class="col-4 d-flex align-items-center pt-3">
                        <button class="btn btn-indigo" type="submit">
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
                        <tbody id="tbodySeguro">


                        </tbody>
                    </table>

                    <div class="row w-100 justify-content-end">

                        <div class="col-4 row">
                            <label for="total" class="col-sm-4 col-form-label">Total:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="total" value="0.00"
                                    @readonly(true)>
                            </div>
                        </div>

                    </div>

                </form>

                <x-slot name="footerSlot">
                    <x-adminlte-button class=" btn-indigo" label="Guardar" />
                    <x-adminlte-button theme="secondary" label="cerrar" data-dismiss="modal" />
                </x-slot>

            </x-adminlte-modal>

            {{-- Transporte --}}
            <x-adminlte-modal id="modalTransporte" class="modal" title="Transporte" size='lg' scrollable>

                <div class="form-group">
                    <label for="transport_value">Valor del Transporte</label>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text text-bold">
                                $
                            </span>
                        </div>
                        <input type="text" class="form-control CurrencyInput" id="transport_value"
                            name="transport_value" onchange="updateFleteTotal(this)" data-type="currency"
                            placeholder="Ingrese valor del flete">

                        @error('transport_value')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="seguroTransporteSwitch1"
                            onchange="enableInsurance(this)">
                        <label class="custom-control-label" for="seguroTransporteSwitch1">Agregar Seguro</label>
                    </div>
                </div>

                <div class="row d-none" id="content_seguroTransporteSwitch1">
                    <div class="col-6">
                        <x-adminlte-select2 name="type_insurance" label="Tipo de seguro" igroup-size="md"
                            data-placeholder="Seleccione una opcion...">
                            <option />
                            <option>Seguro A</option>
                            <option>Seguro B</option>
                        </x-adminlte-select2>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="load_value">Valor del seguro</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span
                                        class="input-group-text text-bold @error('value_insurance') is-invalid @enderror">
                                        $
                                    </span>
                                </div>
                                <input type="text"
                                    class="form-control CurrencyInput @error('value_insurance') is-invalid @enderror "
                                    name="value_insurance" data-type="currency"
                                    placeholder="Ingrese valor de la carga" onchange="updateInsuranceTotal(this)">
                            </div>
                            @error('value_insurance')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                    </div>
                </div>


                <form id="formConceptsTransporte" class="formConcepts row">
                    <div class="col-4">

                        <div class="form-group">
                            <label for="concept">Concepto</label>
                            <input type="text" class="form-control" id="concept" name="concept"
                                placeholder="Ingrese el concept">
                        </div>

                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="value_concept">Valor del Concepto</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-bold">
                                        $
                                    </span>
                                </div>
                                <input type="text" class="form-control CurrencyInput " name="value_concept"
                                    data-type="currency" placeholder="Ingrese valor de la carga" value="">
                            </div>
                        </div>

                    </div>
                    <div class="col-4 d-flex align-items-center pt-3">
                        <button class="btn btn-indigo" type="submit">
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
                        <tbody id="tbodyTransporte">


                        </tbody>
                    </table>

                    <div class="row w-100 justify-content-end">

                        <div class="col-4 row">
                            <label for="total" class="col-sm-4 col-form-label">Total:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="total" value="0.00"
                                    @readonly(true)>
                            </div>
                        </div>

                    </div>

                </form>

                <x-slot name="footerSlot">
                    <x-adminlte-button class=" btn-indigo" label="Guardar" />
                    <x-adminlte-button theme="secondary" label="cerrar" data-dismiss="modal" />
                </x-slot>

            </x-adminlte-modal>
