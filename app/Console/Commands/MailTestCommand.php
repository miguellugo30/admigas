<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class MailTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía un correo de prueba para validar configuración de correo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $to = $this->argument('to');

        try {
            Mail::raw('Este es un correo de prueba enviado desde Laravel 🚀', function ($message) use ($to) {
                $message->to($to)
                        ->subject('Correo de prueba Laravel');
            });

            $this->info("✅ Correo enviado correctamente a: {$to}");
        } catch (\Exception $e) {
            $this->error("❌ Error enviando correo: " . $e->getMessage());
        }
    }
}
