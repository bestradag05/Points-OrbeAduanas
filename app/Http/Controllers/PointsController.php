<?php

namespace App\Http\Controllers;

use App\Exports\AdditionalExport;
use App\Exports\CustomsExport;
use App\Exports\FreightExport;
use App\Exports\InsuranceExport;
use App\Exports\TransportExport;
use App\Models\AdditionalPoints;
use App\Models\Custom;
use App\Models\Freight;
use App\Models\Insurance;
use App\Models\Personal;
use App\Models\Transport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PointsController extends Controller
{

    public function getPointCustoms(Request $request)
    {
        return $this->getPointsService($request, 'custom');
    }

    public function getPointFreight(Request $request)
    {

        return $this->getPointsService($request, 'freight');
    }

    public function getPointTransport(Request $request)
    {

        return $this->getPointsService($request, 'transport');
    }



    public function getPointInsurance(Request $request)
    {
        $personals = Personal::whereHas('user.roles', function ($query) {
            $query->where('name', 'Asesor Comercial');
        })->where(function ($query) {
            $query->whereHas('routing.custom.insurance', function ($subQuery) {
                $subQuery->where('state', 'Generado')->where('model_insurable_service', Custom::class);
            })->orWhereHas('routing.freight.insurance', function ($subQuery) {
                $subQuery->where('state', 'Generado')->where('model_insurable_service', Freight::class);
            });
        })->with([
                'routing.custom.insurance' => function ($query) {
                    $query->where('state', 'Generado')->where('model_insurable_service', Custom::class);
                },
                'routing.freight.insurance' => function ($query) {
                    $query->where('state', 'Generado')->where('model_insurable_service', Freight::class);
                }
            ])->get();


        $startDate = $request->startDate ? Carbon::parse($request->startDate)->startOfDay() : Carbon::now()->startOfMonth()->startOfDay();
        $endDate = $request->endDate ? Carbon::parse($request->endDate)->endOfDay() : Carbon::now()->endOfMonth()->endOfDay();


        $personalPoints = $personals->map(function ($personal) use ($startDate, $endDate) {

            // Ahora que tenemos los personales, obtenemos los routing y comenzamos a filtrar
            $filteredRouting = $personal->routing->filter(function ($route) use ($startDate, $endDate) {

                $points = 0;

                // Verificar si el routing tiene un custom con insurance dentro de las fechas
                if ($route->custom && $route->custom->insurance) {
                    $insuranceDate = $route->custom->insurance->created_at;
                    if ($insuranceDate >= $startDate && $insuranceDate <= $endDate) {
                        $points++; // Suma 1 punto si el custom tiene un insurance válido
                    }
                }

                // Verificar si el routing tiene un freight con insurance dentro de las fechas
                if ($route->freight && $route->freight->insurance) {
                    $insuranceDate = $route->freight->insurance->created_at;
                    if ($insuranceDate >= $startDate && $insuranceDate <= $endDate) {
                        $points++; // Suma 1 punto si el freight tiene un insurance válido
                    }
                }

                // Solo incluimos el routing si tiene al menos 1 punto
                return $points > 0;
            });

            // Sumar los puntos para todos los routing filtrados
            $count = $filteredRouting->reduce(function ($carry, $route) use ($startDate, $endDate) {
                $points = 0;

                // Sumar puntos si el custom tiene un insurance en las fechas indicadas
                if ($route->custom && $route->custom->insurance) {
                    $insuranceDate = $route->custom->insurance->created_at;
                    if ($insuranceDate >= $startDate && $insuranceDate <= $endDate) {
                        $points++;
                    }
                }

                // Sumar puntos si el freight tiene un insurance en las fechas indicadas
                if ($route->freight && $route->freight->insurance) {
                    $insuranceDate = $route->freight->insurance->created_at;
                    if ($insuranceDate >= $startDate && $insuranceDate <= $endDate) {
                        $points++;
                    }
                }

                // Agregar los puntos de este routing al total
                return $carry + $points;
            }, 0);

            // Retornar el personal con el número total de puntos
            return [
                'personal' => $personal,
                'puntos' => $count
            ];
        });


        // Ordenamos del mayor al menor
        $personalPoints = $personalPoints->sortByDesc('puntos')->values();


        //verificamos que sea una solicitud ajax para reenviar como json la informacion
        if ($request->type) {
            return response()->json($personalPoints);
        }

        return view('points/points-insurance');
    }



    public function getPointAdditional(Request $request)
    {

        $personals = Personal::whereHas('user.roles', function ($query) {
            $query->where('name', 'Asesor Comercial');
        })
            ->whereHas('routing.custom.additional_point', function ($query) {
                $query->where('state', 'Generado')->where('model_additional_service', Custom::class);
            })
            ->orWhereHas('routing.freight.additional_point', function ($query) {
                $query->where('state', 'Generado')->where('model_additional_service', Freight::class);
            })
            ->orWhereHas('routing.transport.additional_point', function ($query) {
                $query->where('state', 'Generado')->where('model_additional_service', Transport::class);
            })
            ->with([
                'routing.custom.additional_point' => function ($query) {
                    $query->where('state', 'Generado')->where('model_additional_service', Custom::class);
                },
                'routing.freight.additional_point' => function ($query) {
                    $query->where('state', 'Generado')->where('model_additional_service', Freight::class);
                },
                'routing.transport.additional_point' => function ($query) {
                    $query->where('state', 'Generado')->where('model_additional_service', Transport::class);
                }
                
            ])
            ->get();

        $startDate = $request->startDate ? Carbon::parse($request->startDate)->startOfDay() : Carbon::now()->startOfMonth()->startOfDay();
        $endDate = $request->endDate ? Carbon::parse($request->endDate)->endOfDay() : Carbon::now()->endOfMonth()->endOfDay();

        $personalPoints = $personals->map(function ($personal) use ($startDate, $endDate) {

            $customPointsTotal = 0;
            $freightPointsTotal = 0;
            $transportPointsTotal = 0;

            // Ahora que tenemos los personales, obtenemos los routing y comenzamos a filtrar
            $personal->routing->filter(function ($route) use ($startDate, $endDate, &$customPointsTotal, &$freightPointsTotal, &$transportPointsTotal) {

                // Verificar si el routing tiene un custom con puntos adicionales dentro de las fechas
                if ($route->custom && $route->custom->additional_point) {

                    $validCustomPoints = $route->custom->additional_point->filter(function ($additionalPoint) use ($startDate, $endDate) {
                        return $additionalPoint->created_at >= $startDate && $additionalPoint->created_at <= $endDate;
                    });

                    // Sumar los puntos del campo `points` en `custom`
                    $customPointsTotal += $validCustomPoints->sum('points');
                    $hasValidPoints = $validCustomPoints->isNotEmpty(); // Marcar si hay puntos válidos

                }

                // Verificar si el routing tiene un freight con adicionales dentro de las fechas
                if ($route->freight && $route->freight->additional_point) {
                    $validCustomPoints = $route->freight->additional_point->filter(function ($additionalPoint) use ($startDate, $endDate) {
                        return $additionalPoint->created_at >= $startDate && $additionalPoint->created_at <= $endDate;
                    });

                    // Sumar los puntos del campo `points` en `freight`
                    $freightPointsTotal += $validCustomPoints->sum('points');
                    $hasValidPoints = $validCustomPoints->isNotEmpty(); // Marcar si hay puntos válidos
                }

                // Verificar si el routing tiene un transport con adicionales dentro de las fechas
                if ($route->transport && $route->transport->additional_point) {
                    $validCustomPoints = $route->transport->additional_point->filter(function ($additionalPoint) use ($startDate, $endDate) {
                        return $additionalPoint->created_at >= $startDate && $additionalPoint->created_at <= $endDate;
                    });

                    // Sumar los puntos del campo `points` en `transport`
                    $transportPointsTotal += $validCustomPoints->sum('points');
                    $hasValidPoints = $validCustomPoints->isNotEmpty(); // Marcar si hay puntos válidos
                }

                // Solo incluimos el routing si tiene al menos 1 punto
                return $hasValidPoints; // Incluir el routing solo si tiene puntos válidos
            });

            $puntosTotal = $customPointsTotal + $freightPointsTotal + $transportPointsTotal;

            return [
                'personal' => $personal,
                'puntosAduanas' => $customPointsTotal,
                'puntosFlete' => $freightPointsTotal,
                'puntosTransporte' => $transportPointsTotal,
                'puntos' => $puntosTotal
            ];
        });


        $personalPoints = $personalPoints->sortByDesc('pointsTotal')->values();


        //verificamos que sea una solicitud ajax para reenviar como json la informacion
        if ($request->type) {
            return response()->json($personalPoints);
        }



        return view('points/points-additional');
    }



    public function getPointsService($request, $service)
    {
        //Obtenemos todo el personal que tenga el rol de Asesor comercial y tenga relacion con la tabla freight
        $personals = $this->getPersonalRoles($service);

        /*  echo "<script>console.log(" . json_encode($personals) . ");</script>"; */

        //Si las fechas existen, entonces lo convertimos en el formato adecuado

        // Convertir las fechas si están presentes en el formato adecuado
        $startDate = $request->startDate ? Carbon::parse($request->startDate)->startOfDay() : Carbon::now()->startOfMonth()->startOfDay();;
        $endDate = $request->endDate ? Carbon::parse($request->endDate)->endOfDay() : Carbon::now()->endOfMonth()->endOfDay();;

        //Vamos a recorrer los personales 
        $personalPoints = $personals->map(function ($personal) use ($startDate, $endDate, $service) {

            // ahora que tenemos los personales, obtenemos los routing que tienen estos personales y comenzamos a filtrar
            // Solo los routing que tenga una relacion con la tabla freight
            $filteredRouting = $personal->routing->filter(function ($route) use ($startDate, $endDate, $service) {


                // Verificar si $route->custom no es nulo antes de acceder a created_at
                if ($route->{$service}) {
                    $dateCondition = $route->{$service}->created_at >= $startDate && $route->{$service}->created_at <= $endDate;
                    return $dateCondition;
                }

                return false;
            });

            // Contar el número de registros en la tabla freigth
            $count = $filteredRouting->count();


            // Retornar el personal con el número de puntos
            return [
                'personal' => $personal,
                'puntos' => $count
            ];
        });



        // Ordenamos del mayor al menor
        $personalPoints = $personalPoints->sortByDesc('puntos')->values();


        //verificamos que sea una solicitud ajax para reenviar como json la informacion
        if ($request->type) {
            return response()->json($personalPoints);
        }

        return view('points/points-' . $service);
    }



    public function getPointDetail()
    {


        $personalPoints = $this->getPersonalRoles(null);


        return view('points/points-detail', compact('personalPoints'));
    }




    public function getPersonalRoles($relationship)
    {

        if ($relationship != null) {

            return Personal::whereHas('user.roles', function ($query) {
                $query->where('name', 'Asesor Comercial');
            })->with(['routing.' . $relationship => function ($query) {
                // Filtrar los registros de la tabla custom por estado 'Punto'
                $query->where('state', 'Generado');
            }])->get();
        } else {
            return Personal::whereHas('user.roles', function ($query) {
                $query->where('name', 'Asesor Comercial');
            })->get();
        }
    }



    public function exportCustom(Request $request, $type)
    {

        if ($type === 'excel') {

            return Excel::download(new CustomsExport($request->startDate, $request->endDate), 'customs.xlsx');

        } else if ($type === 'pdf') {

            $customs = Custom::whereBetween('date_register', [$request->startDate, $request->endDate])
            ->where('state', 'Generado') // Ajusta "estado" al nombre correcto de tu columna
            ->get();


            // Genera el PDF
            $pdf = Pdf::loadView('points.exports.custom.custom-export', compact('customs'));

            // Opcional: Configura el tamaño de página y orientación
            $pdf->setPaper('A4', 'landscape');

            // Descarga el PDF
            return $pdf->stream('customs.pdf');
        }
    }

    public function exportFreight(Request $request, $type)
    {

        if ($type === 'excel') {

            return Excel::download(new FreightExport($request->startDate, $request->endDate), 'freight.xlsx');

        } else if ($type === 'pdf') {

            $freights = Freight::whereBetween('date_register', [$request->startDate, $request->endDate])
            ->where('state', 'Generado') // Ajusta "estado" al nombre correcto de tu columna
            ->get();

            // Genera el PDF
            $pdf = Pdf::loadView('points.exports.freight.freight-export', compact('freights'));

            // Opcional: Configura el tamaño de página y orientación
            $pdf->setPaper('A4', 'landscape');

            // Descarga el PDF
            return $pdf->stream('freight.pdf');
        }
    }


    public function exportTransport(Request $request, $type)
    {

        if ($type === 'excel') {

            return Excel::download(new TransportExport($request->startDate, $request->endDate), 'transport.xlsx');

        } else if ($type === 'pdf') {

            $transports = Transport::whereBetween('date_register', [$request->startDate, $request->endDate])
            ->where('state', 'Generado') // Ajusta "estado" al nombre correcto de tu columna
            ->get();

            // Genera el PDF
            $pdf = Pdf::loadView('points.exports.transport.transport-export', compact('transports'));

            // Opcional: Configura el tamaño de página y orientación
            $pdf->setPaper('A4', 'landscape');

            // Descarga el PDF
            return $pdf->stream('transport.pdf');
        }
    }

    public function exportInsurance(Request $request, $type)
    {

        if ($type === 'excel') {

            return Excel::download(new InsuranceExport($request->startDate, $request->endDate), 'insurance.xlsx');

        } else if ($type === 'pdf') {

            $insurances = Insurance::whereBetween('date', [$request->startDate, $request->endDate])
            ->where('state', 'Generado') // Ajusta "estado" al nombre correcto de tu columna
            ->get();

            // Genera el PDF
            $pdf = Pdf::loadView('points.exports.insurance.insurance-export', compact('insurances'));

            // Opcional: Configura el tamaño de página y orientación
            $pdf->setPaper('A4', 'landscape');

            // Descarga el PDF
            return $pdf->stream('insurance.pdf');
        }
    }

    public function exportAdditional(Request $request,$type)
    {

        if ($type === 'excel') {

            return Excel::download(new AdditionalExport($request->startDate, $request->endDate), 'additional.xlsx');

        } else if ($type === 'pdf') {

            $additionals = AdditionalPoints::whereBetween('date_register', [$request->startDate, $request->endDate])
            ->where('state', 'Generado') // Ajusta "estado" al nombre correcto de tu columna
            ->get();

            // Genera el PDF
            $pdf = Pdf::loadView('points.exports.additional.additional-export', compact('additionals'));

            // Opcional: Configura el tamaño de página y orientación
            $pdf->setPaper('A4', 'landscape');

            // Descarga el PDF
            return $pdf->stream('additional.pdf');
        }
    }


}
