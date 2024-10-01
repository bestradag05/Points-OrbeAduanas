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
                <td> <i class="fas fa-fw fa-copy " aria-hidden="true"></i> admin </td>
                <td colspan="2">
                    <a href="{{url('roles/grupos/add-all-permissions', [$rol->id, 'admin'])}}">Todo</a>
                    /
                    <a href="{{url('roles/grupos/remove-all-permissions', [$rol->id, 'admin'])}}">Nada</a>
                </td>
            </tr>

            @foreach ($permissions as $permission)
                @if (Str::startsWith($permission->name, 'admin.'))
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
