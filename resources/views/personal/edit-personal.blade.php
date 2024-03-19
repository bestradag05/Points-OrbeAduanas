@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar un personal</h2>
        <div>
            <button class="btn btn-primary"> Atras </button>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action={{ url('/personal/'. $personal->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('personal.form-personal', ['formMode' => 'edit'])
    </form>

    @push('scripts')
        <script src="{{ asset('js/personal.js') }}"></script>
    @endpush
@stop
