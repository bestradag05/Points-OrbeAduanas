<div class="row">
    {{-- Placeholder, sm size, and prepend icon --}}

    <div class="col-6">

        @php
            $config = ['format' => 'DD/MM/YYYY'];

        @endphp
        <x-adminlte-input-date name="date_register" id="date_register"
            value="{{ isset($additional->date_register) ? \Carbon\Carbon::parse($additional->date_register)->format('d/m/Y') : now()->format('d/m/Y') }}"
            label="Fecha de registro" :config="$config" placeholder="Ingresa la fecha...">
            <x-slot name="appendSlot">
                <div class="input-group-append">
                    <div class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                </div>
            </x-slot>
        </x-adminlte-input-date>

    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="bl_to_work">Bl a Trabajar</label>
            <input type="text" class="form-control @error('bl_to_work') is-invalid @enderror"
                id="bl_to_work" name="bl_to_work" placeholder="Ingrese el numero de certificado"
                value="{{ isset($additional->bl_to_work) ? $additional->bl_to_work : old('bl_to_work') }}">
            @error('bl_to_work')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>

    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="ruc_to_invoice">RUC a facturar</label>
            <input type="text" class="form-control @error('ruc_to_invoice') is-invalid @enderror"
                id="ruc_to_invoice" name="ruc_to_invoice"
                placeholder="Ingrese su numero de referencia de aseguradora"
                value="{{ isset($additional->ruc_to_invoice) ? $additional->ruc_to_invoice : old('ruc_to_invoice') }}">
            @error('ruc_to_invoice')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="invoice_number">N° de factura</label>
            <input type="text" class="form-control @error('invoice_number') is-invalid @enderror" id="invoice_number"  name="invoice_number" placeholder="Ingrese su numero de factura"
                value="{{ isset($additional->insurable->routing->invoice_number) ? $additional->insurable->routing->invoice_number : '' }}">
            @error('invoice_number')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>
    </div>
    

</div>

<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="Guardar">
</div>
