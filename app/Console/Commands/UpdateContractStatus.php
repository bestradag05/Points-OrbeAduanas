<?php

namespace App\Console\Commands;

use App\Models\Contract;
use Illuminate\Console\Command;

class UpdateContractStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contracts:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza el contrato cuando llega al fin de su fecha';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Contract::where('end_date', '<=' , now())
        ->where('state', '!=', 'Vencido')
        ->update(['state' => 'Vencido']);

        $this->info('Estado del contracto fuera de plazo actualizado correctamente');
    }
}
