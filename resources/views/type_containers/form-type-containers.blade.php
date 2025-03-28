<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                placeholder="Nombre del tipo" value="{{ $typeContainer->name ?? old('name') }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="description">Descripcion</label>
            <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" description="description"
                name="description" placeholder="Descripcion del contenedor" value="{{ $typeContainer->description ?? old('description') }}">
            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="container text-center mt-5">
            <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
        </div>
    </div>
</div>