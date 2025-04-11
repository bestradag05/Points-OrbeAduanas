<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ $container->name ?? old('name') }}" placeholder="Nombre del contenedor">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="type_container_id">Tipo de Contenedor</label>
            <x-adminlte-select2 name="type_container_id" igroup-size="md">
                @foreach($typeContainers as $type)
                <option value="{{ $type->id }}" {{ (isset($container->type_container_id) && $container->type_container_id == $type->id) ? 'selected' : '' }}>
                    {{ $type->name }}
                </option>
                @endforeach
            </x-adminlte-select2>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="description">Descripción</label>
            <input type="text" class="form-control" id="description" name="description"
                value="{{ $container->description ?? old('description') }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="length">Longitud (m)</label>
            <input type="number" step="0.01" class="form-control" id="length" name="length"
                value="{{ $container->length ?? old('length') }}">
        </div>
    </div>
</div>



<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="width">Anchura (m)</label>
            <input type="number" step="0.01" class="form-control" id="width" name="width"
                value="{{ $container->width ?? old('width') }}">
        </div>
    </div>


    <div class="col-md-6">
        <div class="form-group">
            <label for="height">Altura (m)</label>
            <input type="number" step="0.01" class="form-control" id="height" name="height"
                value="{{ $container->height ?? old('height') }}">
        </div>
    </div>
</div>


<div class="row">
<div class="col-md-6">
        <div class="form-group">
            <label for="max_load">Carga Máx (kg)</label>
            <input type="number" step="0.01" class="form-control" id="max_load" name="max_load"
                value="{{ $container->max_load ?? old('max_load') }}">
        </div>
    </div>
</div>


<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
</div>