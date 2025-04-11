@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Contenedores</h2>
        <div>
            <a href="{{ route('containers.create') }}" class="btn btn-primary">Agregar</a>
        </div>
    </div>
@stop

@section('dinamic-content')
    <x-adminlte-datatable id="table1" :heads="$heads">
    @foreach ($containers as $container)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $container->name }}</td>
                <td>{{ $container->typeContainer->name }}</td>
                <td>{{ $container->description }}</td>
                <td>{{ $container->length }} m</td>
                <td>{{ $container->width }} m</td>
                <td>{{ $container->height }} m</td>
                <td>{{ $container->volume }} m³</td>
                <td>{{ $container->max_load }} kg</td>
                <td>{{ $container->state }} </td>
                <td>
                    @can('container.update')
                        <a href="{{ route('containers.edit', $container->id) }}"><i class="fas fa-edit"></i></a>
                    @endcan
                    @can('container.delete')
                        <form action="{{ route('containers.destroy', $container->id) }}" method="POST" class="form-delete" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border:none;background:none;"><i class="fas fa-trash text-primary"></i></button>
                        </form>
                    @endcan
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