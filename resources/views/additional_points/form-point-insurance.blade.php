<div class="row">
    {{-- Placeholder, sm size, and prepend icon --}}

    <div class="col-6">

        @php
            $config = ['format' => 'DD/MM/YYYY'];

        @endphp
        <x-adminlte-input-date name="date" id="date"
            value="{{ isset($insurance->date) ? \Carbon\Carbon::parse($insurance->date)->format('d/m/Y') : now()->format('d/m/Y') }}"
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
            <label for="certified_number">Numero de Certificado</label>
            <input type="text" class="form-control @error('certified_number') is-invalid @enderror"
                id="certified_number" name="certified_number" placeholder="Ingrese el numero de certificado"
                value="{{ isset($insurance->certified_number) ? $insurance->certified_number : old('certified_number') }}">
            @error('certified_number')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>

    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="insured_references">N° de referencia de asegurado</label>
            <input type="text" class="form-control @error('insured_references') is-invalid @enderror"
                id="insured_references" name="insured_references"
                placeholder="Ingrese su numero de referencia de aseguradora"
                value="{{ isset($insurance->insured_references) ? $insurance->insured_references : old('insured_references') }}">
            @error('insured_references')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="load_value">Valor Asegurado</label>
            <input type="text" class="form-control @error('load_value') is-invalid @enderror" id="load_value"
                @readonly(true)
                value="{{ isset($insurance->insurable->routing->load_value) ? $insurance->insurable->routing->load_value : '' }}">
            @error('load_value')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="name_service">Aduana / Flete</label>
            <input type="text" class="form-control @error('name_service') is-invalid @enderror" id="name_service"
                @readonly(true)
                value="{{ isset($insurance->name_service) ? $insurance->name_service : old('name_service') }}">
            @error('name_service')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="type_insurance">Aseguradora</label>
            <input type="text" class="form-control @error('type_insurance') is-invalid @enderror" id="type_insurance"
                @readonly(true)
                value="{{ isset($insurance->typeInsurance->name) ? $insurance->typeInsurance->name : old('type_insurance') }}">
            @error('type_insurance')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>
    </div>

</div>

<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="Guardar">
</div>
