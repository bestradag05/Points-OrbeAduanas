<div class="container">
    <div class="row">
        <div class="col-12">

            <div class="head-quote mb-2">
                <h5 id="title_quote" class="text-center text-uppercase bg-indigo p-2">Formato <span></span></h5>
            </div>

            <div class="form-group row">
                <label for="customer" class="col-sm-2 col-form-label">Cliente</label>
                <div class="col-sm-10 customer_quote">
                    <input type="text" class="form-control @error('customer') is-invalid @enderror"
                        id="customer" name="customer" placeholder="Ingresa el cliente" {{isset($quote->routing->customer->name_businessname) ? 'readonly' : ''}}
                        value="{{ isset($quote->routing->customer->name_businessname) ? $quote->routing->customer->name_businessname : old('customer') }}">
                </div>

            </div>

            <div class="form-group row">
                <label for="type_shipment" class="col-sm-2 col-form-label">Tipo de embarque</label>
                <div class="col-sm-10 type_shipment_quote">
                    <input type="text" class="form-control @error('type_shipment') is-invalid @enderror"
                        id="type_shipment" name="type_shipment" placeholder="Ingresa el cliente" {{isset($quote->routing->type_shipment->description) ? 'readonly' : ''}}
                        value="{{ isset($quote->routing->type_shipment->description) ? $quote->routing->type_shipment->description : old('type_shipment') }}">

                </div>

            </div>

            <div class="form-group row">
                <label for="origin" id="lbl_origin" class="col-sm-2 col-form-label">Aeropuerto de Salida</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('origin') is-invalid @enderror"
                        id="origin" name="origin" placeholder="Ingrese la direccion de recojo"
                        value="{{ isset($quote->origin) ? $quote->origin : old('origin') }}">
                    @error('origin')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>


            <div class="form-group row">
                <label for="destination" id="lbl_destination" class="col-sm-2 col-form-label">Aeropuerto de llegada</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('destination') is-invalid @enderror" id="destination"
                        name="destination" placeholder="Ingrese la direccion de entrega"
                        value="{{ isset($quote->destination) ? $quote->destination : old('destination') }}">
                    @error('delivery')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="load_type" class="col-sm-2 col-form-label">Tipo de Carga</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('load_type') is-invalid @enderror" id="load_type"
                        name="load_type" placeholder="Ingrese el tipo de carga" {{isset($quote->load_type) ? 'readonly' : ''}}
                        value="{{ isset($quote->load_type) ? $quote->load_type : old('load_type') }}">
                    @error('load_type')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

            </div>
            <div class="form-group row">
                <label for="commodity" class="col-sm-2 col-form-label">Descripcion de Mercaderia</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('commodity') is-invalid @enderror" id="commodity"
                        name="commodity" placeholder="Ingrese descripcion del producto" {{isset($quote->commodity) ? 'readonly' : ''}}
                        value="{{ isset($quote->commodity) ? $quote->commodity : old('commodity') }}">
                    @error('commodity')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

            </div>
            <div class="form-group row  fcl_quote {{isset($quote->container_type) ? '' : 'd-none'}}" >
                <label for="container_type" class="col-sm-2 col-form-label">Tipo de contenedor</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('container_type') is-invalid @enderror"
                        id="container_type" name="container_type" placeholder="Ingrese el tipo de contenedor" {{isset($quote->container_type) ? 'readonly' : ''}}
                        value="{{ isset($quote->container_type) ? $quote->container_type : old('container_type') }}">


                    @error('container_type')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

            </div>
            <div class="form-group row  fcl_quote {{isset($quote->ton_kilogram) ? '' : 'd-none'}}">
                <label for="ton_kilogram" class="col-sm-2 col-form-label">Toneladas / KG</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('ton_kilogram') is-invalid @enderror"
                        id="ton_kilogram" name="ton_kilogram" placeholder="Ingrese el preso de carga" {{isset($quote->ton_kilogram) ? 'readonly' : ''}}
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
                        id="packaging_type" name="packaging_type" placeholder="Ingrese el tipo de embalaje" {{isset($quote->packaging_type) ? 'readonly' : ''}}
                        value="{{ isset($quote->packaging_type) ? $quote->packaging_type : old('packaging_type') }}">

                    @error('packaging_type')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

            </div>
            <div class="form-group row lcl_quote {{isset($quote->cubage_kgv) ? '' : 'd-none'}}">
                <label for="cubage_kgv" class="col-sm-2 col-form-label">Cubicaje/KGV</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('cubage_kgv') is-invalid @enderror"
                        id="cubage_kgv" name="cubage_kgv" placeholder="Ingresa el cubicaje / kgv" {{isset($quote->cubage_kgv) ? 'readonly' : ''}}
                        value="{{ isset($quote->cubage_kgv) ? $quote->cubage_kgv : old('cubage_kgv') }}">
                    @error('cubage_kgv')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row lcl_quote {{isset($quote->total_weight) ? '' : 'd-none'}}">
                <label for="total_weight" class="col-sm-2 col-form-label">Peso total</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control @error('total_weight') is-invalid @enderror"
                        id="total_weight" name="total_weight"
                        placeholder="Ingresa la hora maxima de recojo del cliente" {{isset($quote->total_weight) ? 'readonly' : ''}}
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
                        id="packages" name="packages" placeholder="Ingresa si tendra valor de cuadrilla" {{isset($quote->packages) ? 'readonly' : ''}}
                        value="{{ isset($quote->packages) ? $quote->packages : old('packages') }}">
                    @error('packages')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

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
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Crear Borrador' }}">
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

            
                $('#customer').val(data.customer.name_businessname).prop('readonly', true);
                $('#type_shipment').val(data.type_shipment.description + ' ' + ((data.lcl_fcl != null) ? data.lcl_fcl : '')).prop('readonly', true);
                $('#load_type').val(data.type_load.name).prop('readonly', true);
                $('#origin').val(data.origin);
                $('#destination').val(data.destination);
                $('#commodity').val(data.commodity).prop('readonly', true);
                $('#packaging_type').val(data.packaging_type).prop('readonly', true);

                if (data.type_shipment.description === "Marítima") {
                    $('#lbl_origin').text('Puerto de salida');
                    $('#lbl_destination').text('Puerto de llegada');
                }


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
                $('#modalQuoteFreight').hide();

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
            const dataMeasures = @json(isset($quote->measures) ? $quote->measures : '');

            // Cargamos la data si existe

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

            if (dataMeasures != "") {

                const measuresObject = JSON.parse(dataMeasures);

                Object.entries(measuresObject).forEach(([key, item], index) => {

                    const newRow = table.row.add([
                        `<input type="number" class="form-control" readonly id="amount-${index}" name="amount-${index}" value="${item.amount}" placeholder="Cantidad" min="0" step="1">`,
                        `<input type="number" class="form-control" readonly id="width-${index}" name="width-${index}" value="${item.width}" placeholder="Ancho" min="0" step="0.0001">`,
                        `<input type="number" class="form-control" readonly id="length-${index}" name="length-${index}" value="${item.length}" placeholder="Largo" min="0" step="0.0001">`,
                        `<input type="number" class="form-control" readonly id="height-${index}" name="height-${index}" value="${item.height}" placeholder="Alto" min="0" step="0.0001">`
                    ]).draw().node();
                    newRow.id = `row-${index}`;

                    // Guardamos las medidas en el objeto `arrayMeasures`
                    arrayMeasures[index] = {
                        amount: item.amount,
                        width: item.width,
                        length: item.length,
                        height: item.height
                    };

                    currentPackage += item.amount; // Sumar al total de paquetes ya cargados
                });

                $('#measures').val(JSON.stringify(arrayMeasures));

            }


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


            function cleanMeasures() {
                table.clear().draw();

                arrayMeasures = {};
                $('#measures').val("");

                // Restablecer variables relacionadas
                currentPackage = 0;
                rowIndex = 1;

            }
        </script>
    @endif

@endpush
