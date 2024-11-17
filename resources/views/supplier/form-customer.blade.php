<div class="row">

    <div class="col-6">
        <label for="name_businessname">RUC</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" class="form-control" id="ruc" name="ruc" placeholder="Ingrese su ruc"
                onchange="searchCustomer(this)" value="{{ isset($customer->ruc) ? $customer->ruc : old('ruc') }}">

        </div>

        @error('ruc')
            <div class="text-danger">{{ $message }}</div>
        @enderror

    </div>

    <div class="col-6">

        <div class="form-group">
            <label for="name_businessname">Razon Social / Nombre</label>
            <input type="text" class="form-control" id="name_businessname" name="name_businessname"
                placeholder="Ingrese su razon social o nombre"
                value="{{ isset($customer->name_businessname) ? $customer->name_businessname : old('name_businessname') }}">
            @error('name_businessname')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

    </div>


    <div class="col-6">
        <div class="form-group">
            <label for="contact_name">Nombre del contacto</label>
            <input type="text" class="form-control" id="contact_name" name="contact_name"
                placeholder="Ingrese su numero de celular"
                value="{{ isset($customer->contact_name) ? $customer->contact_name : old('contact_name') }}">
            @error('contact_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>


    <div class="col-6">
        <div class="form-group">
            <label for="contact_number">Numero del contacto</label>
            <input type="text" class="form-control" id="contact_number" name="contact_number"
                placeholder="Ingrese su numero de celular"
                value="{{ isset($customer->contact_number) ? $customer->contact_number : old('contact_number') }}">
            @error('contact_number')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>


    <div class="col-6">

        <div class="form-group">
            <label for="contact_email">Correo del contacto</label>
            <input type="text" class="form-control" id="contact_email" name="contact_email"
                placeholder="Ingrese su numero de celular"
                value="{{ isset($customer->contact_email) ? $customer->contact_email : old('contact_email') }}">
            @error('contact_email')
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

            fetch(`/obtener-datos-ruc/${event.value}`)
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
