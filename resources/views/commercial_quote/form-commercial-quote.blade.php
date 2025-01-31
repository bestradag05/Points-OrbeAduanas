  <div id="informacion" role="tabpanel" class="bs-stepper-pane active dstepper-block" aria-labelledby="stepperInformacion">

      <div class="form-group">
          <label for="nro_quote_commercial">N° de Cotizacion</label>
          <input type="text" class="form-control" id="nro_quote_commercial" name="nro_quote_commercial"
              placeholder="Ingrese el numero de operacion" @readonly(true)
              value="{{ isset($quote_commercial->nro_quote_commercial) ? $quote_commercial->nro_quote_commercial : $nro_quote_commercial }}">
          @error('nro_quote_commercial')
              <div class="text-danger">{{ $message }}</div>
          @enderror
      </div>

      <div class="row">

          <div class="col-6">

              <x-adminlte-select2 name="origin" label="Origen" igroup-size="md"
                  data-placeholder="Seleccione una opcion...">
                  <option />
                  @foreach ($stateCountrys as $stateCountry)
                      <option
                          {{ (isset($routing->origin) && $routing->origin == $stateCountry->country->name . ' - ' . $stateCountry->name) || old('origin') == $stateCountry->country->name . ' - ' . $stateCountry->name ? 'selected' : '' }}>
                          {{ $stateCountry->country->name . ' - ' . $stateCountry->name }}
                      </option>
                  @endforeach
              </x-adminlte-select2>

          </div>
          <div class="col-6">

              <x-adminlte-select2 name="destination" label="Destino" igroup-si ze="md"
                  data-placeholder="Seleccione una opcion...">
                  <option />
                  @foreach ($stateCountrys as $stateCountry)
                      <option
                          {{ (isset($routing->destination) && $routing->destination == $stateCountry->country->name . ' - ' . $stateCountry->name) || old('destination') == $stateCountry->country->name . ' - ' . $stateCountry->name ? 'selected' : '' }}>
                          {{ $stateCountry->country->name . ' - ' . $stateCountry->name }}
                      </option>
                  @endforeach
              </x-adminlte-select2>

          </div>



          <div class="col-6">

              <div class="form-group">
                  <label for="load_value">Valor del la carga / factura</label>

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
                  @error('load_value')
                      <span class="invalid-feedback d-block" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror

              </div>
          </div>

          <div class="col-6 row" id="lclfcl_content">
              <div class="col-12">
                  <x-adminlte-select2 name="id_type_shipment" label="Tipo de embarque" igroup-size="md"
                      data-placeholder="Seleccione una opcion...">
                      <option />
                      @foreach ($type_shipments as $type_shipment)
                          <option value="{{ $type_shipment->id }}"
                              {{ (isset($routing->id_type_shipment) && $routing->id_type_shipment == $type_shipment->id) || old('id_type_shipment') == $type_shipment->id ? 'selected' : '' }}>
                              {{ $type_shipment->code . ' - ' . $type_shipment->name }}</option>
                      @endforeach
                  </x-adminlte-select2>

              </div>
              <div id="contenedor_radio_lcl_fcl" class="col-4 d-none align-items-center">
                  <div class="form-check d-inline">
                      <input type="radio" id="radioLcl" name="lcl_fcl" value="LCL"
                          {{ (isset($routing->lcl_fcl) && $routing->lcl_fcl === 'LCL') || old('lcl_fcl') === 'LCL' ? 'checked' : '' }}
                          class="form-check-input @error('lcl_fcl') is-invalid @enderror">
                      <label for="radioLclFcl" class="form-check-label">
                          LCL
                      </label>
                  </div>
                  <div class="form-check d-inline">
                      <input type="radio" id="radioFcl" name="lcl_fcl" value="FCL"
                          {{ (isset($routing->lcl_fcl) && $routing->lcl_fcl === 'FCL') || old('lcl_fcl') === 'FCL' ? 'checked' : '' }}
                          class="form-check-input @error('lcl_fcl') is-invalid @enderror">
                      <label for="radioLclFcl" class="form-check-label">
                          FCL
                      </label>
                  </div>
              </div>

          </div>

          <div class="col-6">
              <x-adminlte-select2 name="id_type_load" label="Tipo de carga" igroup-size="md"
                  data-placeholder="Seleccione una opcion...">
                  <option />
                  @foreach ($type_loads as $type_load)
                      <option value="{{ $type_load->id }}"
                          {{ (isset($routing->id_type_load) && $routing->id_type_load == $type_load->id) || old('id_type_load') == $type_load->id ? 'selected' : '' }}>
                          {{ $type_load->name }}
                      </option>
                  @endforeach
              </x-adminlte-select2>
          </div>

          <div class="col-6">
              <x-adminlte-select2 name="id_regime" label="Regimen" igroup-size="md"
                  data-placeholder="Seleccione una opcion...">
                  <option />
                  @foreach ($regimes as $regime)
                      <option value="{{ $regime->id }}"
                          {{ (isset($routing->id_regime) && $routing->id_regime == $regime->id) || old('id_regime') == $regime->id ? 'selected' : '' }}>
                          {{ $regime->code . ' - ( ' . $regime->description . ' )' }}
                      </option>
                  @endforeach
              </x-adminlte-select2>
          </div>

          <div class="col-6">
              <x-adminlte-select2 name="id_incoterms" label="Incoterms" igroup-size="md"
                  data-placeholder="Seleccione una opcion...">
                  <option />
                  @foreach ($incoterms as $incoter)
                      <option value="{{ $incoter->id }}"
                          {{ (isset($routing->id_incoterms) && $routing->id_incoterms == $incoter->id) || old('id_incoterms') == $incoter->id ? 'selected' : '' }}>
                          {{ $incoter->code }}</option>
                  @endforeach
              </x-adminlte-select2>
          </div>


      </div>

      <button class="btn btn-primary" onclick="stepper.next()">Siguiente</button>
  </div>
  <div id="detalle_producto" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepperDetalleProducto">

      <div class="form-group row">
          <label for="commodity" class="col-sm-2 col-form-label">Producto</label>
          <div class="col-sm-10">
              <input type="text" class="form-control @error('commodity') is-invalid @enderror" id="commodity"
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

          <div class="col-6">
              <div class="form-group row">
                  <label for="nro_package" class="col-sm-4 col-form-label">N° Paquetes</label>
                  <div class="col-sm-8">
                      <input type="number" min="0" step="1"
                          class="form-control @error('nro_package') is-invalid @enderror" id="nro_package"
                          name="nro_package" placeholder="Ingrese el nro de paquetes.."
                          oninput="validarInputNumber(this)" onchange="cleanMeasures()"
                          value="{{ isset($routing) ? $routing->nro_package : '' }}">
                      @error('nro_package')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>

          </div>

          <div class="col-6">
              <div class="form-group row">
                  <label for="packaging_type" class="col-sm-4 col-form-label">Tipo de embalaje</label>
                  <div class="col-sm-8">
                      <input type="text" min="0" step="1"
                          class="form-control @error('packaging_type') is-invalid @enderror" id="packaging_type"
                          name="packaging_type" placeholder="Ingrese el tipo de embalaje.."
                          value="{{ isset($routing) ? $routing->packaging_type : '' }}">
                      @error('packaging_type')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>
          </div>

          <div class="col-4 d-none" id="containerTypeWrapper">
              <div class="form-group row">
                  <label for="container_type" class="col-sm-4 col-form-label">Tipo de contenedor</label>
                  <div class="col-sm-8">
                      <input type="text" min="0" step="1"
                          class="form-control @error('container_type') is-invalid @enderror" id="container_type"
                          name="container_type" placeholder="Ingrese el tipo de contenedor.."
                          value="{{ isset($routing) ? $routing->container_type : old('container_type') }}">
                      @error('container_type')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>
          </div>
          <div id="container_measures" class="col-12 mt-2">

              <div id="div_measures" class="row justify-content-center">

                  <div class="col-2">
                      <input type="number" class="form-control" step="1" id="amount_package"
                          name="amount_package" placeholder="Ingresa la cantidad">
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
                      <button id="addRow" class="btn btn-indigo btn-sm"><i class="fa fa-plus"></i>Agregar</button>
                  </div>

              </div>

              <table id="measures" class="table table-bordered" style="width:100%">
                  <thead>
                      <tr>
                          <th>Cantidad</th>
                          <th>Ancho (cm)</th>
                          <th>Largo (cm)</th>
                          <th>Alto (cm)</th>
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
          <div class="col-4">
              <div id="contenedor_weight" class="form-group row d-none">
                  <label for="kilograms" class="col-sm-4 col-form-label">Peso Total : </label>
                  <div class="col-sm-8">
                      <input type="text"
                          class="form-control CurrencyInput @error('kilograms') is-invalid @enderror" id="kilograms"
                          name="kilograms" data-type="currency" placeholder="Ingrese el peso.."
                          value="{{ isset($routing->kilograms) ? $routing->kilograms : old('kilograms') }}">
                      @error('kilograms')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>

              <div id="contenedor_tons" class="form-group row d-none">
                  <label for="tons" class="col-sm-4 col-form-label">Toneladas : </label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control CurrencyInput @error('tons') is-invalid @enderror"
                          id="tons" name="tons" data-type="currency"
                          placeholder="Ingrese el nro de paquetes.."
                          value="{{ isset($routing->tons) ? $routing->tons : old('tons') }}">
                  </div>
                  @error('tons')
                      <span class="invalid-feedback d-block" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>

          </div>


          <div class="col-4">
              <div id="contenedor_volumen" class="form-group row  d-none">
                  <label for="volumen" class="col-sm-4 col-form-label">Volumen: </label>
                  <div class="col-sm-8">
                      {{-- Volumen --}}
                      <input type="text" class="form-control CurrencyInput @error('volumen') is-invalid @enderror"
                          id="volumen" name="volumen" data-type="currency"
                          placeholder="Ingrese el nro de paquetes.."
                          value="{{ isset($routing->volumen) ? $routing->volumen : old('volumen') }}">
                  </div>

                  @error('volumen')
                      <span class="invalid-feedback d-block" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
              <div id="contenedor_kg_vol" class="form-group row d-none">
                  <label for="volumen" class="col-sm-4 col-form-label">Kg/vol: </label>
                  <div class="col-sm-8">
                      {{-- Kilogramo volumen --}}

                      <input type="text"
                          class="form-control CurrencyInput @error('kilogram_volumen') is-invalid @enderror"
                          id="kilogram_volumen" name="kilogram_volumen" data-type="currency"
                          placeholder="Ingrese el nro de paquetes.."
                          value="{{ isset($routing->kilogram_volumen) ? $routing->kilogram_volumen : old('kilogram_volumen') }}">
                  </div>
                  @error('kilogram_volumen')
                      <span class="invalid-feedback d-block" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>

          </div>
      </div>

      <input type="hidden" id="type_shipment_name" name="type_shipment_name">



      <button class="btn btn-secondary mt-5" onclick="stepper.previous()">Anterior</button>
      <button class="btn btn-primary mt-5" onclick="stepper.next()">Siguiente</button>
  </div>

  <div id="servicios" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepperServicios">

      <div class="container">
          <div class="row">
              <div class="col-12 text-center">
                  <h5 class="text-indigo">Seleccione los servicios que se cotizaran para incluir dentro de este
                      documento</h5>
              </div>
          </div>
      </div>



      <button class="btn btn-secondary mt-5" onclick="stepper.previous()">Anterior</button>
      <button type="submit" class="btn btn-indigo mt-5" onclick="submitForm()">Guardar</button>
  </div>

  @push('scripts')
      <script>
          const dataMeasures = @json(isset($routing->measures) ? $routing->measures : '');
          document.addEventListener('DOMContentLoaded', function() {



              // Obtener los valores de los campos del formulario (puedes personalizar esto para tu caso)
              let volumenValue = document.getElementById('volumen');
              let kilogramoVolumenValue = document.getElementById('kilogram_volumen');
              let toneladasValue = document.getElementById('tons');
              let totalWeight = document.getElementById('kilograms');
              let lcl_fcl = document.getElementsByName('lcl_fcl');
              let container_type = document.getElementById('container_type');

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

              if (container_type.value !== '' || container_type.classList.contains('is-invalid')) {
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

          $('#id_type_shipment').on('change', (e) => {

              var idShipment = $(e.target).find("option:selected").val();

              $.ajax({
                  type: "GET",
                  url: "/getLCLFCL",
                  data: {
                      idShipment
                  },
                  dataType: "JSON",
                  success: function(respu) {
                      if (respu.description === "Marítima") {

                          $('#type_shipment_name').val(respu.description);

                          $('#lclfcl_content').children().first().removeClass('col-12').addClass('col-8');
                          $('#lclfcl_content').children().last().removeClass('d-none').addClass('d-flex');

                          $('#contenedor_volumen').removeClass('d-none');
                          $('#contenedor_kg_vol').addClass('d-none');

                          $('#contenedor_volumen').find('input').val("");
                          $('#contenedor_kg_vol').find('input').val("");




                      } else {


                          $('#type_shipment_name').val(respu.description);

                          $('#lclfcl_content').children().first().removeClass('col-8').addClass('col-12');
                          $('#lclfcl_content').children().last().removeClass('d-flex').addClass('d-none');
                          $('input[name="lcl_fcl"]').prop('checked', false);

                          $('#contenedor_volumen').addClass('d-none');
                          $('#contenedor_kg_vol').removeClass('d-none');

                          $('#contenedor_kg_vol').find('input').val("");
                          $('#contenedor_volumen').find('input').val("");

                          $('#containerTypeWrapper').find('input').val("");
                          $('#containerTypeWrapper').addClass('d-none');

                          const parentElement = document.getElementById('containerTypeWrapper').closest(
                              '.row');

                          if (parentElement) {
                              const firstChild = parentElement.children[0]; // Primer hijo
                              const secondChild = parentElement.children[1]; // Segundo hijo

                              // Añade la clase 'col-6' a los dos primeros hijos
                              if (firstChild) {
                                  firstChild.classList.add('col-6');
                                  firstChild.classList.remove('col-4');
                              }
                              if (secondChild) {

                                  secondChild.classList.add('col-6');
                                  secondChild.classList.remove('col-4')

                              }
                          }


                          $('#contenedor_tons').find('input').val("");
                          $('#contenedor_tons').addClass('d-none');
                          $('#contenedor_weight').removeClass('d-none');



                      }
                  }
              });


          });



          //Inicializamos la tabla de medidas

          const table = new DataTable('#measures', {
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
                      `<input type="number" class="form-control" readonly id="height-${index}" name="height-${index}" value="${item.height}" placeholder="Alto" min="0" step="0.0001">`,
                      `<button type="button" class="btn btn-danger btn-sm" id="delete-${index}" onclick="deleteRow('row-${index}', ${item.amount}, ${index})"><i class="fa fa-trash"></i></button>`
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

              $('#value_measures').val(JSON.stringify(arrayMeasures));

          }



          document.getElementById('addRow').addEventListener('click', () => {

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

              const nro_package = parseInt($('#nro_package').val());
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


                  $('#value_measures').val(JSON.stringify(arrayMeasures));

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
              $('#value_measures').val(JSON.stringify(arrayMeasures));

          }

          function cleanMeasures() {
              table.clear().draw();

              arrayMeasures = {};
              $('#value_measures').val("");

              // Restablecer variables relacionadas
              currentPackage = 0;
              rowIndex = 1;

          }


          document.querySelectorAll('input[name="lcl_fcl"]').forEach(radio => {
              radio.addEventListener('change', function() {
                  const containerTypeWrapper = document.getElementById('containerTypeWrapper');
                  const contenedor_tons = document.getElementById('contenedor_tons');
                  const contenedor_weight = document.getElementById('contenedor_weight');
                  const contentedor_measures = document.getElementById('container_measures');

                  // Si el valor es FCL, mostrar el campo
                  if (this.value === 'FCL') {
                      containerTypeWrapper.classList.remove('d-none');
                      contenedor_tons.classList.remove('d-none');
                      contenedor_weight.classList.add('d-none');
                      contentedor_measures.classList.add('d-none');

                      const parentElement = containerTypeWrapper.closest('.row');
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

                  } else {
                      // Si no es FCL, ocultar el campo
                      containerTypeWrapper.classList.add('d-none');
                      contenedor_tons.classList.add('d-none');
                      contenedor_weight.classList.remove('d-none');
                      contentedor_measures.classList.remove('d-none');

                      $('#containerTypeWrapper').find('input').val('');

                      const parentElement = containerTypeWrapper.closest('.row');
                      if (parentElement) {
                          const firstChild = parentElement.children[0]; // Primer hijo
                          const secondChild = parentElement.children[1]; // Segundo hijo

                          // Añade la clase 'col-6' a los dos primeros hijos
                          if (firstChild) {
                              firstChild.classList.add('col-6');
                              firstChild.classList.remove('col-4');
                          }
                          if (secondChild) {

                              secondChild.classList.add('col-6');
                              secondChild.classList.remove('col-4')

                          }
                      }

                  }
              });
          });
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
                      /*  console.log(invalidInputs[0].parentNode.parentNode.closest('.bs-stepper-pane')); */

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
