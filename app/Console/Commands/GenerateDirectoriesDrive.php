<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\donwloadFotosLecturasController;
use \DB;

class GenerateDirectoriesDrive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:directories {empresa_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea los directorios de edificios en el drive';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    private $cloud;

    public function __construct(donwloadFotosLecturasController $cloud )
    {
        parent::__construct();
        $this->cloud = $cloud;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $condominios = DB::select("call SP_condominios_empresa( ". $this->argument('empresa_id')." )");
        $this->cloud->createDirectoriesCloud($condominios);
    }
}
