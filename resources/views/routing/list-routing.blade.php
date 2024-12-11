@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Routing Order</h2>
        <div>
            <a href="{{ 'routing/create' }}" class="btn btn-primary"> Agregar </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach ($routings as $routing)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <a href="{{ url('/routing/'. $routing->id . '/detail') }}">
                        {{ $routing->nro_operation }}
                    </a>
                </td>
                <td class="text-uppercase">{{ $routing->origin }}</td>
                <td class="text-uppercase">{{ $routing->destination }}</td>
                <td>{{ $routing->type_shipment->description }}</td>
                <td>{{ $routing->personal->names }}</td>
                <td class="{{ $routing->state == 'Activo' ? 'text-success' : 'text-danger' }}">{{ $routing->state }}</td>
        
                <td>
                     <a href="{{ url('/routing/'. $routing->id . '/edit') }}"> <i class="fas fa-edit"></i></a>
                     <form action="{{ url('/routing/'.$routing->id) }}" class="form-delete" method="POST" style="display: inline;" data-confirm-delete="true">
                        {{ method_field('DELETE') }}
                        @csrf
                        <button  type="submit" style="border: none; background: none; padding: 0; margin: 0; cursor: pointer;"> <i class="fas fa-trash text-primary"></i> </button>
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
