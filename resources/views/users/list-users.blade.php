@extends('home')

@section('content_header')
    <div class="">
        <h2>Users</h2>
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
