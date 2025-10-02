<div class="form-group">
    <label for="name">Nombre del concepto</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
        placeholder="Ingrese el name" value="{{ isset($concept->name) ? $concept->name : '' }}">

    @error('name')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label>¿Este concepto se utiliza en todos los servicios?</label>
    <div class="form-check">
        <input type="radio" id="allServices" name="allServiceCheck" value="1" class="form-check-input"
            onchange="toggleAllServices()">
        <label for="allServices" class="form-check-label">Sí</label>
    </div>
    <div class="form-check form-check-inline">
        <input type="radio" id="dontAllServices" name="allServiceCheck" value="0" class="form-check-input"
            onchange="toggleAllServices()" checked>
        <label for="dontAllServices" class="form-check-label">No</label>
    </div>
</div>


<x-adminlte-select2 name="id_type_shipment" label="Tipo de embarque" igroup-size="md"
    data-placeholder="Selecciona una opcion...">
    <option />
    @foreach ($type_shipments as $type_shipment)
        <option value="{{ $type_shipment->id }}"
            {{ (isset($concept->id_type_shipment) && $concept->id_type_shipment == $type_shipment->id) || old('id_type_shipment') == $type_shipment->id ? 'selected' : '' }}>
            {{ $type_shipment->name }}
        </option>
    @endforeach

    @error('load_value')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

</x-adminlte-select2>


<x-adminlte-select2 name="id_type_service" label="Tipo de servicio" igroup-size="md"
    data-placeholder="Selecciona una opcion...">
    <option />
    @foreach ($type_services as $type_service)
        <option value="{{ $type_service->id }}"
            {{ (isset($concept->id_type_service) && $concept->id_type_service == $type_service->id) || old('id_type_service') == $type_service->id ? 'selected' : '' }}>
            {{ $type_service->name }}
        </option>
    @endforeach


    @error('id_type_service')
        <div class="text-danger">{{ $message }}</div>
    @enderror

</x-adminlte-select2>



<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
</div>


@push('scripts')
    <script>
        function toggleAllServices() {
            const allServicesChecked = document.getElementById('allServices').checked;
            const idTypeShipment = document.getElementById('id_type_shipment');
            const idTypeService = document.getElementById('id_type_service');

            // Si "Sí" está seleccionado, deshabilitar los campos
            if (allServicesChecked) {
                idTypeShipment.disabled = true;
                idTypeService.disabled = true;
            } else {
                idTypeShipment.disabled = false;
                idTypeService.disabled = false;
            }
        }

        // Llamar a la función para que se ejecute al cargar la página, según el estado inicial
        window.onload = toggleAllServices;
    </script>
@endpush
