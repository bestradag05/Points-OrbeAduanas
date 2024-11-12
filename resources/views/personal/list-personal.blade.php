@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Personal</h2>
        <div>
            <a href="{{ 'personal/create' }}" class="btn btn-primary"> Agregar </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach ($personals as $personal)
            <tr>
                <td>{{ $personal->id }}</td>
                <td>{{ $personal->names }}</td>
                <td>{{ $personal->last_name }}</td>
                <td>{{ $personal->cellphone }}</td>
                <td>{{ $personal->document->name }}</td>
                <td>{{ $personal->document_number }}</td>
                <td>{{ $personal->email }}</td>
                
                <td>
                    <img src="{{ asset('storage/'.$personal->img_url) }}" class="img-circle elevation-2" width="50px" height="50px" alt="User Image">
                </td>
                <td>
                     <a href="{{ url('/personal/'. $personal->id . '/edit') }}"> <i class="fa-solid fa-pen-to-square"></i> </a>
                     <a href=""> <i class="fa-solid fa-trash"></i> </a>
                </td>
            </tr>
        @endforeach
    </x-adminlte-datatable>
@stop
