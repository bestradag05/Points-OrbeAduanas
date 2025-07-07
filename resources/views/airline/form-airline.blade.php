<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
    placeholder="Ingrese el name" value="{{ isset($airline->name) ? $airline->name : ''}}">
    @error('name')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="contact">Contacto</label>
    <input type="text" class="form-control @error('contact') is-invalid @enderror" id="contact" name="contact" 
    placeholder="Ingrese el contacto" value="{{ isset($airline->contact) ? $airline->contact : ''}}">
    @error('contact')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="cellphone">Telefono</label>
    <input type="text" class="form-control @error('cellphone') is-invalid @enderror" id="cellphone" name="cellphone" 
    placeholder="Ingrese el cellphone" value="{{ isset($airline->cellphone) ? $airline->cellphone : ''}}">
    @error('cellphone')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="email">Email</label>
    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
    placeholder="Ingrese el email" value="{{ isset($airline->email) ? $airline->email : ''}}">
    @error('email')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>


<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
</div>