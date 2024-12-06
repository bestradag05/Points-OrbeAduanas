<div class="container">
    <div class="row">
        <div class="col-12">

            <div class="head-quote mb-2">
                <h5 id="title_quote" class="text-center text-uppercase bg-indigo p-2">Formato <span></span></h5>
            </div>
            <div class="body-detail-customer p-2">
                <div class="form-group row">
                    <label for="customer" class="col-sm-2 col-form-label">Cliente</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('customer') is-invalid @enderror"
                            id="customer" name="customer" placeholder="Ingresa el cliente"
                            value="{{ isset($quote->customer) ? $quote->customer : old('customer') }}">
                    </div>
                    @error('customer')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row lcl_quote">
                    <label for="pick_up_lcl" class="col-sm-2 col-form-label">Direccion de recojo</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('pick_up_lcl') is-invalid @enderror"
                            id="pick_up_lcl" name="pick_up_lcl" placeholder="Ingrese la direccion de recojo"
                            value="{{ (isset($quote->pick_up) && $quote->lcl_fcl === 'LCL') ? $quote->pick_up : old('pick_up_lcl') }}">
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
                            value="{{ (isset($quote->pick_up) && $quote->lcl_fcl === 'FCL') ? $quote->pick_up : old('pick_up_fcl') }}">
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
                    </div>
                    @error('contact_name')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="contact_phone" class="col-sm-2 col-form-label">Telefono del contacto</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('contact_phone') is-invalid @enderror"
                            id="contact_phone" name="contact_phone"
                            placeholder="Ingresa el numero de celular del contacto"
                            value="{{ isset($quote->contact_phone) ? $quote->contact_phone : old('contact_phone') }}">
                    </div>
                    @error('contact_phone')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
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
                                {{ ((isset($quote->gang) && $quote->gang === 'SI' ) || old('gang') === 'SI') ? 'checked' : '' }}>
                            <label for="radioLclFcl" class="form-check-label">
                                SI
                            </label>
                        </div>
                        <div class="form-check d-inline">
                            <input type="radio" id="radioLclFcl" name="gang" value="NO"
                                class="form-check-input @error('gang') is-invalid @enderror"
                                {{ ((isset($quote->gang) && $quote->gang === 'NO') || old('gang') === 'NO') ? 'checked' : '' }}>
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
                                {{ ((isset($quote->guard) && $quote->guard === 'SI') ||old('guard') === 'SI') ? 'checked' : '' }}>
                            <label for="radioGuard" class="form-check-label">
                                SI
                            </label>
                        </div>
                        <div class="form-check d-inline">
                            <input type="radio" id="radioGuard" name="guard" value="NO"
                                class="form-check-input @error('guard') is-invalid @enderror"
                                {{ ((isset($quote->guard) && $quote->guard === 'NO') || old('guard') === 'NO') ? 'checked' : '' }}>
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
                    </div>
                    @error('load_type')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="commodity" class="col-sm-2 col-form-label">Descripcion</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('commodity') is-invalid @enderror"
                            id="commodity" name="commodity" placeholder="Ingrese descripcion del producto"
                            value="{{ isset($quote->commodity) ? $quote->commodity : old('commodity') }}">
                    </div>
                    @error('commodity')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row  fcl_quote">
                    <label for="container_type" class="col-sm-2 col-form-label">Tipo de contenedor</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('container_type') is-invalid @enderror"
                            id="container_type" name="container_type" placeholder="Ingrese el tipo de contenedor"
                            value="{{ isset($quote->container_type) ? $quote->container_type : old('container_type') }}" @readonly(true)>


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
                    </div>
                    @error('packaging_type')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row lcl_quote">
                    <label for="stackable" class="col-sm-2 col-form-label">Apilable</label>
                    <div class="col-sm-10">
                        <div class="form-check d-inline">
                            <input type="radio" id="radioStackable" name="stackable" value="SI"
                                class="form-check-input @error('stackable') is-invalid @enderror"
                                {{((isset($quote->stackable) && $quote->stackable === 'SI') || old('stackable') === 'SI') ? 'checked' : '' }}>
                            <label for="radioStackable" class="form-check-label">
                                SI
                            </label>
                        </div>
                        <div class="form-check d-inline">
                            <input type="radio" id="radioStackable" name="stackable" value="NO"
                                class="form-check-input  @error('stackable') is-invalid @enderror"
                                {{((isset($quote->stackable) && $quote->stackable === 'NO') || old('stackable') === 'NO') ? 'checked' : '' }}>
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
                    </div>
                    @error('total_weight')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="packages" class="col-sm-2 col-form-label">Bultos</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('packages') is-invalid @enderror"
                            id="packages" name="packages" placeholder="Ingresa si tendra valor de cuadrilla"
                            value="{{ isset($quote->packages) ? $quote->packages : old('packages') }}">
                    </div>
                    @error('packages')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group row">
                    <label for="cargo_detail" class="col-sm-2 col-form-label">Detalles</label>
                    <div class="col-sm-10">
                        <textarea class="form-control @error('cargo_detail') is-invalid @enderror" id="cargo_detail" name="cargo_detail"
                            placeholder="Ingresa un detalle o alguna observacion"
                            >{{ isset($quote->cargo_detail) ? $quote->cargo_detail : old('cargo_detail') }}</textarea>
                    </div>
                </div>
            </div>

        </div>


        <div class="col-12">

            <div class="head-quote mb-2">
                <h5 class="text-center text-uppercase bg-indigo p-2">Medidas</h5>
            </div>
            <div class="body-detail-product p-2">

                <table id="table_measures" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Cantidad</th>
                            <th>Ancho (cm)</th>
                            <th>Largo (cm)</th>
                            <th>Alto (cm)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Las filas de la tabla se llenarán dinámicamente -->
                    </tbody>

                </table>

                <input type="hidden" id="measures" name="measures">
                <input type="hidden" id="nro_operation" name="nro_operation"
                    value="{{ isset($quote->nro_operation) ? $quote->nro_operation : old('nro_operation') }}">
                <input type="hidden" id="lcl_fcl" name="lcl_fcl">

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
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('modalQuoteTransport'), {
                    backdrop: 'static', // Evita cierre al hacer clic fuera
                    keyboard: false // Evita cierre con la tecla ESC
                });
                myModal.show();

            });


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

                $('#customer').val(data.customer.name_businessname).prop('readonly', true);
                $('#contact_name').val(data.customer.contact_name);
                $('#contact_phone').val(data.customer.contact_number);
                $('#load_type').val(data.type_load.name).prop('readonly', true);
                $('#commodity').val(data.commodity).prop('readonly', true);
                $('#packaging_type').val(data.packaging_type).prop('readonly', true);

                if(data.type_shipment.description === "Marítima" && data.lcl_fcl === 'LCL'){
                    $('#cubage_kgv').val(data.volumen + ' m3').prop('readonly', true);
                }

                if(data.type_shipment.description === "Marítima" && data.lcl_fcl === 'FCL'){
                    $('#container_type').val(data.container_type).prop('readonly', true);
                }

                if(data.type_shipment.description === "Aérea" && data.lcl_fcl === null){
                    $('#cubage_kgv').val(data.kilogram_volumen + ' KGV').prop('readonly', true);
                }
               
                if(data.type_shipment.description === "Marítima" && data.lcl_fcl === 'FCL'){
                    $('#ton_kilogram').val(data.tons + " T").prop('readonly', true);
                }
                $('#total_weight').val(data.kilograms).prop('readonly', true);
                $('#packages').val(data.nro_package).prop('readonly', true);
                $('#measures').val(data.measures);
                //Campos Hidden
                $('#nro_operation').val(data.nro_operation);
                if(data.lcl_fcl != null){
                    
                    $('#lcl_fcl').val(data.lcl_fcl);
                }else{
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
    @else
        <script>
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


            const nro_operation = $('#nro_operation').val();


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

                $('#customer').val(data.customer.name_businessname).prop('readonly', true);
                $('#contact_name').val(data.customer.contact_name);
                $('#contact_phone').val(data.customer.contact_number);
                $('#load_type').val(data.type_load.name).prop('readonly', true);
                $('#commodity').val(data.commodity).prop('readonly', true);
                $('#packaging_type').val(data.packaging_type).prop('readonly', true);
                if(data.type_shipment.description === "Marítima" && data.lcl_fcl === 'LCL'){
                    $('#cubage_kgv').val(data.volumen + ' m3').prop('readonly', true);
                }

                if(data.type_shipment.description === "Aérea" && data.lcl_fcl === 'LCL'){
                    $('#cubage_kgv').val(data.kilogram_volumen+' KGV').prop('readonly', true);
                }

                if(data.type_shipment.description === "Marítima" && data.lcl_fcl === 'FCL'){
                    $('#ton_kilogram').val(data.tons + " T").prop('readonly', true);
                }
                $('#total_weight').val(data.kilograms).prop('readonly', true);
                $('#packages').val(data.nro_package).prop('readonly', true);
                $('#measures').val(data.measures);
                //Campos Hidden
                $('#nro_operation').val(data.nro_operation);
                if(data.lcl_fcl != null){
                    
                    $('#lcl_fcl').val(data.lcl_fcl);
                }else{
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