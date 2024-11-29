<div class="container">
    <div class="row">
        <div class="col-12">

            <div class="head-quote mb-2">
                <h5 class="text-center text-uppercase bg-indigo p-2">Formato LCL</h5>
            </div>
            <div class="body-detail-customer p-2">
                <div class="form-group row">
                    <label for="customer" class="col-sm-2 col-form-label">Cliente</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="customer" name="customer"
                            placeholder="Ingresa el cliente">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pick_up" class="col-sm-2 col-form-label">Direccion de recojo</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pick_up" name="pick_up"
                            placeholder="Ingrese la direccion de recojo">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="delivery" class="col-sm-2 col-form-label">Direccion de entrega</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="delivery" name="delivery"
                            placeholder="Ingrese la direccion de entrega">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="contact_name" class="col-sm-2 col-form-label">Nombre del contacto</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="contact_name" name="contact_name"
                            placeholder="Ingresa el nombre del contacto">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="contact_phone" class="col-sm-2 col-form-label">Telefono del contacto</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="contact_phone" name="contract_phone"
                            placeholder="Ingresa el numero de celular del contacto">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="max_attention_hour" class="col-sm-2 col-form-label">Hora maxima de entrega</label>
                    @php
                        $config = ['format' => 'LT'];
                    @endphp
                    <x-adminlte-input-date name="max_attention_hour" :config="$config" placeholder="Ingrese la hora maxima de entrega">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-indigo">
                                <i class="fas fa-clock"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>

                </div>
                <div class="form-group row">
                    <label for="gang" class="col-sm-2 col-form-label">Cuadrilla</label>
                    <div class="col-sm-10">
                        <div class="form-check d-inline">
                            <input type="radio" id="radioLclFcl" name="gang" value="SI"
                                class="form-check-input">
                            <label for="radioLclFcl" class="form-check-label">
                                SI
                            </label>
                        </div>
                        <div class="form-check d-inline">
                            <input type="radio" id="radioLclFcl" name="gang" value="NO"
                                class="form-check-input">
                            <label for="radioLclFcl" class="form-check-label">
                                NO
                            </label>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="col-12">

            <div class="head-quote mb-2">
                <h5 class="text-center text-uppercase bg-indigo p-2">Detalle de carga LCL</h5>
            </div>
            <div class="body-detail-product p-2">
                <div class="form-group row">
                    <label for="load_type" class="col-sm-2 col-form-label">Tipo de Carga</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="load_type" name="load_type"
                            placeholder="Ingrese el tipo de carga">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="commodity" class="col-sm-2 col-form-label">Descripcion</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="commodity" name="commodity"
                            placeholder="Ingrese descripcion del producto">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="packaging_type" class="col-sm-2 col-form-label">Tipo de embalaje</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="packaging_type" name="packaging_type"
                            placeholder="Ingrese el tipo de embalaje">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="stackable" class="col-sm-2 col-form-label">Apilable</label>
                    <div class="col-sm-10">
                        <div class="form-check d-inline">
                            <input type="radio" id="radioStackable" name="stackable" value="SI"
                                class="form-check-input">
                            <labe l for="radioStackable" class="form-check-label">
                                SI
                            </labe>
                        </div>
                        <div class="form-check d-inline">
                            <input type="radio" id="radioStackable" name="stackable" value="NO"
                                class="form-check-input">
                            <label for="radioStackable" class="form-check-label">
                                NO
                            </label>
                        </div>

                    </div>
                </div>
                <div class="form-group row">
                    <label for="cubage_kgv" class="col-sm-2 col-form-label">Cubicaje/KGV</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="cubage_kgv" name="cubage_kgv"
                            placeholder="Ingresa el numero de celular del contacto">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="total_weight" class="col-sm-2 col-form-label">Peso total</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="total_weight" name="total_weight"
                            placeholder="Ingresa la hora maxima de recojo del cliente">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="packages" class="col-sm-2 col-form-label">Bultos</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="packages" name="packages"
                            placeholder="Ingresa si tendra valor de cuadrilla">
                    </div>
                </div>
            </div>

        </div>


    </div>
</div>

<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
</div>
