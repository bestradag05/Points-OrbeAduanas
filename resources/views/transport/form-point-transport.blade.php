<div class="row">
    <div class="col-6">

        @php
            $config = ['format' => 'DD/MM/YYYY'];

        @endphp
        <x-adminlte-input-date name="date_register" id="date_register"
            value="{{ isset($transport->date_register) ? \Carbon\Carbon::parse($transport->date_register)->format('d/m/Y') : now()->format('d/m/Y') }}"
            label="Fecha de Registro" :config="$config" placeholder="Ingresa la fecha...">
            <x-slot name="appendSlot">
                <div class="input-group-append">
                    <div class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                </div>
            </x-slot>
        </x-adminlte-input-date>

    </div>

    {{-- Placeholder, sm size, and prepend icon --}}
    <div class="col-6">
        <div class="form-group">
            <label for="invoice_number">N° de factura</label>
            <input type="text" class="form-control @error('invoice_number') is-invalid @enderror" id="invoice_number"
                name="invoice_number" placeholder="Ingrese el numero de orden"
                value="{{ isset($transport->invoice_number) ? $transport->invoice_number : old('invoice_number') }}">
            @error('invoice_number')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>

    </div>

    <div class="col-6">
        <x-adminlte-select2 name="id_supplier" label="Proveedor" igroup-size="md"
            data-placeholder="Seleccione una opcion...">
            <option />
            @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->id }}"
                    {{ (isset($transport->id_supplier) && $transport->id_supplier == $supplier->id) || old('id_supplier') == $supplier->id ? 'selected' : '' }}>
                    {{ $supplier->name_businessname }}
                </option>
            @endforeach
        </x-adminlte-select2>
    </div>

    <div class="col-6">

        <div class="form-group">
            <label for="nro_orden">N° Orden</label>
            <input type="text" class="form-control @error('nro_orden') is-invalid @enderror" id="nro_orden"
                name="nro_orden" placeholder="Ingrese su numero de orden"
                value="{{ isset($transport->nro_orden) ? $transport->nro_orden : old('nro_orden') }}">
            @error('nro_orden')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>

    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="nro_dua">N° de Dua</label>
            <input type="text" class="form-control @error('nro_dua') is-invalid @enderror" id="nro_dua"
                name="nro_dua" placeholder="Ingrese su numero de dua"
                value="{{ isset($transport->nro_dua) ? $transport->nro_dua : old('nro_dua') }}">
            @error('nro_dua')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <x-adminlte-select2 name="payment_state" label="Estado del pago" igroup-size="md"
            data-placeholder="Seleccione una opcion...">
            <option />
            <option
                {{ (isset($transport->payment_state) && $transport->payment_state == 'Pendiente') || old('payment_state') == 'Pendiente' ? 'selected' : '' }}>
                Pendiente</option>
            <option
                {{ (isset($transport->payment_state) && $transport->payment_state == 'Cancelado') || old('payment_state') == 'Cancelado' ? 'selected' : '' }}>
                Cancelado</option>

        </x-adminlte-select2>
    </div>

    <div class="col-6">

        @php
            $config = ['format' => 'DD/MM/YYYY'];

        @endphp
        <x-adminlte-input-date name="payment_date" id="payment_date"
            value="{{ isset($transport->payment_date) ? \Carbon\Carbon::parse($transport->payment_date)->format('d/m/Y') : now()->format('d/m/Y') }}"
            label="Fecha de pago" :config="$config" placeholder="Ingresa la fecha...">
            <x-slot name="appendSlot">
                <div class="input-group-append">
                    <div class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                </div>
            </x-slot>
        </x-adminlte-input-date>

    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="weight">Peso de la carga</label>
            <input type="text" class="form-control @error('weight') is-invalid @enderror" id="weight"
                name="weight" placeholder="Ingrese el numero de bl"
                value="{{ isset($transport->weight) ? $transport->weight : old('weight') }}">
            @error('weight')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>
    </div>




</div>

<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="Guardar">
</div>
