<div class="form-group">
    <label for="code">Código</label>
    <input 
        type="text" 
        class="form-control @error('code') is-invalid @enderror" 
        id="code" 
        name="code" 
        placeholder="Ingrese el código" 
        value="{{ isset($regime->code) ? $regime->code : old('code') }}"
    >
    @error('code')
        <span class="invalid-feedback d-block">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="description">Descripción</label>
    <input
        class="form-control @error('description') is-invalid @enderror" 
        id="description" 
        name="description" 
        rows="3"
        placeholder="Ingrese la descripción"
        value="{{ isset($regime->description) ? $regime->description : old('description') }}"
    >
    @error('description')
        <span class="invalid-feedback d-block">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="container text-center mt-5">
    <input 
        class="btn btn-primary" 
        type="submit" 
        value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}"
    >
</div>