<?php

namespace App\Services;

use App\Models\Freight;
use App\Models\FreightDocuments;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FreightDocumentService
{


    public function storeFreightDocument(Freight $freight, string $fileContent, string $filename, ?string $extension = null): FreightDocuments
    {
        $folder = 'commercial_quote/' . $freight->commercial_quote->nro_quote_commercial . '/freight';

        // Si no se pasó la extensión, la extraemos del $filename
        if (!$extension) {
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
        }

        // Generar nombre encriptado con extensión
        $encryptedName = Str::random(40) . '.' . $extension;

        $path = $folder . '/' . $encryptedName;

        Storage::disk('public')->put($path, $fileContent);

        return FreightDocuments::create([
            'name' => pathinfo($filename, PATHINFO_FILENAME), // muestra sin extensión
            'path' => Storage::url($path),
            'id_freight' => $freight->id
        ]);
    }
}
