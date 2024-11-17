@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra documento para clientes y proveedores</h2>
        <div>
            <a href="{{url('/document') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/customer_supplier_document" method="post" enctype="multipart/form-data">
        @csrf
        @include ('customer_supplier_documents.form-customer-supplier-document', ['formMode' => 'create'])
    </form>


@stop
