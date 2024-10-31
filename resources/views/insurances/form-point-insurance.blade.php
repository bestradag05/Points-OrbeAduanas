<div class="row">
    {{-- Placeholder, sm size, and prepend icon --}}

    <div class="col-6">
       
            @php
                $config = ['format' => 'DD/MM/YYYY'];

            @endphp
            <x-adminlte-input-date name="date_register" id="date_register"
                value="{{ isset($freight->date_register) ? \Carbon\Carbon::parse($freight->date_register)->format('d/m/Y') : now()->format('d/m/Y') }}"
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
            <input type="text" class="form-control @error('certified_number') is-invalid @enderror" id="certified_number" name="certified_number"
                placeholder="Ingrese el numero de certified_number" value="{{ isset($freight->certified_number) ? $freight->certified_number : old('certified_number') }}">
            @error('certified_number')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>

    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="certified_number">N° de referencia de asegurado</label>
            <input type="text" class="form-control @error('certified_number') is-invalid @enderror" id="certified_number"
                name="certified_number" placeholder="Ingrese su numero de Hawb/HBL"
                value="{{ isset($freight->certified_number) ? $freight->certified_number : old('certified_number') }}">
            @error('certified_number')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>
    </div>


 {{--    <div class="col-6">

        @php
            $config = ['format' => 'DD/MM/YYYY'];

        @endphp
        <x-adminlte-input-date name="edt" id="edt"
            value="{{ isset($freight->edt) ? \Carbon\Carbon::parse($freight->edt)->format('d/m/Y') : now()->format('d/m/Y') }}"
            label="Fecha de arribo" :config="$config" placeholder="Ingresa la fecha...">
            <x-slot name="appendSlot">
                <div class="input-group-append">
                    <div class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                </div>
            </x-slot>
        </x-adminlte-input-date>

    </div>

    <div class="col-6">

        @php
            $config = ['format' => 'DD/MM/YYYY'];

        @endphp
        <x-adminlte-input-date name="eta" id="eta"
            value="{{ isset($freight->eta) ? \Carbon\Carbon::parse($freight->eta)->format('d/m/Y') : now()->format('d/m/Y') }}"
            label="Fecha de Llegada" :config="$config" placeholder="Ingresa la fecha...">
            <x-slot name="appendSlot">
                <div class="input-group-append">
                    <div class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                </div>
            </x-slot>
        </x-adminlte-input-date>

    </div>



    <div class="col-6">

        <div class="form-group">
            <label for="bl_work">BL a trabajar</label>
            <input type="text" class="form-control @error('bl_work') is-invalid @enderror" id="bl_work"
                name="bl_work" placeholder="Ingrese su numero de BL"
                value="{{ isset($freight->bl_work) ? $freight->bl_work : old('bl_work') }}">
            @error('bl_work')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>

    </div>


    <div class="col-6">

        <div class="form-group">
            <label for="value_utility">Utilidad</label>
            <input type="number" class="form-control @error('value_utility') is-invalid @enderror" id="value_utility"
                @readonly(true) name="value_utility" placeholder="Ingrese su numero de dam"
                value="{{ isset($freight->value_utility) ? $freight->value_utility : old('value_utility') }}">
            @error('value_utility')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>

    </div>


    <div class="col-6">

        <div class="form-group">
            <label for="value_freight">Valor del Flete</label>
            <input type="number" class="form-control @error('value_freight') is-invalid @enderror" @readonly(true)
                id="value_freight" name="value_freight" placeholder="Ingrese el valor cif"
                value="{{ isset($freight->value_freight) ? $freight->value_freight : number_format($value_freight, 2) }}">
            @error('value_freight')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>
    </div>
 --}}
</div>

<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="Guardar">
</div>
