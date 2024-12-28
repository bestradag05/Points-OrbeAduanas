<div class="container">
    <div class="row">
        <div class="col-12">

            <div class="head-quote mb-2">
                <h5 id="title_quote" class="text-center text-uppercase bg-indigo p-2">Formato <span></span></h5>
            </div>
            <div class="body-detail-customer p-2">
                <div class="form-group row">
                    <label for="customer" class="col-sm-2 col-form-label">Cliente</label>
                    <div class="col-sm-10 customer_quote">
                        <input type="text" class="form-control @error('customer') is-invalid @enderror"
                            id="customer_name" name="customer_name" placeholder="Ingresa el cliente"
                            value="{{ isset($quote->customer_name) ? $quote->customer_name : old('customer_name') }}">

                        <input type="hidden" id="customer" name="customer"
                            value="{{ isset($quote->customer) ? $quote->customer : old('customer') }}">
                    </div>
                    <div class="col-sm-10 d-none customer_quote_manual">
                        <select name="customer_manual"
                            class="form-control @error('customer_manual') is-invalid @enderror">
                            <option />
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ (isset($quote->id_customer) && $quote->id_customer == $customer->id) || old('customer_manual') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name_businessname }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="form-group row lcl_quote">
                    <label for="pick_up_lcl" class="col-sm-2 col-form-label">Direccion de recojo</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('pick_up_lcl') is-invalid @enderror"
                            id="pick_up_lcl" name="pick_up_lcl" placeholder="Ingrese la direccion de recojo"
                            value="{{ isset($quote->pick_up) && $quote->lcl_fcl === 'LCL' ? $quote->pick_up : old('pick_up_lcl') }}">
                        @error('pick_up_lcl')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="form-group row  fcl_quote">
                    <label for="pick_up_fcl" class="col-sm-2 col-form-label">Puerto / Almacen</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('pick_up_fcl') is-invalid @enderror"
                            id="pick_up_fcl" name="pick_up_fcl" placeholder="Ingrese la direccion de recojo"
                            value="{{ isset($quote->pick_up) && $quote->lcl_fcl === 'FCL' ? $quote->pick_up : old('pick_up_fcl') }}">
                        @error('pick_up_fcl')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="delivery" class="col-sm-2 col-form-label">Direccion de entrega</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('delivery') is-invalid @enderror"
                            id="delivery" name="delivery" placeholder="Ingrese la direccion de entrega"
                            value="{{ isset($quote->delivery) ? $quote->delivery : old('delivery') }}">
                        @error('delivery')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row fcl_quote">
                    <label for="container_return" class="col-sm-2 col-form-label">Devolucion de contenedor</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('container_return') is-invalid @enderror"
                            id="container_return" name="container_return"
                            placeholder="Ingrese donde se hara la devolucion"
                            value="{{ isset($quote->container_return) ? $quote->container_return : old('container_return') }}">

                        @error('container_return')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="contact_name" class="col-sm-2 col-form-label">Nombre del contacto</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('contact_name') is-invalid @enderror"
                            id="contact_name" name="contact_name" placeholder="Ingresa el nombre del contacto"
                            value="{{ isset($quote->contact_name) ? $quote->contact_name : old('contact_name') }}">
                        @error('contact_name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>
                <div class="form-group row">
                    <label for="contact_phone" class="col-sm-2 col-form-label">Telefono del contacto</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('contact_phone') is-invalid @enderror"
                            id="contact_phone" name="contact_phone"
                            placeholder="Ingresa el numero de celular del contacto"
                            value="{{ isset($quote->contact_phone) ? $quote->contact_phone : old('contact_phone') }}">
                        @error('contact_phone')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                </div>
                <div class="form-group row">
                    <label for="max_attention_hour" class="col-sm-2 col-form-label">Hora maxima de entrega</label>
                    @php
                        $config = ['format' => 'LT'];
                    @endphp
                    <x-adminlte-input-date name="max_attention_hour" :config="$config"
                        placeholder="Ingrese la hora maxima de entrega"
                        value="{{ isset($quote->max_attention_hour) ? $quote->max_attention_hour : old('max_attention_hour') }}">
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
                                class="form-check-input @error('gang') is-invalid @enderror"
                                {{ (isset($quote->gang) && $quote->gang === 'SI') || old('gang') === 'SI' ? 'checked' : '' }}>
                            <label for="radioLclFcl" class="form-check-label">
                                SI
                            </label>
                        </div>
                        <div class="form-check d-inline">
                            <input type="radio" id="radioLclFcl" name="gang" value="NO"
                                class="form-check-input @error('gang') is-invalid @enderror"
                                {{ (isset($quote->gang) && $quote->gang === 'NO') || old('gang') === 'NO' ? 'checked' : '' }}>
                            <label for="radioLclFcl" class="form-check-label">
                                NO
                            </label>
                        </div>

                        @error('gang')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                </div>
                <div class="form-group row  fcl_quote">
                    <label for="guard" class="col-sm-2 col-form-label">Resguardo</label>
                    <div class="col-sm-10">
                        <div class="form-check d-inline">
                            <input type="radio" id="radioGuard" name="guard" value="SI"
                                class="form-check-input @error('guard') is-invalid @enderror"
                                {{ (isset($quote->guard) && $quote->guard === 'SI') || old('guard') === 'SI' ? 'checked' : '' }}>
                            <label for="radioGuard" class="form-check-label">
                                SI
                            </label>
                        </div>
                        <div class="form-check d-inline">
                            <input type="radio" id="radioGuard" name="guard" value="NO"
                                class="form-check-input @error('guard') is-invalid @enderror"
                                {{ (isset($quote->guard) && $quote->guard === 'NO') || old('guard') === 'NO' ? 'checked' : '' }}>
                            <label for="radioGuard" class="form-check-label">
                                NO
                            </label>
                        </div>

                        @error('guard')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                </div>


                <div class="form-group row">
                    <label for="customer_detail" class="col-sm-2 col-form-label">Detalles</label>
                    <div class="col-sm-10">
                        <textarea class="form-control @error('customer_detail') is-invalid @enderror" id="customer_detail"
                            name="customer_detail" placeholder="Ingresa un detalle o alguna observacion">{{ isset($quote->customer_detail) ? $quote->customer_detail : old('customer_detail') }}</textarea>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-12">

            <div class="head-quote mb-2">
                <h5 id="title_quote" class="text-center text-uppercase bg-indigo p-2">Detalle de carga <span></span>
                </h5>
            </div>
            <div class="body-detail-product p-2">
                <div class="form-group row">
                    <label for="load_type" class="col-sm-2 col-form-label">Tipo de Carga</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('load_type') is-invalid @enderror"
                            id="load_type" name="load_type" placeholder="Ingrese el tipo de carga"
                            value="{{ isset($quote->load_type) ? $quote->load_type : old('load_type') }}">
                        @error('load_type')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                </div>
                <div class="form-group row">
                    <label for="commodity" class="col-sm-2 col-form-label">Descripcion</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('commodity') is-invalid @enderror"
                            id="commodity" name="commodity" placeholder="Ingrese descripcion del producto"
                            value="{{ isset($quote->commodity) ? $quote->commodity : old('commodity') }}">
                        @error('commodity')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                </div>
                <div class="form-group row  fcl_quote">
                    <label for="container_type" class="col-sm-2 col-form-label">Tipo de contenedor</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('container_type') is-invalid @enderror"
                            id="container_type" name="container_type" placeholder="Ingrese el tipo de contenedor"
                            value="{{ isset($quote->container_type) ? $quote->container_type : old('container_type') }}">


                        @error('container_type')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                </div>
                <div class="form-group row  fcl_quote">
                    <label for="ton_kilogram" class="col-sm-2 col-form-label">Toneladas / KG</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('ton_kilogram') is-invalid @enderror"
                            id="ton_kilogram" name="ton_kilogram" placeholder="Ingrese el preso de carga"
                            value="{{ isset($quote->ton_kilogram) ? $quote->ton_kilogram : old('ton_kilogram') }}">

                        @error('ton_kilogram')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="packaging_type" class="col-sm-2 col-form-label">Tipo de embalaje</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('packaging_type') is-invalid @enderror"
                            id="packaging_type" name="packaging_type" placeholder="Ingrese el tipo de embalaje"
                            value="{{ isset($quote->packaging_type) ? $quote->packaging_type : old('packaging_type') }}">

                        @error('packaging_type')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>
                <div class="form-group row lcl_quote">
                    <label for="stackable" class="col-sm-2 col-form-label">Apilable</label>
                    <div class="col-sm-10">
                        <div class="form-check d-inline">
                            <input type="radio" id="radioStackable" name="stackable" value="SI"
                                class="form-check-input @error('stackable') is-invalid @enderror"
                                {{ (isset($quote->stackable) && $quote->stackable === 'SI') || old('stackable') === 'SI' ? 'checked' : '' }}>
                            <label for="radioStackable" class="form-check-label">
                                SI
                            </label>
                        </div>
                        <div class="form-check d-inline">
                            <input type="radio" id="radioStackable" name="stackable" value="NO"
                                class="form-check-input  @error('stackable') is-invalid @enderror"
                                {{ (isset($quote->stackable) && $quote->stackable === 'NO') || old('stackable') === 'NO' ? 'checked' : '' }}>
                            <label for="radioStackable" class="form-check-label">
                                NO
                            </label>
                        </div>
                        @error('stackable')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                </div>
                <div class="form-group row lcl_quote">
                    <label for="cubage_kgv" class="col-sm-2 col-form-label">Cubicaje/KGV</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('cubage_kgv') is-invalid @enderror"
                            id="cubage_kgv" name="cubage_kgv" placeholder="Ingresa el cubicaje / kgv"
                            value="{{ isset($quote->cubage_kgv) ? $quote->cubage_kgv : old('cubage_kgv') }}">
                        @error('cubage_kgv')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row lcl_quote">
                    <label for="total_weight" class="col-sm-2 col-form-label">Peso total</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('total_weight') is-invalid @enderror"
                            id="total_weight" name="total_weight"
                            placeholder="Ingresa la hora maxima de recojo del cliente"
                            value="{{ isset($quote->total_weight) ? $quote->total_weight : old('total_weight') }}">
                        @error('total_weight')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror


                    </div>

                </div>
                <div class="form-group row">
                    <label for="packages" class="col-sm-2 col-form-label">Bultos</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('packages') is-invalid @enderror"
                            id="packages" name="packages" placeholder="Ingresa si tendra valor de cuadrilla"
                            value="{{ isset($quote->packages) ? $quote->packages : old('packages') }}">
                        @error('packages')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                </div>

                <div class="form-group row">
                    <label for="cargo_detail" class="col-sm-2 col-form-label">Detalles</label>
                    <div class="col-sm-10">
                        <textarea class="form-control @error('cargo_detail') is-invalid @enderror" id="cargo_detail" name="cargo_detail"
                            placeholder="Ingresa un detalle o alguna observacion">{{ isset($quote->cargo_detail) ? $quote->cargo_detail : old('cargo_detail') }}</textarea>
                    </div>
                </div>

            </div>

        </div>


        <div class="col-12">

            <div class="head-quote mb-2">
                <h5 class="text-center text-uppercase bg-indigo p-2">Medidas</h5>
            </div>
            <div class="body-detail-product p-2">

                <div id="div_measures" class="row justify-content-center mb-4 d-none">

                    <div class="col-2">
                        <input type="number" class="form-control" step="1" id="amount_package"
                            name="amount_package" placeholder="Ingresa N° bultos">
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control CurrencyInput" data-type="currency" id="width"
                            name="width" placeholder="Ancho(cm)">
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control CurrencyInput" data-type="currency" id="length"
                            name="length" placeholder="Largo(cm)">
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control CurrencyInput" data-type="currency" id="height"
                            name="height" placeholder="Alto(cm)">
                    </div>
                    <div class="col-2">
                        <button id="addRow" class="btn btn-indigo btn-sm"><i
                                class="fa fa-plus"></i>Agregar</button>
                    </div>

                </div>

                <table id="table_measures" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Cantidad</th>
                            <th>Ancho (cm)</th>
                            <th>Largo (cm)</th>
                            <th>Alto (cm)</th>
                            <th id="measure_delete" class="d-none">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Las filas de la tabla se llenarán dinámicamente -->
                    </tbody>

                </table>

                <input type="hidden" id="measures" name="measures">
                <input type="hidden" id="nro_operation" name="nro_operation"
                    value="{{ isset($quote->nro_operation) ? $quote->nro_operation : old('nro_operation') }}">
                <input type="hidden" id="lcl_fcl" name="lcl_fcl"
                    value="{{ isset($quote->lcl_fcl) ? $quote->lcl_fcl : old('lcl_fcl') }}">

            </div>

        </div>




    </div>
</div>

<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
</div>


@push('scripts')
    @if ($showModal ?? false)
        <script>
            $('#searchRouting').on('click', () => {

                const nro_operation = $('#modal_nro_operation').val().trim();

                if (nro_operation === '') {

                    $('#modal_nro_operation').addClass('is-invalid');
                    $('#error_nro_operation').removeClass('d-block').addClass('d-none');

                } else {
                    $('#modal_nro_operation').removeClass('is-invalid');

                    // Realizar solicitud AJAX
                    $.ajax({
                        url: `/quote/search-routing/${nro_operation}`, // Cambia esto por la URL de tu servidor
                        type: 'GET',
                        success: function(response) {
                            // Manejo de la respuesta exitosa

                            loadInfoRouting(response.data[0]);


                        },
                        error: function(xhr, status, error) {
                            // Manejo del error
                            var errorMessage = xhr.responseJSON ? xhr.responseJSON.message :
                                'Ocurrió un error inesperado.';

                            // Mostrar el mensaje de error al usuario
                            $('#error_nro_operation').removeClass('d-none').addClass('d-block');
                            $('#texto_nro_operation').text(errorMessage);
                            $('#modal_nro_operation').addClass('is-invalid');

                        }
                    });

                }



            });



            function loadInfoRouting(data) {
                if (data.lcl_fcl === 'LCL' || data.lcl_fcl === null) {
                    $('#title_quote span').text('LCL');

                    $('.lcl_quote').removeClass('d-none');
                    $('.fcl_quote').addClass('d-none');


                } else {
                    $('#title_quote span').text('FCL');
                    $('.lcl_quote').addClass('d-none');
                    $('.fcl_quote').removeClass('d-none');
                }

                $('#customer_name').val(data.customer.name_businessname).prop('readonly', true);
                $('#customer').val(data.customer.id);
                $('#contact_name').val(data.customer.contact_name);
                $('#contact_phone').val(data.customer.contact_number);
                $('#load_type').val(data.type_load.name).prop('readonly', true);
                $('#commodity').val(data.commodity).prop('readonly', true);
                $('#packaging_type').val(data.packaging_type).prop('readonly', true);

                if (data.type_shipment.description === "Marítima" && data.lcl_fcl === 'LCL') {
                    $('#cubage_kgv').val(data.volumen + ' m3').prop('readonly', true);
                }

                if (data.type_shipment.description === "Marítima" && data.lcl_fcl === 'FCL') {
                    $('#container_type').val(data.container_type).prop('readonly', true);
                }

                if (data.type_shipment.description === "Aérea" && data.lcl_fcl === null) {
                    $('#cubage_kgv').val(data.kilogram_volumen + ' KGV').prop('readonly', true);
                }

                if (data.type_shipment.description === "Marítima" && data.lcl_fcl === 'FCL') {
                    $('#ton_kilogram').val(data.tons + " T").prop('readonly', true);
                }
                $('#total_weight').val(data.kilograms).prop('readonly', true);
                $('#packages').val(data.nro_package).prop('readonly', true);
                $('#measures').val(data.measures);
                //Campos Hidden
                $('#nro_operation').val(data.nro_operation);
                if (data.lcl_fcl != null) {

                    $('#lcl_fcl').val(data.lcl_fcl);
                } else {
                    $('#lcl_fcl').val('LCL');
                }

                //load Table measures

                populateTable(JSON.parse(data.measures));


                // Cerrar el modal utilizando la instancia nativa de Bootstrap
                $('#modalQuoteTransport').hide();

                // Eliminar manualmente el backdrop si persiste
                const modalBackdrop = document.querySelector('.modal-backdrop');
                if (modalBackdrop) {
                    modalBackdrop.remove();
                }

                // Eliminar la clase `modal-open` del body para restaurar el scroll
                document.body.classList.remove('modal-open');
                document.body.style.paddingRight = ''


            }



            function populateTable(data) {
                const tableBody = document.getElementById('table_measures').getElementsByTagName('tbody')[0];

                // Limpiar la tabla antes de agregar nuevos datos
                tableBody.innerHTML = '';

                // Iterar sobre los datos y agregar una fila por cada objeto
                for (const key in data) {
                    if (data.hasOwnProperty(key)) {
                        const item = data[key]; // Accede al objeto de cada clave

                        // Crear una nueva fila
                        let row = tableBody.insertRow();

                        // Insertar celdas en la fila y agregar los valores
                        let cellAmount = row.insertCell(0);
                        cellAmount.textContent = item.amount;

                        let cellHeight = row.insertCell(1);
                        cellHeight.textContent = item.height;

                        let cellLength = row.insertCell(2);
                        cellLength.textContent = item.length;

                        let cellWidth = row.insertCell(3);
                        cellWidth.textContent = item.width;
                    }
                }

            }


            //Insertar manualmente las medidas: 

            //Inicializamos la tabla de medidas

            const table = new DataTable('#table_measures', {
                paging: false, // Desactiva la paginación
                searching: false, // Oculta el cuadro de búsqueda
                info: false, // Oculta la información del estado de la tabla
                lengthChange: false, // Oculta el selector de cantidad de registros por página
                language: { // Traducciones al español
                    emptyTable: "No hay medidas registradas"
                }
            });
            let counter = 1;

            // Función para agregar una fila editable
            let rowIndex = 1; //
            let currentPackage = 0;
            let arrayMeasures = {};

            document.getElementById('addRow').addEventListener('click', (e) => {

                e.preventDefault();

                var measures = document.getElementById("div_measures");
                const inputs = measures.querySelectorAll('input');

                let isValid = true;
                inputs.forEach(input => {

                    if (input.value.trim() === '' || input.value <= 0) {
                        isValid = false;
                        input.classList.add('is-invalid');
                        return;
                    } else {
                        input.classList.remove('is-invalid');
                        return;
                    }

                });

                if (!isValid) {
                    return;
                }

                const nro_package = parseInt($('#packages').val());
                const amount_package = parseInt($('#amount_package').val());
                const width = inputs[1].value.replace(/,/g, '');;
                const length = inputs[2].value.replace(/,/g, '');;
                const height = inputs[3].value.replace(/,/g, '');;




                if (isNaN(amount_package) || amount_package <= 0) {
                    $('#amount_package').addClass('is-invalid');
                    return;
                } else {
                    if (isNaN(nro_package) || amount_package > nro_package) {
                        alert(
                            'El numero de paquetes / bultos no puede ser menor que la cantidad ingresada'
                        );
                        return;
                    }

                    currentPackage += amount_package;


                    if (currentPackage > nro_package) {
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

                        `<button type="button" class="btn btn-danger btn-sm" id="delete-${rowIndex}" onclick="deleteRow('row-${rowIndex}', ${amount_package}, ${rowIndex})"><i class="fa fa-trash"></i></button>`
                    ]).draw().node();
                    newRow.id = `row-${rowIndex}`;

                    arrayMeasures[rowIndex] = { // Usamos rowIndex como clave
                        amount: amount_package,
                        width,
                        length,
                        height
                    };


                    $('#measures').val(JSON.stringify(arrayMeasures));

                    rowIndex++

                    // Opcional: Enfocar el primer campo de la nueva fila
                    newRow.querySelector('input').focus();

                }

            });


            function deleteRow(rowId, amount, index) {
                // Reducir el paquete actual
                currentPackage -= parseInt(amount);
                // Eliminar la fila del DataTable
                const row = document.getElementById(rowId);
                table.row($(row).closest('tr')).remove().draw();
                delete arrayMeasures[index];
                $('#measures').val(JSON.stringify(arrayMeasures));

            }

            function cleanMeasures() {
                table.clear().draw();

                arrayMeasures = {};
                $('#measures').val("");

                // Restablecer variables relacionadas
                currentPackage = 0;
                rowIndex = 1;

            }
        </script>
    @else
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                let customer_manual = $('.customer_quote_manual').find('select')[0];
                let nro_operation = $('#nro_operation').val();


                if ((customer_manual.value !== '' || customer_manual.classList.contains('is-invalid')) && nro_operation === "") {
                    $('.customer_quote_manual').removeClass('d-none');
                    $('.customer_quote').addClass('d-none');
                }



            });

            // Cerrar el modal utilizando la instancia nativa de Bootstrap
            $('#modalQuoteTransport').hide();

            // Eliminar manualmente el backdrop si persiste
            const modalBackdrop = document.querySelector('.modal-backdrop');
            if (modalBackdrop) {
                modalBackdrop.remove();
            }

            // Eliminar la clase `modal-open` del body para restaurar el scroll
            document.body.classList.remove('modal-open');
            document.body.style.paddingRight = ''

            //Buscamos numero de operacion
            const nro_operation = $('#nro_operation').val();



            if (nro_operation === '') {
                const lcl_fcl = $('#lcl_fcl').val();


                if (lcl_fcl === 'LCL' || !lcl_fcl) {
                    $('#title_quote span').text('LCL');

                    $('.lcl_quote').removeClass('d-none');
                    $('.fcl_quote').addClass('d-none');


                } else {
                    $('#title_quote span').text('FCL');
                    $('.lcl_quote').addClass('d-none');
                    $('.fcl_quote').removeClass('d-none');
                }

            }


            // Realizar solicitud AJAX
            $.ajax({
                url: `/quote/search-routing/${nro_operation}`, // Cambia esto por la URL de tu servidor
                type: 'GET',
                success: function(response) {
                    // Manejo de la respuesta exitosa

                    loadInfoRouting(response.data[0]);


                },
                error: function(xhr, status, error) {
                    // Manejo del error
                    var errorMessage = xhr.responseJSON ? xhr.responseJSON.message :
                        'Ocurrió un error inesperado.';

                    // Mostrar el mensaje de error al usuario
                    $('#error_nro_operation').removeClass('d-none').addClass('d-block');
                    $('#texto_nro_operation').text(errorMessage);
                    $('#modal_nro_operation').addClass('is-invalid');

                }
            });


            function loadInfoRouting(data) {

                $('#title_quote span').text(data.lcl_fcl);


                if (data.lcl_fcl === 'LCL' || data.lcl_fcl === null) {
                    $('#title_quote span').text('LCL');

                    $('.lcl_quote').removeClass('d-none');
                    $('.fcl_quote').addClass('d-none');


                } else {
                    $('#title_quote span').text('FCL');
                    $('.lcl_quote').addClass('d-none');
                    $('.fcl_quote').removeClass('d-none');
                }

                $('#customer_name').val(data.customer.name_businessname).prop('readonly', true);
                $('#customer').val(data.customer.id);
                $('#load_type').val(data.type_load.name).prop('readonly', true);
                $('#commodity').val(data.commodity).prop('readonly', true);
                $('#packaging_type').val(data.packaging_type).prop('readonly', true);
                if (data.type_shipment.description === "Marítima" && data.lcl_fcl === 'LCL') {
                    $('#cubage_kgv').val(data.volumen + ' m3').prop('readonly', true);
                }

                if (data.type_shipment.description === "Aérea" && data.lcl_fcl === 'LCL') {
                    $('#cubage_kgv').val(data.kilogram_volumen + ' KGV').prop('readonly', true);
                }

                if (data.type_shipment.description === "Marítima" && data.lcl_fcl === 'FCL') {
                    $('#ton_kilogram').val(data.tons + " T").prop('readonly', true);
                }
                $('#total_weight').val(data.kilograms).prop('readonly', true);
                $('#packages').val(data.nro_package).prop('readonly', true);
                $('#measures').val(data.measures);
                //Campos Hidden
                $('#nro_operation').val(data.nro_operation);
                if (data.lcl_fcl != null) {

                    $('#lcl_fcl').val(data.lcl_fcl);
                } else {
                    $('#lcl_fcl').val('LCL');
                }

                //load Table measures
                populateTable(JSON.parse(data.measures));


                // Cerrar el modal utilizando la instancia nativa de Bootstrap
                $('#modalQuoteTransport').hide();

                // Eliminar manualmente el backdrop si persiste
                const modalBackdrop = document.querySelector('.modal-backdrop');
                if (modalBackdrop) {
                    modalBackdrop.remove();
                }

                // Eliminar la clase `modal-open` del body para restaurar el scroll
                document.body.classList.remove('modal-open');
                document.body.style.paddingRight = ''


            }



            function populateTable(data) {
                const tableBody = document.getElementById('table_measures').getElementsByTagName('tbody')[0];

                // Limpiar la tabla antes de agregar nuevos datos
                tableBody.innerHTML = '';

                // Iterar sobre los datos y agregar una fila por cada objeto
                for (const key in data) {
                    if (data.hasOwnProperty(key)) {
                        const item = data[key]; // Accede al objeto de cada clave

                        // Crear una nueva fila
                        let row = tableBody.insertRow();

                        // Insertar celdas en la fila y agregar los valores
                        let cellAmount = row.insertCell(0);
                        cellAmount.textContent = item.amount;

                        let cellHeight = row.insertCell(1);
                        cellHeight.textContent = item.height;

                        let cellLength = row.insertCell(2);
                        cellLength.textContent = item.length;

                        let cellWidth = row.insertCell(3);
                        cellWidth.textContent = item.width;
                    }
                }

            }
        </script>
    @endif

@endpush
