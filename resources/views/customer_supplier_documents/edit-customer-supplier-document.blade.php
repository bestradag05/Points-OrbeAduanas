@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar documento para clientes y proveedores</h2>
        <div>
            <a href="{{ url('/customer_supplier_document') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action={{ url('/customer_supplier_document/'. $customer_supplier_document->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('customer_supplier_documents.form-customer-supplier-document', ['formMode' => 'edit'])
    </form>

   
@stop
