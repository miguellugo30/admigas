<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ReporteLitrosExport implements FromArray, WithHeadings
{
    use Exportable;
    protected $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */

    public function array() : array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Unidad',
            'Edificio',
            'Departamento',
            'Periodo',
            'Lectura Inicial',
            'Lectura Final',
            'M 3',
            'Litros',
        ];
    }
}
