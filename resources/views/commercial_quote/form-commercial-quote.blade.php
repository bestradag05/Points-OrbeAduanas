<div id="informacion" role="tabpanel" class="bs-stepper-pane active dstepper-block" aria-labelledby="stepperInformacion">
    <div class="row">
        <div class="col-6 transporte-hide">

            <label for="origin">Origen <span class="text-danger">*</span></label>

            <x-adminlte-select2 name="origin" igroup-size="md" data-placeholder="Seleccione una opcion...">
                <option />
                @foreach ($stateCountrys as $stateCountry)
                    <option value="{{ $stateCountry->id }}">
                        {{ $stateCountry->country->name . ' - ' . $stateCountry->name }}
                    </option>
                @endforeach
            </x-adminlte-select2>

        </div>
        <div class="col-6 transporte-hide">

            <label for="destination">Destino <span class="text-danger">*</span></label>

            <x-adminlte-select2 name="destination" igroup-si ze="md" data-placeholder="Seleccione una opcion...">
                <option />
                @foreach ($stateCountrys as $stateCountry)
                    <option value="{{ $stateCountry->id }}">
                        {{ $stateCountry->country->name . ' - ' . $stateCountry->name }}
                    </option>
                @endforeach
            </x-adminlte-select2>

        </div>

        <div class="col-6">
            <div class="row" id="lclfcl_content">
                <div class="col-12">
                    <label for="id_type_shipment">Tipo de embarque <span class="text-danger">*</span></label>
                    <x-adminlte-select2 name="id_type_shipment" igroup-size="md"
                        data-placeholder="Seleccione una opcion...">
                        <option />
                        @foreach ($type_shipments as $type_shipment)
                            <option value="{{ $type_shipment->id }}"
                                {{ (isset($routing->id_type_shipment) && $routing->id_type_shipment == $type_shipment->id) || old('id_type_shipment') == $type_shipment->id ? 'selected' : '' }}>
                                {{ $type_shipment->name }}
                            </option>
                        @endforeach
                    </x-adminlte-select2>
                </div>

                <div id="contenedor_radio_lcl_fcl" class="col-4 row align-items-center d-none">
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
            <div class="row" id="lclfcl_content">
                <div class="col-12">
                    <label for="id_customs_district">Circunscripción - Aduana</label>
                    <x-adminlte-select2 name="id_customs_district" igroup-size="md"
                        data-placeholder="Seleccione una opcion...">
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

            <x-adminlte-select2 name="id_type_load" igroup-size="md" data-placeholder="Seleccione una opcion...">
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

            <x-adminlte-select2 name="id_regime" igroup-size="md" data-placeholder="Seleccione una opcion...">
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
                data-placeholder="Seleccione una opcion..." onchange="toggleExwPickupAddress(this)">
                <option />
                @foreach ($incoterms as $incoter)
                    <option value="{{ $incoter->id }}" data-code="{{ $incoter->code }}"
                        {{ (isset($routing->id_incoterms) && $routing->id_incoterms == $incoter->id) || old('id_incoterms') == $incoter->id ? 'selected' : '' }}>
                        {{ $incoter->code }} ({{ $incoter->name }})
                    </option>
                @endforeach
            </x-adminlte-select2>
        </div>

        <div class="col-6 transporte-hide row align-items-center justify-content-center lcl-fields">
            <div class="form-group mb-0">
                <label>¿Es consolidado?</label>
                <div class="form-check form-check-inline">
                    <input type="radio" id="consolidadoSi" name="is_consolidated" value="1"
                        class="form-check-input" onchange="toggleConsolidatedSection()">
                    <label for="consolidadoSi" class="form-check-label">Sí</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" id="consolidadoNo" name="is_consolidated" value="0"
                        class="form-check-input" onchange="toggleConsolidatedSection()" checked>
                    <label for="consolidadoNo" class="form-check-label">No</label>
                </div>
            </div>
        </div>

        <div id="div_supplier_data" class="col-12 row transporte-hide d-none">

            <div class="col-12 row justify-content-center align-items-center mt-3">
                <div class="form-group text-indigo text-center">
                    <label class="col-12">Proveedor</label>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="supplierOldExw" name="isNewSupplier" value="No"
                            class="form-check-input" onchange="toggleSupplierNewOldtSection()" checked>
                        <label for="supplierOldExw" class="form-check-label">Registrado</label>
                    </div>
                    <div class="form-check form-check-inline mt-2">
                        <input type="radio" id="supplierNewExw" name="isNewSupplier" value="Si"
                            class="form-check-input" onchange="toggleSupplierNewOldtSection()">
                        <label for="supplierNewExw" class="form-check-label">Nuevo</label>
                    </div>
                </div>
            </div>

            <div id="divSupplierOld" class="row col-12 justify-content-center">

                <div class="col-6">
                    <div class="form-group">
                        <label for="id_supplier">Proveedor <span class="text-danger">*</span></label>

                        <x-adminlte-select2 name="id_supplier" igroup-size="md"
                            data-placeholder="Seleccione una opcion...">
                            <option />
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ (isset($commercialQuote->id_supplier) && $commercialQuote->id_supplier == $supplier->id) || old('id_supplier') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name_businessname }} //   {{ $supplier->address }}
                                </option>
                            @endforeach
                        </x-adminlte-select2>
                        @error('id_supplier')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                </div>

            </div>

            <div id="divSupplierNew" class="row d-none">
                <div class="col-6">
                    <div class="form-group">
                        <label for="shipper_name">Proveedor:</label>
                        <input id="shipper_name" class="form-control required" type="text" name="shipper_name">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="shipper_contact">Contacto:</label>
                        <input id="shipper_contact" class="form-control" type="text" name="shipper_contact">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="shipper_contact_email">Correo de contacto:</label>
                        <input id="shipper_contact_email" class="form-control" type="text"
                            name="shipper_contact_email">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="shipper_contact_phone">Nro de contacto:</label>
                        <input id="shipper_contact_phone" class="form-control" type="text"
                            name="shipper_contact_phone">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="shipper_address">Direccion:</label>
                        <input id="shipper_address" class="form-control required" type="text"
                            name="shipper_address">
                    </div>
                </div>
            </div>

            <div class="col-12">
                <hr>
            </div>

        </div>

        <div class="col-12 row justify-content-center align-items-center mt-3">
            <div class="form-group text-indigo">
                <label class="col-12">¿Es cliente o prospecto?</label>
                <div class="form-check form-check-inline mt-2">
                    <input type="radio" id="customer" name="is_customer_prospect" value="customer"
                        class="form-check-input" onchange="toggleCustomerProspectSection()">
                    <label for="customer" class="form-check-label">Cliente</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" id="prospect" name="is_customer_prospect" value="prospect"
                        class="form-check-input" onchange="toggleCustomerProspectSection()" checked>
                    <label for="prospect" class="form-check-label">Prospecto</label>
                </div>
            </div>
        </div>

        <div id="contentProspect" class="col-12 row">
            <div class="col-6">
                <div class="form-group">
                    <label for="customer_company_name">Razon social / Nombre</label>

                    <div class="input-group">
                        <input type="text"
                            class="form-control @error('customer_company_name') is-invalid @enderror "
                            name="customer_company_name" id="customer_company_name"
                            placeholder="Ingrese valor de la carga"
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
                    <input type="text" class="form-control @error('contact') is-invalid @enderror" id="contact"
                        name="contact" placeholder="Ingrese su numero de celular"
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
                    <input type="text" class="form-control @error('cellphone') is-invalid @enderror"
                        id="cellphone" name="cellphone" placeholder="Ingrese su numero de celular"
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
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" placeholder="Ingrese su numero de celular"
                        value="{{ isset($customer->email) ? $customer->email : old('email') }}">
                    @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

        </div>

        <div id="contentCustomer" class="col-12 row justify-content-center d-none">
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
                    @error('id_customer')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
            </div>

        </div>


    </div>

    <button class="btn btn-primary mt-3" onclick="stepper.next()">Siguiente</button>
