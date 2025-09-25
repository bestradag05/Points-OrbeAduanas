<div class="row">
    {{-- Campos obligatorios comunes para todos --}}
    <div class="col-6">
        <div class="form-group">
            <label for="name_businessname">Razón social / Nombre</label>
            <input type="text" class="form-control @error('name_businessname') is-invalid @enderror"
                id="name_businessname" name="name_businessname" placeholder="Ingrese la razón social o nombre"
                value="{{ old('name_businessname', $supplier->name_businessname ?? '') }}">
            @error('name_businessname')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="area_type">Tipo de proveedor</label>
            <select name="area_type" id="area_type" class="form-control @error('area_type') is-invalid @enderror">
                <option value="">Seleccione...</option>
                <option value="comercial"
                    {{ old('area_type', $supplier->area_type ?? '') === 'comercial' ? 'selected' : '' }}>Comercial
                </option>
                <option value="transporte"
                    {{ old('area_type', $supplier->area_type ?? '') === 'transporte' ? 'selected' : '' }}>Transporte
                </option>
                <option value="pricing"
                    {{ old('area_type', $supplier->area_type ?? '') === 'agente' ? 'selected' : '' }}>Agente de Carga
                </option>
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
            <input type="text" name="city" class="form-control"
                value="{{ old('city', $supplier->city ?? '') }}">
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
        document.addEventListener('DOMContentLoaded', () => {
            const userRole = @json(Auth::user()->roles->pluck('name')->first());

            const fieldsByArea = {
                'Transporte': ['group-cargo-type', 'group-unit', 'group-document', 'group-document-type'],
                'Asesor Comercial': ['group-document', 'group-document-type'],
                'Pricing': ['group-country', 'group-city'],
            };

            // Ocultar todos
            const allFields = [
                'group-cargo-type', 'group-unit',
                'group-document', 'group-document-type',
                'group-country', 'group-city'
            ];
            allFields.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.classList.add('d-none');
            });

            // Mostrar solo los campos de su área
            const areaFields = fieldsByArea[userRole] || [];
            areaFields.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.classList.remove('d-none');
            });
        });
    </script>
@endpush
