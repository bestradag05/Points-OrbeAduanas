@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Aduanas</h2>
        <div>
            <a href="{{ 'custom/create' }}" class="btn btn-primary"> Agregar </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach ($customs as $custom)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $custom->ruc }}</td>
                <td>{{ $custom->name_businessname }}</td>
                <td>{{ $custom->contact_name }}</td>
                <td>{{ $custom->contact_number }}</td>
                <td>{{ $custom->contact_email }}</td>
                <td>{{ $custom->usercustom->name . ' ' . $custom->usercustom->last_name}}</td>
                <td>
                     <a href="{{ url('/custom/'. $custom->id . '/edit') }}"> <i class="fa-solid fa-pen-to-square"></i> </a>
                     <form action="{{ url('/custom/'.$custom->id) }}" class="form-delete" method="POST" style="display: inline;" data-confirm-delete="true">
                        {{ method_field('DELETE') }}
                        @csrf
                        <button  type="submit" style="border: none; background: none; padding: 0; margin: 0; cursor: pointer;"> <i class="fa-solid fa-trash text-primary"></i> </button>
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
