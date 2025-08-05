<div class="row">
    {{-- Placeholder, sm size, and prepend icon --}}

    <div class="col-6">
        <x-adminlte-select2 name="insurance_type_id" label="Tipo de seguro" igroup-size="md"
            data-placeholder="Seleccione una opcion...">
            <option />
            @foreach ($insuranceTypes as $type)
                <option value="{{ $type->id }}" {{isset($insurance_rate) && $insurance_rate->insurance_type_id === $type->id ? 'selected' : ''}}>
                    {{ $type->name }}
                </option>
            @endforeach
        </x-adminlte-select2>

        @error('insurance_type_id')
            <strong class="invalid-feedback d-block">{{ $message }}</strong>
        @enderror

    </div>

    <div class="col-6">
        <x-adminlte-select2 name="shipment_type_description" label="Tipo de embarque" igroup-size="md"
            data-placeholder="Seleccione una opcion...">
            <option />
            @foreach ($typeShipments as $type)
                <option value="{{ $type->description }}"  {{isset($insurance_rate) && $insurance_rate->shipment_type_description === $type->description ? 'selected' : ''}}>
                    {{ $type->description }}
                </option>
            @endforeach
        </x-adminlte-select2>

        @error('shipment_type_description')
            <strong class="invalid-feedback d-block">{{ $message }}</strong>
        @enderror
    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="min_value">Valor asegurado</label>
            <input type="text" class="form-control CurrencyInput @error('min_value') is-invalid @enderror"
                id="min_value" name="min_value" data-type="currency"
                placeholder="Ingrese el valor asegurado maximo para aplicar tarifa fija"
                value="{{ isset($insurance_rate->min_value) ? $insurance_rate->min_value : old('min_value') }}">
            @error('min_value')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>

    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="fixed_cost">Tarifa Fije</label>
            <input type="text" class="form-control CurrencyInput @error('fixed_cost') is-invalid @enderror"
                id="fixed_cost" name="fixed_cost" data-type="currency" placeholder="Ingrese la tarifa fija"
                value="{{ isset($insurance_rate->fixed_cost) ? $insurance_rate->fixed_cost : old('fixed_cost') }}">
            @error('fixed_cost')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>

    </div>


    <div class="col-6">

        <div class="form-group">
            <label for="percentage">Porcentaje aplicar</label>

            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">%</span>
                </div>
                <input type="text" class="form-control CurrencyInput @error('percentage') is-invalid @enderror"
                    id="percentage" name="percentage" data-type="currency"
                    placeholder="Porcentaje para aplicar si se pasa el fob minimo"
                    value="{{ isset($insurance_rate->percentage) ? $insurance_rate->percentage : old('percentage') }}">
            </div>
            @error('percentage')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>


    </div>


    <div class="col-12">
        <div class="text-info text-sm px-5 py-2 text-center">
            <p>*Recuerda que el valor asegurado que debes poner es el maximo hasta donde se puede aplicar la tarifa fija
                y el porcentaje solo se aplicara cuando el valor de la factura (FOB) sobrepase este valor asegurado*
            </p>
        </div>
    </div>



</div>

<div class="container text-center mt-2">
    <input class="btn btn-primary" type="submit" value="Guardar">
</div>



@push('scripts')
    <script>
        function cleanCurrencyInput() {
            // Limpiar los campos que tienen formato de moneda
            const currencyInputs = document.querySelectorAll('.CurrencyInput');

            currencyInputs.forEach(function(input) {
                // Obtener el valor, eliminar cualquier símbolo de moneda y comas
                let value = input.value.replace(/[^\d.-]/g, '');
                // Asignar el valor limpio al input
                input.value = value;
            });
        }

        // Agregar evento de submit para limpiar los campos antes de enviar el formulario
        document.getElementById('formInsuranceRate').addEventListener('submit', function(event) {
            event.preventDefault();
            cleanCurrencyInput();
            event.target.submit();
        });
    </script>
@endpush
