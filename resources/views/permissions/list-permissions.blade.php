<div class="d-flex justify-content-between">


    <table class="table">
        <thead class="table-dark">
            <tr class="">
                <th>Modulo</th>
                <th>Todo/Nada</th>
                <th style="width: 40px">Permisos</th>
            </tr>
        </thead>
        <tbody>
            <tr class="table-secondary">
                <td> <i class="fas fa-fw fa-users " aria-hidden="true"></i> Usuarios</td>
                <td colspan="2">
                    <a href="{{url('roles/grupos/add-all-permissions', [$rol->id, 'users'])}}">Todo</a>
                    /
                    <a href="{{url('roles/grupos/remove-all-permissions', [$rol->id, 'users'])}}">Nada</a>
                </td>
            </tr>



            @foreach ($permissions as $permission)
                @if (Str::startsWith($permission->name, 'users.'))
                    <tr>
                        <td></td>
                        <td>{{ $permission->alias }}</td>
                        <td>

                            @if ($rol->hasPermissionTo($permission->name))
                                <a class="reposition"
                                    href="{{ url('roles/grupos/removepermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-on fa-2xl"></i>
                                </a>
                            @else
                                <a class="reposition"
                                    href="{{ url('roles/grupos/assignpermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-off fa-2xl"></i>
                                </a>
                            @endif


                        </td>
                    </tr>
                @endif
            @endforeach

            <tr class="table-secondary">
                <td> <i class="fa-sharp fa-solid fa-user-tie"></i> Personal </td>
                <td colspan="2">
                    <a href="{{url('roles/grupos/add-all-permissions', [$rol->id, 'personal'])}}">Todo</a>
                    /
                    <a href="{{url('roles/grupos/remove-all-permissions', [$rol->id, 'personal'])}}">Nada</a>
                </td>
            </tr>

            @foreach ($permissions as $permission)
                @if (Str::startsWith($permission->name, 'personal.'))
                    <tr>
                        <td></td>
                        <td>{{ $permission->alias }}</td>
                        <td>

                            @if ($rol->hasPermissionTo($permission->name))
                                <a class="reposition"
                                    href="{{ url('roles/grupos/removepermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-on fa-2xl"></i>
                                </a>
                            @else
                                <a class="reposition"
                                    href="{{ url('roles/grupos/assignpermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-off fa-2xl"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach


            <tr class="table-secondary">
                <td> <i class="fa-sharp fa-solid fa-user-tie"></i> Conceptops </td>
                <td colspan="2">
                    <a href="{{url('roles/grupos/add-all-permissions', [$rol->id, 'concept'])}}">Todo</a>
                    /
                    <a href="{{url('roles/grupos/remove-all-permissions', [$rol->id, 'concept'])}}">Nada</a>
                </td>
            </tr>

            @foreach ($permissions as $permission)
                @if (Str::startsWith($permission->name, 'concept.'))
                    <tr>
                        <td></td>
                        <td>{{ $permission->alias }}</td>
                        <td>

                            @if ($rol->hasPermissionTo($permission->name))
                                <a class="reposition"
                                    href="{{ url('roles/grupos/removepermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-on fa-2xl"></i>
                                </a>
                            @else
                                <a class="reposition"
                                    href="{{ url('roles/grupos/assignpermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-off fa-2xl"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach


            <tr class="table-secondary">
                <td> <i class="fas fa-fw fa-laptop " aria-hidden="true"></i>liquidacion </td>
                <td colspan="2">
                    <a href="{{url('roles/grupos/add-all-permissions', [$rol->id, 'liquidacion'])}}">Todo</a>
                    /
                    <a href="{{url('roles/grupos/remove-all-permissions', [$rol->id, 'liquidacion'])}}">Nada</a>
                </td>
            </tr>

            @foreach ($permissions as $permission)
                @if (Str::startsWith($permission->name, 'liquidacion.'))
                    <tr>
                        <td></td>
                        <td>{{ $permission->alias }}</td>
                        <td>

                            @if ($rol->hasPermissionTo($permission->name))
                                <a class="reposition"
                                    href="{{ url('roles/grupos/removepermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-on fa-2xl"></i>
                                </a>
                            @else
                                <a class="reposition"
                                    href="{{ url('roles/grupos/assignpermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-off fa-2xl"></i>
                                </a>
                            @endif

                        </td>
                    </tr>
                @endif
            @endforeach

            <tr class="table-secondary">
                <td> <i class="fas fa-fw fa-user-tie " aria-hidden="true"></i> operaciones </td>
                <td colspan="2">
                    <a href="{{url('roles/grupos/add-all-permissions', [$rol->id, 'operaciones'])}}">Todo</a>
                    /
                    <a href="{{url('roles/grupos/remove-all-permissions', [$rol->id, 'operaciones'])}}">Nada</a>
                </td>
            </tr>

            @foreach ($permissions as $permission)
                @if (Str::startsWith($permission->name, 'operaciones.'))
                    <tr>
                        <td></td>
                        <td>{{ $permission->alias }}</td>
                        <td>

                            @if ($rol->hasPermissionTo($permission->name))
                                <a class="reposition"
                                    href="{{ url('roles/grupos/removepermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-on fa-2xl"></i>
                                </a>
                            @else
                                <a class="reposition"
                                    href="{{ url('roles/grupos/assignpermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-off fa-2xl"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach

            <tr class="table-secondary">
                <td> <i class="fas fa-fw fa-truck-moving " aria-hidden="true"></i> transporte </td>
                <td colspan="2">
                    <a href="{{url('roles/grupos/add-all-permissions', [$rol->id, 'transporte'])}}">Todo</a>
                    /
                    <a href="{{url('roles/grupos/remove-all-permissions', [$rol->id, 'transporte'])}}">Nada</a>
                </td>
            </tr>

            @foreach ($permissions as $permission)
                @if (Str::startsWith($permission->name, 'transporte.'))
                    <tr>
                        <td></td>
                        <td>{{ $permission->alias }}</td>
                        <td>

                            @if ($rol->hasPermissionTo($permission->name))
                                <a class="reposition"
                                    href="{{ url('roles/grupos/removepermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-on fa-2xl"></i>
                                </a>
                            @else
                                <a class="reposition"
                                    href="{{ url('roles/grupos/assignpermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-off fa-2xl"></i>
                                </a>
                            @endif

                        </td>
                    </tr>
                @endif
            @endforeach
            

            <tr class="table-secondary">
                <td> <i class="fas fa-fw fa-copy " aria-hidden="true"></i> Adicionales </td>
                <td colspan="2">
                    <a href="{{url('roles/grupos/add-all-permissions', [$rol->id, 'additional'])}}">Todo</a>
                    /
                    <a href="{{url('roles/grupos/remove-all-permissions', [$rol->id, 'additional'])}}">Nada</a>
                </td>
            </tr>

            @foreach ($permissions as $permission)
                @if (Str::startsWith($permission->name, 'additional.'))
                    <tr>
                        <td></td>
                        <td>{{ $permission->alias }}</td>
                        <td>

                            @if ($rol->hasPermissionTo($permission->name))
                                <a class="reposition"
                                    href="{{ url('roles/grupos/removepermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-on fa-2xl"></i>
                                </a>
                            @else
                                <a class="reposition"
                                    href="{{ url('roles/grupos/assignpermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-off fa-2xl"></i>
                                </a>
                            @endif

                        </td>
                    </tr>
                @endif
            @endforeach


            <tr class="table-secondary">
                <td> <i class="fas fa-fw fa-copy " aria-hidden="true"></i> Puntos </td>
                <td colspan="2">
                    <a href="{{url('roles/grupos/add-all-permissions', [$rol->id, 'points'])}}">Todo</a>
                    /
                    <a href="{{url('roles/grupos/remove-all-permissions', [$rol->id, 'points'])}}">Nada</a>
                </td>
            </tr>

            @foreach ($permissions as $permission)
                @if (Str::startsWith($permission->name, 'points.'))
                    <tr>
                        <td></td>
                        <td>{{ $permission->alias }}</td>
                        <td>

                            @if ($rol->hasPermissionTo($permission->name))
                                <a class="reposition"
                                    href="{{ url('roles/grupos/removepermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-on fa-2xl"></i>
                                </a>
                            @else
                                <a class="reposition"
                                    href="{{ url('roles/grupos/assignpermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-off fa-2xl"></i>
                                </a>
                            @endif

                        </td>
                    </tr>
                @endif
            @endforeach


            <tr class="table-secondary">
                <td> <i class="fas fa-fw fa-copy " aria-hidden="true"></i> Clientes </td>
                <td colspan="2">
                    <a href="{{url('roles/grupos/add-all-permissions', [$rol->id, 'customer'])}}">Todo</a>
                    /
                    <a href="{{url('roles/grupos/remove-all-permissions', [$rol->id, 'customer'])}}">Nada</a>
                </td>
            </tr>

            @foreach ($permissions as $permission)
                @if (Str::startsWith($permission->name, 'customer.'))
                    <tr>
                        <td></td>
                        <td>{{ $permission->alias }}</td>
                        <td>

                            @if ($rol->hasPermissionTo($permission->name))
                                <a class="reposition"
                                    href="{{ url('roles/grupos/removepermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-on fa-2xl"></i>
                                </a>
                            @else
                                <a class="reposition"
                                    href="{{ url('roles/grupos/assignpermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-off fa-2xl"></i>
                                </a>
                            @endif

                        </td>
                    </tr>
                @endif
            @endforeach

            <tr class="table-secondary">
                <td> <i class="fas fa-fw fa-copy " aria-hidden="true"></i> Tipo de embarque </td>
                <td colspan="2">
                    <a href="{{url('roles/grupos/add-all-permissions', [$rol->id, 'type_shipment'])}}">Todo</a>
                    /
                    <a href="{{url('roles/grupos/remove-all-permissions', [$rol->id, 'type_shipment'])}}">Nada</a>
                </td>
            </tr>

            @foreach ($permissions as $permission)
                @if (Str::startsWith($permission->name, 'type_shipment.'))
                    <tr>
                        <td></td>
                        <td>{{ $permission->alias }}</td>
                        <td>

                            @if ($rol->hasPermissionTo($permission->name))
                                <a class="reposition"
                                    href="{{ url('roles/grupos/removepermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-on fa-2xl"></i>
                                </a>
                            @else
                                <a class="reposition"
                                    href="{{ url('roles/grupos/assignpermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-off fa-2xl"></i>
                                </a>
                            @endif

                        </td>
                    </tr>
                @endif
            @endforeach

            <tr class="table-secondary">
                <td> <i class="fas fa-fw fa-copy " aria-hidden="true"></i> Modalidad </td>
                <td colspan="2">
                    <a href="{{url('roles/grupos/add-all-permissions', [$rol->id, 'modality'])}}">Todo</a>
                    /
                    <a href="{{url('roles/grupos/remove-all-permissions', [$rol->id, 'modality'])}}">Nada</a>
                </td>
            </tr>

            @foreach ($permissions as $permission)
                @if (Str::startsWith($permission->name, 'modality.'))
                    <tr>
                        <td></td>
                        <td>{{ $permission->alias }}</td>
                        <td>

                            @if ($rol->hasPermissionTo($permission->name))
                                <a class="reposition"
                                    href="{{ url('roles/grupos/removepermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-on fa-2xl"></i>
                                </a>
                            @else
                                <a class="reposition"
                                    href="{{ url('roles/grupos/assignpermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-off fa-2xl"></i>
                                </a>
                            @endif

                        </td>
                    </tr>
                @endif
            @endforeach

            <tr class="table-secondary">
                <td> <i class="fas fa-fw fa-copy " aria-hidden="true"></i> Routing </td>
                <td colspan="2">
                    <a href="{{url('roles/grupos/add-all-permissions', [$rol->id, 'routing'])}}">Todo</a>
                    /
                    <a href="{{url('roles/grupos/remove-all-permissions', [$rol->id, 'routing'])}}">Nada</a>
                </td>
            </tr>

            @foreach ($permissions as $permission)
                @if (Str::startsWith($permission->name, 'routing.'))
                    <tr>
                        <td></td>
                        <td>{{ $permission->alias }}</td>
                        <td>

                            @if ($rol->hasPermissionTo($permission->name))
                                <a class="reposition"
                                    href="{{ url('roles/grupos/removepermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-on fa-2xl"></i>
                                </a>
                            @else
                                <a class="reposition"
                                    href="{{ url('roles/grupos/assignpermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                    <i class="fa-regular fa-toggle-large-off fa-2xl"></i>
                                </a>
                            @endif

                        </td>
                    </tr>
                @endif
            @endforeach

        </tbody>
    </table>


</div>
