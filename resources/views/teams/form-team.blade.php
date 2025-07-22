<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" name="name"
                placeholder="Ingrese el nombre del equipo" value="{{ isset($team->name) ? $team->name : old('name') }}">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="area_id">Área asignada</label>
            <select name="areas[]" id="area_id" class="form-control">
                <option value="" disabled selected>-- Seleccione un área --</option>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}"
                        {{ isset($team) && $team->areas->pluck('id')->contains($area->id) ? 'selected' : '' }}>
                        {{ $area->name }}
                    </option>
                @endforeach
            </select>
            @error('areas')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
</div>
