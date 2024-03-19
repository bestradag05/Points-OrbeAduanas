<div class="form-group">
    <label for="code">Codigo</label>
    <input type="text" class="form-control" id="code" name="code" 
    placeholder="Ingrese el code" value="{{ isset($type_shipment->code) ? $type_shipment->code : ''}}">
    @error('code')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="description">Descripcion</label>
    <input type="text" class="form-control" id="description" name="description" placeholder="Ingrese su razon social o nombre" value="{{ isset($type_shipment->description) ? $type_shipment->description : ''}}">
    @error('description')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>




<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
</div>