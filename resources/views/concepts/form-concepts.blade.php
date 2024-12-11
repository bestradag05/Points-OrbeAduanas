<div class="form-group">
    <label for="name">Nombre del concepto</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Ingrese el name"
        value="{{ isset($concept->name) ? $concept->name : '' }}">

    @error('name')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<x-adminlte-select2 name="id_type_shipment" label="Tipo de embarque" igroup-size="md"
    data-placeholder="Selecciona una opcion...">
    <option />
    @foreach ($type_shipments as $type_shipment)
        <option value="{{ $type_shipment->id }}" {{ (isset($concept->id_type_shipment) && $concept->id_type_shipment == $type_shipment->id) || old('id_type_shipment') == $type_shipment->id ? 'selected' : '' }}>
            {{ '( ' . $type_shipment->code . ' ) - ' . $type_shipment->name  }}
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
        <option value="{{ $type_service->id }}" {{ (isset($concept->id_type_service) && $concept->id_type_service == $type_service->id) || old('id_type_service') == $type_service->id ? 'selected' : '' }}>
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
