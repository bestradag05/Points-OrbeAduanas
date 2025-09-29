@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Almacenes</h2>
        <div>

            <a href="{{ 'warehouses/create' }}" class="btn btn-primary">Agregar</a>

        </div>
    </div>
@stop

@section('dinamic-content')
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach ($warehouses as $warehouse)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $warehouse->ruc }}</td>
                <td>{{ $warehouse->name_businessname }}</td>
                <td>{{ $warehouse->contact_name }}</td>
                <td>{{ $warehouse->contact_number }}</td>
                <td>{{ $warehouse->contact_email }}</td>
                <td>{{ $warehouse->warehouses_type }}</td>
                <td>
                    <div class="custom-badge status-{{ strtolower($warehouse->status) }}">
                        {{ $warehouse->status }}
                    </div>
                </td>

                <td>
                    @can('warehouse.update')
                        <a href="{{ url('warehouses/' . $warehouse->id . '/edit') }}"> <i class="fas fa-edit"></i> </a>
                    @endcan
                    @can('warehouse.delete')
                        <form action="{{ url('/warehouses/' . $warehouse->id) }}" class="form-delete" method="POST"
                            style="display: inline;" data-confirm-delete="true">
                            {{ method_field('DELETE') }}
                            @csrf
                            <button type="submit"
                                style="border: none; background: none; padding: 0; margin: 0; cursor: pointer;"> <i
                                    class="fas fa-trash text-primary"></i> </button>
                        </form>
                    @endcan
                </td>
            </tr>
        @endforeach
    </x-adminlte-datatable>
@stop

@push('scripts')
    @if (session('eliminar') == 'ok')
        <script>
            Swal.fire('Eliminado!', 'El registro fue eliminado.', 'success');
        </script>
    @endif

    <script>
        $('.form-delete').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    </script>
@endpush