</div>
<div id="detalle_producto" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepperDetalleProducto">

    <div id="lcl_container" class="lcl-fields">

        <div id="singleProviderSection">

            <div class="form-group row">
                <label for="commodity" class="col-sm-2 col-form-label">Producto <span
                        class="text-danger">*</span></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('commodity') is-invalid @enderror"
                        id="commodity" name="commodity" placeholder="Ingrese el producto.."
                        value="{{ isset($routing->commodity) ? $routing->commodity : old('commodity') }}">
                    @error('commodity')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row my-4">

                <div class="col-4 transporte-hide">
                    <div class="form-group row">
                        <label for="load_value" class="col-sm-4 col-form-label">Valor de factura <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-bold @error('load_value') is-invalid @enderror">
                                        $
                                    </span>
                                </div>
                                <input type="text"
                                    class="form-control CurrencyInput @error('load_value') is-invalid @enderror "
                                    name="load_value" data-type="currency" placeholder="Ingrese valor de la carga"
                                    value="{{ isset($routing->load_value) ? $routing->load_value : old('load_value') }}">
                            </div>
                        </div>
                        @error('load_value')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group row">
                        <label for="nro_package" class="col-sm-4 col-form-label">N° Paquetes / Bultos <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="number" min="0" step="1"
                                class="form-control @error('nro_package') is-invalid @enderror" id="nro_package"
                                name="nro_package" placeholder="Ingrese el nro de paquetes.."
                                oninput="validarInputNumber(this)"
                                value="{{ isset($routing) ? $routing->nro_package : '' }}">
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
                        <label for="id_packaging_type" class="col-sm-4 col-form-label">Tipo de embalaje <span
                                class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <x-adminlte-select2 name="id_packaging_type" data-placeholder="Seleccione una opcion...">
                                <option />
                                @foreach ($packingTypes as $packingType)
                                    <option value="{{ $packingType->id }}">
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
                            <input type="number" class="form-control" step="1" id="amount_package"
                                name="amount_package" placeholder="Ingresa la cantidad">
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control CurrencyInput" data-type="currency"
                                id="width" name="width" placeholder="Ancho">
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control CurrencyInput" data-type="currency"
                                id="length" name="length" placeholder="Largo">
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control CurrencyInput" data-type="currency"
                                id="height" name="height" placeholder="Alto">
                        </div>
                        <div class="col-2">
                            <select class="form-control" id="units_measurements" name="units_measurements">
                                <option value="cm">cm</option>
                                <option value="in">in</option>
                                <option value="lbs">lbs</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-indigo btn-sm" onclick="addMeasures()"><i
                                    class="fa fa-plus"></i>Agregar</button>
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
                    <input id="value_measures" type="hidden" name="value_measures" />
                    @error('value_measures')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
            </div>


            <div class="row mt-4">

                <div class="col-4 transporte-hide">
                    <div class="form-group">
                        <label for="pounds" class="col-form-label">Libras </label>

                        <input type="text" class="form-control CurrencyInput" id="pounds" name="pounds"
                            data-type="currency" placeholder="Ingrese las libras"
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
                                    value="{{ isset($routing->weight) ? $routing->weight : old('weight') }}">
                                <div class="input-group-prepend">
                                    <select class="form-control" name="unit_of_weight" id="unit_of_weight">
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
                                    <select class="form-control" name="unit_of_volumen_kgv" id="unit_of_volumen_kgv">
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
                        <th>Direccion</th>
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


            <input id="shippers_consolidated" type="hidden" name="shippers_consolidated" />

            <div class="row">
                <hr class="w-100">
                <div class="col-6 mt-4 d-none fcl-fields" id="containerTypeWrapperConsolidated">
                    <div class="form-group row">
                        <label for="id_containers_consolidated" class="col-sm-4 col-form-label">Tipo de
                            contenedor <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control @error('id_containers_consolidated') is-invalid @enderror"
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
                </div>
                <div class="col-6 mt-4 d-none fcl-fields" id="containerQuantityWrapperConsolidated">
                    <div class="form-group row">
                        <label for="container_quantity_consolidated" class="col-sm-4 col-form-label">Nº
                            Contenedor <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input type="number" min="0" step="1"
                                class="form-control @error('container_quantity_consolidated') is-invalid @enderror"
                                id="container_quantity_consolidated" name="container_quantity_consolidated"
                                placeholder="Ingrese el nro de contenedores.." oninput="validarInputNumber(this)"
                                value="{{ isset($routing) ? $routing->container_quantity_consolidated : '' }}">
                            @error('container_quantity_consolidated')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>

    <div id="fcl_container" class="fcl-fields d-none">
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

        <input id="data_containers" type="hidden" name="data_containers" />


    </div>



    <input type="hidden" id="type_shipment_name" name="type_shipment_name">
    <input type="hidden" id="type_service_checked" name="type_service_checked">



    <button class="btn btn-secondary mt-5" onclick="stepper.previous()">Anterior</button>
    <button type="submit" class="btn btn-indigo mt-5" onclick="submitForm()">Guardar</button>
