<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Retorna clientes con el personal asignado y paginacion.
     */
    public function index(Request $request)
    {
        $hasPagination = $request->has('per_page') || $request->has('page');

        $query = Customer::query()
            ->with([
                'personal:id,names,last_name,mother_last_name',
                'document:id,name',
            ])
            ->select([
                'id',
                'document_number',
                'id_document',
                'name_businessname',
                'address',
                'contact_name',
                'contact_number',
                'contact_email',
                'state',
                'type',
                'id_personal',
            ])
            ->orderByDesc('id')
            ->where('type', 'cliente');


        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('name_businessname', 'like', "%{$search}%")
                    ->orWhere('document_number', 'like', "%{$search}%");
            });
        }


        if ($request->has('state')) {
            $state = strtolower(trim((string) $request->state));
            if (in_array($state, ['activo', 'inactivo'], true)) {
                $query->where('state', $state);
            }
        }

        if ($hasPagination) {
            $perPage = (int) $request->input('per_page', 15);
            $page = (int) $request->input('page', 1);
            $perPage = max(1, min($perPage, 100));
            $page = max(1, $page);

            $customersPaginated = $query->paginate($perPage, ['*'], 'page', $page);
            $customers = $customersPaginated->getCollection()->map(function ($customer) {
                $personal = $customer->personal;
                $document = $customer->document;
                $fullName = trim(implode(' ', array_filter([
                    optional($personal)->names,
                    optional($personal)->last_name,
                    optional($personal)->mother_last_name,
                ])));

                return [
                    'id' => $customer->id,
                    'document_number' => $customer->document_number,
                    'name_businessname' => $customer->name_businessname,
                    'address' => $customer->address,
                    'contact_name' => $customer->contact_name,
                    'contact_number' => $customer->contact_number,
                    'contact_email' => $customer->contact_email,
                    'state' => $customer->state,
                    'type' => $customer->type,
                    'document' => $document ? [
                        'id' => $customer->id_document,
                        'name' => $document->name,
                    ] : null,
                    'personal' => $personal ? [
                        'id' => $customer->id_personal,
                        'full_name' => $fullName,
                    ] : null,
                ];
            });
            $customersPaginated->setCollection($customers);

            return response()->json([
                'customers' => $customersPaginated->items(),
                'pagination' => [
                    'current_page' => $customersPaginated->currentPage(),
                    'per_page' => $customersPaginated->perPage(),
                    'total' => $customersPaginated->total(),
                    'last_page' => $customersPaginated->lastPage(),
                    'from' => $customersPaginated->firstItem(),
                    'to' => $customersPaginated->lastItem(),
                ],
            ]);
        } else {
            $customers = $query->get()->map(function ($customer) {
                $personal = $customer->personal;
                $document = $customer->document;
                $fullName = trim(implode(' ', array_filter([
                    optional($personal)->names,
                    optional($personal)->last_name,
                    optional($personal)->mother_last_name,
                ])));

                return [
                    'id' => $customer->id,
                    'document_number' => $customer->document_number,
                    'name_businessname' => $customer->name_businessname,
                    'address' => $customer->address,
                    'contact_name' => $customer->contact_name,
                    'contact_number' => $customer->contact_number,
                    'contact_email' => $customer->contact_email,
                    'state' => $customer->state,
                    'type' => $customer->type,
                    'document' => $document ? [
                        'id' => $customer->id_document,
                        'name' => $document->name,
                    ] : null,
                    'personal' => $personal ? [
                        'id' => $customer->id_personal,
                        'full_name' => $fullName,
                    ] : null,
                ];
            });

            return response()->json([
                'customers' => $customers,
                'count' => $customers->count(),
                'pagination' => null,
            ]);
        }
    }
}
