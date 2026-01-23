<?php

namespace Database\Seeders;

use App\Models\RequiredDocumentConfig;
use Illuminate\Database\Seeder;

class RequiredDocumentConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Documentos requeridos para Flete (flete)
        RequiredDocumentConfig::create([
            'service_type' => 'Flete',
            'document_name' => 'Routing Order',
            'is_required' => true,
            'is_auto_generated' => true,
            'order' => 1,
            'description' => 'Se genera automáticamente al confirmar recepción de carga',
        ]);

        RequiredDocumentConfig::create([
            'service_type' => 'Flete',
            'document_name' => 'Factura Comercial',
            'is_required' => true,
            'is_auto_generated' => false,
            'order' => 2,
            'description' => 'Documento comercial obligatorio del proveedor',
        ]);

        // Documentos requeridos para Aduanal (Customs)
        RequiredDocumentConfig::create([
            'service_type' => 'Aduanas',
            'document_name' => 'Declaración Aduanal',
            'is_required' => true,
            'is_auto_generated' => false,
            'order' => 1,
            'description' => 'Documento aduanal obligatorio',
        ]);

        RequiredDocumentConfig::create([
            'service_type' => 'Aduanas',
            'document_name' => 'Factura Comercial',
            'is_required' => true,
            'is_auto_generated' => false,
            'order' => 2,
            'description' => 'Factura del proveedor',
        ]);

        // Documentos requeridos para Transporte (Transport)
        RequiredDocumentConfig::create([
            'service_type' => 'Transporte',
            'document_name' => 'Guía de Remisión',
            'is_required' => true,
            'is_auto_generated' => false,
            'order' => 1,
            'description' => 'Comprobante de transporte',
        ]);
    }
}