</div>




<!-- Modal de Bootstrap -->
<div class="modal fade" id="incotermModal" tabindex="-1" aria-labelledby="incotermModalLabel" aria-hidden="true">
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

        // Función para agregar una fila editable
        let rowIndex = 1; //
        let currentPackage = 0;
        let arrayMeasures = {};
        let arrayMeasuresFCL = {};
        let arrayMeasuresConsolidated = {};

        //Tipo de embarque de la cotizacion:
        let typeShipmentCurrent = {};

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


            // Obtener los valores de los campos del formulario (puedes personalizar esto para tu caso)
            let volumenValue = document.getElementById('volumen');
            let kilogramoVolumenValue = document.getElementById('kilogram_volumen');
            let toneladasValue = document.getElementById('tons');
            let totalWeight = document.getElementById('kilograms');
            let lcl_fcl = document.getElementsByName('lcl_fcl');
            let id_containers = document.getElementById('id_containers');

            let lclfclSelected = Array.from(document.getElementsByName('lcl_fcl')).find(radio => radio.checked)
                ?.value;



            // Mostrar/ocultar los campos según los valores
            if (volumenValue.value !== '' || volumenValue.classList.contains('is-invalid')) {
                $('#contenedor_volumen').removeClass('d-none');
                $('#contenedor_kg_vol').addClass('d-none');

            }

            if (kilogramoVolumenValue.value !== '' || kilogramoVolumenValue.classList.contains('is-invalid')) {
                $('#contenedor_kg_vol').removeClass('d-none');
                $('#contenedor_volumen').addClass('d-none');
            }

            if (totalWeight.value !== '' || totalWeight.classList.contains('is-invalid')) {
                $('#contenedor_weight').removeClass('d-none');
                $('#contenedor_tons').addClass('d-none');

            }

            if (toneladasValue.value !== '' || toneladasValue.classList.contains('is-invalid')) {
                $('#contenedor_tons').removeClass('d-none');
                $('#contenedor_weight').addClass('d-none');


            }

            if (id_containers.value !== '' || id_containers.classList.contains('is-invalid')) {
                $('#containerTypeWrapper').removeClass('d-none');

                const parentElement = document.getElementById('containerTypeWrapper').closest('.row');

                if (parentElement) {
                    const firstChild = parentElement.children[0]; // Primer hijo
                    const secondChild = parentElement.children[1]; // Segundo hijo


                    // Añade la clase 'col-6' a los dos primeros hijos
                    if (firstChild) {
                        firstChild.classList.add('col-4');
                        firstChild.classList.remove('col-6');

                    }
                    if (secondChild) {

                        secondChild.classList.add('col-4');
                        secondChild.classList.remove('col-6')

                    }

                }

            }

            let isChecked = Array.from(lcl_fcl).some(radio => radio.checked);
            let hasInvalidClass = Array.from(lcl_fcl).some(radio => radio.classList.contains('is-invalid'));


            if (isChecked || hasInvalidClass) {
                $('#lclfcl_content').children().first().removeClass('col-12').addClass('col-8');
                $('#lclfcl_content').children().last().removeClass('d-none').addClass('d-flex');
                document.getElementById('contenedor_radio_lcl_fcl').classList.remove('d-none');
            }
        })


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
                /*                   $('#contenedor_vol_consolidated').removeClass('d-none');
                                  $('#contenedor_kg_vol').addClass('d-none');
                                  $('#contenedor_kg_vol_consolidated').addClass('d-none'); */

                $('#contenedor_volumen').find('input').val("");
                /* $('#contenedor_kg_vol').find('input').val("");
                $('#contenedor_kg_vol_consolidated').find('input').val(""); */

                $('#unit_of_volumen_kgv').val('m³');


            } else {

                $('#type_shipment_name').val(typeShipmentCurrent.name);

                $('#lclfcl_content').removeClass('row');
                $('#lclfcl_content').children().first().removeClass('col-8').addClass(
                    'col-12 p-0');
                $('#lclfcl_content').children().last().addClass('d-none');
                $('input[name="lcl_fcl"]').prop('checked', false);

                /*   $('#contenedor_vol_consolidated').addClass('d-none');
                  $('#contenedor_kg_vol').removeClass('d-none');
                  $('#contenedor_kg_vol_consolidated').removeClass('d-none');

                  $('#contenedor_kg_vol').find('input').val("");
                  $('#contenedor_kg_vol_consolidated').find('input').val("");
                  $('#contenedor_volumen').find('input').val("");
                  $('#contenedor_vol_consolidated').find('input').val(""); */

                $('#containerTypeWrapper').find('input').val("");
                $('#containerTypeWrapper').addClass('d-none');
                $('#containerQuantityWrapper').find('input').val("");
                $('#containerQuantityWrapper').addClass('d-none');

                $('#containerTypeWrapperConsolidated').find('input').val("");
                $('#containerTypeWrapperConsolidated').addClass('d-none');
                $('#containerQuantityWrapperConsolidated').find('input').val("");
                $('#containerQuantityWrapperConsolidated').addClass('d-none');

                /*    $('#contenedor_tons').find('input').val("");
                   $('#contenedor_tons').addClass('d-none');
                   $('#contenedor_weight').removeClass('d-none'); */

                $('#unit_of_volumen_kgv').val('kgv');

                $('#lcl_container').removeClass('d-none');
                $('#fcl_container').addClass('d-none');

            }

        });

        function toggleExwPickupAddress(selectElement) {
            const selectedCode = selectElement.options[selectElement.selectedIndex].getAttribute('data-code')
            let isConsolidated = document.querySelector('input[name="is_consolidated"]:checked').value;

            if (selectedCode === 'EXW' && isConsolidated != "1") {
                const exwPickupAddressDiv = document.querySelector('#div_supplier_data');
                exwPickupAddressDiv.classList.remove('d-none');
            } else {
                hideSupplierDataInExw();
            }

        }


        function toggleConsolidatedSection() {
            let isConsolidated = document.querySelector('input[name="is_consolidated"]:checked').value;


            if (isConsolidated === "1") {
                document.getElementById("multipleProvidersSection").classList.remove("d-none");
                document.getElementById("singleProviderSection").classList.add("d-none");

                //Ocultamos los datos del proveedor ya que esta en la otra seccion:
                hideSupplierDataInExw();

                let lcl_fcl = document.querySelector('input[name="lcl_fcl"]:checked');
                if (lcl_fcl) {
                    const containerTypeWrapper = document.getElementById('containerTypeWrapperConsolidated');

                    if (lcl_fcl.value === 'FCL') {
                        containerTypeWrapper.classList.remove('d-none');
                    } else {
                        containerTypeWrapper.classList.add('d-none');
                    }

                }


            } else {
                document.getElementById("multipleProvidersSection").classList.add("d-none");
                document.getElementById("singleProviderSection").classList.remove("d-none");

                const selectElement = document.getElementById('incoterms');
                const selectedCode = selectElement.options[selectElement.selectedIndex].getAttribute('data-code')
                if (selectedCode === 'EXW') {
                    const exwPickupAddressDiv = document.querySelector('#div_supplier_data');
                    exwPickupAddressDiv.classList.remove('d-none');
                }

            }
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
            });
        }

        function toggleCustomerProspectSection() {
            let isCustomerProspect = document.querySelector('input[name="is_customer_prospect"]:checked').value;

            if (isCustomerProspect === "customer") {

                $("#contentCustomer").removeClass("d-none");
                $("#contentProspect").addClass("d-none");
                $("#contentProspect").find('input').val("");

            } else {
                $("#contentCustomer").addClass("d-none");
                $("#contentProspect").removeClass("d-none");
                $('#id_customer').val('').trigger('change');
            }
        }


        function toggleSupplierNewOldtSection() {
            let isNewSupplier = document.querySelector('input[name="isNewSupplier"]:checked').value;
            if (isNewSupplier === "Si") {
               
                $("#divSupplierNew").removeClass("d-none");
                $("#divSupplierOld").addClass("d-none");
                $("#divSupplierNew").find('input').val("");

            } else {
                $("#divSupplierOld").removeClass("d-none");
                $("#divSupplierNew").addClass("d-none");
                $('#divSupplierOld').val('').trigger('change');
            }
        }

        function showItemConsolidated() {
            $('#modal-consolidated').modal('show');
        }

        function removeRow(button) {
            button.parentElement.parentElement.remove();
        }



        $('#weight').on('change', (e) => {

            let kilogramsVal = $(e.target).val();
            let kilograms = kilogramsVal.replace(/,/g, '');
            let numberValue = parseFloat(kilograms);

            if (!kilogramsVal || isNaN(numberValue)) {

                $('#pounds').val(0);

            } else {

                $('#pounds').val(numberValue * 2.21);

            }


        });



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
            let nroPackage = parseInt(formContainer.querySelector("#nro_package").value); // Usar querySelector aquí también
            let valueMeasuresHidden = formContainer.querySelector('#value_measures');

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
                    alert(
                        'El numero de paquetes / bultos no puede ser menor que la cantidad ingresada'
                    );
                    return;
                }


                currentPackage += amount_package;


                if (currentPackage > nroPackage) {
                    alert(
                        'No se puede agregar otra fila, por que segun los registros ya completaste el numero de bultos'
                    );
                    currentPackage -= amount_package;
                    return;
                }

                const newRow = table.row.add([

                    // Campo para Cantidad
                    `<input type="number" class="form-control"  readonly id="amount-${rowIndex}" name="amount-${rowIndex}" value="${amount_package}" placeholder="Cantidad" min="0" step="1">`,

                    // Campo para Ancho
                    `<input type="number" class="form-control"  readonly id="width-${rowIndex}" name="width-${rowIndex}" value="${width}" placeholder="Ancho" min="0" step="0.0001">`,

                    // Campo para Largo
                    `<input type="number" class="form-control"  readonly id="length-${rowIndex}" name="length-${rowIndex}" value="${length}" placeholder="Largo" min="0" step="0.0001">`,

                    // Campo para Alto
                    `<input type="number" class="form-control"  readonly id="height-${rowIndex}" name="height-${rowIndex}" value="${height}" placeholder="Alto" min="0" step="0.0001">`,
                    // Campo para unidad de medida
                    `<input type="text" class="form-control"  readonly id="unit-measurement-${rowIndex}" name="unit_measurement-${rowIndex}" value="${unit_measurement}">`,

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

                let containerName = $('#id_containers option:selected').text().trim();
                let packaginTypeName = $('#formContainer #id_packaging_type option:selected').text().trim();
                let unit_of_volumen_kgv = $('#formContainer #unit_of_volumen_kgv option:selected').text().trim();
                let unit_of_weight = $('#formContainer #unit_of_weight option:selected').text().trim();

                let container = {
                    'id_container': getValueByNameFCL('id_containers'),
                    'containerName': containerName,
                    'container_quantity': getValueByNameFCL('container_quantity'),
                    'commodity': getValueByNameFCL('commodity'),
                    'nro_package': getValueByNameFCL('nro_package'),
                    'id_packaging_type': getValueByNameFCL('id_packaging_type'),
                    'packaginTypeName': packaginTypeName,
                    'load_value': getValueByNameFCL('load_value'),
                    'volumen_kgv': getValueByNameFCL('volumen_kgv'),
                    'unit_of_volumen_kgv': unit_of_volumen_kgv,
                    'weight': getValueByNameFCL('weight'),
                    'unit_of_weight': unit_of_weight,
                    'value_measures': getValueByNameFCL('value_measures') ? JSON.parse(getValueByNameFCL(
                        'value_measures')) : ''
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

        /* Agregar un item del consolidado  */

        function saveConsolidated(e) {

            let tableShipper = $('#providersTable');
            let elements = $('#form-consolidated').find('input.required, select.required').toArray();

            if (!validateInputs(elements)) {
                return;
            }

            let shipper = {
                'id_incoterms': getValueByName('id_incoterms'),
                'shipper_name': getValueByName('shipper_name'),
                'shipper_contact': getValueByName('shipper_contact'),
                'shipper_contact_email': getValueByName('shipper_contact_email'),
                'shipper_contact_phone': getValueByName('shipper_contact_phone'),
                'shipper_address': getValueByName('shipper_address'),
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

            // Agregar shipper al array y obtener su índice
            let index = shippers.length;
            shippers.push(shipper);

            // Actualizar el input hidden con la nueva lista en JSON
            updateHiddenInput();

            let newRow = `
                    <tr data-index="${index}">
                        <td>${shipper.shipper_name}</td>
                        <td>${shipper.shipper_contact}</td>
                        <td>${shipper.shipper_address}</td>
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

        // Función para actualizar el input hidden con el array `shippers`
        function updateHiddenInput() {
            $('#shippers_consolidated').val(JSON.stringify(shippers));
        }


        $('#providersTable').on('click', '.delete-row', function() {
            let row = $(this).closest('tr'); // Obtener la fila
            let index = row.data('index'); // Obtener el índice del array

            // Eliminar del array si el índice es válido
            if (index !== undefined && index < shippers.length) {
                shippers.splice(index, 1);
            }


            row.remove(); // Eliminar la fila del DOM


            // Actualizar los índices de las filas restantes
            $('#providersTable tbody tr').each(function(i) {
                $(this).attr('data-index', i);
            });

            // Actualizar el input hidden con la nueva lista
            updateHiddenInput();
        });

        $('#providersTable').on('click', '.btn-detail', function() {

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

                const fclFields = document.querySelectorAll('.fcl-fields');
                const lclFields = document.querySelectorAll('.lcl-fields');


                if (this.value === 'FCL') {
                    // Mostrar los campos FCL y ocultar los LCL
                    fclFields.forEach(el => el.classList.remove('d-none'));
                    lclFields.forEach(el => el.classList.add('d-none'));

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
                    // Mostrar los campos LCL y ocultar los FCL
                    fclFields.forEach(el => el.classList.add('d-none'));
                    lclFields.forEach(el => el.classList.remove('d-none'));

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


    {{-- Stepper --}}


    <script>
        document.addEventListener("DOMContentLoaded", (event) => {

            var form = document.getElementById('formRouting');

            if (form.querySelectorAll(".is-invalid").length > 0) {

                var invalidInputs = form.querySelectorAll(".is-invalid");
                if (form.querySelectorAll(".is-invalid")) {
                    // Encuentra el contenedor del paso que contiene el campo de entrada inválido
                    var stepContainer = invalidInputs[0].parentNode.parentNode.closest('.bs-stepper-pane')

                    // Encuentra el índice del paso correspondiente
                    var stepIndex = Array.from(stepContainer.parentElement.children).indexOf(stepContainer);

                    // Cambia el stepper al paso correspondiente
                    stepper.to(stepIndex);

                    // Enfoca el primer campo de entrada inválido
                    invalidInputs[0].focus();
                }


            }
        });


        var stepper1Node = document.querySelector('#stepper');
        var stepper = new Stepper(document.querySelector('#stepper'));


        function submitForm() {
            var form = document.getElementById('formRouting');


            if (form.checkValidity()) {
                // Aquí puedes enviar el formulario si la validación pasa
                form.submit();
            } else {


                var invalidInputs = form.querySelectorAll(":invalid");
                if (form.querySelectorAll("invalid")) {
                    // Encuentra el contenedor del paso que contiene el campo de entrada inválido
                    var stepContainer = invalidInputs[0].closest('.content');

                    // Encuentra el índice del paso correspondiente
                    var stepIndex = Array.from(stepContainer.parentElement.children).indexOf(stepContainer);

                    // Cambia el stepper al paso correspondiente
                    stepper.to(stepIndex);

                    // Enfoca el primer campo de entrada inválido
                    invalidInputs[0].focus();
                }
            }
        }


        function validarInputNumber(input) {
            if (input.value < 0) {
                input.value = '';
            }
        }
    </script>
@endpush
