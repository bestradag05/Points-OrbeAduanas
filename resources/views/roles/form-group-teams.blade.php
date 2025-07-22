<x-adminlte-datatable id="tableEquipos" :heads="['ID', 'Nombre', 'Área', 'Equipo asignado', 'Acciones']">
    @foreach ($users as $user)
        @php
            $personal = $user->personal;
            $areas = $personal?->areas;
            $equipos = $areas ? $areas->flatMap->teams->unique('id') : collect();
        @endphp
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $personal?->names }} {{ $personal?->last_name }}</td>
            <td>{{ $areas?->pluck('name')->join(', ') ?? 'Sin área' }}</td>
            <td>{{ $personal?->team?->name ?? 'Sin asignar' }}</td>
            <td>
                @if ($equipos->isNotEmpty())
                    <form action="{{ url('roles/equipos/asignar') }}" method="POST" class="d-flex align-items-center">
                        @csrf
                        <input type="hidden" name="id_user" value="{{ $user->id }}">
                        <select name="id_team" class="form-control mr-2" style="width: 200px">
                            <option value="">-- Seleccione --</option>
                            @foreach ($equipos as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary">Asignar</button>
                    </form>
                @else
                    <span class="text-muted">Sin equipos disponibles</span>
                @endif
            </td>
        </tr>
    @endforeach
</x-adminlte-datatable>
