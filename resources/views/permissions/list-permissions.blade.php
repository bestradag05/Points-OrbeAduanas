<table class="table">
    <thead class="table-dark">
        <tr>
            <th>Módulo</th>
            <th>Todo/Nada</th>
            <th style="width: 40px">Permisos</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($modules as $prefix => $groupPermissions)
            <tr class="table-secondary">
                <td><i class="fas fa-fw fa-folder"></i> {{ ucfirst($prefix) }}</td>
                <td colspan="2">
                    <a href="{{ url('roles/grupos/add-all-permissions', [$rol->id, $prefix]) }}">Todo</a> /
                    <a href="{{ url('roles/grupos/remove-all-permissions', [$rol->id, $prefix]) }}">Nada</a>
                </td>
            </tr>

            @foreach ($groupPermissions as $permission)
                <tr>
                    <td></td>
                    <td>{{ $permission->alias }}</td>
                    <td>
                        @if ($rol->hasPermissionTo($permission->name))
                            <a class="reposition"
                               href="{{ url('roles/grupos/removepermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                <i class="fas fa-toggle-on fa-lg"></i>
                            </a>
                        @else
                            <a class="reposition"
                               href="{{ url('roles/grupos/assignpermission', ['id_permission' => $permission->id, 'id_role' => $rol->id]) }}">
                                <i class="fas fa-toggle-off fa-lg"></i>
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
