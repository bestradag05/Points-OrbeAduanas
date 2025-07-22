@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Proveedores</h2>
        @can('supplier.create')
        <a href="{{ url('suppliers/create') }}" class="btn btn-primary">Agregar</a>
        @endcan
    </div>
@stop

@section('dinamic-content')
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach ($suppliers as $supplier)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $supplier->name_businessname }}</td>
                <td>{{ $supplier->contact_name }}</td>
                <td>{{ $supplier->contact_number }}</td>
                <td>{{ $supplier->contact_email }}</td>
                <td>{{ $supplier->provider_type }}</td>
                <td>{{ $supplier->document_type }} </td>
                <td>{{ $supplier->document_number }}</td>
                <td>{{ $supplier->address }}</td>
                <td>{{ $supplier->country }}</td>
                <td>{{ $supplier->city }}</td>
                <td>{{ $supplier->state }}</td>
                <td>
                    @can('supplier.update')
                        <a href="{{ url('suppliers/'.$supplier->id.'/edit') }}">
                            <i class="fas fa-edit"></i>
                        </a>
                    @endcan
                    @can('supplier.delete')
                        <form action="{{ url('suppliers/'.$supplier->id) }}"
                              class="form-delete"
                              method="POST"
                              style="display: inline;"  
                              data-confirm-delete="true">
                            {{ method_field('DELETE') }}
                            @csrf
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; cursor: pointer;"> <i class="fas fa-trash text-primary"></i></button>
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
                title: "Eliminado",
                text: "El registro fue desactivado.",
                icon: "success"
            });
        </script>
    @endif

    <script>
    $('.form-delete').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: "¿Estás seguro?",
            text: "Esta acción es irreversible.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        }).then(result => {
            if (result.isConfirmed) this.submit();
        });
    });
    </script>
@endpush

