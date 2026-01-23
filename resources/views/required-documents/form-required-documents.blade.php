<div class="form-group row">
    <label for="service_type" class="col-sm-2 col-form-label">
        Tipo de Servicio <span class="text-danger">*</span>
    </label>
    <div class="col-sm-10">
        <select name="service_type" id="service_type" class="form-control @error('service_type') is-invalid @enderror"
            required>
            <option value="">-- Seleccionar --</option>
            @foreach ($serviceTypes as $type)
                @php
                    $currentValue = old('service_type') ?? (isset($document) ? $document->service_type : '');
                @endphp
                <option value="{{ $type }}" {{ $currentValue == $type ? 'selected' : '' }}>
                    {{ ucfirst($type) }}
                </option>
            @endforeach
        </select>
        @error('service_type')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="document_name" class="col-sm-2 col-form-label">
        Nombre del Documento <span class="text-danger">*</span>
    </label>
    <div class="col-sm-10">
        <input type="text" name="document_name" id="document_name"
            class="form-control @error('document_name') is-invalid @enderror" value="{{ old('document_name') ?? (isset($document) ? $document->document_name : '') }}"
            placeholder="Ej: Factura Comercial" required>
        @error('document_name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="order" class="col-sm-2 col-form-label">
        Orden de Visualización <span class="text-danger">*</span>
    </label>
    <div class="col-sm-10">
        <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror"
            value="{{ old('order') ?? (isset($document) ? $document->order : 0) }}" min="0" required>
        <small class="form-text text-muted">Número para ordenar la visualización en la tabla</small>
        @error('order')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label">Opciones</label>
    <div class="col-sm-10">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" name="is_required" id="is_required" class="custom-control-input" value="1"
                {{ old('is_required') ?? (isset($document) && $document->is_required ? 'checked' : '') }}>
            <label class="custom-control-label" for="is_required">
                Es documento requerido
            </label>
        </div>
        <div class="custom-control custom-checkbox mt-2">
            <input type="checkbox" name="is_auto_generated" id="is_auto_generated" class="custom-control-input"
                value="1" {{ old('is_auto_generated') ?? (isset($document) && $document->is_auto_generated ? 'checked' : '') }}>
            <label class="custom-control-label" for="is_auto_generated">
                Se genera automáticamente (ej: Routing Order)
            </label>
        </div>
    </div>
</div>

<div class="form-group row">
    <label for="description" class="col-sm-2 col-form-label">
        Descripción
    </label>
    <div class="col-sm-10">
        <textarea name="description" id="description" rows="3"
            class="form-control @error('description') is-invalid @enderror" placeholder="Notas o descripción del documento">{{ old('description') ?? (isset($document) ? $document->description : '') }}</textarea>
        @error('description')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="{{ isset($formMode) && $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
    <a href="{{ route('required-documents.index') }}" class="btn btn-secondary">
        <i class="fas fa-times"></i> Cancelar
    </a>
</div>
