<?php

namespace App\Http\Controllers;

use App\Http\Controllers\QuerysJoinController;
use Illuminate\Http\Request;
use App\Exports\DepartamentosExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportarLecturasExcelController extends Controller
{
    private $query;

    public function __construct(
        QuerysJoinController $query
    ) {

        $this->query = $query;
    }

    public function exportLecturasExcel($id, $path)
    {

        $deptos =  $this->query->queryExcelLecturas( $id );
        Excel::store(new DepartamentosExport($deptos), $path.'/lecturas.xlsx', 'google' );
    }
}
