<div class="row">
    {{-- Placeholder, sm size, and prepend icon --}}
    <div class="col-6">

        <div class="form-group">
            <label for="nro_orde">N° de Orden</label>
            <input type="text" class="form-control @error('nro_orde') is-invalid @enderror" id="nro_orde"
                name="nro_orde" placeholder="Ingrese el numero de orden"
                value="{{ isset($custom->nro_orde) ? $custom->nro_orde : '' }}">
            @error('nro_orde')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>

        <div class="form-group">
            <label for="nro_dam">N° Dam</label>
            <input type="text" class="form-control @error('nro_dam') is-invalid @enderror" id="nro_dam"
                name="nro_dam" placeholder="Ingrese su numero de dam"
                value="{{ isset($custom->nro_dam) ? $custom->nro_dam : '' }}">
            @error('nro_dam')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>

    </div>

    <div class="col-6">

        <div class="form-group">
            <label for="nro_dua">N° de Dua</label>
            <input type="text" class="form-control @error('nro_dua') is-invalid @enderror" id="nro_dua"
                name="nro_dua" placeholder="Ingrese su numero de dua"
                value="{{ isset($custom->nro_dua) ? $custom->nro_dua : '' }}">
            @error('nro_dua')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>

        @php
            $config = ['format' => 'DD/MM/YYYY'];
        @endphp
        <x-adminlte-input-date name="date_register" id="date_register" value="{{ now()->format('d/m/Y') }}"
            label="Fecha de Registro" :config="$config" placeholder="Ingresa la fecha...">
            <x-slot name="appendSlot">
                <div class="input-group-append">
                    <div class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                </div>
            </x-slot>
        </x-adminlte-input-date>



    </div>


    <div class="col-6">

        <div class="form-group">
            <label for="cif_value">Valor CIF</label>
            <input type="text" class="form-control CurrencyInput @error('cif_value') is-invalid @enderror"
                id="cif_value" name="cif_value" data-type="currency" placeholder="Ingrese el valor cif"
                value="{{ isset($custom->cif_value) ? $custom->cif_value : '' }}">
            @error('cif_value')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>

        <div class="form-group">
            <label for="channel">Canal</label>
            <select name="channel" class="form-control @error('channel') is-invalid @enderror" id="channel">
                <option selected disabled>Selecciona un canal...</option>
                <option value="v">Verde</option>
                <option value="r">Rojo</option>
                <option value="n">Naranja</option>
            </select>
            @error('channel')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>




    </div>

    <div class="col-6">




        <div class="form-group">
            <label for="nro_bl">N° Bl</label>
            <input type="text" class="form-control @error('nro_bl') is-invalid @enderror" id="nro_bl"
                name="nro_bl" placeholder="Ingrese el numero de bl"
                value="{{ isset($custom->nro_bl) ? $custom->nro_bl : '' }}">
            @error('nro_bl')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>


        <label for="regularization_date">Fecha de reguralizacion</label>


        @if ($custom->modality->name == 'DIFERIDO')
            <div class="input-group date" id="reguralization">

                <input type="text" class="form-control @error('regularization_date') is-invalid @enderror"
                    name="regularization_date" data-target="#reguralization" @readonly(true) value="NO REQUIERE">


                <div class="input-group-append" data-target="#reguralization" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        @else
            <div class="input-group date" id="reguralization" data-target-input="nearest">

                <input type="text" class="form-control @error('regularization_date') is-invalid @enderror"
                    name="regularization_date" data-target="#reguralization" @readonly(true)>


                <div class="input-group-append" data-target="#reguralization" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        @endif

        @error('regularization_date')
            <strong class="invalid-feedback d-block">{{ $message }}</strong>
        @enderror



    </div>



</div>

<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="Guardar">
</div>
