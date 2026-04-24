<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\donwloadFotosLecturasController;
use \DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterDepto;

class HomeController extends Controller
{
    private $cloud;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(donwloadFotosLecturasController $cloud )
    {
        $this->middleware('auth');
        $this->cloud = $cloud;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if ( \Auth::user()->tipo == 1 ) {
            return redirect('clientes');
        } else {
            return view('home');
        }

    }

    public function directorios()
    {

        /**
         * Obtenemos los condominios de la empresa
         */
        $condominios = DB::select("call SP_condominios_empresa( 1 )");
        $this->cloud->createDirectoriesCloud( $condominios );
        //dd(Storage::cloud()->listContents('/', true));
	//Mail::to('mchlugo@hotmail.com')->send(new RegisterDepto('Miguel Chavez', '12345'));
	//Mail::to('ingmchlugo@gmail.com')->send(new RegisterDepto('Miguel Chavez', '12345'));
    }
}
