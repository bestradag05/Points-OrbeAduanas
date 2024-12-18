@extends('adminlte::page')


@section('content_header')

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mt-2">
                <div class="card-body">
                    @yield('dinamic-content')
                </div>
            </div>
        </div>
    </div>
@stop


<script>
    document.addEventListener('DOMContentLoaded', () => {

        // Suscripción al canal privado
        Echo.private('quote')
            .listen('QuoteNotification', (event) => {
                toastr.info(event.message, "Nuevo requerimiento!");
            })
            .subscribed(() => {
                console.log('Usuario suscrito correctamente al canal quote');
            })
            .error((error) => {
                console.error('Error al intentar suscribirse al canal:', error);
            });
    });
</script>
