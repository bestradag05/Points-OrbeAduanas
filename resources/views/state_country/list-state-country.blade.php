@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Ciudades</h2>
        <div>
            
            <a href="{{ 'state_country/create' }}" class="btn btn-primary"> Agregar </a>
          
        </div>
    </div>

@stop
@section('dinamic-content')
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach ($statecountrys as $stateCountry)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $stateCountry->name}}</td>
                <td>{{ $stateCountry->country->name}}</td>
                <td>{{ $stateCountry->state}}</td>
                    
                <td>
                    @can('country.update')
                     <a href="{{ url('/state_country/'. $stateCountry->id . '/edit') }}"> <i class="fas fa-edit"></i> </a>
                    @endcan
                    @can('country.delete')
                     <form action="{{ url('/state_country/'.$stateCountry->id) }}" class="form-delete" method="POST" style="display: inline;" data-confirm-delete="true">
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
