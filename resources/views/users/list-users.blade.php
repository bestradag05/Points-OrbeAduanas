@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Usuarios</h2>
       {{--  <div>
            <a href="{{ 'users/create' }}" class="btn btn-primary"> Agregar </a>
        </div> --}}
    </div>

@stop
@section('dinamic-content')
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->password }}</td>
            </tr>
        @endforeach
    </x-adminlte-datatable>
@stop
