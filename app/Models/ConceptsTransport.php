<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptsTransport extends Model
{
    use HasFactory;
    protected $table = 'concepts_transport';


        // Inversa N:1 → Transport
    public function transport()
    {
        return $this->belongsTo(Transport::class, 'transport_id');
    }
        // Inversa N:1 → Concept
    public function concept()
    {
        return $this->belongsTo(Concept::class, 'concepts_id');
    }


}
