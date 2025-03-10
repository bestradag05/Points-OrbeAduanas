@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Personal</h2>
        <div>
            <a href="{{ 'personal/create' }}" class="btn btn-primary"> Agregar </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach ($personals as $personal)
            <tr>
                <td>{{ $personal->id }}</td>
                <td>{{ $personal->names }}</td>
                <td>{{ $personal->last_name }}</td>
                <td>{{ $personal->cellphone }}</td>
                <td>{{ $personal->document->name }}</td>
                <td>{{ $personal->document_number }}</td>
                <td>{{ $personal->email }}</td>
                <td>{{ $personal->state }}</td>

                <td>

                    <img src="{{ asset('storage/' . ($personal->img_url !== null ? $personal->img_url : 'personals/user_default.png')) }}" class="img-circle elevation-2" width="50px" height="50px" alt="User Image">

                </td>
                <td>
                    <a href="{{ url('/personal/' . $personal->id . '/edit') }}"> <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ url('/personal/' . $personal->id) }}" class="form-delete" method="POST"
                        style="display: inline;" data-confirm-delete="true">
                        {{ method_field('DELETE') }}
                        @csrf
                        <button type="submit"
                            style="border: none; background: none; padding: 0; margin: 0; cursor: pointer;"> <i class="fas fa-trash text-primary"></i> </button>
                    </form>
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
