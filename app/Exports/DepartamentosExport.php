<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DepartamentosExport implements FromCollection, WithHeadings
{
    Use Exportable;
    protected $deptos;

    public function __construct($deptos = null)
    {
        $this->deptos = $deptos;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return  $this->deptos;
    }

    public function headings(): array
    {
        return [
            'Departamento ID',
            'Numero Departamento',
            'Numero Serie ',
            'Lectura anterior',
            'Lectura actual',
        ];
    }
}
