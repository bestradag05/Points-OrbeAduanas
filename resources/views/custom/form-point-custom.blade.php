<div class="row">

    @section('plugins.BsCustomFileInput', true)

    <form id="form_doc" action="{{ url('/custom/load') }}" method="post" enctype="multipart/form-data">
        <div class="col-12">
            <x-adminlte-input-file name="doc_custom" igroup-size="md" placeholder="Suba el archivo...">
                <x-slot name="prependSlot">
                    <div class="input-group-text bg-lightblue">
                        <i class="fas fa-upload"></i>
                    </div>
                </x-slot>
            </x-adminlte-input-file>
            <hr>
        </div>
    </form>
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

        @php
            $config = ['format' => 'L'];
        @endphp
        <x-adminlte-input-date name="date_register" id="date_register" value="{{ now()->format('d/m/Y') }}" disabled
            label="Fecha de Registro" :config="$config" placeholder="Ingresa la fecha...">
            <x-slot name="appendSlot">
                <div class="input-group-append">
                    <div class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                </div>
            </x-slot>
        </x-adminlte-input-date>



        <div class="form-group">
            <label for="cif_value">Valor CIF</label>
            <input type="text" class="form-control @error('cif_value') is-invalid @enderror" id="cif_value"
                name="cif_value" placeholder="Ingrese el valor cif"
                value="{{ isset($custom->cif_value) ? $custom->cif_value : '' }}">
            @error('cif_value')
                <strong class="invalid-feedback d-block">{{ $message }}</strong>
            @enderror
        </div>

    </div>


    <div class="col-6">

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


        <label for="regularization_date">Fecha de reguralizacion</label>
        <div class="input-group date" id="reguralization" data-target-input="nearest">
            <input type="text" class="form-control @error('regularization_date') is-invalid @enderror"
                name="regularization_date" data-target="#reguralization">
            <div class="input-group-append" data-target="#reguralization" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div>

        @error('regularization_date')
            <strong class="invalid-feedback d-block">{{ $message }}</strong>
        @enderror

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



    </div>



</div>

<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="Guardar">
</div>

@push('scripts')
    <script>
        $('#reguralization').datetimepicker({
            format: 'L'
        });

        $('#doc_custom').change(function() {
            var archivo = $(this).prop('files')[0];
            if (archivo) {
                // Por ejemplo, podrías enviar el formulario después de seleccionar el archivo
                console.log(archivo);
                console.log($('#form_doc'));
                $('#form_doc').submit();
            }
        });

    </script>


@endpush
