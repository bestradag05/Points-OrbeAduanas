<div class="row">

    <div class="col-6">

        <div class="form-group">
            <label for="nro_orde">N° de Orden</label>
            <input type="text" class="form-control" id="nro_orde" name="nro_orde"
                placeholder="Ingrese el numero de orden" value="{{ isset($custom->nro_orde) ? $custom->nro_orde : '' }}">
            @error('nro_orde')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="nro_dam">N° Dam</label>
            <input type="text" class="form-control" id="nro_dam" name="nro_dam"
                placeholder="Ingrese su numero de dam" value="{{ isset($custom->nro_dam) ? $custom->nro_dam : '' }}">
            @error('nro_dam')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

    </div>

    <div class="col-6">


        @php
            $config = ['format' => 'L'];
        @endphp
        <x-adminlte-input-date name="idDateOnly" label="Fecha de Registro" :config="$config"
            placeholder="Ingresa la fecha...">
            <x-slot name="appendSlot">
                <div class="input-group-append">
                    <div class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                </div>
            </x-slot>
        </x-adminlte-input-date>

        <div class="form-group">
            <label for="channel">Valor CIF</label>
            <input type="text" class="form-control" id="cif_value" name="cif_value"
                placeholder="Ingrese el valor cif" value="{{ isset($custom->cif_value) ? $custom->cif_value : '' }}">
            @error('cif_value')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

    </div>


    <div class="col-6">

        <div class="form-group">
            <label for="regularization_date">Canal</label>
            <select name="regularization_date" class="form-control" id="regularization_date">
                <option selected disabled>Selecciona un canal...</option>
                <option value="v">Verde</option>
                <option value="r">Rojo</option>
                <option value="n">Naranja</option>
            </select>
            @error('channel')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <label for="regularization_date">Fecha de reguralizacion</label>
        <div class="input-group date" id="reguralization" data-target-input="nearest">
            <input type="text" class="form-control" name="regularization_date" data-target="#reguralization">
            <div class="input-group-append" data-target="#reguralization" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div>



    </div>

    <div class="col-6">


        <div class="form-group">
            <label for="nro_bl">N° Bl</label>
            <input type="text" class="form-control" id="nro_bl" name="nro_bl"
                placeholder="Ingrese el numero de bl" value="{{ isset($custom->nro_bl) ? $custom->nro_bl : '' }}">
            @error('nro_bl')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>



    </div>



</div>

{{-- <div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
</div> --}}

@push('scripts')
    <script>
        $('#reguralization').datetimepicker({
            format: 'L'
        });
    </script>
@endpush
