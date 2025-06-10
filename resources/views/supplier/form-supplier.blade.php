<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label for="name_businessname">Razón social / Nombre</label>
            <input type="text"
                   class="form-control @error('name_businessname') is-invalid @enderror"
                   id="name_businessname"
                   name="name_businessname"
                   placeholder="Ingrese la razón social o nombre"
                   value="{{ old('name_businessname', $supplier->name_businessname ?? '') }}">
            @error('name_businessname')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="area_type">Tipo de proveedor</label>
            <select name="area_type"
                    id="area_type"
                    class="form-control @error('area_type') is-invalid @enderror">
                <option value="">Seleccione...</option>
                <option value="comercial" {{ old('area_type', $supplier->area_type ?? '') === 'comercial' ? 'selected' : '' }}>Comercial</option>
                <option value="transporte" {{ old('area_type', $supplier->area_type ?? '') === 'transporte' ? 'selected' : '' }}>Transporte</option>
                <option value="pricing" {{ old('area_type', $supplier->area_type ?? '') === 'agente' ? 'selected' : '' }}>Agente de Carga</option>
            </select>
            @error('area_type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="address">Dirección</label>
            <input type="text"
                   class="form-control @error('address') is-invalid @enderror"
                   id="address"
                   name="address"
                   placeholder="Ingrese la dirección"
                   value="{{ old('address', $supplier->address ?? '') }}">
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="contact_name">Nombre del contacto</label>
            <input type="text"
                   class="form-control @error('contact_name') is-invalid @enderror"
                   id="contact_name"
                   name="contact_name"
                   placeholder="Ingrese nombre de contacto"
                   value="{{ old('contact_name', $supplier->contact_name ?? '') }}">
            @error('contact_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="contact_number">Teléfono del contacto</label>
            <input type="text"
                   class="form-control @error('contact_number') is-invalid @enderror"
                   id="contact_number"
                   name="contact_number"
                   placeholder="Ingrese teléfono de contacto"
                   value="{{ old('contact_number', $supplier->contact_number ?? '') }}">
            @error('contact_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="contact_email">Correo del contacto</label>
            <input type="email"
                   class="form-control @error('contact_email') is-invalid @enderror"
                   id="contact_email"
                   name="contact_email"
                   placeholder="Ingrese correo electrónico"
                   value="{{ old('contact_email', $supplier->contact_email ?? '') }}">
            @error('contact_email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12 text-center mt-4">
        <button type="submit" class="btn btn-primary">
            {{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}
        </button>
    </div>
</div>



@push('scripts')
    <script>
        function searchsupplier(event) {

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
                    name_businessname.readOnly = true;

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
