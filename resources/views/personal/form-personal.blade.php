<div class="row">
    {{-- 
    <div class="col-12">

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

    </div> --}}


    <div class="col-6">
        <div class="form-group">
            <label for="names">Nombre</label>
            <input type="text" class="form-control" id="names" name="names" placeholder="Ingrese su nombre"
                value="{{ isset($personal->names) ? $personal->names : old('names') }}">
            @error('names')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="last_name">Apellido Paterno</label>
            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Ingrese su apellido"
                value="{{ isset($personal->last_name) ? $personal->last_name : old('last_name') }}">
            @error('last_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="mother_last_name">Apellido Materno</label>
            <input type="text" class="form-control" id="mother_last_name" name="mother_last_name"
                placeholder="Ingrese su apellido"
                value="{{ isset($personal->mother_last_name) ? $personal->mother_last_name : old('mother_last_name') }}">
            @error('mother_last_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-6">

        <div id="contain_select" class="form-group">
            <label for="id_document">Documento de identidad</label>
            <select name="id_document" id="id_document" class="form-control">
                <option value="" disabled selected> -- Seleccione --</option>
                @foreach ($documents as $document)
                    <option value="{{ $document->id }}" 
                        {{ (isset($personal->id_document) && $personal->id_document == $document->id) || old('id_document') == $document->id ? 'selected' : '' }}
                        >
                        {{ $document->name }}
                    </option>
                @endforeach
            </select>
        </div>


    </div>

    <div class="col-6">

        <div class="form-group">
            <label for="document_number">N° de documento</label>
            <input type="text" class="form-control" id="document_number" name="document_number"
                placeholder="Ingrese su apellido"
                value="{{ isset($personal->document_number) ? $personal->document_number : old('document_number') }}">
            @error('document_number')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

    </div>


    <div class="col-6">
        @php
            $config = ['format' => 'L'];
        @endphp
        <x-adminlte-input-date name="birthdate" label="Fecha de nacimiento" :config="$config"
            value="{{ isset($personal->birthdate) ? $personal->birthdate : old('birthdate') }}"
            placeholder="Ingresa la fecha...">
            <x-slot name="appendSlot">
                <div class="input-group-append">
                    <div class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                </div>
            </x-slot>
        </x-adminlte-input-date>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="civil_status">Estado Civil</label>
            <input type="text" class="form-control" id="civil_status" name="civil_status"
                placeholder="Ingrese su apellido"
                value="{{ isset($personal->civil_status) ? $personal->civil_status : old('civil_status') }}">
            @error('civil_status')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="sexo">Sexo</label>
            <input type="text" class="form-control" id="sexo" name="sexo" placeholder="Ingrese su apellido"
                value="{{ isset($personal->sexo) ? $personal->sexo : old('sexo') }}">
            @error('sexo')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="email">Correo</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Ingrese su apellido"
                value="{{ isset($personal->email) ? $personal->email : old('email') }}">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="address">Direccion</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Ingrese su apellido"
                value="{{ isset($personal->address) ? $personal->address : old('address') }}">
            @error('address')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="cellphone">Celular</label>
            <input type="text" class="form-control" id="cellphone" name="cellphone"
                placeholder="Ingrese su numero de celular"
                value="{{ isset($personal->cellphone) ? $personal->cellphone : old('cellphone') }}">
            @error('cellphone')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-6">

        <div class="form-group">
            <label for="documento_identidad">Foto</label>
            <br>
            <img id="preview_img" src="{{ isset($personal->img_url) ? asset('storage/' . $personal->img_url) : '' }}"
                class="{{ isset($personal->img_url) ? '' : 'd-none' }}" alt="" width="100px"
                height="100px">

            <input type="file" id="personal_file" class="form-control" name="imagen" accept="image/*">
            @error('img_url')
                <div class="text-danger">{{ $message }}</div>
            @enderror


        </div>

    </div>


    <div class="col-12">
        <hr>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label for="email">Crear un usuario</label>
            <div class="row">
                <div class="col-4">

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" id="user" name="user"
                            placeholder="Ingrese su user"
                            value="{{ isset($personal->user->email) ? $personal->user->email : old('user') }}">

                    </div>
                    @error('user')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                </div>
                <div class="col-4">

                    <div class="input-group ">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Ingrese su password"
                            value="{{ isset($personal->password) ? $personal->password : old('password') }}">

                    </div>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                </div>
                <div class="col-4">
                    <div class="input-group ">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            placeholder="confirme su password"
                            value="{{ isset($personal->password_confirmation) ? $personal->password_confirmation : old('password_confirmation') }}">

                    </div>
                    @error('password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>



            </div>

        </div>
    </div>


</div>
<div class="container text-center mt-5">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
</div>
