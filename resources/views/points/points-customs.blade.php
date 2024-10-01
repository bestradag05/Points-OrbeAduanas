{{-- Integramos chart.js a esta pantalla mediante vit --}}
@vite(['resources/js/app.js', 'resources/js/chartjs/custom.js'])

@include('points.points-template', ['title' => 'Puntos de Aduanas', 'chart' => 'customChart']);