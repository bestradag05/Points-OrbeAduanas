@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Equipos</h2>
        <div>
            <a href="{{ url('teams/create') }}" class="btn btn-primary">Agregar</a>
        </div>
    </div>
@stop

@section('dinamic-content')
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach ($teams as $team)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $team->name }}</td>
                <td>{{ $team->state }}</td>
                <td>
                    @can('teams.update')
                        <a href="{{ url('/teams/' . $team->id . '/edit') }}">
                            <i class="fas fa-edit"></i>
                        </a>
                    @endcan
                    @can('teams.delete')
                        <form action="{{ url('/teams/' . $team->id) }}" class="form-delete" method="POST" style="display: inline;"
                            data-confirm-delete="true">
                            @csrf
                            @method('DELETE')
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
        </script>
    @endif

    <script>
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
