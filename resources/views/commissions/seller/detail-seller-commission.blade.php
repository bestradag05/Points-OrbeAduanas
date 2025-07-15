@extends('home')

@section('dinamic-content')

    <div class="row">
        <div class="row p-5 w-100">
            <div class="col-12 my-5">
                <h3 class="text-center text-indigo">Comisiones en flete</h3>
            </div>
            <div class="col-12">
                <div class="alert alert-sm text-center text-muted" role="alert" style="font-size: 14px;">
                    <strong>Estimado vendedor:</strong> Para poder generar profit, primero debe pasar el mínimo de 10 puntos. Si aún no se completa la ganancia se pasará de forma automática a puntos adicionales, una vez pasado el minimo tendra la opcion de generar profit tomando en cuanta que debe dejar como minimo de utilidad <strong>$ 250</strong> .
                </div>
            </div>
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Flete</th>
                            <th scope="col">Costo venta</th>
                            <th scope="col">Costo Neto</th>
                            <th scope="col">Ganacia</th>
                            <th scope="col">Puntos Generados</th>
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
                            <td>
                                <div class="custom-badge status-{{ strtolower($commercialQuote->state) }}">
                                    $ {{ $commercialQuote->freight->profit_on_freight }}
                                </div>
                            </td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>
                                <button class="btn btn-indigo">Generar puntos</button>
                                <button class="btn btn-indigo">Generar profit</button>
                            </td>
                        </tr>


                    </tbody>
                </table>
            </div>

        </div>


    </div>

@stop
