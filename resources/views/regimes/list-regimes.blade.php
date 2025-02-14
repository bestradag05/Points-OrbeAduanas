@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Regímenes</h2>
        <div>

            <a href="{{ 'regimes/create' }}" class="btn btn-primary">Agregar</a>

        </div>
    </div>
@stop

@section('dinamic-content')
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach ($regimes as $regime)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $regime->code}}</td>
                <td>{{ $regime->description}}</td>
                <td>{{ $regime->state}}</td>   

                <td>
                    @can('regime.update')
                     <a href="{{ url('regimes/'. $regime->id . '/edit' ) }}"> <i class="fas fa-edit"></i> </a>
                    @endcan
                    @can('regime.delete')
                     <form action="{{ url('/regimes/'.$regime->id . '/destroy' ) }}" class="form-delete" method="POST" style="display: inline;" data-confirm-delete="true">
                        {{ method_field('DELETE') }}
                        @csrf
                        <button  type="submit" style="border: none; background: none; padding: 0; margin: 0; cursor: pointer;"> <i class="fas fa-trash text-primary"></i> </button>
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