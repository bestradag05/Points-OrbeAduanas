@extends('home')

@section('dinamic-content')

    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="info-box mb-3 bg-indigo">
                <span class="info-box-icon"><i class="fas fa-tag"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total monto cobrado</span>
                    <span class="info-box-number">$ {{$commercialQuote->freight->total_freight_value}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="info-box mb-3 bg-indigo">
                <span class="info-box-icon"><i class="fas fa-tag"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total monto ah cobrar</span>
                    <span class="info-box-number">$ {{$commercialQuote->freight->total_answer_utility}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="info-box mb-3 bg-indigo">
                <span class="info-box-icon"><i class="fas fa-tag"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Ganancia</span>
                    <span class="info-box-number">$ {{$commercialQuote->freight->profit_on_freight}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="info-box mb-3 bg-indigo">
                <span class="info-box-icon"><i class="fas fa-tag"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Puntos Generados</span>
                    <span class="info-box-number">$ {{$commercialQuote->freight->total_freight_value}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
    </div>

@stop
