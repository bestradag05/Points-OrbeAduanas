        {{-- Commercial Fill Data --}}
        <x-adminlte-modal id="commercialFillData" class="modal"
            title="Complete la informacion para aceptar esta cotizacion" size='lg' scrollable>
            <form action="/customs" method="POST">
                @csrf

                <div class="row">

                    <div class="col-6">

                        <x-adminlte-select2 name="id_document" label="Tipo de documento" igroup-size="sm"
                            data-placeholder="Seleccione una opcion...">
                            <option />
                            @foreach ($documents as $document)
                                <option value="{{ $document->id }}"
                                    {{ (isset($customer->id_document) && $customer->id_document == $document->id) || old('id_document') == $document->id ? 'selected' : '' }}>
                                    {{ $document->name }}
                                </option>
                            @endforeach
                        </x-adminlte-select2>

                    </div>

                    <div class="col-6">
                        <label for="document_number">Numero de documento</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" class="form-control form-control-sm" id="document_number" name="document_number"
                                placeholder="Ingrese su numero de documento" onchange="searchsupplier(this)"
                                value="{{ isset($customer->document_number) ? $customer->document_number : old('document_number') }}">

                        </div>

                        @error('document_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="col-6">

                        <div class="form-group">
                            <label for="name_businessname">Razon Social / Nombre</label>
                            <input type="text" class="form-control form-control-sm" id="name_businessname" name="name_businessname"
                                placeholder="Ingrese su razon social o nombre"
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
                            <input type="text" class="form-control form-control-sm" id="contact_name" name="contact_name"
                                placeholder="Ingrese su numero de celular"
                                value="{{ isset($customer->contact_name) ? $customer->contact_name : old('contact_name') }}">
                            @error('contact_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="col-6">
                        <div class="form-group">
                            <label for="contact_number">Numero del contacto</label>
                            <input type="text" class="form-control form-control-sm" id="contact_number" name="contact_number"
                                placeholder="Ingrese su numero de celular"
                                value="{{ isset($customer->contact_number) ? $customer->contact_number : old('contact_number') }}">
                            @error('contact_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="col-6">

                        <div class="form-group">
                            <label for="contact_email">Correo del contacto</label>
                            <input type="text" class="form-control form-control-sm" id="contact_email" name="contact_email"
                                placeholder="Ingrese su numero de celular"
                                value="{{ isset($customer->contact_email) ? $customer->contact_email : old('contact_email') }}">
                            @error('contact_email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>



                </div>

                <x-slot name="footerSlot">
                    <x-adminlte-button class="btn btn-indigo" id="btnSubmit" type="submit"
                        onclick="submitCustomsForm(this)" label="Guardar" />
                    <x-adminlte-button theme="secondary" label="Cerrar" data-dismiss="modal" />
                </x-slot>

            </form>
        </x-adminlte-modal>
