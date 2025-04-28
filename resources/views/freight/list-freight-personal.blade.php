@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Fletes</h2>
    </div>

@stop
@section('dinamic-content')


    <x-adminlte-datatable id="table1" :heads="$heads" hoverable>
        @foreach ($freights as $freight)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $freight->commercial_quote->customer->name_businessname }}</td>
                <td>{{ $freight->commercial_quote->origin }}</td>
                <td>{{ $freight->commercial_quote->destination }}</td>
                <td>{{ $freight->value_utility }}</td>
                <td>{{ $freight->value_freight }}</td>
                <td class="text-indigo text-bold">{{ ($freight->insurance) ? 'SI' : 'NO' }}</td>
                <td>
                    <a href="{{ url('/commercial/quote/' . $freight->commercial_quote->id . '/detail') }}">
                        {{ $freight->nro_quote_commercial }}
                    </a>
                </td>

                <td>{{ $freight->commercial_quote->personal->names }}</td>
                <td class="{{ $freight->state == 'Pendiente' ? 'text-warning' : 'text-success' }}">{{ $freight->state }}
                </td>

                <td>
                    <a href="{{ url('/freight/' . $freight->id) }}" class="btn btn-indigo btn-sm">Detalle</a>
                </td>
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
