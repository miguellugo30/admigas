<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LecturasDepartamentosExport;
use App\AdmigasDepartamentos;
use App\Http\Controllers\ExportarLecturasExcelController;
use Illuminate\Support\Facades\Log;

class donwloadFotosLecturasController extends Controller
{
    private $exportar;

    public function __construct(
        ExportarLecturasExcelController $exportar
    ) {

        $this->exportar = $exportar;
    }

    public function donwloadFotos($condominio, $empresa_id, $fecha_lectura, $tipo = 'Fotos')
    {
        $dirCondomino = str_replace(" ", "_", $condominio->nombre . "_" . $condominio->id);

        $this->validateRutaLocal($condominio->id, $fecha_lectura, $empresa_id);
        $dir = $this->dirCloud( $dirCondomino );
        /**
         * Obtenemos los directorios del condominio
         **/
        $e = collect(Storage::cloud()->listContents($dir['path'], false));
        Log::debug($e);

        $dirFotos = $e->where('type', '=', 'dir')->where('name', '=', 'Fotos')->first();
        if ( $tipo == 'Iniciales')
        {
            $dirFotos = $e->where('type', '=', 'dir')->where('name', '=', 'Iniciales')->first();
            Log::debug($dirFotos);

        }

        if (!$dirFotos) {
            return 'No existe el directorio de las fotos!';
            Log::debug('No existe el directorio de las fotos.');
        }
        /**
         * Obtenemos los contenidos de los directorios
         */
        $fotos = collect(Storage::cloud()->listContents($dirFotos['path'], false));
        Log::debug($fotos);
        /**
         * Descargamos las fotos de las lecturas
         */
        foreach ($fotos as  $foto) {
            $rawData = Storage::cloud()->get($foto['path']);
            $infoDepto = AdmigasDepartamentos::select('id')->where('numero_departamento', str_replace('.jpeg', '', $foto['name'] ) )->where('admigas_condominios_id', $condominio->id )->first();
            $name = $infoDepto->id."_".$foto['name'];
            Log::debug($name);
            Log::debug('/' . $empresa_id . '\/' . $condominio->id. '\/' . $fecha_lectura . '\/' . $name);
            Storage::put('/' . $empresa_id . '\/' . $condominio->id. '\/' . $fecha_lectura . '\/' . $name, $rawData);
        }
    }
    /**
     * Creamos los directorios localmente
     */
    public function validateRutaLocal($dirCondomino, $fecha_lectura, $empresa_id)
    {
        /**
         * Validamos que exista la carpeta de la empresa
         */
        if (!Storage::exists('/' . $empresa_id)) {
            Storage::makeDirectory('/' . $empresa_id);
        }
        /**
         * Validamos que exista la carpeta del condominio
         */
        if (!Storage::exists('/' . $empresa_id . '\/' . $dirCondomino)) {
            Storage::makeDirectory('/' . $empresa_id . '\/' . $dirCondomino);
        }
        /**
         * Validamos que exista la fecha de la lectura
         */
        if (!Storage::exists('/' . $empresa_id . '\/' . $dirCondomino . '\/' . $fecha_lectura)) {
            Storage::makeDirectory('/' . $empresa_id . '\/' . $dirCondomino . '\/' . $fecha_lectura);
        }
    }
    /**
     * Descargamos e importalos la informacion de las lecturas
     */
    public function importLecturas($condominio, $empresa_id, $fecha_lectura)
    {
        $dirCondomino = str_replace( " ", "_", $condominio->nombre . "_" . $condominio->id );

        $this->validateRutaLocal($condominio->id, $fecha_lectura, $empresa_id);
        $dir = $this->dirCloud($dirCondomino);
        /**
         * Obtenemos el directorio de las fotos
         **/
        $e = collect(Storage::cloud()->listContents($dir['path'], false));
        $dirLecturas = $e->where('type', '=', 'dir')->where('name', '=', 'Lecturas')->first();
        if (!$dirLecturas) {
            return 'No existe el directorio de las lecturas!';
            Log::debug('No existe el directorio de las lecturas.');
        }
        /**
         * Obtenemos el archivo
         */
        $lecturas = collect(Storage::cloud()->listContents($dirLecturas['path'], false));
        Log::debug($lecturas);
        $rawData = Storage::cloud()->get($lecturas[0]['path']);
        /**
         * Descargamos el excel de las lecturas
         */
        Storage::put('/' . $empresa_id . '\/' . $condominio->id . '\/' . $fecha_lectura . '\/' . $lecturas[0]['name'], $rawData);

        if( Storage::exists('/' . $empresa_id . '\/' . $condominio->id . '\/' . $fecha_lectura . '\/' . $lecturas[0]['name']) )
        {
            return Excel::toCollection(new LecturasDepartamentosExport(), '/' . $empresa_id . '\/' . $condominio->id . '\/' . $fecha_lectura . '\/' . $lecturas[0]['name'])->first();
        }
        else
        {
            return false;
        }


    }
    /**
     * Listamos lo que contiene el directorios raiz
     */
    public function dirCloud($dirCondomino)
    {
        /**
         * Obtenemos todos los directorios y buscamos el del condominios
         */
        $e = collect(Storage::cloud()->listContents('/', true));
        $dir = $e->where('type', '=', 'dir')->where('name', '=', $dirCondomino)->first();
        if (!$dir) {
            return false;
        }
        return $dir;
    }
    /**
     * Validamos que exsite el directorio de lecturas
     */
    public function dirLecturas($path)
    {
        $e = collect(Storage::cloud()->listContents($path, false));
        $dirLecturas = $e->where('type', '=', 'dir')->where('name', '=', 'Lecturas')->first();
        if (!$dirLecturas) {
            return false;
        }
        return $dirLecturas;
    }
    /**
     * Validamos que exsite el directorio de fotos
     */
    public function dirFotos($path)
    {
        $e = collect(Storage::cloud()->listContents($path, false));
        $dirFotos = $e->where('type', '=', 'dir')->where('name', '=', 'Fotos')->first();
        if (!$dirFotos) {
            return false;
        }
        return $dirFotos;
    }
    /**
     * Validamos que exsite el directorio de las fotos iniciales
     */
    public function dirFotosIniciales($path)
    {
        $e = collect(Storage::cloud()->listContents($path, false));
        $dirFotos = $e->where('type', '=', 'dir')->where('name', '=', 'Iniciales')->first();
        if (!$dirFotos) {
            return false;
        }
        return $dirFotos;
    }
    /**
     * Creamos los directorios en la nube
     */
    public function createDirectoriesCloud($condominios)
    {
        foreach ($condominios as $c)
        {
            $dirCondomino = str_replace(" ", "_", $c->nombre." ".$c->id );
            $dir = $this->dirCloud( $dirCondomino );
            if ( !$dir )
            {
                Storage::cloud()->makeDirectory('/'.$dirCondomino);
                $dir = $this->dirCloud($dirCondomino);
                Storage::cloud()->makeDirectory( $dir['path'].'/Lecturas');
                Storage::cloud()->makeDirectory( $dir['path'].'/Fotos');
                $dirLecturas = $this->dirLecturas($dir['path'] . '/Fotos');
                /**
                 * Eliminamos el excel existente
                 */
                //Storage::cloud()->allFiles($dirLecturas['path']);
                //Log::debug($dirLecturas['path']);
                /**
                 * Creamamos el excel de las lecturas
                 */
                $this->exportar->exportLecturasExcel( $c->id, $dirLecturas['path'] );
            }
            else
            {
                /**
                 * Validamos que exista el directorio de fotos
                 */
                if (!$this->dirFotos($dir['path']))
                {
                    Storage::cloud()->makeDirectory($dir['path'] . '/Fotos');
                }
                /**
                 * Validamos que exista el directorio de lecturas
                 */
                $dirLecturas = $this->dirLecturas($dir['path']);
                if (!$dirLecturas)
                {
                    Storage::cloud()->makeDirectory($dir['path'] . '/Lecturas');
                }
                /**
                 * Eliminamos el excel existente
                 */
                $archivos = collect(Storage::cloud()->listContents($dirLecturas['path'], false));
                foreach ($archivos as $e)
                {
                    Storage::cloud()->delete($e['path']);
                    Log::debug($e['path']);
                }
                /**
                 * Creamamos el excel de las lecturas
                 */
                $this->exportar->exportLecturasExcel($c->id, $dirLecturas['path']);
            }
        }
    }
}
