<?php

namespace App\Console\Commands;

use App\Models\QuotesSentClient;
use App\Models\ResponseFreightQuotes;
use App\Models\ResponseTransportQuote;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateExpiredRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-expired-records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar el estado de los registros cuya fecha de validez ha pasado';

    protected $models = [
        ResponseFreightQuotes::class,
        ResponseTransportQuote::class,
        QuotesSentClient::class,
        // Agrega más modelos si es necesario
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach ($this->models as $model) {
            // Obtener todos los registros del modelo donde la fecha de validez ha pasado
            $expiredRecords = $model::where('valid_until', '<', Carbon::now())->get();

            foreach ($expiredRecords as $record) {
                // Actualizar el estado del registro
                $record->status = 'Caducado'; // O el estado que desees asignar
                $record->save();
            }

            $this->info("Registros expirados de {$model} actualizados.");
        }
    }
}
