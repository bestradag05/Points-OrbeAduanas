<div class="row">
    {{-- Campos obligatorios comunes para todos --}}
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
            <input type="text" class="form-control" name="address" id="address"
                value="{{ old('address', $supplier->address ?? '') }}">
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="contact_name">Nombre de Contacto</label>
            <input type="text" class="form-control" name="contact_name" id="contact_name"
                value="{{ old('contact_name', $supplier->contact_name ?? '') }}">
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="contact_number">Teléfono</label>
            <input type="text" class="form-control" name="contact_number" id="contact_number"
                value="{{ old('contact_number', $supplier->contact_number ?? '') }}">
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="contact_email">Correo</label>
            <input type="email" class="form-control" name="contact_email" id="contact_email"
                value="{{ old('contact_email', $supplier->contact_email ?? '') }}">
        </div>
    </div>

    {{-- Tipo de proveedor solo para PRICING --}}
    @php
        $userArea = Auth::user()->area ?? 'pricing'; // reemplaza por la forma real de obtener el área
    @endphp


    @if (in_array($userArea, ['pricing']))
        <div class="col-6">
            <div class="form-group">
                <label for="provider_type">Tipo de proveedor</label>
                <select name="provider_type" id="provider_type" class="form-control">
                    <option value="">Seleccione...</option>
                    @if ($userArea === 'pricing')
                        <option value="NAVIERA"
                            {{ old('provider_type', $supplier->provider_type ?? '') === 'NAVIERA' ? 'selected' : '' }}>
                            Naviera</option>
                        <option value="AEROLINEA"
                            {{ old('provider_type', $supplier->provider_type ?? '') === 'AEROLINEA' ? 'selected' : '' }}>
                            Aerolínea</option>
                        <option value="AGENTE DE CARGA"
                            {{ old('provider_type', $supplier->provider_type ?? '') === 'AGENTE DE CARGA' ? 'selected' : '' }}>
                            Agente de Carga</option>
                    @elseif ($userArea === 'agente')
                        <option value="AGENTE DE CARGA" selected>Agente de Carga</option>
                    @endif
                </select>
            </div>
        </div>
    @endif

    {{-- Campos condicionales (van debajo) --}}
    <div class="col-6 d-none" id="group-document">
        <div class="form-group">
            <label for="document_number">Número de Documento</label>
            <input type="text" name="document_number" class="form-control"
                value="{{ old('document_number', $supplier->document_number ?? '') }}">
        </div>
    </div>

    <div class="col-6 d-none" id="group-document-type">
        <div class="form-group">
            <label for="document_type">Tipo de Documento</label>
            <input type="text" name="document_type" class="form-control"
                value="{{ old('document_type', $supplier->document_type ?? '') }}">
        </div>
    </div>

    <div class="col-6 d-none" id="group-cargo-type">
        <div class="form-group">
            <label for="cargo_type">Tipo de Carga</label>
            <input type="text" name="cargo_type" class="form-control"
                value="{{ old('cargo_type', $supplier->cargo_type ?? '') }}">
        </div>
    </div>

    <div class="col-6 d-none" id="group-unit">
        <div class="form-group">
            <label for="unit">Unidad</label>
            <input type="text" name="unit" class="form-control" value="{{ old('unit', $supplier->unit ?? '') }}">
        </div>
    </div>

    <div class="col-6 d-none" id="group-country">
        <div class="form-group">
            <label for="country">País</label>
            <input type="text" name="country" class="form-control"
                value="{{ old('country', $supplier->country ?? '') }}">
        </div>
    </div>

    <div class="col-6 d-none" id="group-city">
        <div class="form-group">
            <label for="city">Ciudad</label>
            <input type="text" name="city" class="form-control" value="{{ old('city', $supplier->city ?? '') }}">
        </div>
    </div>

    {{-- Botón de Guardar --}}
    <div class="col-12 text-center mt-4">
        <button type="submit" class="btn btn-primary">
            {{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}
        </button>
    </div>
</div>


@push('scripts')
    <script>
        function toggleFields() {
            const type = document.getElementById('provider_type').value;

            const fields = {
                'group-document': false,
                'group-document-type': false,
                'group-cargo-type': false,
                'group-unit': false,
                'group-country': false,
                'group-city': false
            };

            if (type === 'TRANSPORTISTA' || type === 'COMERCIAL') {
                fields['group-document'] = true;
                fields['group-document-type'] = true;
            }
            if (type === 'TRANSPORTISTA') {
                fields['group-cargo-type'] = true;
                fields['group-unit'] = true;
            }
            if (type === 'AGENTE DE CARGA') {
                fields['group-country'] = true;
                fields['group-city'] = true;
            }

            for (const id in fields) {
                const el = document.getElementById(id);
                if (el) {
                    el.classList.toggle('d-none', !fields[id]);
                }
            }
        }

        document.addEventListener('DOMContentLoaded', toggleFields);
        document.getElementById('provider_type').addEventListener('change', toggleFields);
    </script>
@endpush
