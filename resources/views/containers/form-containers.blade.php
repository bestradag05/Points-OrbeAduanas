<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
        value="{{ $container->name ?? old('name') }}" placeholder="Nombre del contenedor">
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

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

<!-- Campos adicionales (longitud, anchura, etc.) -->
<div class="form-group">
    <label for="length">Longitud (m)</label>
    <input type="number" step="0.01" class="form-control" id="length" name="length" 
        value="{{ $container->length ?? old('length') }}">
</div>

<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
</div>