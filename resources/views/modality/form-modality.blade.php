<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" class="form-control" id="name" name="name" 
    placeholder="Ingrese el name" value="{{ isset($modality->name) ? $modality->name : ''}}">
    @error('name')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="description">Descripcion</label>
    <input type="text" class="form-control" id="description" name="description" placeholder="Ingrese su razon social o nombre" value="{{ isset($modality->description) ? $modality->description : ''}}">
    @error('description')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>




<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
</div>