<!--Card Contend de usuarios -->

<form action="{{ url('/roles/grupos/' . $rol) }}" method="POST" class="row justify-content-around">
    @csrf
    <div class="col-6">
        <x-adminlte-select2 name="user" igroup-size="md" data-placeholder="Select un usuario...">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fa-solid fa-users mr-2"></i>
                </div>
            </x-slot>
            <option />
            @foreach ($personals as $personal)
                @if(!$personal->user->hasRole($rol->name))
                    <option value="{{ $personal->user->id }}">{{ $personal->name . ' ' . $personal->last_name }}</option>
                @endif
            @endforeach
        </x-adminlte-select2>
    </div>
    <div class="col-2 d-flex align-items-center">
        <button type="submit" class="btn btn-block btn-indigo btn-md">Agregar</button>
    </div>
</form>

<div class="card ">
    <div class="card-header d-flex align-items-center">
        <p class="mb-0 pb-0  ">Listado de usuarios de este grupo</p>
    </div>
    <div class="card-body">
        <x-adminlte-datatable id="UserHasRole" :heads="$headsRolUser">
            @foreach ($userHasRoles as $userHasRole)
                <tr>
                    <td> {{ $loop->iteration }}</td>
                    <td> {{ $userHasRole->personal->name . ' ' . $userHasRole->personal->last_name }}
                    </td>
                    <td><img src="{{ asset('fotos-de-usuarios/' . $userHasRole->personal->img_url) }}"
                            class="img-circle elevation-2" width="50px" height="50px" alt="User Image"></td>
                    <td>
                        <form action="{{ url('/roles/grupos/' . $rol->id) }}" class="form-delete" method="POST"
                            style="display: inline;" data-confirm-delete="true">
                            {{ method_field('DELETE') }}
                            @csrf
                            <input type="hidden" value="{{ $userHasRole->id }}" name="id_user">
                            <button type="submit"
                                style="border: none; background: none; padding: 0; margin: 0; cursor: pointer;">
                                <i class="fa-regular fa-circle-minus"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </div>
</div>
<!-- Fin card content de usuarios -->
