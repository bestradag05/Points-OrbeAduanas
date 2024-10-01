@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra un personal</h2>
        <div>
            <a href="{{url('/personal') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/personal" method="post" enctype="multipart/form-data">
        @csrf
        @include ('personal.form-personal', ['formMode' => 'create'])
    </form>

    @push('scripts')
        <script src="{{ asset('js/personal.js') }}"></script>
    @endpush
@stop
