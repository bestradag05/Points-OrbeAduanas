  <div id="test-l-1" role="tabpanel" class="bs-stepper-pane active dstepper-block" aria-labelledby="stepper1trigger1">
      <div class="form-group">
          <label for="nro_operation">N° de operacion</label>
          <input type="text" class="form-control" id="nro_operation" name="nro_operation"
              placeholder="Ingrese el numero de operacion" @readonly(true)
              value="{{ isset($nro_operation) ? $nro_operation : '' }}">
          @error('nro_operation')
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

              <x-adminlte-select2 name="destination" label="Destino" igroup-size="md"
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
                  <label for="load_value">Valor del la carga</label>

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


          <div class="col-6">
              <x-adminlte-select2 name="id_customer" label="Clientes" igroup-size="md"
                  data-placeholder="Seleccione una opcion...">
                  <option />
                  @foreach ($customers as $customer)
                      <option value="{{ $customer->id }}"
                          {{ (isset($routing->id_customer) && $routing->id_customer == $customer->id) || old('id_customer') == $customer->id ? 'selected' : '' }}>
                          {{ $customer->name_businessname }}
                      </option>
                  @endforeach
              </x-adminlte-select2>
          </div>

          <div class="col-6">
              <x-adminlte-select2 name="id_supplier" label="Provedor del Cliente" igroup-size="md"
                  data-placeholder="Seleccione una opcion...">
                  <option />
                  @foreach ($suppliers as $supplier)
                      <option value="{{ $supplier->id }}"
                          {{ (isset($routing->id_supplier) && $routing->id_supplier == $supplier->id) || old('id_supplier') == $supplier->id ? 'selected' : '' }}>
                          {{ $supplier->name_businessname }}
                      </option>
                  @endforeach
              </x-adminlte-select2>
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
                      <input type="radio" id="radioLclFcl" name="lcl_fcl" value="LCL"
                          {{ old('lcl_fcl') === 'LCL' ? 'checked' : '' }} class="form-check-input @error('lcl_fcl') is-invalid @enderror">
                      <label for="radioLclFcl" class="form-check-label">
                          LCL
                      </label>
                  </div>
                  <div class="form-check d-inline">
                      <input type="radio" id="radioLclFcl" name="lcl_fcl" value="FCL"
                          {{ old('lcl_fcl') === 'FCL' ? 'checked' : '' }} class="form-check-input @error('lcl_fcl') is-invalid @enderror">
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

          <div class="col-12 mb-5">
              <label for="wr_loading" class="bg-indigo w-100 px-2 py-1"> WR Loading </label>
              <div class="form-group row justify-content-center">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">WR Loading:</label>
                  <div class="col-sm-6">
                      <input type="text" class="form-control" id="wr_loading" name="wr_loading"
                          placeholder="Ingrese su WR...">
                  </div>
              </div>
          </div>

      </div>

      <button class="btn btn-primary" onclick="stepper.next()">Siguiente</button>
  </div>
  <div id="test-l-2" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger2">


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

      <div class="form-group row">
          <label for="nro_package" class="col-sm-2 col-form-label">N° Paquetes</label>
          <div class="col-sm-10">
              <input type="number" min="0" step="1" class="form-control" id="nro_package"
                  name="nro_package" placeholder="Ingrese el nro de paquetes.." oninput="validarInputNumber(this)"
                  value="{{ isset($routing) ? $routing->nro_package : '' }}">
              @error('nro_package')
                  <div class="text-danger">{{ $message }}</div>
              @enderror
          </div>
      </div>

      <div class="row">
          <label for="total_gross_weight" class="w-100">Total peso bruto</label>
          <hr class="w-100">

          <div class="col-4">
              <div class="form-group row">
                  <label for="pounds" class="col-sm-4 col-form-label">Libras: </label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control CurrencyInput" id="pounds" name="pounds"
                          data-type="currency" placeholder="Ingrese el nro de paquetes.."
                          value="{{ isset($routing) ? $routing->pounds : '' }}" @readonly(true)>
                      @error('pounds')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>
              </div>
          </div>

          <div class="col-4">
              <div class="form-group row">
                  <label for="kilograms" class="col-sm-4 col-form-label">Kilogramos: </label>
                  <div class="col-sm-8">
                      <input type="text"
                          class="form-control CurrencyInput @error('kilograms') is-invalid @enderror" id="kilograms"
                          name="kilograms" data-type="currency" placeholder="Ingrese el nro de paquetes.."
                          value="{{ isset($routing->kilograms) ? $routing->kilograms : old('kilograms') }}">
                      @error('kilograms')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
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
      <hr class="w-100">
      <div class="form-group row">
          <label for="hs_code" class="col-sm-2 col-form-label">H.S. Code</label>
          <div class="col-sm-10">
              <input type="number" min="0" step="1" class="form-control" id="hs_code"
                  name="hs_code" placeholder="Ingrese el nro de paquetes.." oninput="validarInputNumber(this)"
                  value="{{ isset($routing) ? $routing->hs_code : '' }}">
              @error('hs_code')
                  <div class="text-danger">{{ $message }}</div>
              @enderror
          </div>
      </div>

      <div class="form-group row">
          <label for="observation" class="col-sm-2 col-form-label">Observacion</label>
          <div class="col-sm-10">
              <textarea name="observation" id="observation" class="form-control" cols="30" rows="5">

          </textarea>
              @error('observation')
                  <div class="text-danger">{{ $message }}</div>
              @enderror
          </div>
      </div>

      <input type="hidden" id="type_shipment_name" name="type_shipment_name">



      <button class="btn btn-secondary mt-5" onclick="stepper.previous()">Anterior</button>
      <button type="submit" class="btn btn-indigo mt-5" onclick="submitForm()">Guardar</button>
  </div>


  @push('scripts')
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              // Obtener los valores de los campos del formulario (puedes personalizar esto para tu caso)
              let volumenValue = document.getElementById('volumen');
              let kilogramoVolumenValue = document.getElementById('kilogram_volumen');
              let lcl_fcl = document.getElementById('radioLclFcl');

              // Mostrar/ocultar los campos según los valores
              if (volumenValue.value !== '' || volumenValue.classList.contains('is-invalid')) {
                  document.getElementById('contenedor_volumen').classList.remove('d-none');
              }

              if (kilogramoVolumenValue.value !== '' || kilogramoVolumenValue.classList.contains('is-invalid')) {
                  document.getElementById('contenedor_kg_vol').classList.remove('d-none');
              }

              if (lcl_fcl.checked === true || lcl_fcl.classList.contains('is-invalid')) {
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

                      }
                  }
              });


          });

          $('#kilograms').on('change', (e) => {

              let kilogramsVal = $(e.target).val();
              let numberValue = parseFloat(kilogramsVal);

              if (!kilogramsVal || isNaN(numberValue)) {

                  $('#pounds').val(0);

              } else {

                  $('#pounds').val(numberValue * 2.21);

              }


          });


          $('select').on('select2:open', function(e) {
              var searchField = $(this).data('select2').dropdown.$search || $(this).data('select2').selection.$search;
              if (searchField) {
                  searchField[0].focus();
              }
          });
      </script>
  @endpush
