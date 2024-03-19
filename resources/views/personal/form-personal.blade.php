<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" class="form-control" id="name" name="name" 
    placeholder="Ingrese su nombre" value="{{ isset($personal->name) ? $personal->name : ''}}">
    @error('name')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="last_name">Apellido</label>
    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Ingrese su apellido" value="{{ isset($personal->last_name) ? $personal->last_name : ''}}">
    @error('last_name')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div>

    <div id="contain_select" class="form-group">
        <label for="documento_identidad">Documento de identidad</label>
        <select name="documento_identidad" id="documento_identidad" class="form-control">
            <option value="" disabled selected> -- Seleccione --</option>
            <option value="contain_dni" {{ isset($personal->dni) ? 'selected' : ''}}>DNI</option>
            <option value="contain_immigration_card" {{ isset($personal->immigration_card) ? 'selected' : ''}}>Carnet de Extranjeria</option>
            <option value="contain_passport" {{ isset($personal->passport) ? 'selected' : ''}}>Pasaporte</option>
        </select>
        @error('dni')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        @error('immigration_card')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        @error('passport')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        
    </div>
    <div id="contain_dni" class="form-group {{ isset($personal->dni ) ? '' : 'd-none'}}">
        <label for="dni">DNI</label>
        <input type="text" class="form-control" id="dni" name="dni" placeholder="Ingrese su DNI" value="{{ isset($personal->dni) ? $personal->dni : ''}}">
    </div>
    <div id="contain_immigration_card" class="form-group {{ isset($personal->immigration_card ) ? '' : 'd-none'}}">
        <label for="immigration_card">Carnet de Extranjeria</label>
        <input type="text" class="form-control" id="immigration_card" name="immigration_card"
            placeholder="Ingrese su carnet de extranjeria" value="{{ isset($personal->immigration_card) ? $personal->immigration_card : ''}}">
    </div>
    <div id="contain_passport" class="form-group {{ isset($personal->passport ) ? '' : 'd-none'}}">
        <label for="passport">Pasaporte</label>
        <input type="text" class="form-control" id="passport" name="passport"
            placeholder="Ingrese su passaporte" value="{{ isset($personal->passport) ? $personal->passport : ''}}">
    </div>

</div>

<div class="form-group">
    <label for="cellphone">Celular</label>
    <input type="text" class="form-control" id="cellphone" name="cellphone" placeholder="Ingrese su numero de celular"
    value="{{ isset($personal->cellphone) ? $personal->cellphone : ''}}">
    @error('cellphone')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="email">Crear un usuario</label>
    <div class="row">
        <div class="input-group col-12 col-md-6 mb-4 mb-md-0">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="text" class="form-control" id="email" name="email" placeholder="Ingrese su email"
            value="{{ isset($personal->email) ? $personal->email : ''}}">
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-group col-12 col-md-6">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
            </div>
            <input type="password" class="form-control" id="password" name="password"
                placeholder="Ingrese su password" value="{{ isset($personal->password) ? $personal->password : ''}}">
                @error('password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
        </div>

    </div>

</div>
<div class="form-group">
    <label for="documento_identidad">Foto</label>
    <br>
    <img id="preview_img" src="{{ isset($personal->img_url) ? asset('fotos-de-usuarios/'. $personal->img_url) : ''}}" class="{{isset($personal->img_url) ? '' : 'd-none'}}" alt="" width="100px" height="100px">

    <input type="file" id="personal_file" class="form-control" name="image" accept="image/*">
    @error('img_url')
    <div class="text-danger">{{ $message }}</div>
    @enderror

  
</div>

<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
</div>