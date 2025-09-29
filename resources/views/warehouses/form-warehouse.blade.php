<div class="row">

    <div class="col-6 form-group">
        <label for="ruc">Ruc</label>
        <input type="text" class="form-control @error('ruc') is-invalid @enderror" id="ruc" name="ruc"
            placeholder="Ingrese el ruc..." value="{{ isset($warehouses->ruc) ? $warehouses->ruc : old('ruc') }}">
        @error('ruc')
            <span class="invalid-feedback d-block">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-6 form-group">
        <label for="name_businessname">Razon social</label>
        <input type="text" class="form-control @error('name_businessname') is-invalid @enderror"
            id="name_businessname" name="name_businessname" placeholder="Ingrese la razon social..."
            value="{{ isset($warehouses->name_businessname) ? $warehouses->name_businessname : old('name_businessname') }}">
        @error('name_businessname')
            <span class="invalid-feedback d-block">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="col-6 form-group">
        <label for="contact_name">Contacto</label>
        <input type="text" class="form-control @error('contact_name') is-invalid @enderror" id="contact_name"
            name="contact_name" placeholder="Ingrese el contacto..."
            value="{{ isset($warehouses->contact_name) ? $warehouses->contact_name : old('contact_name') }}">
        @error('contact_name')
            <span class="invalid-feedback d-block">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>


    <div class="col-6 form-group">
        <label for="contact_number">Numero</label>
        <input type="text" class="form-control @error('contact_number') is-invalid @enderror" id="contact_number"
            name="contact_number" placeholder="Ingrese el numero de contacto..."
            value="{{ isset($warehouses->contact_number) ? $warehouses->contact_number : old('contact_number') }}">
        @error('contact_number')
            <span class="invalid-feedback d-block">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="col-6 form-group">
        <label for="contact_email">Email</label>
        <input type="text" class="form-control @error('contact_email') is-invalid @enderror" id="contact_email" name="contact_email"
            placeholder="Ingrese el contact_email del contacto..." value="{{ isset($warehouses->contact_email) ? $warehouses->contact_email : old('contact_email') }}">
        @error('contact_email')
            <span class="invalid-feedback d-block">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

   <div class="col-6">
     <x-adminlte-select2 name="warehouses_type" label="Tipo de almacen" igroup-size="md"
         data-placeholder="Selecciona una opcion...">
         <option value="Marítima" {{ old('warehouses_type', $warehouses) == 'Marítima' ? 'selected' : '' }}>Marítima</option>
         <option value="Aérea" {{ old('warehouses_type', $warehouses) == 'Aérea' ? 'selected' : '' }}>Aérea</option>

         @error('warehouses_type')
             <span class="invalid-feedback d-block" role="alert">
                 <strong>{{ $message }}</strong>
             </span>
         @enderror
     </x-adminlte-select2>
 </div>




</div>

<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
</div>
