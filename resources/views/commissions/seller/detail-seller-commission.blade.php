@extends('home')

@section('dinamic-content')

    <div class="row">


        <div class="col-12 my-3">
            <h3 class="text-center text-bold text-indigo">Gestion de comisiones</h3>
        </div>

        <div class="col-12">
            <div class="alert alert-sm text-center text-muted" role="alert" style="font-size: 14px;">
                <strong>Estimado vendedor:</strong> Para poder generar profit, primero debe pasar el mínimo de 10
                puntos. Si aún no se completa la ganancia se pasará de forma automática a puntos adicionales, una vez
                pasado el minimo tendrá la opción de generar profit tomando en cuenta que debe dejar como mínimo de
                utilidad <strong>$ 250.00</strong>.
            </div>
        </div>

        <!-- Comisiones de Flete -->
        @if ($freightCommissions->isNotEmpty())
            <div class="col-12 my-3">
                <h4 class="text-center text-indigo">Flete</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">N° de cotización</th>
                            <th scope="col">Flete</th>
                            <th scope="col">Seguro</th>
                            <th scope="col">Costo Venta</th>
                            <th scope="col">Costo Neto</th>
                            <th scope="col">Utilidad</th>
                            <th scope="col">Ganancia</th>
                            <th scope="col">Puntos Puro</th>
                            <th scope="col">Puntos Adicional</th>
                            <th scope="col">Profit</th>
                            <th scope="col">Saldo</th>
                            <th scope="col">Comisión Generada</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($freightCommissions as $commission)
                            <tr>
                                <td class="text-indigo text-bold">
                                    {{ $commission->commissionable->commercial_quote->nro_quote_commercial }}</td>
                                <td>{{ $commission->commissionable->nro_operation_freight }}</td>
                                <td class="text-blue">{{ $commission->insurance ? 'SI' : 'NO' }}</td>
                                <td>${{ $commission->cost_of_sale }}</td>
                                <td>${{ $commission->net_cost }}</td>
                                <td>${{ $commission->utility }}</td>
                                <td>${{ $commission->gross_profit }}</td>
                                <td>{{ $commission->pure_points }}</td>
                                <td>{{ $commission->additional_points }}</td>
                                <td>
                                    <div class="custom-badge status-info">
                                        ${{ $commission->distributed_profit }}
                                    </div>
                                </td>
                                <td>${{ $commission->remaining_balance }}</td>

                                <td>
                                    <div class="custom-badge status-success">
                                        $ {{ number_format($commission->generated_commission, 2) }}
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm"
                                        onclick="confirmPointsGeneration({{ $commission->remaining_balance }}, 'freight')">Calcular
                                        puntos</button>
                                    <button class="btn btn-secondary btn-sm"
                                        @if (!$canGenerateProfit['freight']) disabled @endif
                                        onclick="confirmProfitGeneration({{ $commission->remaining_balance }}, 'freight')">Calcular
                                        profit</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Gastos Locales (Aduana + Transporte) -->
       @if ($localCommissions->isNotEmpty())
    <div class="col-12 my-3">
        <h4 class="text-center text-indigo">Gastos Locales (Aduana + Transporte)</h4>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">N° de cotización</th>
                    <th scope="col">Servicio</th>
                    <th scope="col">Seguro</th>
                    <th scope="col">Costo Venta</th>
                    <th scope="col">Costo Neto</th>
                    <th scope="col">Utilidad</th>
                    <th scope="col">Ganancia</th>
                    <th scope="col">Puntos Puros</th>
                    <th scope="col">Puntos Adicionales</th>
                    <th scope="col">Profit</th>
                    <th scope="col">Saldo</th>
                    <th scope="col">Comisión Generada</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($localCommissions as $commission)
                    <tr>
                        <td class="text-indigo text-bold">
                            {{ $commission->commissionable->commercial_quote->nro_quote_commercial }}</td>
                        <td>{{ $commission->commissionable_type === 'App\Models\Custom' ? $commission->commissionable->nro_operation_custom : $commission->commissionable->nro_operation_transport }}</td>
                        <td class="text-blue">
                            {{ $commission->commissionable_type === 'App\Models\Transport' ? 'NO' : ($commission->insurance ? 'SI' : 'NO') }}
                        </td>
                        <td>${{ $commission->cost_of_sale }}</td>
                        <td>${{ $commission->net_cost }}</td>
                        <td>${{ $commission->utility }}</td>
                        <td>${{ $commission->gross_profit }}</td>
                        <td>{{ $commission->pure_points }}</td>
                        <td>{{ $commission->additional_points }}</td>
                        <td>
                            <div class="custom-badge status-info">
                                ${{ $commission->distributed_profit }}
                            </div>
                        </td>
                        <td>${{ $commission->remaining_balance }}</td>
                        <td>
                            <div class="custom-badge status-success">
                                $ {{ number_format($commission->generated_commission, 2) }}
                            </div>
                        </td>
                        <td>
                           -
                        </td>
                    </tr>
                @endforeach

                <!-- Fila de Totales (Aduana + Transporte) -->
                <tr class="table-success">
                    <td colspan="3" class="text-center"><strong>Total Gastos Locales (Aduana + Transporte)</strong></td>
                    <td>${{ number_format($localCommissions->sum('cost_of_sale'), 2) }}</td>
                    <td>${{ number_format($localCommissions->sum('net_cost'), 2) }}</td>
                    <td>${{ number_format($localCommissions->sum('utility'), 2) }}</td>
                    <td>${{ number_format($localCommissions->sum('gross_profit'), 2) }}</td>
                    <td>{{ $localCommissions->sum('pure_points') }}</td>
                    <td>{{$localCommissions->sum('additional_points') }}</td>
                    <td class="text-center">${{ number_format($localCommissions->sum('distributed_profit'), 2) }}</td>
                    <td>${{ number_format($localCommissions->sum('remaining_balance'), 2) }}</td>
                    <td class="text-center text-success">${{ number_format($localCommissions->sum('generated_commission'), 2) }}</td>
                    <td>
                        <!-- Botones para calcular puntos y profit para los gastos locales -->
                        <button class="btn btn-primary btn-sm"
                                onclick="confirmPointsGeneration({{ $localCommissions->sum('remaining_balance') }}, 'local')">Calcular
                            puntos</button>
                        <button class="btn btn-secondary btn-sm"
                                @if (!$canGenerateProfit['local']) disabled @endif
                                onclick="confirmProfitGeneration({{ $localCommissions->sum('remaining_balance') }}, 'local')">Calcular
                            profit</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endif




        <!-- Comisiones de Aduana -->
        {{--  @if ($customCommissions->isNotEmpty())
            <div class="col-12 my-3">
                <h4 class="text-center text-indigo">Aduana</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">N° de cotización</th>
                            <th scope="col">Aduana</th>
                            <th scope="col">Seguro</th>
                            <th scope="col">Costo Venta</th>
                            <th scope="col">Costo Neto</th>
                            <th scope="col">Utilidad</th>
                            <th scope="col">Ganancia</th>
                            <th scope="col">Puntos Puros</th>
                            <th scope="col">Puntos Adicionales</th>
                            <th scope="col">Profit</th>
                            <th scope="col">Saldo</th>
                            <th scope="col">Comisión Generada</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customCommissions as $commission)
                            <tr>
                                <td class="text-indigo text-bold">
                                    {{ $commission->commissionable->commercial_quote->nro_quote_commercial }}</td>
                                <td>{{ $commission->commissionable->nro_operation_custom }}</td>
                                <td class="text-blue">{{ $commission->insurance ? 'SI' : 'NO' }}</td>
                                <td>${{ $commission->cost_of_sale }}</td>
                                <td>${{ $commission->net_cost }}</td>
                                <td>${{ $commission->utility }}</td>
                                <td>${{ $commission->gross_profit }}</td>
                                <td>{{ $commission->pure_points }}</td>
                                <td>{{ $commission->additional_points }}</td>
                                <td>
                                    <div class="custom-badge status-info">
                                        ${{ $commission->distributed_profit }}
                                    </div>
                                </td>
                                <td>${{ $commission->remaining_balance }}</td>
                                <td>
                                    <div class="custom-badge status-success">
                                        $ {{ number_format($commission->generated_commission, 2) }}
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm"
                                        onclick="confirmPointsGeneration({{ $commission->remaining_balance }}, {{ $commission->id }})">Calcular
                                        puntos</button>
                                    <button class="btn btn-secondary btn-sm"
                                        @if (!$canGenerateProfit['custom']) disabled @endif
                                        onclick="confirmProfitGeneration({{ $commission->remaining_balance }}, {{ $commission->id }})">Calcular
                                        profit</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif --}}

        <!-- Comisiones de Transporte -->
        {{--  @if ($transportCommissions->isNotEmpty())
            <div class="col-12 my-3">
                <h4 class="text-center text-indigo">Transporte</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">N° de cotización</th>
                            <th scope="col">Transporte</th>
                            <th scope="col">Costo Venta</th>
                            <th scope="col">Costo Neto</th>
                            <th scope="col">Utilidad</th>
                            <th scope="col">Ganancia</th>
                            <th scope="col">Puntos Puros</th>
                            <th scope="col">Puntos Adicionales</th>
                            <th scope="col">Profit</th>
                            <th scope="col">Saldo</th>
                            <th scope="col">Comisión Generada</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transportCommissions as $commission)
                            <tr>
                                <td class="text-indigo text-bold">
                                    {{ $commission->commissionable->commercial_quote->nro_quote_commercial }}</td>
                                <td>{{ $commission->commissionable->nro_operation_transport }}</td>
                                <td>${{ $commission->cost_of_sale }}</td>
                                <td>${{ $commission->net_cost }}</td>
                                <td>${{ $commission->utility }}</td>
                                <td>${{ $commission->gross_profit }}</td>
                                <td>{{ $commission->pure_points }}</td>
                                <td>{{ $commission->additional_points }}</td>
                                <td>
                                    <div class="custom-badge status-info">
                                        ${{ $commission->distributed_profit }}
                                    </div>
                                </td>
                                <td>${{ $commission->remaining_balance }}</td>
                                <td>
                                    <div class="custom-badge status-success">
                                        $ {{ number_format($commission->generated_commission, 2) }}
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm"
                                        onclick="confirmPointsGeneration({{ $commission->remaining_balance }}, {{ $commission->id }})">Calcular
                                        puntos</button>
                                    <button class="btn btn-secondary btn-sm"
                                        @if (!$canGenerateProfit['transport']) disabled @endif
                                        onclick="confirmProfitGeneration({{ $commission->remaining_balance }}, {{ $commission->id }})">Calcular
                                        profit</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif --}}


    </div>

