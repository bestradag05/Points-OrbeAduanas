<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
        placeholder="Ingrese el nombre" value="{{ isset($commission->name) ? $commission->name : '' }}">

    @error('name')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="default_amount">Monto por defecto</label>
    <input type="text" class="form-control CurrencyInput @error('default_amount') is-invalid @enderror"
        id="default_amount" data-type="currency" name="default_amount" placeholder="Ingrese el nombre"
        value="{{ isset($commission->default_amount) ? $commission->default_amount : '' }}">

    @error('default_amount')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="description">Descripcion</label>
    <textarea type="text" class="form-control" id="description" name="description" placeholder="Ingrese el nombre">{{ isset($commission->description) ? $commission->description : '' }}</textarea>
</div>



<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
</div>
