<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\DeptosFechaLimite;

class deptosProximosVencer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:deptosProximosVencer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar notificacion a departamentos con fecha limite a vencer';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    private $deptos;

    public function __construct( DeptosFechaLimite $deptos )
    {
        parent::__construct();
        $this->deptos = $deptos;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->deptos->DeptosProximoVencer();
    }
}
