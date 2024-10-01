@vite(['resources/js/app.js', 'resources/js/chartjs/transport.js'])

@include('points.points-template', ['title' => 'Puntos de Transporte', 'chart' => 'transportChart']);