@stop

@push('scripts')
    <script>
        // Función para mostrar la alerta de confirmación antes de generar los puntos
        function confirmPointsGeneration(remainingBalance, commissionType) {
            // Calcular los puntos a generar
            const points = Math.floor(remainingBalance / 45);
            //Grupo de la comisiones gestionadas actualmente
            let commissionsGroup = @json($commissionsGroup->id);

            if (points > 0) {
                // Mostrar la alerta de SweetAlert
                Swal.fire({
                    title: '¿Estás seguro?',
                    html: `Vas a generar <strong class="text-indigo">${points}</strong> puntos adicionales para este servicio. ¿Deseas continuar?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, generar puntos',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `/commissions/seller/generate/points/${commissionType}/${commissionsGroup}`;
                    }
                });

            } else {

                Swal.fire({
                    icon: "error",
                    title: "Sin saldo restante",
                    html: `Estimado vendedor, ya no puede generar puntos adicionales por que tiene un saldo restante de <strong>$ ${remainingBalance}</strong>, recuerde que el minimo para poder generar puntos es de <strong>$ 45.00</strong>`,
                });

            }

        }


        function confirmProfitGeneration(profit, commissionType) {
            // Calcular los puntos a generar
            const sellerProfit = profit / 2;
            let commissionsGroup = @json($commissionsGroup->id);

            // Mostrar la alerta de SweetAlert
            Swal.fire({
                title: '¿Estás seguro?',
                html: `Estimado vendedor usted es candidado para obtener un profit del 50% de la ganancia, el monto que obtendra sera <strong class="text-indigo">$${sellerProfit}</strong> y el otro 50% sera para la empresa, ¿Esta de acuerdo?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, generar profit',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/commissions/seller/generate/profit/${commissionType}/${commissionsGroup}`;
                }
            });
        }
    </script>
@endpush
