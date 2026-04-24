<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReporteRecibosGeneradosExport implements FromArray, WithHeadings
{
    use Exportable;
    protected $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

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
            'Referencia',
            'Gasto de Admin',
            'Adeudo Anterior',
            'Cargos Adicionales',
            'Importe',
            'Total a pagar',
            'Fecha Recibo',
            'Fecha Limite Pago',
            'Pago'
        ];

    }
}
