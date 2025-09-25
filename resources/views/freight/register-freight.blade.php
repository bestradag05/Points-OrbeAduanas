@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra un Flete</h2>
        <div>
            <a href="{{ url()->previous() }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')


    @if ($acceptedResponse)
        <div class="row">
            <div class="col-12 text-center p-2 rounded">
                <h5 class="p-0 m-0 text-bold">Resumen de la respuesta aceptada: <span
                        class="text-indigo">{{ $acceptedResponse->nro_response }}
                        <button class="btn" onclick="showDetail({{ $acceptedResponse->id }})">
                            <i class="fas fa-file-pdf text-danger"></i>

                        </button>
                    </span></h5>
            </div>
        </div>
    @endif


    <!-- Modal para PDF -->
    <div class="modal fade" id="pdfDetailResponse" tabindex="-1" role="dialog" aria-labelledby="pdfDetailResponseLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalle de Cotización</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="pdfFrame" src="" frameborder="0" style="width: 100%; height: 80vh;"></iframe>
                </div>
            </div>
        </div>
    </div>



    <form action="/freight" method="post" id="formFreight" enctype="multipart/form-data">
        @csrf
        @include ('freight.form-freight', ['formMode' => 'create'])
    </form>


@stop


@push('scripts')

    <script>
        function showDetail(responseId) {

            //Abrir modal
            const url = `/quote/freight/response/${responseId}/show`;
            $('#pdfFrame').attr('src', url);
            $('#pdfDetailResponse').modal('show');
            return;
        }
    </script>


@endpush
