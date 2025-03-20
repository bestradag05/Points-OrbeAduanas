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
                  <label for="customer_ruc">RUC</label>

                  <div class="input-group">

                      <input type="text" class="form-control  @error('customer_ruc') is-invalid @enderror "
                          name="customer_ruc" placeholder="Ingrese el ruc"
                          value="{{ isset($routing->customer_ruc) ? $routing->customer_ruc : old('customer_ruc') }}">
                  </div>
                  @error('customer_ruc')
                      <span class="invalid-feedback d-block" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror

              </div>
          </div>
          <div class="col-6">

              <div class="form-group">
                  <label for="customer_company_name">Razon social / Nombre</label>

                  <div class="input-group">
                      <input type="text" class="form-control @error('customer_company_name') is-invalid @enderror "
                          name="customer_company_name" placeholder="Ingrese valor de la carga"
                          value="{{ isset($routing->customer_company_name) ? $routing->customer_company_name : old('customer_company_name') }}">
                  </div>
                  @error('customer_company_name')
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
            <label for="customer_company_name">Incoterm</label>
            <a href="#" data-bs-toggle="modal" data-bs-target="#incotermModal">
                <i class="fas fa-info-circle"></i>
            </a>
              <x-adminlte-select2 name="id_incoterms" igroup-size="md"
                  data-placeholder="Seleccione una opcion...">
                  <option />
                  @foreach ($incoterms as $incoter)
                      <option value="{{ $incoter->id }}"
                          {{ (isset($routing->id_incoterms) && $routing->id_incoterms == $incoter->id) || old('id_incoterms') == $incoter->id ? 'selected' : '' }}>
                          {{ $incoter->code }}  ({{$incoter->name}})</option>
                  @endforeach
              </x-adminlte-select2>
          </div>


      </div>

      <button class="btn btn-primary" onclick="stepper.next()">Siguiente</button>
  </div>
  <div id="detalle_producto" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepperDetalleProducto">

      <div class="form-group">
          <label>¿Es consolidado?</label>
          <div class="form-check form-check-inline">
              <input type="radio" id="consolidadoSi" name="is_consolidated" value="1" class="form-check-input"
                  onchange="toggleConsolidatedSection()">
              <label for="consolidadoSi" class="form-check-label">Sí</label>
          </div>
          <div class="form-check form-check-inline">
              <input type="radio" id="consolidadoNo" name="is_consolidated" value="0"
                  class="form-check-input" onchange="toggleConsolidatedSection()" checked>
              <label for="consolidadoNo" class="form-check-label">No</label>
          </div>
      </div>

      <div id="singleProviderSection">

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

              <div class="col-4">
                  <div class="form-group row">
                      <label for="load_value" class="col-sm-4 col-form-label">Valor de factura</label>
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
                      <label for="nro_package" class="col-sm-4 col-form-label">N° Paquetes / Bultos</label>
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

              <div class="col-4 d-none fcl-fields" id="containerTypeWrapper">
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

                  <div id="div-measures" class="row justify-content-center">

                      <div class="col-2">
                          <input type="number" class="form-control" step="1" id="amount_package"
                              name="amount_package" placeholder="Ingresa la cantidad">
                      </div>
                      <div class="col-2">
                          <input type="text" class="form-control CurrencyInput" data-type="currency"
                              id="width" name="width" placeholder="Ancho(cm)">
                      </div>
                      <div class="col-2">
                          <input type="text" class="form-control CurrencyInput" data-type="currency"
                              id="length" name="length" placeholder="Largo(cm)">
                      </div>
                      <div class="col-2">
                          <input type="text" class="form-control CurrencyInput" data-type="currency"
                              id="height" name="height" placeholder="Alto(cm)">
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
                              <th>Ancho (cm)</th>
                              <th>Largo (cm)</th>
                              <th>Alto (cm)</th>
                              <th>Eliminar</th>
                          </tr>
                      </thead>
                  </table>
                  <input id="value-measures" type="hidden" name="value-measures" />
                  @error('value_measures')
                      <span class="invalid-feedback d-block" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror

              </div>
          </div>


          <div class="row mt-4">

              <div class="col-4">
                  <div class="form-group row">
                      <label for="pounds" class="col-sm-4 col-form-label">Libras: </label>
                      <div class="col-sm-8">
                          <input type="text" class="form-control CurrencyInput" id="pounds" name="pounds"
                              data-type="currency" placeholder="Ingrese las libras"
                              value="{{ isset($routing) ? $routing->pounds : '' }}" @readonly(true)>
                          @error('pounds')
                              <div class="text-danger">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>
              </div>

              <div class="col-4">
                  <div id="contenedor_weight" class="form-group row lcl-fields d-none">
                      <label for="kilograms" class="col-sm-4 col-form-label">Peso Total : </label>
                      <div class="col-sm-8">
                          <input type="text"
                              class="form-control CurrencyInput @error('kilograms') is-invalid @enderror"
                              id="kilograms" name="kilograms" data-type="currency" placeholder="Ingrese el peso.."
                              value="{{ isset($routing->kilograms) ? $routing->kilograms : old('kilograms') }}">
                          @error('kilograms')
                              <span class="invalid-feedback d-block" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                  </div>

                  <div id="contenedor_tons" class="form-group row fcl-fields d-none">
                      <label for="tons" class="col-sm-4 col-form-label">Toneladas : </label>
                      <div class="col-sm-8">
                          <input type="text"
                              class="form-control CurrencyInput @error('tons') is-invalid @enderror" id="tons"
                              name="tons" data-type="currency" placeholder="Ingrese el peso en toneladas.."
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
                          <input type="text"
                              class="form-control CurrencyInput @error('volumen') is-invalid @enderror"
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
                      <th>Volumen</th>
                      <th>Peso</th>
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
                  <h5 class="text-indigo mb-3">Seleccione los servicios que se cotizaran para incluir dentro de este
                      documento</h5>
                  @foreach ($types_services as $type_service)
                      @if ($type_service->name != 'Aduanas')
                          <div class="icheck-danger d-inline mx-4 mt-4">
                              <input type="checkbox" id="type_service_{{ $type_service->id }}"
                                  value="{{ $type_service->name }}" name="type_service[]">
                              <label for="type_service_{{ $type_service->id }}">
                                  {{ $type_service->name }}
                              </label>
                          </div>
                      @endif
                  @endforeach

              </div>
          </div>
      </div>



      <button class="btn btn-secondary mt-5" onclick="stepper.previous()">Anterior</button>
      <button type="submit" class="btn btn-indigo mt-5" onclick="submitForm()">Guardar</button>
  </div>


  <!-- Modal de Bootstrap -->
