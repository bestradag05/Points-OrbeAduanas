<div class="form-group">
    <label for="code">Codigo</label>
    <input type="text" class="form-control" id="code" name="code" placeholder="Ingrese el code"
        value="{{ isset($incoterm->code) ? $incoterm->code : '' }}">
    @error('code')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" class="form-control" id="name" name="name"
        placeholder="Ingrese el nombre del incoterm" value="{{ isset($incoterm->name) ? $incoterm->name : '' }}">
    @error('name')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="description">Descripcion</label>
    <input type="text" class="form-control" id="description" name="description" placeholder="Ingrese la descripcion"
        value="{{ isset($incoterm->description) ? $incoterm->description : '' }}">
    @error('description')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>


<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
</div>
