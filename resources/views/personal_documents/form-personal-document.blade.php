<div class="row">

    <div class="col-6">

        <div class="form-group">
            <label for="name">Nombre de documento</label>
            <input type="text" class="form-control" id="name" name="name"
                placeholder="Ingrese el nombre del documento "
                value="{{ isset($personal_document->name) ? $personal_document->name : old('name') }}">
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
                value="{{ isset($personal_document->number_digits) ? $personal_document->number_digits : old('number_digits') }}">
            @error('number_digits')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

    </div>


    <div class="container text-center mt-5">
        <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
    </div>



</div>


@push('scripts')
    <script>
        function searchCustomer(event) {

            const name_businessname = document.getElementById('name_businessname');

            fetch(`/api/consult-ruc/${event.value}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta de la red');
                    }
                    return response.json();
                })
                .then(data => {
                    // Manejar los datos de la respuesta

                    name_businessname.value = data.lista[0].apenomdenunciado;
                    name_businessname.readOnly  = true;
                   
                })
                .catch(error => {
                    // Manejar cualquier error
                    console.error('Hubo un problema con la solicitud fetch:', error);
            
                    name_businessname.value = '';
                    name_businessname.readOnly = false;
                });


        }
    </script>
@endpush
