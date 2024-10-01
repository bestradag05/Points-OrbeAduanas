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
                <td><a href="{{url('roles/grupos/'.$rol->id)}}">{{ $rol->name }}</a></td>
                <td>{{ $usersCountByRoles[$rol->name] }}</td>
                <td>
                    <a href="{{ url('/roles/'. $rol->id . '/edit') }}"> <i class="fa-solid fa-pen-to-square"></i> </a>
                    <form action="{{ url('/roles/'.$rol->id) }}" class="form-delete" method="POST" style="display: inline;" data-confirm-delete="true">
                        {{ method_field('DELETE') }}
                        @csrf
                        <button  type="submit" style="border: none; background: none; padding: 0; margin: 0; cursor: pointer;"> <i class="fa-solid fa-trash text-primary"></i> </button>
                    </form>
                    
               </td>
            </tr>
        @endforeach
    </x-adminlte-datatable>
@stop


@push('scripts')


@if(session('eliminar') == 'ok')
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

