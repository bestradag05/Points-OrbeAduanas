            {{-- Aduanas --}}
            <x-adminlte-modal id="modalAduanas" title="Aduana" size='lg' scrollable>

                <div class="form-group">
                    <label for="freight_value">Valor de aduanas</label>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text text-bold">
                                $
                            </span>
                        </div>
                        <input type="text" class="form-control CurrencyInput" id="freight_value" name="freight_value"
                            onchange="updateFleteTotal(this)" data-type="currency"
                            placeholder="Ingrese valor del flete">

                        @error('freight_value')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="seguroAduanasSwitch1"
                            onchange="enableInsurance(this)">
                        <label class="custom-control-label" for="seguroAduanasSwitch1">Agregar Seguro</label>
                    </div>
                </div>

                <div class="row d-none" id="contentInsurance">
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
                                    name="value_insurance" data-type="currency" placeholder="Ingrese valor de la carga"
                                    onchange="updateInsuranceTotal(this)">
                            </div>
                            @error('value_insurance')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                    </div>
                </div>


                <form id="formConceptsAduanas" class="formConcepts row">
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
                        <tbody id="tbodyRouting">


                        </tbody>
                    </table>

                </form>

                <div class="row w-100 justify-content-end">

                    <div class="col-4 row">
                        <label for="total" class="col-sm-4 col-form-label">Total:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="total" @readonly(true)>
                        </div>
                    </div>

                </div>

                <x-slot name="footerSlot">
                    <x-adminlte-button class=" btn-indigo" label="Guardar" />
                    <x-adminlte-button theme="secondary" label="cerrar" data-dismiss="modal" />
                </x-slot>

            </x-adminlte-modal>




            {{-- Flete --}}
            <x-adminlte-modal id="modalFlete" title="Flete" size='lg' scrollable>

                <div class="form-group">
                    <label for="freight_value">Valor del Flete</label>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text text-bold">
                                $
                            </span>
                        </div>
                        <input type="text" class="form-control CurrencyInput" id="freight_value" name="freight_value"
                            onchange="updateFleteTotal(this)" data-type="currency"
                            placeholder="Ingrese valor del flete">

                        @error('freight_value')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="seguroFleteSwitch1"
                            onchange="enableInsurance(this)">
                        <label class="custom-control-label" for="seguroFleteSwitch1">Agregar Seguro</label>
                    </div>
                </div>

                <div class="row d-none" id="contentInsurance">
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


                <form id="formConceptsFlete" class="formConcepts row">
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
                        <tbody id="tbodyRouting">


                        </tbody>
                    </table>

                </form>

                <div class="row w-100 justify-content-end">

                    <div class="col-4 row">
                        <label for="total" class="col-sm-4 col-form-label">Total:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="total" @readonly(true)>
                        </div>
                    </div>

                </div>

                <x-slot name="footerSlot">
                    <x-adminlte-button class=" btn-indigo" label="Guardar" />
                    <x-adminlte-button theme="secondary" label="cerrar" data-dismiss="modal" />
                </x-slot>

            </x-adminlte-modal>



            {{-- Seguro --}}
            <x-adminlte-modal id="modalSeguro" title="Seguro" size='lg' scrollable>

                <div class="form-group">
                    <label for="freight_value">Valor del Flete</label>

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

                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="seguroSwitch1"
                            onchange="enableInsurance(this)">
                        <label class="custom-control-label" for="seguroSwitch1">Agregar Seguro</label>
                    </div>
                </div>

                <div class="row d-none" id="contentInsurance">
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
                        <tbody id="tbodyRouting">


                        </tbody>
                    </table>

                </form>

                <div class="row w-100 justify-content-end">

                    <div class="col-4 row">
                        <label for="total" class="col-sm-4 col-form-label">Total:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="total" @readonly(true)>
                        </div>
                    </div>

                </div>

                <x-slot name="footerSlot">
                    <x-adminlte-button class=" btn-indigo" label="Guardar" />
                    <x-adminlte-button theme="secondary" label="cerrar" data-dismiss="modal" />
                </x-slot>

            </x-adminlte-modal>

            {{-- Transporte --}}
            <x-adminlte-modal id="modalTransporte" title="Transporte" size='lg' scrollable>

                <div class="form-group">
                    <label for="freight_value">Valor del Flete</label>

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

                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="seguroTransporteSwitch1"
                            onchange="enableInsurance(this)">
                        <label class="custom-control-label" for="seguroTransporteSwitch1">Agregar Seguro</label>
                    </div>
                </div>

                <div class="row d-none" id="contentInsurance">
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
                        <tbody id="tbodyRouting">


                        </tbody>
                    </table>

                </form>

                <div class="row w-100 justify-content-end">

                    <div class="col-4 row">
                        <label for="total" class="col-sm-4 col-form-label">Total:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="total" @readonly(true)>
                        </div>
                    </div>

                </div>

                <x-slot name="footerSlot">
                    <x-adminlte-button class=" btn-indigo" label="Guardar" />
                    <x-adminlte-button theme="secondary" label="cerrar" data-dismiss="modal" />
                </x-slot>

            </x-adminlte-modal>
