@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Aduanas</h2>
    </div>

@stop
@section('dinamic-content')


    <x-adminlte-datatable id="table1" :heads="$heads" hoverable>
        @foreach ($customs as $custom)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <a href="{{ url('/routing/' . $custom->routing->id . '/detail') }}">
                        {{ $custom->nro_operation }}
                    </a>
                </td>
                <td>{{ $custom->routing->personal->names }}</td>
                <td>{{ $custom->modality->name }}</td>
                <td class="{{ $custom->state == 'Pendiente' ? 'text-warning' : 'text-success' }}">{{ $custom->state }}</td>

                @can('liquidacion.generate')
                    <td>
                        <a href="{{ url('/custom/' . $custom->id . '/edit') }}" class="btn btn-outline-success btn-sm">
                            {{ $custom->state == 'Pendiente' ? 'Generar punto' : 'Modificar' }}
                        </a>

                    </td>
                @else
                    <td></td>
                @endcan
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
