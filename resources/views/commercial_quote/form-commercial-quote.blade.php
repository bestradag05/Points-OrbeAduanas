                <div id="step0" class="content">
                    <div class="row">
                        <div class="col-6 transporte-hide">

                            <label for="origin">Origen <span class="text-danger">*</span></label>

                            <x-adminlte-select2 name="origin" igroup-size="md" data-placeholder="Seleccione una opcion..."
                                data-required="true">
                                <option />
                                @foreach ($stateCountrys as $stateCountry)
                                    <option value="{{ $stateCountry->id }}"
                                        {{ old('origin') == $stateCountry->id ? 'selected' : '' }}>
                                        {{ $stateCountry->country->name . ' - ' . $stateCountry->name }}
                                    </option>
                                @endforeach
                            </x-adminlte-select2>

                        </div>
                        <div class="col-6 transporte-hide">

                            <label for="destination">Destino <span class="text-danger">*</span></label>

                            <x-adminlte-select2 name="destination" igroup-size="md"
                                data-placeholder="Seleccione una opcion..." data-required="true">
                                <option />
                                @foreach ($stateCountrys as $stateCountry)
                                    <option value="{{ $stateCountry->id }}"
                                        {{ old('destination') == $stateCountry->id ? 'selected' : '' }}>
                                        {{ $stateCountry->country->name . ' - ' . $stateCountry->name }}
                                    </option>
                                @endforeach
                            </x-adminlte-select2>

                        </div>

                        <div class="col-6">
                            <div class="row" id="lclfcl_content">
                                <div class=" {{ old('lcl_fcl') || isset($routing->lcl_fcl) ? 'col-8' : 'col-12' }}">
                                    <label for="id_type_shipment">Tipo de embarque <span
                                            class="text-danger">*</span></label>
                                    <x-adminlte-select2 name="id_type_shipment" igroup-size="md"
                                        data-placeholder="Seleccione una opcion..." data-required="true">
                                        <option />
                                        @foreach ($type_shipments as $type_shipment)
                                            <option value="{{ $type_shipment->id }}"
                                                {{ (isset($routing->id_type_shipment) && $routing->id_type_shipment == $type_shipment->id) || old('id_type_shipment') == $type_shipment->id ? 'selected' : '' }}>
                                                {{ $type_shipment->name }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select2>
                                </div>

                                <div id="contenedor_radio_lcl_fcl"
                                    class="col-4 row align-items-center {{ old('lcl_fcl') || isset($routing->lcl_fcl) ? '' : 'd-none' }}">
                                    <div class="col-6 form-check text-center">
                                        <input type="radio" id="radioLcl" name="lcl_fcl" value="LCL"
                                            {{ (isset($routing->lcl_fcl) && $routing->lcl_fcl === 'LCL') || old('lcl_fcl') === 'LCL' ? 'checked' : '' }}
                                            class="form-check-input @error('lcl_fcl') is-invalid @enderror">
                                        <label for="radioLclFcl" class="form-check-label">
                                            LCL
                                        </label>
                                    </div>
                                    <div class="col-6 form-check text-center">
                                        <input type="radio" id="radioFcl" name="lcl_fcl" value="FCL"
                                            {{ (isset($routing->lcl_fcl) && $routing->lcl_fcl === 'FCL') || old('lcl_fcl') === 'FCL' ? 'checked' : '' }}
                                            class="form-check-input @error('lcl_fcl') is-invalid @enderror">
                                        <label for="radioLclFcl" class="form-check-label">
                                            FCL
                                        </label>
                                    </div>
                                </div>

                            </div>


                        </div>

                        <div class="col-6 transporte-hide">
                            <div class="row">
                                <div class="col-12">
                                    <label for="id_customs_district">Circunscripción - Aduana</label>
                                    <x-adminlte-select2 name="id_customs_district" igroup-size="md"
                                        data-placeholder="Seleccione una opcion..." data-required="true">
                                        <option />
                                        @foreach ($customsDistricts as $customDistrict)
                                            <option value="{{ $customDistrict->id }}"
                                                {{ (isset($routing->id_customs_district) && $routing->id_customs_district == $customDistrict->id) || old('id_customs_district') == $customDistrict->id ? 'selected' : '' }}>
                                                {{ $customDistrict->code . ' - ' . $customDistrict->name }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select2>
                                </div>

                            </div>

                        </div>


                        <div class="col-6">

                            <label for="id_type_load">Tipo de carga <span class="text-danger">*</span></label>

                            <x-adminlte-select2 name="id_type_load" igroup-size="md"
                                data-placeholder="Seleccione una opcion..." data-required="true">
                                <option />
                                @foreach ($type_loads as $type_load)
                                    <option value="{{ $type_load->id }}"
                                        {{ (isset($routing->id_type_load) && $routing->id_type_load == $type_load->id) || old('id_type_load') == $type_load->id ? 'selected' : '' }}>
                                        {{ $type_load->name }}
                                    </option>
                                @endforeach
                            </x-adminlte-select2>
                        </div>

                        <div class="col-6 transporte-hide">

                            <label for="id_regime">Regimen <span class="text-danger">*</span></label>

                            <x-adminlte-select2 name="id_regime" igroup-size="md"
                                data-placeholder="Seleccione una opcion..." data-required="true">
                                <option />
                                @foreach ($regimes as $regime)
                                    <option value="{{ $regime->id }}"
                                        {{ (isset($routing->id_regime) && $routing->id_regime == $regime->id) || old('id_regime') == $regime->id ? 'selected' : '' }}>
                                        {{ $regime->code . ' - ( ' . $regime->description . ' )' }}
                                    </option>
                                @endforeach
                            </x-adminlte-select2>
                        </div>

                        <div class="col-6 transporte-hide">
                            <label for="id_incoterms">Incoterm <span class="text-danger">*</span></label>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#incotermModal">
                                <i class="fas fa-info-circle"></i>
                            </a>
                            <x-adminlte-select2 id="incoterms" name="id_incoterms" igroup-size="md"
                                data-placeholder="Seleccione una opcion..." onchange="toggleExwPickupAddress(this)"
                                data-required="true">
                                <option />
                                @foreach ($incoterms as $incoter)
                                    <option value="{{ $incoter->id }}" data-code="{{ $incoter->code }}"
                                        {{ (isset($routing->id_incoterms) && $routing->id_incoterms == $incoter->id) || old('id_incoterms') == $incoter->id ? 'selected' : '' }}>
                                        {{ $incoter->code }} ({{ $incoter->name }})
                                    </option>
                                @endforeach
                            </x-adminlte-select2>
                        </div>

                        <div class="col-6 transporte-hide row align-items-center justify-content-center">
                            <div class="form-group mb-0">
                                <label>¿Es consolidado?</label>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="consolidadoSi" name="is_consolidated" value="1"
                                        class="form-check-input" onchange="toggleConsolidatedSection()"
                                        {{ old('is_consolidated') === '1' ? 'checked' : '' }}>
                                    <label for="consolidadoSi" class="form-check-label">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="consolidadoNo" name="is_consolidated" value="0"
                                        class="form-check-input" onchange="toggleConsolidatedSection()"
                                        {{ !old('is_consolidated') || old('is_consolidated') === '0' ? 'checked' : '' }}>
                                    <label for="consolidadoNo" class="form-check-label">No</label>
                                </div>
                            </div>
                        </div>

                        <div id="div_supplier_data"
                            class="col-12 row transporte-hide {{ old('pickup_address_at_origin') || isset($routing->pickup_address_at_origin) ? '' : 'd-none' }}">
                            <div class="col-12">
                                <hr>
                            </div>
                            <div class="col-12 my-4">
                                <p class="text-muted text-center mb-0">*Dirección de recojo para realizar el pickup en
                                    origen*</p>
                                <div class="form-group">
                                    <label for="pickup_address_at_origin">Direccion de recojo</label>
                                    <input type="text"
                                        class="form-control @error('pickup_address_at_origin') is-invalid @enderror "
                                        name="pickup_address_at_origin" id="pickup_address_at_origin"
                                        placeholder="Ingrese la dirección de recojo"
                                        value="{{ isset($routing->pickup_address_at_origin) ? $routing->pickup_address_at_origin : old('pickup_address_at_origin') }}">

                                    @error('pickup_address_at_origin')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                        </div>


                        <div class="col-12 row justify-content-center align-items-center text-center mt-3">
                            <div class="form-group text-indigo">
                                <label class="col-12">¿Es cliente o prospecto?</label>
                                <div class="form-check form-check-inline mt-2">
                                    <input type="radio" id="customer" name="is_customer_prospect"
                                        value="customer" class="form-check-input"
                                        onchange="toggleCustomerProspectSection()"
                                        {{ old('is_customer_prospect') === 'customer' || $errors->has('id_customer') ? 'checked' : '' }}>
                                    <label for="customer" class="form-check-label">Cliente</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="prospect" name="is_customer_prospect"
                                        value="prospect" class="form-check-input"
                                        onchange="toggleCustomerProspectSection()"
                                        {{ old('is_customer_prospect') === 'prospect' || (!old('is_customer_prospect') && !$errors->has('id_customer')) ? 'checked' : '' }}>
                                    <label for="prospect" class="form-check-label">Prospecto</label>
                                </div>
                            </div>
                        </div>

                        <div id="contentProspect"
                            class="col-12 row {{ old('is_customer_prospect') === 'customer' || $errors->has('id_customer') ? 'd-none' : '' }}">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="customer_company_name">Razon social / Nombre</label>

                                    <div class="input-group">
                                        <input type="text"
                                            class="form-control @error('customer_company_name') is-invalid @enderror "
                                            name="customer_company_name" id="customer_company_name"
                                            data-required="true" placeholder="Ingrese valor de la carga"
                                            value="{{ isset($routing->customer_company_name) ? $routing->customer_company_name : old('customer_company_name') }}">
                                    </div>
                                    @error('customer_company_name')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="contact">Contacto</label>
                                    <input type="text" class="form-control @error('contact') is-invalid @enderror"
                                        id="contact" name="contact" placeholder="Ingrese su numero de celular"
                                        data-optional="true"
                                        value="{{ isset($customer->contact) ? $customer->contact : old('contact') }}">
                                    @error('contact')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-6">
                                <div class="form-group">
                                    <label for="cellphone">Celular</label>
                                    <input type="text"
                                        class="form-control @error('cellphone') is-invalid @enderror" id="cellphone"
                                        name="cellphone" placeholder="Ingrese su numero de celular"
                                        data-optional="true"
                                        value="{{ isset($customer->cellphone) ? $customer->cellphone : old('cellphone') }}">
                                    @error('cellphone')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-6">

                                <div class="form-group">
                                    <label for="email">Correo</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="Ingrese su numero de celular"
                                        data-optional="true"
                                        value="{{ isset($customer->email) ? $customer->email : old('email') }}">
                                    @error('email')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div id="contentCustomer"
                            class="col-12 row justify-content-center {{ old('is_customer_prospect') === 'customer' || $errors->has('id_customer') ? '' : 'd-none' }}">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="id_customer">Cliente <span class="text-danger">*</span></label>

                                    <x-adminlte-select2 name="id_customer" igroup-size="md"
                                        data-placeholder="Seleccione una opcion...">
                                        <option />
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                {{ (isset($routing->id_customer) && $routing->id_customer == $customer->id) || old('id_customer') == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name_businessname }} -
                                                {{ $customer->document->name }}:{{ $customer->document_number }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select2>

                                </div>
                            </div>

                        </div>


                    </div>

                    <button class="btn btn-primary mt-3" onclick="stepperCommercialQuote.next()">Siguiente</button>
                </div>
                <div id="step1" class="content">

                    <div id="lcl_container" class="lcl-fields">

                        <div id="singleProviderSection">

                            <div class="form-group row">
                                <label for="commodity" class="col-sm-2 col-form-label">Producto <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" data-required="true"
                                        class="form-control @error('commodity') is-invalid @enderror" id="commodity"
                                        name="commodity" placeholder="Ingrese el producto.."
                                        value="{{ isset($routing->commodity) ? $routing->commodity : old('commodity') }}">
                                    @error('commodity')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row my-4">

                                <div class="col-4">
                                    <div class="form-group row">
                                        <label for="load_value" class="col-sm-4 col-form-label">Valor de factura <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span
                                                        class="input-group-text text-bold @error('load_value') is-invalid @enderror">
                                                        $
                                                    </span>
                                                </div>
                                                <input type="text" data-required="true"
                                                    class="form-control CurrencyInput @error('load_value') is-invalid @enderror "
                                                    name="load_value" data-type="currency"
                                                    placeholder="Ingrese valor de la carga"
                                                    value="{{ isset($routing->load_value) ? $routing->load_value : old('load_value') }}">
                                            </div>
                                            @error('load_value')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group row">
                                        <label for="nro_package" class="col-sm-4 col-form-label">N° Paquetes / Bultos
                                            <span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="number" min="0" step="1" data-required="true"
                                                class="form-control @error('nro_package') is-invalid @enderror"
                                                id="nro_package" name="nro_package"
                                                placeholder="Ingrese el nro de paquetes.."
                                                oninput="validarInputNumber(this)"
                                                value="{{ isset($routing) ? $routing->nro_package : old('nro_package') }}">
                                            @error('nro_package')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                <div class="col-4">
                                    <div class="form-group row">
                                        <label for="id_packaging_type" class="col-sm-4 col-form-label">Tipo de
                                            embalaje
                                            <span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <x-adminlte-select2 name="id_packaging_type"
                                                data-placeholder="Seleccione una opcion..." data-required="true">
                                                <option />
                                                @foreach ($packingTypes as $packingType)
                                                    <option value="{{ $packingType->id }}"
                                                        {{ old('id_packaging_type') == $packingType->id ? 'selected' : '' }}>
                                                        {{ $packingType->name }}
                                                    </option>
                                                @endforeach
                                            </x-adminlte-select2>
                                        </div>
                                    </div>
                                </div>

                                <div id="container_measures" class="col-12 mt-2">

                                    <div id="div-measures" class="row justify-content-center">

                                        <div class="col-2">
                                            <input type="number" class="form-control" step="1"
                                                id="amount_package" name="amount_package"
                                                placeholder="Ingresa la cantidad">
                                        </div>
                                        <div class="col-2">
                                            <input type="text" class="form-control CurrencyInput"
                                                data-type="currency" id="width" name="width"
                                                placeholder="Ancho">
                                        </div>
                                        <div class="col-2">
                                            <input type="text" class="form-control CurrencyInput"
                                                data-type="currency" id="length" name="length"
                                                placeholder="Largo">
                                        </div>
                                        <div class="col-2">
                                            <input type="text" class="form-control CurrencyInput"
                                                data-type="currency" id="height" name="height"
                                                placeholder="Alto">
                                        </div>
                                        <div class="col-2">
                                            <select class="form-control" id="units_measurements"
                                                name="units_measurements">
                                                <option value="cm">cm</option>
                                                <option value="in">in</option>
                                                <option value="lbs">lbs</option>
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-indigo btn-sm"
                                                onclick="addMeasures()"><i class="fa fa-plus"></i>Agregar</button>
                                        </div>

                                    </div>

                                    <table id="measures" class="table table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Cantidad</th>
                                                <th>Ancho</th>
                                                <th>Largo</th>
                                                <th>Alto</th>
                                                <th>Unidad</th>
                                                <th>Eliminar</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <input id="value_measures" type="hidden" name="value_measures"
                                        value="{{ old('value_measures', isset($routing->value_measures) ? $routing->value_measures : '') }}" />
                                </div>
                            </div>


                            <div class="row mt-4">

                                <div class="col-4 transporte-hide">
                                    <div class="form-group">
                                        <label for="pounds" class="col-form-label">Libras </label>

                                        <input type="text" class="form-control CurrencyInput" id="pounds"
                                            name="pounds" data-type="currency" placeholder="Ingrese las libras"
                                            value="{{ isset($routing) ? $routing->pounds : '' }}" @readonly(true)>
                                        @error('pounds')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-4">
                                    <div id="contenedor_weight" class="form-group lcl-fields">
                                        <div class="form-group ">
                                            <label for="weight" class="col-form-label">Peso</label>

                                            <div class="input-group">
                                                <input type="text"
                                                    class="form-control CurrencyInput @error('weight') is-invalid @enderror"
                                                    data-type="currency" id="weight" name="weight"
                                                    onchange="calculatePounds(event)"
                                                    value="{{ isset($routing->weight) ? $routing->weight : old('weight') }}">
                                                <div class="input-group-prepend">
                                                    <select class="form-control" name="unit_of_weight"
                                                        id="unit_of_weight">
                                                        <option>kg</option>
                                                        <option>ton</option>
                                                    </select>
                                                </div>
                                            </div>


                                            @error('weight')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>


                                <div class="col-4">
                                    <div id="contenedor_volumen" class="form-group">
                                        <div class="form-group">
                                            <label for="volumen_kgv" class="col-form-label">Volumen</label>

                                            <div class="input-group">
                                                <input type="text"
                                                    class="form-control CurrencyInput @error('volumen_kgv') is-invalid @enderror"
                                                    data-type="currency" id="volumen_kgv" name="volumen_kgv"
                                                    value="{{ isset($routing->volumen_kgv) ? $routing->volumen_kgv : old('volumen_kgv') }}">
                                                <div class="input-group-prepend">
                                                    <select class="form-control" name="unit_of_volumen_kgv"
                                                        id="unit_of_volumen_kgv">
                                                        <option>m³</option>
                                                        <option>kgv</option>
                                                    </select>
                                                </div>
                                            </div>

                                            @error('volumen_kgv')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>

                        <div id="multipleProvidersSection" class="d-none">
                            <div class="row justify-content-between px-5 mb-3">
                                <button type="button" class="btn btn-indigo" onclick="showItemConsolidated()"><i
                                        class="fas fa-plus"></i></button>
                            </div>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Proveedor</th>
                                        <th>Contacto</th>
                                        <th>Incoterm</th>
                                        <th>Direccion de recojo</th>
                                        <th>Producto</th>
                                        <th>Valor de la carga</th>
                                        <th>Bultos</th>
                                        <th>Embalaje</th>
                                        <th>Peso</th>
                                        <th>Volumen</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody id="providersTable"></tbody>
                            </table>


                            <input id="shippers_consolidated" type="hidden" name="shippers_consolidated"
                                value="{{ old('shippers_consolidated', isset($routing->shippers_consolidated) ? $routing->shippers_consolidated : '') }}" />

                        </div>

                    </div>

                    <div id="fcl_container" class="fcl-fields d-none">

                        <div id="singleProviderFCLSection">

                            <div class="text-center mb-4">
                                <h5 class="text-indigo text-center d-inline mx-2"> Agregar contenedores</h5>
                                <button class="btn btn-indigo btn-sm d-inline mx-2" data-toggle="modal"
                                    data-target="#modalAddedContainer">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <table class="table text-sm" id="table-containers">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Contenedor</th>
                                        <th scope="col">N° contenedor</th>
                                        <th scope="col">Producto</th>
                                        <th scope="col">N° Bultos</th>
                                        <th scope="col">Tipo de Embalaje</th>
                                        <th scope="col">Valor de factura</th>
                                        <th scope="col">Volumen</th>
                                        <th scope="col">Peso</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                            <input id="data_containers" type="hidden" name="data_containers"
                                value="{{ old('data_containers', isset($routing->data_containers) ? $routing->data_containers : '') }}" />

                        </div>

                        <div id="multipleProviderFCLSection" class="d-none">

                            <div class="row justify-content-between px-5 mb-3">
                                <button type="button" class="btn btn-indigo" onclick="showItemConsolidated()"><i
                                        class="fas fa-plus"></i></button>
                            </div>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Proveedor</th>
                                        <th>Contacto</th>
                                        <th>Incoterm</th>
                                        <th>Direccion de recojo</th>
                                        <th>Producto</th>
                                        <th>Valor de la carga</th>
                                        <th>Bultos</th>
                                        <th>Embalaje</th>
                                        <th>Peso</th>
                                        <th>Volumen</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody id="providersTable"></tbody>
                            </table>

                            <input id="shippers_fcl_consolidated" type="hidden" name="shippers_fcl_consolidated"
                                value="{{ old('shippers_fcl_consolidated', isset($routing->shippers_fcl_consolidated) ? $routing->shippers_fcl_consolidated : '') }}" />

                            <div id="containerDetailFCLConsolidated" class="row mt-3">

                                <div class="col-12">
                                    <h5 class="text-indigo text-center">Agrega la cantidad de contenedores</h5>
                                </div>
                                <div class="col-4 mt-4 ">

                                    <div class="form-group">
                                        <label for="id_containers_consolidated">Tipo
                                            de
                                            contenedor <span class="text-danger">*</span></label>

                                        <select
                                            class="form-control @error('id_containers_consolidated') is-invalid @enderror"
                                            id="id_containers_consolidated" name="id_containers_consolidated">
                                            <option value="">Seleccione un tipo</option>
                                            @foreach ($containers as $container)
                                                <option value="{{ $container->id }}"
                                                    {{ old('id_containers_consolidated') == $container->id ? 'selected' : '' }}>
                                                    {{ $container->typeContainer->name }} - {{ $container->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_containers_consolidated')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>


                                </div>
                                <div class="col-4 mt-4">
                                    <div class="form-group">
                                        <label for="container_quantity_consolidated">Nº
                                            Contenedor <span class="text-danger">*</span></label>

                                        <input type="number" min="0" step="1"
                                            class="form-control @error('container_quantity_consolidated') is-invalid @enderror"
                                            id="container_quantity_consolidated"
                                            name="container_quantity_consolidated"
                                            placeholder="Ingrese el nro de contenedores.."
                                            oninput="validarInputNumber(this)"
                                            value="{{ isset($routing) ? $routing->container_quantity_consolidated : '' }}">
                                        @error('container_quantity_consolidated')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="col-4 d-flex align-items-end mb-3">
                                    <button class="btn btn-indigo" type="button" id="btnaddContainerFCLConsolidated"
                                        onclick="addContainerFCLConsolidated(this)">
                                        Agregar
                                    </button>

                                </div>


                                <div class="col-12 my-3">
                                    <table id="tableContainerFCLConsolidated" class="table">
                                        <thead>
                                            <tr>
                                                <th>Contenedor</th>
                                                <th>Cantidad</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                        </tbody>
                                    </table>


                                </div>


                            </div>

                            <input id="data_containers_consolidated" type="hidden"
                                name="data_containers_consolidated"
                                value="{{ old('data_containers_consolidated', isset($routing->data_containers_consolidated) ? $routing->data_containers_consolidated : '') }}" />


                        </div>

                    </div>



                    <input type="hidden" id="type_shipment_name" name="type_shipment_name">
                    <input type="hidden" id="type_service_checked" name="type_service_checked"
                        value="{{ old('type_service_checked') }}">

                    <button class="btn btn-secondary mt-5"
                        onclick="stepperCommercialQuote.previous()">Anterior</button>
                    <button type="submit" class="btn btn-indigo mt-5" onclick="submitForm()">Guardar</button>
                </div>


                <!-- Modal de Bootstrap -->
                <div class="modal fade" id="incotermModal" tabindex="-1" aria-labelledby="incotermModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-body text-center p-0">
                                <img src="{{ asset('storage/incoterms/incoterms.jpg') }}" class="img-fluid"
                                    alt="Información sobre Incoterms">

                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="modalDetailContainer" tabindex="-1" role="dialog"
                    aria-labelledby="modalDetailContainerLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalDetailContainerLabel">Detalles del contenedor</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-striped">
                                    <tbody id="container-details"></tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>


                @push('scripts')
                    <script>
                        let tableMeasures = null;
                        let tableMeasuresFCL = null;
                        let tableMeasuresConsolidated = null;
                        let counter = 1;

                        let shippers = [];
                        let containers = [];
                        let shippersFCLConsolidated = [];
                        let containersFCLConsolidated = [];

                        // Función para agregar una fila editable
                        let rowIndex = 1; //
                        let currentPackage = 0;
                        let arrayMeasures = {};
                        let arrayMeasuresFCL = {};
                        let arrayMeasuresConsolidated = {};

                        //Tipo de embarque de la cotizacion:
                        let typeShipmentCurrent = {};

                        //Incoterms
                        let incoterms = @json($incoterms);

                        document.addEventListener('DOMContentLoaded', function() {


                            //Inicializamos la tabla de medidas

                            tableMeasures = new DataTable('#measures', {
                                paging: false, // Desactiva la paginación
                                searching: false, // Oculta el cuadro de búsqueda
                                info: false, // Oculta la información del estado de la tabla
                                lengthChange: false, // Oculta el selector de cantidad de registros por página
                                language: { // Traducciones al español
                                    emptyTable: "No hay medidas registradas"
                                }
                            });

                            //Solo se restaurara si hay un valor en el input hidden, por errores de validacion o edicion
                            restoreMeasuresFromHidden();


                            tableMeasuresFCL = new DataTable('#measures-fcl', {
                                paging: false, // Desactiva la paginación
                                searching: false, // Oculta el cuadro de búsqueda
                                info: false, // Oculta la información del estado de la tabla
                                lengthChange: false, // Oculta el selector de cantidad de registros por página
                                language: { // Traducciones al español
                                    emptyTable: "No hay medidas registradas"
                                }
                            });


                            tableMeasuresConsolidated = new DataTable('#measures-consolidated', {
                                paging: false, // Desactiva la paginación
                                searching: false, // Oculta el cuadro de búsqueda
                                info: false, // Oculta la información del estado de la tabla
                                lengthChange: false, // Oculta el selector de cantidad de registros por página
                                language: { // Traducciones al español
                                    emptyTable: "No hay medidas registradas"
                                }
                            });

                            const typeShipmentSelect = document.querySelector('select[name="id_type_shipment"]');

                            // Si tiene un valor seleccionado, disparar el evento onchange
                            if (typeShipmentSelect && typeShipmentSelect.value) {
                                typeShipmentSelect.dispatchEvent(new Event('change'));
                            }
                            //Solo si hay errores del backend o edicion, para mostrar el contenido en el segundo paso.
                            const selectedRadio = document.querySelector('input[name="lcl_fcl"]:checked');
                            if (selectedRadio) {
                                // Disparar el evento change para activar la lógica existente
                                selectedRadio.dispatchEvent(new Event('change'));
                            }

                            const selectedConsolidated = document.querySelector('input[name="is_consolidated"]:checked');
                            if (selectedConsolidated) {
                                // Disparar el evento change para activar la lógica existente
                                selectedConsolidated.dispatchEvent(new Event('change'));
                            }

                            //Solo se restaurara si hay un valor en el input hidden, por errores de validacion o edicion (FCL)
                            restoreContainersFromHidden();
                            restoreContainersFCLFromHidden()

                            restoreConsolidatedFromHidden();
                            restoreConsolidatedFCLFromHidden()

                        });



                        function restoreMeasuresFromHidden() {
                            const hidden = document.getElementById('value_measures');
                            if (!hidden || !hidden.value) return;
                            let data;
                            try {
                                data = JSON.parse(hidden.value);
                            } catch (e) {
                                console.error('Invalid value_measures JSON', e);
                                return;
                            }

                            // Reiniciar estado
                            arrayMeasures = {};
                            currentPackage = 0;
                            rowIndex = 1;
                            tableMeasures.clear().draw();

                            // data puede ser objeto con keys numéricas o array
                            const entries = Array.isArray(data) ? data.entries() : Object.entries(data);

                            for (const [key, m] of Object.entries(data)) {
                                const idx = parseInt(key, 10) || rowIndex;
                                // Normalizar valores
                                const amount = parseInt(m.amount || m.amount === 0 ? m.amount : 0, 10) || 0;
                                const width = m.width ?? '';
                                const length = m.length ?? '';
                                const height = m.height ?? '';
                                const unit = m.unit_measurement ?? (m.unit_measurement || '');

                                // Guardar en tu arrayMeasures (misma estructura que AddRowMeasures)
                                arrayMeasures[idx] = {
                                    amount,
                                    width,
                                    length,
                                    height,
                                    unit_measurement: unit
                                };
                                currentPackage += amount;

                                // Añadir fila a la DataTable (mismo HTML que AddRowMeasures)
                                const node = tableMeasures.row.add([
                                    `<input type="number" class="form-control" readonly id="amount-${idx}" value="${amount}" placeholder="Cantidad" min="0" step="1">`,
                                    `<input type="number" class="form-control" readonly id="width-${idx}" value="${width}" placeholder="Ancho" step="0.0001">`,
                                    `<input type="number" class="form-control" readonly id="length-${idx}" value="${length}" placeholder="Largo" step="0.0001">`,
                                    `<input type="number" class="form-control" readonly id="height-${idx}" value="${height}" placeholder="Alto" step="0.0001">`,
                                    `<input type="text" class="form-control" readonly id="unit-measurement-${idx}" value="${unit}">`,
                                    `<button type="button" class="btn btn-danger btn-sm" id="delete-${idx}" onclick="deleteRow('${tableMeasures.table().node().id}', 'row-${idx}', ${amount}, arrayMeasures, 'value_measures')"><i class="fa fa-trash"></i></button>`
                                ]).draw().node();

                                node.id = `row-${idx}`;
                                rowIndex = Math.max(rowIndex, idx + 1);
                            }

                            // Asegura que el hidden refleje la estructura interna (opcional)
                            document.getElementById('value_measures').value = JSON.stringify(arrayMeasures);
                        }


                        /* Buscar cliente por el ruc */

                        $('#customer_ruc').on('blur', function() {
                            const document_number = $(this).val();


                            $.get(`/customer/data/${document_number}`, function(response) {

                                if (response) {
                                    $('#customer_company_name').val(response.name_businessname);
                                    $('#customer_company_name').prop('readonly', true);

                                } else {
                                    $('#customer_company_name').val('');
                                    $('#customer_company_name').prop('readonly', false);

                                }
                            });

                        });

                        $('#id_type_shipment').on('change', (e) => {

                            var idShipment = $(e.target).find("option:selected").val();

                            var data = @json($type_shipments);

                            var typeShipmentCurrent = data.find(typeShipment => typeShipment.id === parseInt(idShipment));


                            if (typeShipmentCurrent.name === "Marítima") {
                                $('#type_shipment_name').val(typeShipmentCurrent.name);

                                $('#lclfcl_content').addClass('row');
                                $('#lclfcl_content').children().first().removeClass('col-12 p-0').addClass(
                                    'col-8');
                                $('#lclfcl_content').children().last().removeClass('d-none');

                                $('#contenedor_volumen').removeClass('d-none');


                                $('#contenedor_volumen').find('input').val("");

                                $('#unit_of_volumen_kgv').val('m³');

                                $('#radioLcl').attr('data-required', 'true');
                                $('#radioFcl').attr('data-required', 'true');

                            } else {

                                $('#type_shipment_name').val(typeShipmentCurrent.name);

                                $('#lclfcl_content').removeClass('row');
                                $('#lclfcl_content').children().first().removeClass('col-8').addClass(
                                    'col-12 p-0');
                                $('#lclfcl_content').children().last().addClass('d-none');
                                $('input[name="lcl_fcl"]').prop('checked', false);


                                $('#containerTypeWrapper').find('input').val("");
                                $('#containerTypeWrapper').addClass('d-none');
                                $('#containerQuantityWrapper').find('input').val("");
                                $('#containerQuantityWrapper').addClass('d-none');

                                $('#containerTypeWrapperConsolidated').find('input').val("");
                                $('#containerTypeWrapperConsolidated').addClass('d-none');
                                $('#containerQuantityWrapperConsolidated').find('input').val("");
                                $('#containerQuantityWrapperConsolidated').addClass('d-none');

                                $('#unit_of_volumen_kgv').val('kgv');

                                $('#lcl_container').removeClass('d-none');
                                $('#fcl_container').addClass('d-none');

                                $('#radioLcl').removeAttr('data-required');
                                $('#radioFcl').removeAttr('data-required');

                            }

                        });

                        function toggleExwPickupAddress(selectElement) {
                            const selectedCode = selectElement.options[selectElement.selectedIndex].getAttribute('data-code')
                            let isConsolidated = document.querySelector('input[name="is_consolidated"]:checked').value;
                            const exwPickupAddressDiv = document.querySelector('#div_supplier_data');
                            const exwPickupAddressInput = exwPickupAddressDiv.querySelector('input');

                            if (selectedCode === 'EXW' && isConsolidated != "1") {
                                exwPickupAddressDiv.classList.remove('d-none');
                                exwPickupAddressInput.setAttribute('data-required', 'true');
                            } else {
                                hideSupplierDataInExw();

                                if (exwPickupAddressInput.hasAttribute('data-required')) {
                                    exwPickupAddressInput.removeAttribute('data-required');
                                }
                            }

                        }


                        function toggleExwPickupAddressConsolidated(selectElement) {

                            const selectedCode = selectElement.options[selectElement.selectedIndex].getAttribute('data-code')
                            const exwPickupAddressDiv = document.querySelector('#pickup_address_at_origin_consolidated_container');
                            const exwPickupAddressInput = exwPickupAddressDiv.querySelector('input');

                            if (selectedCode === 'EXW') {
                                exwPickupAddressDiv.classList.remove('d-none');
                                exwPickupAddressInput.classList.add('required');
                            } else {

                                exwPickupAddressDiv.classList.add('d-none');
                                exwPickupAddressInput.value = '';
                                if (exwPickupAddressInput.classList.contains('required')) {
                                    exwPickupAddressInput.classList.remove('required');
                                }
                            }

                        }


                        function toggleConsolidatedSection() {
                            let isConsolidated = document.querySelector('input[name="is_consolidated"]:checked').value;
                            const selectElement = document.getElementById('incoterms');
                            const selectedCode = selectElement.options[selectElement.selectedIndex].getAttribute('data-code')
                            const exwPickupAddressDiv = document.querySelector('#div_supplier_data');
                            const exwPickupAddressInput = exwPickupAddressDiv.querySelector('input[name="pickup_address_at_origin"]');
                            const idTypeShipmentSelect = document.querySelector('select[name="id_type_shipment"]');
                            //Verificamos que typeShipment tiene
                            var data = @json($type_shipments);
                            var typeShipmentCurrent = data.find(typeShipment => typeShipment.id === parseInt(idTypeShipmentSelect
                                .value));


                            if (isConsolidated === "1") {

                                setSectionRequired('#singleProviderSection', false);


                                //Ocultamos los datos del proveedor ya que esta en la otra seccion:
                                hideSupplierDataInExw();

                                if (typeShipmentCurrent.name === "Marítima") {
                                    let lcl_fcl = document.querySelector('input[name="lcl_fcl"]:checked');
                                    if (lcl_fcl) {

                                        if (lcl_fcl.value === 'FCL') {

                                            //Se oculta
                                            $('#singleProviderFCLSection').addClass('d-none');

                                            // Se muestra
                                            $('#multipleProviderFCLSection').removeClass('d-none');
                                        } else {
                                            // Se oculta
                                            $('#singleProviderSection').addClass('d-none');

                                            //Se muestra
                                            $('#multipleProvidersSection').removeClass('d-none');
                                        }

                                    }

                                } else {
                                    // Se oculta
                                    $('#singleProviderSection').addClass('d-none');

                                    //Se muestra
                                    $('#multipleProvidersSection').removeClass('d-none');
                                }

                            } else {
                                document.getElementById("multipleProvidersSection").classList.add("d-none");
                                document.getElementById("singleProviderSection").classList.remove("d-none");



                                if (selectedCode === 'EXW') {

                                    exwPickupAddressDiv.classList.remove('d-none');

                                    //Agregaos el data-required si exw para que lo ponga como requerido

                                    exwPickupAddressInput.setAttribute('data-required', 'true');
                                } else {
                                    exwPickupAddressInput.removeAttribute('data-required');
                                }

                                if (typeShipmentCurrent.name === "Marítima") {
                                    let lcl_fcl = document.querySelector('input[name="lcl_fcl"]:checked');
                                    if (lcl_fcl) {

                                        if (lcl_fcl.value === 'FCL') {

                                            //Se oculta
                                            $('#multipleProviderFCLSection').addClass('d-none');

                                            // Se muestra
                                            $('#singleProviderFCLSection').removeClass('d-none');
                                        } else {
                                            // Se oculta
                                            $('#multipleProvidersSection').addClass('d-none');

                                            //Se muestra
                                            $('#singleProviderSection').removeClass('d-none');
                                        }

                                    }

                                } else {

                                    // Se oculta
                                    $('#multipleProvidersSection').addClass('d-none');

                                    //Se muestra
                                    $('#singleProviderSection').removeClass('d-none');

                                }


                            }
                        }

                        function setSectionRequired(sectionSelector, turnOn) {
                            const fields = document.querySelectorAll(
                                `${sectionSelector} input, ${sectionSelector} select, ${sectionSelector} textarea`
                            );

                            fields.forEach(el => {
                                // Cambiamos el valor directamente
                                if (el.hasAttribute('data-required')) {
                                    el.dataset.required = turnOn ? 'true' : 'false';
                                }
                                // Quitamos la marca visual de error
                                el.classList.remove('is-invalid');
                            });
                        }


                        function hideSupplierDataInExw() {
                            $("#div_supplier_data").addClass("d-none");

                            // Resetear los inputs dentro del div, pero no los de tipo radio
                            $("#div_supplier_data input").each(function() {
                                if ($(this).attr('type') !== 'radio') {
                                    $(this).val(""); // Resetear el valor de cada input, menos los de tipo radio
                                }
                                if ($(this).is(":checkbox")) {
                                    $(this).prop("checked", false); // Resetear checkbox
                                }

                                $(this).removeAttr("data-required");
                                $(this).removeClass("is-invalid");
                            });
                        }

                        function toggleCustomerProspectSection() {
                            let isCustomerProspect = document.querySelector('input[name="is_customer_prospect"]:checked').value;

                            if (isCustomerProspect === "customer") {

                                $("#contentCustomer").removeClass("d-none");
                                $("#contentProspect").addClass("d-none");
                                $("#contentProspect").find('input').val("");

                                $('#contentCustomer select').attr('data-required', 'true');
                                $('#contentProspect input').removeAttr('data-required');
                            } else {
                                $("#contentCustomer").addClass("d-none");
                                $("#contentProspect").removeClass("d-none");
                                $('#id_customer').val('').trigger('change');

                                $('#contentProspect input').not('[data-optional="true"]').attr('data-required', 'true');
                                $('#contentCustomer select').removeAttr('data-required');

                            }
                        }


                        function showItemConsolidated() {
                            $('#modal-consolidated').modal('show');
                        }

                        function removeRow(button) {
                            button.parentElement.parentElement.remove();
                        }


                        function calculatePounds(e) {
                            let kilogramsVal = e.target.value;
                            let kilograms = kilogramsVal.replace(/,/g, '');
                            let numberValue = parseFloat(kilograms);

                            if (!kilogramsVal || isNaN(numberValue)) {

                                $('#pounds').val(0);

                            } else {

                                $('#pounds').val(numberValue * 2.21);

                            }
                        }


                        //Funcion para agregar las medidas: 

                        function addMeasures() {


                            let divMeasures = document.getElementById("div-measures");
                            let nroPackage = parseInt(document.getElementById("nro_package").value);
                            let valueMeasuresHidden = document.getElementById('value_measures');

                            AddRowMeasures(divMeasures, nroPackage, tableMeasures, arrayMeasures, "arrayMeasures", valueMeasuresHidden);

                        }

                        function addMeasuresFCL() {
                            let formContainer = document.getElementById('formContainer');
                            let divMeasures = document.getElementById("div-measures-fcl");
                            let nroPackage = parseInt(formContainer.querySelector("#nro_package_container")
                                .value); // Usar querySelector aquí también
                            let valueMeasuresHidden = formContainer.querySelector('#value_measures_container');

                            AddRowMeasures(divMeasures, nroPackage, tableMeasuresFCL, arrayMeasuresFCL, "arrayMeasuresFCL",
                                valueMeasuresHidden);

                        }
                        //Funcion para agregar las medidas en el consolidado: 

                        function addMeasuresConsolidate() {

                            let divMeasures = document.getElementById("div-measures-consolidated");
                            let nroPackageConsolidated = parseInt(document.getElementById("nro_packages_consolidated").value);
                            let valueMeasuresHidden = document.getElementById('value-measures-consolidated');


                            AddRowMeasures(divMeasures, nroPackageConsolidated, tableMeasuresConsolidated, arrayMeasuresConsolidated,
                                "arrayMeasuresConsolidated", valueMeasuresHidden);

                        }


                        function deleteRow(tableId, rowId, amount, array, valueMeasures) {

                            let table = $(`#${tableId}`).DataTable(); // Obtener la instancia del DataTable

                            // Eliminar la fila del DataTable
                            table.row(`#${rowId}`).remove().draw();

                            // Restar la cantidad eliminada del contador actual
                            currentPackage -= amount;

                            // Eliminar la entrada del arrayMeasuresConsolidated

                            const index = rowId.replace("row-", "");

                            delete array[index];


                            // Actualizar el valor en el input oculto
                            $(`#${valueMeasures}`).val(JSON.stringify(array));

                        }

                        function cleanInputMeasures(inputs) {
                            inputs.forEach(input => {

                                input.value = "";

                            });

                        }


                        //Funcion para agregar registros a una tabla de medidas en especifico.

                        function AddRowMeasures(container_measures, nroPackage, table, array, arrayName, valueMeasuresHidden) {

                            const inputs = container_measures.querySelectorAll('input, select');

                            if (!validateInputs(inputs)) {
                                return;
                            }

                            const amount_package = parseInt(inputs[0].value);
                            const width = inputs[1].value.replace(/,/g, '');
                            const length = inputs[2].value.replace(/,/g, '');
                            const height = inputs[3].value.replace(/,/g, '');
                            const unit_measurement = inputs[4].value;

                            if (isNaN(amount_package) || amount_package <= 0) {
                                inputs[0].classList.add('is-invalid');
                                return;
                            } else {

                                if (isNaN(nroPackage) || amount_package > nroPackage) {
                                    toastr.warning(
                                        'El numero de paquetes / bultos no puede ser menor que la cantidad ingresada'
                                    );
                                    return;
                                }


                                currentPackage += amount_package;


                                if (currentPackage > nroPackage) {
                                    toastr.warning(
                                        'No se puede agregar otra fila, por que segun los registros ya completaste el numero de bultos'
                                    );
                                    currentPackage -= amount_package;
                                    return;
                                }

                                const newRow = table.row.add([

                                    // Campo para Cantidad
                                    `<input type="number" class="form-control"  readonly id="amount-${rowIndex}" value="${amount_package}" placeholder="Cantidad" min="0" step="1">`,

                                    // Campo para Ancho
                                    `<input type="number" class="form-control"  readonly id="width-${rowIndex}" value="${width}" placeholder="Ancho" min="0" step="0.0001">`,

                                    // Campo para Largo
                                    `<input type="number" class="form-control"  readonly id="length-${rowIndex}" value="${length}" placeholder="Largo" min="0" step="0.0001">`,

                                    // Campo para Alto
                                    `<input type="number" class="form-control"  readonly id="height-${rowIndex}" value="${height}" placeholder="Alto" min="0" step="0.0001">`,
                                    // Campo para unidad de medida
                                    `<input type="text" class="form-control"  readonly id="unit-measurement-${rowIndex}" value="${unit_measurement}">`,

                                    `<button type="button" class="btn btn-danger btn-sm" id="delete-${rowIndex}" onclick="deleteRow('${table.table().node().id}', 'row-${rowIndex}', ${amount_package}, ${arrayName}, '${valueMeasuresHidden.id}')"><i class="fa fa-trash"></i></button>`
                                ]).draw().node();
                                newRow.id = `row-${rowIndex}`;


                                array[rowIndex] = { // Usamos rowIndex como clave
                                    amount: amount_package,
                                    width,
                                    length,
                                    height,
                                    unit_measurement
                                };

                                valueMeasuresHidden.value = JSON.stringify(array);

                                rowIndex++

                                cleanInputMeasures(inputs)

                            }

                        }



                        /* Agregar contenedores cuando es FCL */

                        function addedContainer(buton) {

                            let form = $('#formContainer');
                            const inputs = form.find('input , select');
                            let isValid = true;

                            inputs.each(function() {
                                const input = this;

                                if (input.closest('.d-none')) return;

                                // Solo validar si el campo tiene el atributo data-required

                                if (input.dataset.required === 'true') {
                                    if (input.value.trim() === '' || input.value == null) {
                                        input.classList.add('is-invalid');
                                        isValid = false;
                                        showError(input, 'Debe completar este campo');
                                    } else {
                                        input.classList.remove('is-invalid');
                                        hideError(input);
                                    }
                                } else {
                                    // No requerido, aseguramos que no tenga error visible
                                    input.classList.remove('is-invalid');
                                    hideError(input);
                                }
                            });

                            if (isValid) {


                                //Validacion para medidas o volumen y peso
                                const valueMeasures = document.getElementById('value_measures_container').value.trim();
                                const volumen = $('#contenedor_volumen_fcl #volumen_kgv').val().trim();
                                const weight = $('#contenedor_weight_fcl #weight').val().trim();

                                if (!((volumen && weight) || valueMeasures)) {
                                    toastr.error("Por favor, complete al menos uno de los siguientes: Volumen y Peso, o Medidas.");
                                    return;
                                }


                                let containerName = $('#formContainer #id_containers option:selected').text().trim();
                                let packaginTypeName = $('#formContainer #id_packaging_type option:selected').text().trim();
                                let unit_of_volumen_kgv = $('#formContainer #unit_of_volumen_kgv option:selected').text().trim();
                                let unit_of_weight = $('#formContainer #unit_of_weight option:selected').text().trim();

                                let container = {
                                    'id_container': getValueByNameFCL('id_containers'),
                                    'containerName': containerName,
                                    'container_quantity': getValueByNameFCL('container_quantity'),
                                    'commodity': getValueByNameFCL('commodity'),
                                    'nro_package': getValueByNameFCL('nro_package_container'),
                                    'id_packaging_type': getValueByNameFCL('id_packaging_type'),
                                    'packaginTypeName': packaginTypeName,
                                    'load_value': getValueByNameFCL('load_value'),
                                    'volumen_kgv': getValueByNameFCL('volumen_kgv'),
                                    'unit_of_volumen_kgv': unit_of_volumen_kgv,
                                    'weight': getValueByNameFCL('weight'),
                                    'unit_of_weight': unit_of_weight,
                                    'value_measures': getValueByNameFCL('value_measures_container') ? JSON.parse(getValueByNameFCL(
                                        'value_measures_container')) : ''
                                };


                                let index = containers.length;
                                containers.push(container);

                                // Actualizar el input hidden con la nueva lista en JSON
                                $('#data_containers').val(JSON.stringify(containers));

                                let newRow = `
                    <tr data-index="${index}">
                        <td>${container.containerName}</td>
                        <td>${container.container_quantity}</td>
                        <td>${container.commodity}</td>
                        <td>${container.nro_package}</td>
                        <td>${container.packaginTypeName}</td>
                        <td>${container.load_value}</td>
                        <td>${container.volumen_kgv} ${container.unit_of_volumen_kgv}</td>
                        <td>${container.weight} ${container.unit_of_weight}</td>
                        <td>
                            <button class="btn btn-info btn-sm btn-detail"><i class="fas fa-folder-open"></i></button>
                            <button class="btn btn-danger btn-sm delete-row"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                `;


                                $('#table-containers tbody').append(newRow);
                                $('#modalAddedContainer .btn-secondary').click();

                                //Reseteamos los inputs

                                clearData(inputs);

                                //reseteamos las medidas
                                arrayMeasuresFCL = {};
                                document.getElementById('value_measures').value = '';
                                tableMeasuresFCL.clear().draw();
                                currentPackage = 0;
                                rowIndex = 1;

                            }



                        };

                        function restoreContainersFromHidden() {
                            const hiddenContainers = document.getElementById('data_containers');
                            if (!hiddenContainers || !hiddenContainers.value) return;

                            try {
                                // Parsear los contenedores guardados
                                containers = JSON.parse(hiddenContainers.value);

                                // Limpiar la tabla actual
                                $('#table-containers tbody').empty();

                                // Recrear las filas
                                containers.forEach((container, index) => {
                                    let newRow = `
                                    <tr data-index="${index}">
                                        <td>${container.containerName}</td>
                                        <td>${container.container_quantity}</td>
                                        <td>${container.commodity}</td>
                                        <td>${container.nro_package}</td>
                                        <td>${container.packaginTypeName}</td>
                                        <td>${container.load_value}</td>
                                        <td>${container.volumen_kgv} ${container.unit_of_volumen_kgv}</td>
                                        <td>${container.weight} ${container.unit_of_weight}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm btn-detail"><i class="fas fa-folder-open"></i></button>
                                            <button class="btn btn-danger btn-sm delete-row"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                `;
                                    $('#table-containers tbody').append(newRow);
                                });

                            } catch (e) {
                                console.error('Error parsing containers data:', e);
                            }
                        }



                        $('#table-containers tbody').on('click', '.delete-row', function() {
                            let row = $(this).closest('tr'); // Obtener la fila
                            let index = row.data('index'); // Obtener el índice del array

                            // Eliminar del array si el índice es válido
                            if (index !== undefined && index < containers.length) {
                                containers.splice(index, 1);
                            }


                            row.remove(); // Eliminar la fila del DOM


                            // Actualizar los índices de las filas restantes
                            $('#table-containers tbody tr').each(function(i) {
                                $(this).attr('data-index', i);
                            });

                            // Actualizar el input hidden con la nueva lista
                            $('#data_containers').val(JSON.stringify(containers));
                        });

                        $('#tableContainerFCLConsolidated tbody').on('click', '.delete-row', function() {
                            let row = $(this).closest('tr'); // Obtener la fila
                            let index = row.data('index'); // Obtener el índice del array

                            // Eliminar del array si el índice es válido
                            if (index !== undefined && index < containersFCLConsolidated.length) {
                                containersFCLConsolidated.splice(index, 1);
                            }


                            row.remove(); // Eliminar la fila del DOM


                            // Actualizar los índices de las filas restantes
                            $('#tableContainerFCLConsolidated tbody tr').each(function(i) {
                                $(this).attr('data-index', i);
                            });

                            // Actualizar el input hidden con la nueva lista
                            $('#data_containers_consolidated').val(JSON.stringify(containersFCLConsolidated));
                        });


                        $('#table-containers tbody').on('click', '.btn-detail', function() {
                            let row = $(this).closest('tr');
                            let index = row.data('index');
                            let container = containers[index];
                            let detailsHtml = `
                <tr><th>Contenedor</th><td>${container.containerName}</td></tr>
                <tr><th>Cantidad de contenedores</th><td>${container.container_quantity}</td></tr>
                <tr><th>Producto</th><td>${container.commodity}</td></tr>
                <tr><th>N° de bultos</th><td>${container.nro_package}</td></tr>
                <tr><th>Tipo de embalaje</th><td>${container.packaginTypeName}</td></tr>
                <tr><th>Valor de factura</th><td>${container.load_value}</td></tr>
                <tr><th>Volumen</th><td>${container.volumen_kgv} ${container.unit_of_volumen_kgv}</td></tr>
                <tr><th>Peso</th><td>${container.weight} ${container.unit_of_weight}</td></tr>
                <tr><th>Medidas</th><td>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Ítem</th>
                                <th>Largo</th>
                                <th>Ancho</th>
                                <th>Alto</th>
                                <th>Medida</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

                            // Convertimos el objeto en un array de pares clave-valor y lo recorremos
                            Object.entries(container.value_measures).forEach(([key, measure]) => {
                                detailsHtml += `
                    <tr>
                        <td>${measure.amount}</td>
                        <td>${measure.length}</td>
                        <td>${measure.width}</td>
                        <td>${measure.height}</td>
                        <td>${measure.unit_measurement}</td>
                    </tr>
                `;
                            });


                            detailsHtml += `
                        </tbody>
                    </table>
                </td></tr>
            `;

                            $('#container-details').html(detailsHtml);
                            $('#modalDetailContainer').modal('show');
                        });



                        function loadConceptData(inputs) {
                            let data = {};
                            inputs.each(function() {
                                const input = this;
                                let name = input.name;
                                if (name) {
                                    if (input.tagName === 'SELECT') {

                                        data[name] = {
                                            id: parseInt(input.value),
                                            text: input.options[input.selectedIndex] ? input.options[input.selectedIndex].text :
                                                ''
                                        };

                                    } else if (input.type === 'checkbox') {
                                        data[name] = $(input).is(':checked') ? input.value : '';
                                    } else {
                                        // Si es un valor numérico formateado, lo limpiamos
                                        if (input.classList.contains('CurrencyInput')) {
                                            0
                                            // Elimina comas y convierte a número
                                            data[name] = parseFloat(input.value.replace(/,/g, '')) || 0;
                                        } else {
                                            data[name] = input.value;
                                        }
                                    }
                                }
                            });

                            return data;
                        }



                        function addContainerFCLConsolidated(buton) {

                            let divConcepts = $('#containerDetailFCLConsolidated');
                            const inputs = divConcepts.find('input, select');

                            inputs.each(function(index, input) {

                                if ($(this).attr('type') !== 'hidden' && $(this).val() === '') {
                                    $(this).addClass('is-invalid'); // Agregar la clase si está vacío y no es hidden
                                } else {
                                    $(this).removeClass('is-invalid'); // Eliminar la clase si tiene valor o es hidden
                                }

                            });
                            var camposInvalidos = divConcepts.find('.is-invalid').length;

                            if (camposInvalidos === 0) {


                                let idContainer = $('#containerDetailFCLConsolidated #id_containers_consolidated option:selected').val();
                                let containerName = $('#containerDetailFCLConsolidated #id_containers_consolidated option:selected').text()
                                    .trim();
                                let containerQuantity = $('#containerDetailFCLConsolidated #container_quantity_consolidated').val();


                                let container = {
                                    'id_container': idContainer,
                                    'containerName': containerName,
                                    'container_quantity': containerQuantity,
                                };

                                let index = containersFCLConsolidated.length;
                                containersFCLConsolidated.push(container)
                                // Actualizar el input hidden con la nueva lista en JSON
                                $('#data_containers_consolidated').val(JSON.stringify(containersFCLConsolidated));


                                let newRow = `
                                    <tr data-index="${index}">
                                        <td>${container.containerName}</td>
                                        <td>${container.container_quantity}</td>
                                        <td>
                                            <button class="btn btn-danger btn-sm delete-row"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                `;

                                $('#tableContainerFCLConsolidated tbody').append(newRow);

                                clearData(inputs);
                            }
                        };


                        function restoreContainersFCLFromHidden() {
                            const hiddenContainersFCL = document.getElementById('data_containers_consolidated');
                            if (!hiddenContainersFCL || !hiddenContainersFCL.value) return;

                            try {
                                // Parsear los contenedores guardados
                                containersFCL = JSON.parse(hiddenContainersFCL.value);

                                // Limpiar la tabla actual
                                $('#tableContainerFCLConsolidated tbody').empty();

                                // Recrear las filas
                                containersFCL.forEach((container, index) => {
                                    let newRow = `
                                    <tr data-index="${index}">
                                        <td>${container.containerName}</td>
                                        <td>${container.container_quantity}</td>
                                        <td>
                                            <button class="btn btn-danger btn-sm delete-row"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                `;
                                    $('#tableContainerFCLConsolidated tbody').append(newRow);
                                });

                            } catch (e) {
                                console.error('Error parsing containers data:', e);
                            }
                        }



                        /* Agregar un item del consolidado  */

                        function saveConsolidated(e) {

                            const idTypeShipmentSelect = document.querySelector('select[name="id_type_shipment"]');
                            let tableShipper = $('#lcl_container #providersTable');

                            var data = @json($type_shipments);
                            var typeShipmentCurrent = data.find(typeShipment => typeShipment.id === parseInt(idTypeShipmentSelect
                                .value));

                            if (typeShipmentCurrent.name === "Marítima") {

                                let lcl_fcl = document.querySelector('input[name="lcl_fcl"]:checked');
                                if (lcl_fcl) {

                                    if (lcl_fcl.value === 'FCL') {

                                        tableShipper = $('#fcl_container #providersTable');

                                    }

                                }

                            }


                            let elements = $('#form-consolidated').find('input.required, select.required').toArray();

                            if (!validateInputs(elements)) {
                                return;
                            }
                            //Validacion para medidas o volumen y peso
                            const valueMeasures = document.getElementById('value-measures-consolidated').value.trim();
                            const volumen = $('#contenedor_volumen_consolidated #volumen_kgv').val().trim();
                            const weight = $('#contenedor_weight_consolidated #weight').val().trim();

                            if (!((volumen && weight) || valueMeasures)) {
                                toastr.error("Por favor, complete al menos uno de los siguientes: Volumen y Peso, o Medidas.");
                                return;
                            }

                            //Obtener el nombre de los incoterms.

                            let incotermSelected = incoterms.find(incoterm => incoterm.id === parseInt(getValueByName('id_incoterms')));

                            let shipper = {
                                'id_incoterms': getValueByName('id_incoterms'),
                                'name_incoterm': incotermSelected.code,
                                'shipper_name': getValueByName('shipper_name'),
                                'shipper_contact': getValueByName('shipper_contact'),
                                'shipper_contact_email': getValueByName('shipper_contact_email'),
                                'shipper_contact_phone': getValueByName('shipper_contact_phone'),
                                'shipper_address': getValueByName('shipper_address'),
                                'pickup_address_at_origin_consolidated': getValueByName('pickup_address_at_origin_consolidated'),
                                'commodity': getValueByName('commodity'),
                                'load_value': getValueByName('load_value'),
                                'nro_packages_consolidated': getValueByName('nro_packages_consolidated'),
                                'id_packaging_type_consolidated': getValueByName('id_packaging_type_consolidated'),
                                'name_packaging_type_consolidated': $('#id_packaging_type_consolidated').find('option:selected').text()
                                    .trim(),
                                'weight': getValueByName('weight'),
                                'unit_of_weight': getValueByName('unit_of_weight'),
                                'volumen_kgv': getValueByName('volumen_kgv'),
                                'unit_of_volumen_kgv': getValueByName('unit_of_volumen_kgv'),
                                'value_measures': getValueByName('value-measures-consolidated') ? JSON.parse(getValueByName(
                                    'value-measures-consolidated')) : ''
                            };

                            let index = null;

                            if (typeShipmentCurrent.name === "Marítima") {

                                let lcl_fcl = document.querySelector('input[name="lcl_fcl"]:checked');
                                if (lcl_fcl) {

                                    if (lcl_fcl.value === 'FCL') {

                                        index = shippersFCLConsolidated.length;
                                        shippersFCLConsolidated.push(shipper);

                                        $('#shippers_fcl_consolidated').val(JSON.stringify(shippersFCLConsolidated));

                                    } else {
                                        index = shippers.length;
                                        shippers.push(shipper);

                                        $('#shippers_consolidated').val(JSON.stringify(shippers));
                                    }

                                } else {
                                    toastr.error('Porfavor selecione antes si el tipo de embarque es LCL o FCL');
                                }

                            } else {


                                // Agregar shipper al array y obtener su índice
                                index = shippers.length;
                                shippers.push(shipper);

                                $('#shippers_consolidated').val(JSON.stringify(shippers));
                            }


                            let newRow = `
                                <tr data-index="${index}">
                                    <td>${shipper.shipper_name}</td>
                                    <td>${shipper.shipper_contact}</td>
                                    <td>${shipper.name_incoterm}</td>
                                    <td>${shipper.pickup_address_at_origin_consolidated}</td>
                                    <td>${shipper.commodity}</td>
                                    <td>${shipper.load_value}</td>
                                    <td>${shipper.nro_packages_consolidated}</td>
                                    <td>${shipper.name_packaging_type_consolidated}</td>
                                    <td>${shipper.weight} ${shipper.unit_of_weight}</td>
                                    <td>${shipper.volumen_kgv} ${shipper.unit_of_volumen_kgv}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm btn-detail"><i class="fas fa-folder-open"></i></button>
                                        <button class="btn btn-danger btn-sm delete-row"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            `;


                            tableShipper.append(newRow);


                            $('#modal-consolidated').modal('hide');
                            //Reseteamos el formulario para agregar un shipper
                            $('#form-consolidated')[0].reset();
                            //reseteamos las medidas
                            arrayMeasuresConsolidated = {};
                            document.getElementById('value-measures-consolidated').value = '';
                            tableMeasuresConsolidated.clear().draw();
                            currentPackage = 0;
                            rowIndex = 1;
                        }




                        function restoreConsolidatedFromHidden() {
                            const hiddenShippers = document.getElementById('shippers_consolidated');

                            if (!hiddenShippers || !hiddenShippers.value) return;

                            try {
                                // Parsear los shippers guardados
                                shippers = JSON.parse(hiddenShippers.value);

                                // Limpiar la tabla actual
                                $('#lcl_container #providersTable').empty();

                                // Recrear las filas con los datos almacenados
                                shippers.forEach((shipper, index) => {
                                    let newRow = `
                                        <tr data-index="${index}">
                                            <td>${shipper.shipper_name}</td>
                                                            <td>${shipper.shipper_contact}</td>
                                                            <td>${shipper.name_incoterm}</td>
                                                            <td>${shipper.pickup_address_at_origin_consolidated}</td>
                                                            <td>${shipper.commodity}</td>
                                                            <td>${shipper.load_value}</td>
                                                            <td>${shipper.nro_packages_consolidated}</td>
                                                            <td>${shipper.name_packaging_type_consolidated}</td>
                                                            <td>${shipper.weight} ${shipper.unit_of_weight}</td>
                                                            <td>${shipper.volumen_kgv} ${shipper.unit_of_volumen_kgv}</td>
                                            <td>
                                                <button class="btn btn-info btn-sm btn-detail"><i class="fas fa-folder-open"></i></button>
                                                <button class="btn btn-danger btn-sm delete-row"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    `;
                                    $('#providersTable').append(newRow);
                                });

                            } catch (e) {
                                console.error('Error al parsear los datos de shippers:', e);
                            }
                        }

                        function restoreConsolidatedFCLFromHidden() {
                            const hiddenShippersFCL = document.getElementById('shippers_fcl_consolidated');

                            if (!hiddenShippersFCL || !hiddenShippersFCL.value) return;

                            try {
                                // Parsear los shippers guardados
                                
                                shippersFCLConsolidated = JSON.parse(hiddenShippersFCL.value);

                                // Limpiar la tabla actual
                                $('#fcl_container #providersTable').empty();

                                // Recrear las filas con los datos almacenados
                                shippersFCLConsolidated.forEach((shipper, index) => {
                                    let newRow = `
                                        <tr data-index="${index}">
                                            <td>${shipper.shipper_name}</td>
                                                            <td>${shipper.shipper_contact}</td>
                                                            <td>${shipper.name_incoterm}</td>
                                                            <td>${shipper.pickup_address_at_origin_consolidated}</td>
                                                            <td>${shipper.commodity}</td>
                                                            <td>${shipper.load_value}</td>
                                                            <td>${shipper.nro_packages_consolidated}</td>
                                                            <td>${shipper.name_packaging_type_consolidated}</td>
                                                            <td>${shipper.weight} ${shipper.unit_of_weight}</td>
                                                            <td>${shipper.volumen_kgv} ${shipper.unit_of_volumen_kgv}</td>
                                            <td>
                                                <button class="btn btn-info btn-sm btn-detail"><i class="fas fa-folder-open"></i></button>
                                                <button class="btn btn-danger btn-sm delete-row"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    `;
                                    $('#fcl_container #providersTable').append(newRow);
                                });

                            } catch (e) {
                                console.error('Error al parsear los datos de shippers:', e);
                            }
                        }

                        $('#lcl_container #providersTable').on('click', '.delete-row', function() {
                            let row = $(this).closest('tr'); // Obtener la fila
                            let index = row.data('index'); // Obtener el índice del array

                            // Eliminar del array si el índice es válido
                            if (index !== undefined && index < shippers.length) {
                                shippers.splice(index, 1);
                            }


                            row.remove(); // Eliminar la fila del DOM


                            // Actualizar los índices de las filas restantes
                            $('#providersTable tr').each(function(i) {
                                $(this).attr('data-index', i);
                            });

                            // Actualizar el input hidden con la nueva lista
                            $('#shippers_consolidated').val(JSON.stringify(shippers));
                        });

                        $('#fcl_container #providersTable').on('click', '.delete-row', function() {
                            let row = $(this).closest('tr'); // Obtener la fila
                            let index = row.data('index'); // Obtener el índice del array

                            // Eliminar del array si el índice es válido
                            if (index !== undefined && index < shippersFCLConsolidated.length) {
                                shippersFCLConsolidated.splice(index, 1);
                            }


                            row.remove(); // Eliminar la fila del DOM


                            // Actualizar los índices de las filas restantes
                            $('#providersTable tr').each(function(i) {
                                $(this).attr('data-index', i);
                            });

                            // Actualizar el input hidden con la nueva lista
                            $('#shippers_fcl_consolidated').val(JSON.stringify(shippersFCLConsolidated));
                        });

                        $('#lcl_container #providersTable').on('click', '.btn-detail', function() {

                            let row = $(this).closest('tr');
                            let index = row.data('index');
                            let shipper = shippers[index];
                            let detailsHtml = `
                                <tr><th>Nombre</th><td>${shipper.shipper_name}</td></tr>
                                <tr><th>Contacto</th><td>${shipper.shipper_contact}</td></tr>
                                <tr><th>Email</th><td>${shipper.shipper_contact_email}</td></tr>
                                <tr><th>Teléfono</th><td>${shipper.shipper_contact_phone}</td></tr>
                                <tr><th>Dirección</th><td>${shipper.shipper_address}</td></tr>
                                <tr><th>Commodity</th><td>${shipper.commodity}</td></tr>
                                <tr><th>Incoterm</th><td>${shipper.name_incoterm}</td></tr>
                                <tr><th>Dirección de recojo</th><td>${shipper.pickup_address_at_origin_consolidated}</td></tr>
                                <tr><th>Valor de Carga</th><td>${shipper.load_value}</td></tr>
                                <tr><th>Nro. Paquetes</th><td>${shipper.nro_packages_consolidated}</td></tr>
                                <tr><th>Tipo de Empaque</th><td>${shipper.name_packaging_type_consolidated}</td></tr>
                                <tr><th>Peso</th><td>${shipper.weight} ${shipper.unit_of_weight}</td></tr>
                                <tr><th>Volumen</th><td>${shipper.volumen_kgv} ${shipper.unit_of_volumen_kgv}</td></tr>
                                <tr><th>Medidas</th><td>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Ítem</th>
                                                <th>Largo</th>
                                                <th>Ancho</th>
                                                <th>Alto</th>
                                                <th>Medida</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                            `;

                            // Convertimos el objeto en un array de pares clave-valor y lo recorremos
                            Object.entries(shipper.value_measures).forEach(([key, measure]) => {
                                detailsHtml += `
                                    <tr>
                                        <td>${measure.amount}</td>
                                        <td>${measure.length}</td>
                                        <td>${measure.width}</td>
                                        <td>${measure.height}</td>
                                        <td>${measure.unit_measurement}</td>
                                    </tr>
                                `;
                            });


                            detailsHtml += `
                                        </tbody>
                                    </table>
                                </td></tr>
                            `;

                            $('#shipper-details').html(detailsHtml);
                            $('#modal-detail').modal('show');
                        });

                        $('#fcl_container #providersTable').on('click', '.btn-detail', function() {

                            let row = $(this).closest('tr');
                            let index = row.data('index');
                            let shipper = shippersFCLConsolidated[index];
                            let detailsHtml = `
                                <tr><th>Nombre</th><td>${shipper.shipper_name}</td></tr>
                                <tr><th>Contacto</th><td>${shipper.shipper_contact}</td></tr>
                                <tr><th>Email</th><td>${shipper.shipper_contact_email}</td></tr>
                                <tr><th>Teléfono</th><td>${shipper.shipper_contact_phone}</td></tr>
                                <tr><th>Dirección</th><td>${shipper.shipper_address}</td></tr>
                                <tr><th>Commodity</th><td>${shipper.commodity}</td></tr>
                                <tr><th>Incoterm</th><td>${shipper.name_incoterm}</td></tr>
                                <tr><th>Dirección de recojo</th><td>${shipper.pickup_address_at_origin_consolidated}</td></tr>
                                <tr><th>Valor de Carga</th><td>${shipper.load_value}</td></tr>
                                <tr><th>Nro. Paquetes</th><td>${shipper.nro_packages_consolidated}</td></tr>
                                <tr><th>Tipo de Empaque</th><td>${shipper.name_packaging_type_consolidated}</td></tr>
                                <tr><th>Peso</th><td>${shipper.weight} ${shipper.unit_of_weight}</td></tr>
                                <tr><th>Volumen</th><td>${shipper.volumen_kgv} ${shipper.unit_of_volumen_kgv}</td></tr>
                                <tr><th>Medidas</th><td>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Ítem</th>
                                                <th>Largo</th>
                                                <th>Ancho</th>
                                                <th>Alto</th>
                                                <th>Medida</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                            `;

                            // Convertimos el objeto en un array de pares clave-valor y lo recorremos
                            Object.entries(shipper.value_measures).forEach(([key, measure]) => {
                                detailsHtml += `
                                    <tr>
                                        <td>${measure.amount}</td>
                                        <td>${measure.length}</td>
                                        <td>${measure.width}</td>
                                        <td>${measure.height}</td>
                                        <td>${measure.unit_measurement}</td>
                                    </tr>
                                `;
                            });


                            detailsHtml += `
                                        </tbody>
                                    </table>
                                </td></tr>
                            `;

                            $('#shipper-details').html(detailsHtml);
                            $('#modal-detail').modal('show');
                        });


                        function getValueByName(name) {

                            let inputs = $('#form-consolidated').find('input, select').toArray();
                            let element = inputs.find(el => $(el).attr('name') === name);
                            return element ? $(element).val() : null;
                        }

                        function getValueByNameFCL(name) {

                            let inputs = $('#formContainer').find('input, select').toArray();
                            let element = inputs.find(el => $(el).attr('name') === name);
                            return element ? $(element).val() : null;
                        }

                        //Validar inputs de un contenedor: 

                        function validateInputs(inputs) {
                            let isValid = true;

                            inputs.forEach(input => {
                                const value = input.value;

                                if (input.tagName === 'SELECT') {
                                    // Valida selects: evitar valores vacíos o "0" si eso significa "ninguna opción"
                                    if (value === '' || value === '0') {
                                        isValid = false;
                                        input.classList.add('is-invalid');
                                        return;
                                    }
                                } else {
                                    // Para otros inputs, como text o number
                                    if (value.trim() === '' || (input.type === 'number' && parseFloat(value) <= 0)) {
                                        isValid = false;
                                        input.classList.add('is-invalid');
                                        return;
                                    }
                                }

                                // Todo bien
                                input.classList.remove('is-invalid');
                            });

                            return isValid;
                        }



                        document.querySelectorAll('input[name="lcl_fcl"]').forEach(radio => {
                            radio.addEventListener('change', function() {

                                let isConsolidated = document.querySelector('input[name="is_consolidated"]:checked').value;

                                const fclFields = document.querySelectorAll('.fcl-fields');
                                const lclFields = document.querySelectorAll('.lcl-fields');

                                if (this.value === 'FCL') {

                                    setSectionRequired('#singleProviderSection', false);

                                    // Mostrar los campos FCL y ocultar los LCL
                                    fclFields.forEach(el => el.classList.remove('d-none'));
                                    lclFields.forEach(el => el.classList.add('d-none'));

                                    if (isConsolidated === '1') {

                                        //Se oculta
                                        $('#singleProviderFCLSection').addClass('d-none');

                                        // Se muestra
                                        $('#multipleProviderFCLSection').removeClass('d-none');

                                    } else {

                                        //Se oculta
                                        $('#multipleProviderFCLSection').addClass('d-none');

                                        // Se muestra
                                        $('#singleProviderFCLSection').removeClass('d-none');

                                    }

                                    // Ajustar columnas de Bootstrap
                                    const parentElement = document.querySelector('.row');
                                    if (parentElement) {
                                        const children = parentElement.children;
                                        if (children.length > 1) {
                                            children[0].classList.add('col-4');
                                            children[0].classList.remove('col-6');
                                            children[1].classList.add('col-4');
                                            children[1].classList.remove('col-6');
                                        }
                                    }
                                } else {

                                    setSectionRequired('#singleProviderSection', true);

                                    // Mostrar los campos LCL y ocultar los FCL
                                    fclFields.forEach(el => el.classList.add('d-none'));
                                    lclFields.forEach(el => el.classList.remove('d-none'));


                                    if (isConsolidated === '1') {

                                        //Se oculta
                                        $('#singleProviderSection').addClass('d-none');

                                        // Se muestra
                                        $('#multipleProvidersSection').removeClass('d-none');

                                    } else {

                                        //Se oculta
                                        $('#multipleProvidersSection').addClass('d-none');

                                        // Se muestra
                                        $('#singleProviderSection').removeClass('d-none');

                                    }


                                    // Limpiar inputs dentro de los elementos ocultos
                                    document.querySelectorAll('.fcl-fields input').forEach(input => input.value = '');
                                }
                            });
                        });


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

                        function clearData(inputs) {
                            inputs.each(function() {
                                const input = this;

                                if (input.tagName === 'SELECT') {
                                    $(input).val(null).trigger('change'); // Resetea select2
                                } else if (input.type === 'checkbox') {
                                    input.checked = false; // Desmarca el checkbox
                                } else {
                                    input.value = ''; // Limpia input de texto, número, etc.
                                }

                                input.classList.remove('is-invalid');
                                hideError(input);
                            });
                        }
                    </script>
                @endpush
