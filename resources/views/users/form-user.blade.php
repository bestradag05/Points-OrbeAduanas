<div class="row">

    <div class="col-4">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="text" class="form-control" id="email" name="email" placeholder="Ingrese su email"
                value="{{ isset($user->email) ? $user->email : old('email') }}">

        </div>

        @error('email')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-4">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
            </div>
            <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su password"
                value="{{ isset($user->password) ? $user->password : old('password') }}">
        </div>

        @error('password')
            <div class="text-danger">{{ $message }}</div>
        @enderror

    </div>
    <div class="col-4">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
            </div>
            <input type="password" class="form-control" id="password_confirm" name="password_confirm"
                placeholder="confirme el password"
                value="{{ isset($user->password_confirm) ? $user->password_confirm : old('password_confirm') }}">

        </div>
        @error('password_confirm')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

</div>


<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
</div>
