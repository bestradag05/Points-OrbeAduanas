        {{-- Commercial Fill Data --}}
        <x-adminlte-modal id="commercialFillData" class="modal"
            title="Complete la informacion para aceptar esta cotizacion" size='lg' scrollable>
            <form action="/commercial/quote/completeData" method="POST" id="forCommercialFillData">
                @csrf

                <input type="hidden" name="nro_quote_commercial" value="{{ $comercialQuote->nro_quote_commercial }}">

                <div class="row">

                    <div id="customer-data" class="row col-12 ">

                        <div class="col-12">
                            <h6 class="text-indigo text-bold">Cliente: </h6>
                        </div>

                        <input type="hidden" name="has_customer_data" id="has_customer_data" value="1">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="document_number">Tipo de documento</label>
                                <select name="id_document" class="form-control form-control-sm">
                                    <option />
                                    @foreach ($documents as $document)
                                        <option value="{{ $document->id }}"
                                            {{ (isset($customer->id_document) && $customer->id_document == $document->id) || old('id_document') == $document->id ? 'selected' : '' }}>
                                            {{ $document->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="document_number">Numero de documento</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" id="document_number"
                                        name="document_number" placeholder="Ingrese su numero de documento"
                                        onchange="searchsupplier(this)"
                                        value="{{ isset($customer->document_number) ? $customer->document_number : old('document_number') }}">

                                </div>

                                @error('document_number')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                            </div>

                        </div>

                        <div class="col-6">

                            <div class="form-group">
                                <label for="name_businessname">Razon Social / Nombre</label>
                                <input type="text" class="form-control form-control-sm" id="name_businessname"
                                    name="name_businessname" placeholder="Ingrese su razon social o nombre"
                                    value="{{ isset($customer->name_businessname) ? $customer->name_businessname : old('name_businessname') }}">
                                @error('name_businessname')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>


                        <div class="col-6">

                            <div class="form-group">
                                <label for="address">Direccion</label>
                                <input type="text" class="form-control form-control-sm" id="address" name="address"
                                    placeholder="Ingrese su razon social o nombre"
                                    value="{{ isset($customer->address) ? $customer->address : old('address') }}">
                                @error('address')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>


                        <div class="col-6">
                            <div class="form-group">
                                <label for="contact_name">Nombre del contacto</label>
                                <input type="text" class="form-control form-control-sm" id="contact_name"
                                    name="contact_name" placeholder="Ingrese su numero de celular"
                                    value="{{ isset($customer->contact_name) ? $customer->contact_name : old('contact_name') }}">
                                @error('contact_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="col-6">
                            <div class="form-group">
                                <label for="contact_number">Numero del contacto</label>
                                <input type="text" class="form-control form-control-sm" id="contact_number"
                                    name="contact_number" placeholder="Ingrese su numero de celular"
                                    value="{{ isset($customer->contact_number) ? $customer->contact_number : old('contact_number') }}">
                                @error('contact_number')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="col-6">

                            <div class="form-group">
                                <label for="contact_email">Correo del contacto</label>
                                <input type="text" class="form-control form-control-sm" id="contact_email"
                                    name="contact_email" placeholder="Ingrese su numero de celular"
                                    value="{{ isset($customer->contact_email) ? $customer->contact_email : old('contact_email') }}">
                                @error('contact_email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <hr>
                        </div>

                    </div>

                    {{-- Proveedor --}}

                    <div id="supplier-data" class="row col-12">
                        <div class="col-12">
                            <h6 class="text-indigo text-bold">Proveedor: </h6>
                        </div>

                        <input type="hidden" name="has_supplier_data" id="has_supplier_data" value="1">

                        <div class="col-6">

                            <div class="form-group">
                                <label for="name_businessname_supplier">Razon Social / Nombre</label>
                                <input type="text"
                                    class="form-control @error('name_businessname_supplier') is-invalid @enderror"
                                    id="name_businessname_supplier" name="name_businessname_supplier"
                                    placeholder="Ingrese su razon social o nombre"
                                    @error('name_businessname_supplier') is-invalid @enderror
                                    value="{{ isset($supplier->name_businessname_supplier) ? $supplier->name_businessname_supplier : old('name_businessname_supplier') }}">
                                @error('name_businessname_supplier')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>


                        <div class="col-6">

                            <div class="form-group">
                                <label for="address_supplier">Direccion</label>
                                <input type="text"
                                    class="form-control @error('address_supplier') is-invalid @enderror"
                                    id="address_supplier" name="address_supplier"
                                    placeholder="Ingrese su razon social o nombre"
                                    @error('address_supplier') is-invalid @enderror
                                    value="{{ isset($supplier->address_supplier) ? $supplier->address_supplier : old('address_supplier') }}">
                                @error('address_supplier')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>


                        <div class="col-6">
                            <div class="form-group">
                                <label for="contact_name_supplier">Nombre del contacto</label>
                                <input type="text"
                                    class="form-control @error('contact_name_supplier') is-invalid @enderror"
                                    id="contact_name_supplier" name="contact_name_supplier"
                                    placeholder="Ingrese su numero de celular"
                                    @error('contact_name_supplier') is-invalid @enderror
                                    value="{{ isset($supplier->contact_name_supplier) ? $supplier->contact_name_supplier : old('contact_name_supplier') }}">
                                @error('contact_name_supplier')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="col-6">
                            <div class="form-group">
                                <label for="contact_number_supplier">Numero del contacto</label>
                                <input type="text"
                                    class="form-control @error('contact_number_supplier') is-invalid @enderror"
                                    id="contact_number_supplier" name="contact_number_supplier"
                                    placeholder="Ingrese su numero de celular"
                                    value="{{ isset($supplier->contact_number_supplier) ? $supplier->contact_number_supplier : old('contact_number_supplier') }}">
                                @error('contact_number_supplier')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="col-6">

                            <div class="form-group">
                                <label for="contact_email_supplier">Correo del contacto</label>
                                <input type="text"
                                    class="form-control @error('contact_email_supplier') is-invalid @enderror"
                                    id="contact_email_supplier" name="contact_email_supplier"
                                    placeholder="Ingrese su correo electronico"
                                    value="{{ isset($supplier->contact_email_supplier) ? $supplier->contact_email_supplier : old('contact_email_supplier') }}">
                                @error('contact_email_supplier')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                </div>

                <x-slot name="footerSlot">
                    <x-adminlte-button class="btn btn-indigo" id="btnSubmit" type="submit"
                        onclick="submitFillData(this)" label="Guardar" />
                    <x-adminlte-button theme="secondary" label="Cerrar" data-dismiss="modal" />
                </x-slot>

            </form>
        </x-adminlte-modal>
