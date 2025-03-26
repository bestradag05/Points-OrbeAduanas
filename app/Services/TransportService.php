<?php

namespace App\Services;

use App\Models\Supplier;
use App\Models\Transport;

class TransportService {



    public function editTransport(string $id){

        $transport = Transport::with('concepts.concept_transport.additional_point')->find($id);
        $suppliers = Supplier::all();

        return compact('transport', 'suppliers');

    }



}