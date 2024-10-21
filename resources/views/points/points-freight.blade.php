@vite(['resources/js/app.js', 'resources/js/chartjs/freight.js'])

@include('points.points-template', ['title' => 'Puntos de Flete', 'chart' => 'freightChart'])