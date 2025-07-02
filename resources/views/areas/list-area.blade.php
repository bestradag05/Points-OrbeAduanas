@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Áreas</h2>
        <div>
            <a href="{{ url('areas/create') }}" class="btn btn-primary">Agregar</a>
        </div>
    </div>
@stop

@section('dinamic-content')
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach ($areas as $area)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $area->name }}</td>
                <td>{{ $area->state }}</td>
                <td>
                    @can('areas.update')
                        <a href="{{ url('/areas/' . $area->id . '/edit') }}"> <i class="fas fa-edit"></i> </a>
                    @endcan
                    @can('areas.delete')
                        <form action="{{ url('/areas/' . $area->id) }}" class="form-delete" method="POST" style="display: inline;"
                            data-confirm-delete="true">
                            {{ method_field('DELETE') }}
                            @csrf
                            <button type="submit"
                                style="border: none; background: none; padding: 0; margin: 0; cursor: pointer;">
                                <i class="fas fa-trash text-primary"></i>
                            </button>
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
            Swal.fire({
                title: "Eliminado!",
                text: "Tu registro fue eliminado.",
                icon: "success"
            });




            $('.form-delete').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "Si eliminas no podrás revertirlo",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, eliminar!",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        </script>
@endpush
