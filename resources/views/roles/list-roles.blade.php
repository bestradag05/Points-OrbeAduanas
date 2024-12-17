@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Roles</h2>
        <div>
            <a href="{{ 'roles/create' }}" class="btn btn-primary"> Agregar </a>
        </div>

    </div>

@stop
@section('dinamic-content')

    <x-adminlte-datatable id="tableRoles" :heads="$heads">
        @foreach ($roles as $rol)
            <tr>
                <td>{{ $rol->id }}</td>
                <td>
                    @if ($rol->name === 'Super-Admin')
                        <p>
                            {{ $rol->name }}
                            <i class="fas fa-star text-warning"></i>
                        </p>
                    @else
                        <a href="{{ url('roles/grupos/' . $rol->id) }}">
                            {{ $rol->name }}
                        </a>
                    @endif

                </td>
                <td>{{ $usersCountByRoles[$rol->name] }}</td>

                @if ($rol->name !== 'Super-Admin')
                    <td>
                        <a href="{{ url('/roles/' . $rol->id . '/edit') }}"> <i class="fa-solid fa-pen-to-square"></i> </a>
                        <form action="{{ url('/roles/' . $rol->id) }}" class="form-delete" method="POST"
                            style="display: inline;" data-confirm-delete="true">
                            {{ method_field('DELETE') }}
                            @csrf
                            <button type="submit"
                                style="border: none; background: none; padding: 0; margin: 0; cursor: pointer;"> <i class="fas fa-trash text-primary"></i> </button>
                        </form>

                    </td>
                @else
                <td></td>
                @endif


            </tr>
        @endforeach
    </x-adminlte-datatable>
@stop


@push('scripts')


    @if (session('eliminar') == 'ok')
        <script>
            Swal.fire({
                title: "Eliminado!",
                text: "tu registro fue eliminado.",
                icon: "success"
            });
        </script>
    @endif
    <script>
        $('.form-delete').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: "¿Estas seguro?",
                text: "Si eliminas no podras revertirlo",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, Eliminar!",
                cancelButtonText: "Descartar"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });

        });
    </script>
@endpush
