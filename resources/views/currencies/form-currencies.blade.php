<div class="form-group">
    <label for="badge">Divisa</label>
    <input type="text" class="form-control" id="badge" name="badge"
        placeholder="Ingrese el nombre de la divisa" value="{{ isset($currency->badge) ? $currency->badge : '' }}">
    @error('badge')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="abbreviation">Abreviatura</label>
    <input type="text" class="form-control" id="abbreviation" name="abbreviation" placeholder="Ingrese la abreviatura"
        value="{{ isset($currency->abbreviation) ? $currency->abbreviation : '' }}">
    @error('code')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="symbol">Simbolo</label>
    <input type="text" class="form-control" id="symbol" name="symbol" placeholder="Ingrese el simbolo"
        value="{{ isset($currency->symbol) ? $currency->symbol : '' }}">
    @error('symbol')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>


<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
</div>
