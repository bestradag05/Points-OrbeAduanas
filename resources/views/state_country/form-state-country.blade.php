<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror " id="name" name="name"
        placeholder="Ingrese el nombre de la ciudad" value="{{ isset($stateCountry->name) ? $stateCountry->name : old('name') }}">
    @error('name')
    <span class="invalid-feedback d-block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror

</div>
<div class="form-group">
    <label for="id_country">Pais</label>

    <x-adminlte-select2 name="id_country" igroup-size="md"
        data-placeholder="Seleccione una opcion...">
        <option />
        @foreach($countrys as $country)
        <option value="{{ $country->id }}" 
        {{ (isset($stateCountry->id_country) && $stateCountry->id_country == $country->id) || old('id_country') == $country->id ? 'selected' : '' }}
        > {{ $country->name }} </option>
        @endforeach

    </x-adminlte-select2>
</div>







<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
</div>