@extends('home')

@section('content_header')
<div class="d-flex justify-content-between">
    <h2>Tipos de Contenedores</h2>
    <div>
        <a href="{{ route('type_containers.create') }}" class="btn btn-primary">Agregar</a>
    </div>
</div>
@stop

@section('dinamic-content')
<x-adminlte-datatable id="table1" :heads="$heads">
    @foreach ($typeContainers as $type)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $type->name }}</td>
        <td>{{ $type->description }}</td>
        <td>{{ $type->state }}</td>
        <td>

            <a href="{{ route('type_containers.edit', $type->id) }}"><i class="fas fa-edit"></i></a>

            <form action="{{ route('type_containers.destroy', $type->id) }}" method="POST" style="display: inline;" class="form-delete">
                @csrf
                @method('DELETE')
                <button type="submit" style="border:none;background:none;"><i class="fas fa-trash text-primary"></i></button>
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