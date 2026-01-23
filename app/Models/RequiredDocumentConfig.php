<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequiredDocumentConfig extends Model
{
    use HasFactory;

    protected $table = 'required_document_configs';

    protected $fillable = [
        'service_type',
        'document_name',
        'is_required',
        'is_auto_generated',
        'order',
        'description',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_auto_generated' => 'boolean',
    ];

    /**
     * Obtener todos los documentos requeridos por tipo de servicio
     */
    public static function getRequiredByService($serviceType)
    {
        return self::where('service_type', $serviceType)
            ->where('is_required', true)
            ->orderBy('order')
            ->get();
    }
}
