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
    
            <x-adminlte-select2 name="origin" label="Origen" igroup-size="md" data-placeholder="Seleccione una opcion...">
                <option />
                @foreach ($stateCountrys as $stateCountry)
                    <option>{{ $stateCountry->country->name . ' - ' . $stateCountry->name }}</option>
                @endforeach
            </x-adminlte-select2>
    
        </div>
        <div class="col-6">
    
            <x-adminlte-select2 name="destination" label="Destino" igroup-size="md"
                data-placeholder="Seleccione una opcion...">
                <option />
                @foreach ($stateCountrys as $stateCountry)
                    <option>{{ $stateCountry->country->name . ' - ' . $stateCountry->name }}</option>
                @endforeach
            </x-adminlte-select2>
    
        </div>
    
    
        <div class="col-6">
    
            <div class="form-group">
                <label for="freight_value">Valor del Flete</label>
    
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-bold">
                            $
                        </span>
                    </div>
                    <input type="text" class="form-control CurrencyInput" name="freight_value" data-type="currency"
                        placeholder="Ingrese valor del flete">
    
                    @error('freight_value')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
    
            </div>
    
        </div>
        <div class="col-6">
    
            <div class="form-group">
                <label for="load_value">Valor del la carga</label>
    
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-bold">
                            $
                        </span>
                    </div>
                    <input type="text" class="form-control CurrencyInput" name="load_value" data-type="currency"
                        placeholder="Ingrese valor de la carga">
    
                    @error('freight_value')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
    
            </div>
        </div>
    
        <div class="col-6">
    
            <div class="form-group">
                <label for="insurance_value">Valor del seguro</label>
    
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-bold">
                            $
                        </span>
                    </div>
                    <input type="text" class="form-control CurrencyInput" name="insurance_value" data-type="currency"
                        placeholder="Ingrese valor de la carga">
    
                    @error('freight_value')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
    
            </div>
        </div>
    
    
        <div class="col-6">
            <x-adminlte-select2 name="id_customer" label="Clientes" igroup-size="md"
                data-placeholder="Seleccione una opcion...">
                <option />
                @foreach ($customers as $customer)
                    <option>{{ $customer->name_businessname }}</option>
                @endforeach
            </x-adminlte-select2>
        </div>
    
        <div class="col-6">
            <x-adminlte-select2 name="id_shipper" label="Provedor del Cliente" igroup-size="md"
                data-placeholder="Seleccione una opcion...">
                <option />
                @foreach ($shippers as $shipper)
                    <option>{{ $shipper->name_businessname }}</option>
                @endforeach
            </x-adminlte-select2>
        </div>
    
        <div class="col-6">
            <x-adminlte-select2 name="id_type_shipment" label="Tipo de embarque" igroup-size="md"
                data-placeholder="Seleccione una opcion...">
                <option />
                @foreach ($type_shipments as $type_shipment)
                    <option value="{{ $type_shipment->id }}">
                        {{ $type_shipment->code . ' - ( ' . $type_shipment->description . ' )' }}</option>
                @endforeach
            </x-adminlte-select2>
        </div>
    
        <div class="col-6">
            <x-adminlte-select2 name="id_modality" label="Modalidad" igroup-size="md"
                data-placeholder="Seleccione una opcion...">
                <option />
                @foreach ($modalitys as $modality)
                    <option value="{{ $modality->id }}">{{ $modality->name }}</option>
                @endforeach
            </x-adminlte-select2>
        </div>
    
        <div class="col-6">
            <x-adminlte-select2 name="id_regime" label="Regimen" igroup-size="md"
                data-placeholder="Seleccione una opcion...">
                <option />
                @foreach ($regimes as $regime)
                    <option value="{{ $regime->id }}">{{ $regime->code . ' - ( ' . $regime->description . ' )' }}
                    </option>
                @endforeach
            </x-adminlte-select2>
        </div>
    
        <div class="col-6">
            <x-adminlte-select2 name="id_incoterms" label="Incoterms" igroup-size="md"
                data-placeholder="Seleccione una opcion...">
                <option />
                @foreach ($incoterms as $incoter)
                    <option value="{{ $incoter->id }}">{{ $incoter->code }}</option>
                @endforeach
            </x-adminlte-select2>
        </div>
    
        <div class="col-12">
            <label for="wr_loading" class="bg-indigo w-100 px-2 py-1"> WR Loading </label>
            <div class="form-group row justify-content-center">
                <label for="inputEmail3" class="col-sm-2 col-form-label">WR Loading:</label>
                <div class="col-sm-6">
                    <input type="email" class="form-control" id="wr_loading" placeholder="Ingrese su WR...">
                </div>
            </div>
        </div>
    
    
    </div>

      <button class="btn btn-primary" onclick="stepper.next()">Next</button>
  </div>
  <div id="test-l-2" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger2">
      <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
      </div>
      <button class="btn btn-primary" onclick="stepper.previous()">Previous</button>
      <button class="btn btn-primary" onclick="stepper.next()">Next</button>
  </div>
  <div id="test-l-3" role="tabpanel" class="bs-stepper-pane text-center" aria-labelledby="stepper1trigger3">
      <button class="btn btn-primary mt-5" onclick="stepper.previous()">Previous</button>
      <button type="submit" class="btn btn-primary mt-5" onclick="submitForm()">Submit</button>
  </div>


{{--     <div class="container text-center mt-5">
        <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
    </div>
 --}}
