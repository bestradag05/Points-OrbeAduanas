<div class="form-group">
    <label for="ruc">Ruc</label>
    <input type="text" class="form-control" id="ruc" name="ruc" 
    placeholder="Ingrese el Ruc" value="{{ isset($customer->ruc) ? $customer->ruc : ''}}">
    @error('ruc')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="name_businessname">Razon Social / Nombre</label>
    <input type="text" class="form-control" id="name_businessname" name="name_businessname" placeholder="Ingrese su razon social o nombre" value="{{ isset($customer->name_businessname) ? $customer->name_businessname : ''}}">
    @error('name_businessname')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="contact_name">Nombre del contacto</label>
    <input type="text" class="form-control" id="contact_name" name="contact_name" placeholder="Ingrese su numero de celular"
    value="{{ isset($customer->contact_name) ? $customer->contact_name : ''}}">
    @error('contact_name')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="contact_number">Numero del contacto</label>
    <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="Ingrese su numero de celular"
    value="{{ isset($customer->contact_number) ? $customer->contact_number : ''}}">
    @error('contact_number')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="contact_email">Correo del contacto</label>
    <input type="text" class="form-control" id="contact_email" name="contact_email" placeholder="Ingrese su numero de celular"
    value="{{ isset($customer->contact_email) ? $customer->contact_email : ''}}">
    @error('contact_email')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>



<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
</div>