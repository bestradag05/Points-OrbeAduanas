@extends('home')

@section('dinamic-content')

    <div class="row">
        <div class="row p-3 w-100">
            <div class="col-12 my-3">
                <h3 class="text-center text-indigo">Comisiones en flete</h3>
            </div>
            <div class="col-12">
                <div class="alert alert-sm text-center text-muted" role="alert" style="font-size: 14px;">
                    <strong>Estimado vendedor:</strong> Para poder generar profit, primero debe pasar el mínimo de 10
                    puntos. Si aún no se completa la ganancia se pasará de forma automática a puntos adicionales, una vez
                    pasado el minimo tendra la opcion de generar profit tomando en cuanta que debe dejar como minimo de
                    utilidad <strong>$ 250.00</strong> .
                </div>
            </div>
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Flete</th>
                            <th scope="col">Costo venta</th>
                            <th scope="col">Costo Neto</th>
                            <th scope="col">Utilidad</th>
                            <th scope="col">Ganacia</th>
                            <th scope="col">Puntos Puros</th>
                            <th scope="col">Profit</th>
                            <th scope="col">Comision Generada</th>
                            <th scope="col">Total Ganancia</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">{{ $commercialQuote->freight->nro_operation_freight }}</th>
                            <td>$ {{ $commercialQuote->freight->total_freight_value }}</td>
                            <td>$ {{ $commercialQuote->freight->accepted_answer_value }}</td>
                            <td>$ {{ $commercialQuote->freight->value_utility }}</td>
                            <td>
                                <div class="custom-badge status-{{ strtolower($commercialQuote->state) }}">
                                    $ {{ $commercialQuote->freight->profit_on_freight }}
                                </div>
                            </td>
                            <td>{{ $commercialQuote->freight->points->sum('quantity') }}</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>
                                <!-- Select para elegir entre generar Puntos o Profit -->
                                <select id="actionSelect" class="form-control">
                                    <option> --- Seleciona una opción --- </option>
                                    <option value="puntos">Generar Puntos</option>
                                    <option value="profit">Generar Profit</option>
                                </select>
                            </td>
                        </tr>


                    </tbody>
                </table>
            </div>


        </div>


    </div>


    <!-- Modal -->
    <div class="modal fade" id="calcularModalPoints" tabindex="-1" aria-labelledby="calcularModalPointsLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="calcularModalPointsLabel">Calcular Puntos y Profit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action={{ url('/commissions/seller/generate/points') }} id="formPoints" method="POST"
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div>
                            <label for="puntos">Puntos a Generar: </label>
                            <input type="number" id="points" name="points" class="form-control" value="0"
                                min="0" oninput="validarPuntos()">
                            <small id="maxPuntos" class="form-text text-muted"></small>
                            <small id="descuentoPorPunto" class="form-text text-muted"></small>
                            <small id="restante" class="form-text text-muted"></small>
                        </div>
                        <br>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-indigo">Generar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@stop


@push('scripts')
    <script>
        const ganancia = @json($commercialQuote->freight->profit_on_freight);
        const costoPorPunto = 45;


        $('#actionSelect').change(function() {
            const selectedAction = $(this).val();

            if (selectedAction === 'puntos') {
                // Si selecciona Generar Puntos, abre el modal correspondiente
                $('#calcularModalPoints').modal('show');
            } else if (selectedAction === 'profit') {
                // Si selecciona Generar Profit, abre el modal correspondiente
                $('#calcularModalProfit').modal('show');
            }
        });


        $('#formPoints').submit(function(e) {
            // Obtener el valor de los puntos
            const puntos = parseInt($('#points').val());

            // Verificar si los puntos son 0 o menor
            if (puntos <= 0) {
                // Si los puntos son 0 o menores, prevenir el envío del formulario
                e.preventDefault(); // Evitar que el formulario se envíe
                $('#points').addClass('is-invalid');
                // Mostrar un mensaje de error
                toastr.error('Debe generar almenos un punto para poder registrarlo');
            }
        });

        // Calcular el máximo de puntos posibles
        function calcularMaxPuntos() {
            return Math.floor(ganancia / costoPorPunto);
        }

        // Actualizar el máximo de puntos en el formulario y validarlo
        function validarPuntos() {
            const maxPuntos = calcularMaxPuntos();

            let puntos = parseInt($('#points').val());

            // Mostrar el máximo de puntos posibles
            $('#maxPuntos').text(`Máximo de puntos posibles: ${maxPuntos}`);

            // Evitar que se ingresen más puntos de los posibles
            if (puntos > maxPuntos) {
                $('#points').val(maxPuntos); // Limitar a la cantidad máxima
            }

            // Evitar que el valor sea negativo
            if (puntos < 0) {
                $('#points').val(0); // Ajustar a 0 si el valor es negativo
            }

            if (puntos <= maxPuntos) {
                // Mostrar el descuento por punto y el monto restante
                const totalDescuento = puntos * costoPorPunto;
                $('#descuentoPorPunto').text(`Descuento total por ${puntos} puntos: $${totalDescuento}`);

                // Calcular y mostrar el monto restante después de descontar los puntos
                const restante = ganancia - totalDescuento;
                $('#restante').text(`Monto restante: $${restante.toFixed(2)}`);

            }


        }

        document.addEventListener('DOMContentLoaded', function() {
            validarPuntos(); // Llamar para establecer el valor inicial del máximo
        });
    </script>
@endpush
