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
              <div class="col-4 d-none align-items-center ">
                  <div class="form-check d-inline">
                      <input type="radio" id="radioLclFcl" name="lcl_fcl">
                      <label for="radioLclFcl">
                          LCL
                      </label>
                  </div>
                  <div class="form-check d-inline">
                      <input type="radio" id="radioLclFcl" name="lcl_fcl">
                      <label for="radioLclFcl">
                          FCL
                      </label>
                  </div>
              </div>

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
                          value="{{ isset($routing) ? $routing->pounds : '' }}">
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
              <div class="form-group row">
                  <label for="meassurement" class="col-sm-4 col-form-label">Medicion: </label>
                  <div class="col-sm-8">
                      <input type="text"
                          class="form-control CurrencyInput @error('meassurement') is-invalid @enderror"
                          id="meassurement" name="meassurement" data-type="currency"
                          placeholder="Ingrese el nro de paquetes.."
                          value="{{ isset($routing->meassurement) ? $routing->meassurement : old('meassurement') }}">
                      @error('meassurement')
                          <span class="invalid-feedback d-block" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
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



      <button class="btn btn-secondary mt-5" onclick="stepper.previous()">Anterior</button>
      <button type="submit" class="btn btn-indigo mt-5" onclick="submitForm()">Guardar</button>
  </div>


  @push('scripts')
      <script>
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
                        $('#lclfcl_content').children().first().removeClass('col-12').addClass('col-8');
                        $('#lclfcl_content').children().last().removeClass('d-none').addClass('d-flex');
                        

                      }else{
                        $('#lclfcl_content').children().first().removeClass('col-8').addClass('col-12');
                        $('#lclfcl_content').children().last().removeClass('d-flex').addClass('d-none');
                        $('input[name="lcl_fcl"]').prop('checked', false);
                      }
                  }
              });


          });
      </script>
  @endpush
