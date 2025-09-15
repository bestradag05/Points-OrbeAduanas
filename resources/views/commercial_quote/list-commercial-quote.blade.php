@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Cotizacion </h2>
        <div>
            <a href="{{ '/commercial/quote/create' }}" class="btn btn-primary"> Agregar </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach ($commercial_quotes as $commercial_quote)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <a href="{{ url('/commercial/quote/' . $commercial_quote->id . '/detail') }}">
                        {{ $commercial_quote->nro_quote_commercial }}
                    </a>
                </td>
                 <td class="text-uppercase">{{ implode(', ', $commercial_quote->services_to_quote) }} </td>
                @if (in_array('Transporte', $commercial_quote->services_to_quote) && count($commercial_quote->services_to_quote) == 1)
                    <td class="text-uppercase">{{ $commercial_quote->transport->origin }} </td>
                    <td class="text-uppercase">{{ $commercial_quote->transport->destination }} </td>
                @else
                    <td class="text-uppercase">{{ $commercial_quote->originState->country->name }} -
                        {{ $commercial_quote->originState->name }}</td>
                    <td class="text-uppercase">{{ $commercial_quote->destinationState->country->name }} -
                        {{ $commercial_quote->destinationState->name }}</td>
                @endif
                <td class="text-uppercase">{{ $commercial_quote->customer->name_businessname ?? '' }}</td>
                <td>{{ $commercial_quote->type_shipment->description . ' ' . ($commercial_quote->type_shipment->description === 'Marítima' ? $commercial_quote->lcl_fcl : '') }}
                </td>
                <td>{{ $commercial_quote->personal->names }}</td>
                <td>{{ $commercial_quote->is_consolidated ? 'SI' : 'NO' }}</td>
                <td>{{ \Carbon\Carbon::parse($commercial_quote->created_at)->format('d/m/Y') }}</td>
                <td>
                    <div class="custom-badge status-{{ strtolower($commercial_quote->state) }}">
                        {{ $commercial_quote->state }}
                    </div>
                </td>

                <td>
                    @if (!$commercial_quote->typeService()->exists() || auth()->user()->hasRole('Super-Admin'))
                        @can('commercial_quote.update')
                            <a href="{{ url('/commercial_quote/' . $commercial_quote->id . '/edit') }}"> <i
                                    class="fas fa-edit"></i></a>
                        @endcan
                        @can('commercial_quote.delete')
                            <form action="{{ url('/commercial_quote/' . $commercial_quote->id) }}" class="form-delete"
                                method="POST" style="display: inline;" data-confirm-delete="true">
                                {{ method_field('DELETE') }}
                                @csrf
                                <button type="submit"
                                    style="border: none; background: none; padding: 0; margin: 0; cursor: pointer;"> <i
                                        class="fas fa-trash text-primary"></i> </button>
                            </form>
                        @endcan
                    @endif
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
