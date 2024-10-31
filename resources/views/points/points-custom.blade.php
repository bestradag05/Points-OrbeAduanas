{{-- Integramos chart.js a esta pantalla mediante vit --}}
@vite(['resources/js/chartjs/points-chart.js'])

@include('points.points-template', ['title' => 'Puntos de Aduanas', 'chart' => 'customs']);