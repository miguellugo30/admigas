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

    public function exportLecturasExcel($id)
    {

        $deptos =  $this->query->queryExcelLecturas(1);
        Excel::store(new DepartamentosExport($deptos), '/1sK-Y6A0Bm-VHFR4vvV_-Pe2TFX0skVZ5/13CDwYFECsNZcMtaqllKdacV9Vur5Gfcv/1XA5j6bw0GNU4SDdUdjX_XQ2YkH5Kxn8U/lecturas.xlsx', 'google' );
        //return (new DepartamentosExport($deptos))->download('lecturas.xlsx');
    }
}
