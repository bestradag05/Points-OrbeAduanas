<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" class="form-control" id="name" name="name" 
    placeholder="Ingrese el name" value="{{ isset($type_insurance->name) ? $type_insurance->name : old('name')}}">
    @error('name')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>





<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
</div>