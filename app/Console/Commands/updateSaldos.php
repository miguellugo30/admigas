<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ActualizarSaldosController;

class updateSaldos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:saldo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar los saldos de los departamentos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    private $saldo;
    public function __construct(ActualizarSaldosController $saldo)
    {
        parent::__construct();
        $this->saldo = $saldo;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->saldo->updateSaldos();
    }
}
