@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>{{ $rol->name }}</h2>
        <div>
            <a href="{{ url('/roles') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')

    <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'usuarios' ? 'active' : '' }}"
                        href="{{ url('roles/grupos/' . $rol->id) }}">Usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'usuarios' ? '' : 'active' }}"
                        href="{{ url('/roles/grupos/permissions/' . $rol->id) }}">Permisos ({{ $rol->permissions->count(); }})</a>
                </li>
                <li class="nav-item">

            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-four-tabContent">
                <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel"
                    aria-labelledby="custom-tabs-four-home-tab">

                    @if ($tab == 'usuarios')
                        @include('roles/form-group-roles')
                    @else
                        @include('permissions/list-permissions  ')
                    @endif
                </div>

            </div>
        </div>

    </div>

@stop


@push('scripts')
@endpush
