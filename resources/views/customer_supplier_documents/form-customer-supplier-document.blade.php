<div class="row">

    <div class="col-6">

        <div class="form-group">
            <label for="name">Nombre de documento</label>
            <input type="text" class="form-control" id="name" name="name"
                placeholder="Ingrese el nombre del documento "
                value="{{ isset($customer_supplier_document->name) ? $customer_supplier_document->name : old('name') }}">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

    </div>



    <div class="col-6">

        <div class="form-group">
            <label for="number_digits">Numero de digitos</label>
            <input type="text" class="form-control" id="number_digits" name="number_digits"
                placeholder="Ingrese el numero de digitos"
                value="{{ isset($customer_supplier_document->number_digits) ? $customer_supplier_document->number_digits : old('number_digits') }}">
            @error('number_digits')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

    </div>


    <div class="container text-center mt-5">
        <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
    </div>



</div>

