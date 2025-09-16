@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Prospectos</h2>
        <div>
            @can('prospects.create')
                <a href="{{ 'prospects/create' }}" class="btn btn-primary"> Agregar </a>
            @endcan
        </div>
    </div>

@stop
@section('dinamic-content')
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach ($customers as $customer)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $customer->document->name }}</td>
                <td>{{ $customer->document_number }}</td>
                <td>{{ $customer->name_businessname }}</td>
                <td>{{ $customer->contact_name }}</td>
                <td>{{ $customer->contact_number }}</td>
                <td>{{ $customer->contact_email }}</td>
                <td>{{ $customer->personal->names }}</td>
                <td>
                    <div class="custom-badge status-{{ strtolower($customer->state) }}">
                        {{ $customer->state }}
                    </div>

                </td>
                <td>
                    @can('customer.update')
                        <a href="{{ url('/prospects/' . $customer->id . '/edit') }}"> <i class="fas fa-edit"></i> </a>
                    @endcan
                    @can('customer.delete')
                        <form action="{{ url('/prospects/' . $customer->id) }}" class="form-delete" method="POST"
                            style="display: inline;" data-confirm-delete="true">
                            {{ method_field('DELETE') }}
                            @csrf
                            <button type="submit"
                                style="border: none; background: none; padding: 0; margin: 0; cursor: pointer;"> <i
                                    class="fas fa-trash text-primary"></i> </button>
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
