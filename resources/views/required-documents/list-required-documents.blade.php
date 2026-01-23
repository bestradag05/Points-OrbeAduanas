@extends('home')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Configuración de Documentos Requeridos</h1>
        </div>
        <div class="col-sm-6">
            <a href="{{ route('required-documents.create') }}" class="btn btn-primary float-right">
                <i class="fas fa-plus"></i> Nuevo Documento
            </a>
        </div>
    </div>
@stop

@section('dinamic-content')

    @if (count($documents) > 0)
        <x-adminlte-datatable id="table1" :heads="$heads">
            @foreach ($documents as $document)
                <tr>
                    <td>
                        <span class="badge badge-primary">
                            {{ ucfirst($document->service_type) }}
                        </span>
                    </td>
                    <td>
                        <strong>{{ $document->document_name }}</strong>
                    </td>
                    <td class="text-center">
                        @if ($document->is_required)
                            <span class="badge badge-success">
                                <i class="fas fa-check"></i> Sí
                            </span>
                        @else
                            <span class="badge badge-secondary">
                                <i class="fas fa-times"></i> No
                            </span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($document->is_auto_generated)
                            <span class="badge badge-info">
                                <i class="fas fa-cog"></i> Sí
                            </span>
                        @else
                            <span class="badge badge-secondary">
                                <i class="fas fa-times"></i> No
                            </span>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-light">{{ $document->order }}</span>
                    </td>
                    <td>
                        <small>{{ Str::limit($document->description, 50) }}</small>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('required-documents.edit', $document->id) }}" 
                            title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('required-documents.destroy', $document->id) }}" method="POST"
                            style="display:inline;" onsubmit="return confirm('¿Eliminar este documento?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="border: none; background: none; padding: 0; margin: 0; cursor: pointer;" title="Eliminar">
                                <i class="fas fa-trash text-primary"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    @else
        <div class="alert alert-info" role="alert">
            <i class="fas fa-info-circle"></i>
            No hay documentos requeridos configurados. <a href="{{ route('required-documents.create') }}">Crear
                uno</a>
        </div>
    @endif

@endsection