<div class="modal fade" id="incotermModal" tabindex="-1" aria-labelledby="incotermModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body text-center p-0">
                <img src="{{ asset('storage/incoterms/incoterms.jpg') }}" class="img-fluid" alt="Información sobre Incoterms">
            </div>
        </div>
    </div>
</div>




  @push('scripts')
      <script>
          const dataMeasures = @json(isset($routing->measures) ? $routing->measures : '');
          let tableMeasures = null;
          let tableMeasuresConsolidated = null;
          let counter = 1;
          let shippers = [];

          // Función para agregar una fila editable
          let rowIndex = 1; //
          let currentPackage = 0;
          let arrayMeasures = {};
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

                          typeShipmentCurrent = respu;

                          $('#type_shipment_name').val(respu.description);

                          $('#lclfcl_content').children().first().removeClass('col-12').addClass('col-8');
                          $('#lclfcl_content').children().last().removeClass('d-none').addClass('d-flex');

                          $('#contenedor_volumen').removeClass('d-none');
                          $('#contenedor_vol_consolidated').removeClass('d-none');
                          $('#contenedor_kg_vol').addClass('d-none');
                          $('#contenedor_kg_vol_consolidated').addClass('d-none');

                          $('#contenedor_volumen').find('input').val("");
                          $('#contenedor_kg_vol').find('input').val("");
                          $('#contenedor_kg_vol_consolidated').find('input').val("");




                      } else {


                          $('#type_shipment_name').val(respu.description);

                          $('#lclfcl_content').children().first().removeClass('col-8').addClass('col-12');
                          $('#lclfcl_content').children().last().removeClass('d-flex').addClass('d-none');
                          $('input[name="lcl_fcl"]').prop('checked', false);

                          $('#contenedor_volumen').addClass('d-none');
                          $('#contenedor_vol_consolidated').addClass('d-none');
                          $('#contenedor_kg_vol').removeClass('d-none');
                          $('#contenedor_kg_vol_consolidated').removeClass('d-none');

                          $('#contenedor_kg_vol').find('input').val("");
                          $('#contenedor_kg_vol_consolidated').find('input').val("");
                          $('#contenedor_volumen').find('input').val("");
                          $('#contenedor_vol_consolidated').find('input').val("");

                          $('#containerTypeWrapper').find('input').val("");
                          $('#containerTypeWrapper').addClass('d-none');
                          $('#containerTypeWrapperConsolidated').find('input').val("");
                          $('#containerTypeWrapperConsolidated').addClass('d-none');

                          $('#contenedor_tons').find('input').val("");
                          $('#contenedor_tons').addClass('d-none');
                          $('#contenedor_weight').removeClass('d-none');



                      }
                  }
              });


          });


          function toggleConsolidatedSection() {
              let isConsolidated = document.querySelector('input[name="is_consolidated"]:checked').value;


              if (isConsolidated === "1") {
                  document.getElementById("multipleProvidersSection").classList.remove("d-none");
                  document.getElementById("singleProviderSection").classList.add("d-none");

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
              }
          }

          function showItemConsolidated() {
              $('#modal-consolidated').modal('show');
          }

          function removeRow(button) {
              button.parentElement.parentElement.remove();
          }



          $('#kilograms').on('change', (e) => {

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
              let valueMeasuresHidden = document.getElementById('value-measures');

              AddRowMeasures(divMeasures, nroPackage, tableMeasures, arrayMeasures, "arrayMeasures", valueMeasuresHidden);

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

              const inputs = container_measures.querySelectorAll('input');

              validateInputs(inputs);

              const amount_package = parseInt(inputs[0].value);
              const width = inputs[1].value.replace(/,/g, '');;
              const length = inputs[2].value.replace(/,/g, '');;
              const height = inputs[3].value.replace(/,/g, '');;

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

                      `<button type="button" class="btn btn-danger btn-sm" id="delete-${rowIndex}" onclick="deleteRow('${table.table().node().id}', 'row-${rowIndex}', ${amount_package}, ${arrayName}, '${valueMeasuresHidden.id}')"><i class="fa fa-trash"></i></button>`
                  ]).draw().node();
                  newRow.id = `row-${rowIndex}`;


                  array[rowIndex] = { // Usamos rowIndex como clave
                      amount: amount_package,
                      width,
                      length,
                      height
                  };


                  valueMeasuresHidden.value = JSON.stringify(array);

                  rowIndex++

                  cleanInputMeasures(inputs)

              }

          }


          /* Agregar un item del consolidado  */

          function saveConsolidated(e) {

              let tableShipper = $('#providersTable');
              let elements = $('#form-consolidated').find('input.required, select.required').toArray();

              if (!validateInputs(elements)) {
                  return;
              }

              let shipper = {
                  'shipper_name': getValueByName('shipper_name'),
                  'shipper_contact': getValueByName('shipper_contact'),
                  'shipper_contact_email': getValueByName('shipper_contact_email'),
                  'shipper_contact_phone': getValueByName('shipper_contact_phone'),
                  'shipper_address': getValueByName('shipper_address'),
                  'commodity': getValueByName('commodity'),
                  'load_value': getValueByName('load_value'),
                  'nro_packages_consolidated': getValueByName('nro_packages_consolidated'),
                  'packaging_type_consolidated': getValueByName('packaging_type_consolidated'),
                  'volumen': getValueByName('volumen'),
                  'kilograms': getValueByName('kilograms'),
                  'value_measures': JSON.parse(getValueByName('value-measures-consolidated'))
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
                        <td>${shipper.packaging_type_consolidated}</td>
                        <td>${shipper.volumen}</td>
                        <td>${shipper.kilograms}</td>
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

          $(document).on('click', '.btn-detail', function() {

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
                <tr><th>Tipo de Empaque</th><td>${shipper.packaging_type_consolidated}</td></tr>
                <tr><th>Volumen</th><td>${shipper.volumen}</td></tr>
                <tr><th>Kilogramos</th><td>${shipper.kilograms}</td></tr>
                <tr><th>Medidas</th><td>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Ítem</th>
                                <th>Largo</th>
                                <th>Ancho</th>
                                <th>Alto</th>
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

          //Validar inputs de un contenedor: 

          function validateInputs(inputs) {
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
