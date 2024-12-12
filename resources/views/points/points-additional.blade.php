@vite(['resources/js/chartjs/points-chart.js'])

@include('points.points-template', ['title' => 'Puntos Adicionales', 'chart' => 'additionals'])