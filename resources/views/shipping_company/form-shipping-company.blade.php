<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
    placeholder="Ingrese el name" value="{{ isset($shippingCompany->name) ? $shippingCompany->name : ''}}">
    @error('name')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="contact">Contacto</label>
    <input type="text" class="form-control @error('contact') is-invalid @enderror" id="contact" name="contact" 
    placeholder="Ingrese el contacto" value="{{ isset($shippingCompany->contact) ? $shippingCompany->contact : ''}}">
    @error('contact')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="cellphone">Telefono</label>
    <input type="text" class="form-control @error('cellphone') is-invalid @enderror" id="cellphone" name="cellphone" 
    placeholder="Ingrese el cellphone" value="{{ isset($shippingCompany->cellphone) ? $shippingCompany->cellphone : ''}}">
    @error('cellphone')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="email">Email</label>
    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
    placeholder="Ingrese el email" value="{{ isset($shippingCompany->email) ? $shippingCompany->email : ''}}">
    @error('email')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>


<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
</div>