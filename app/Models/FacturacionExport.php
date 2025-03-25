<?php

namespace App\Models;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FacturacionExport implements FromCollection, WithHeadings
{
    protected $filtAdmincitasTable;

    public function __construct(array $filtAdmincitasTable)
    {
        $this->filtAdmincitasTable = $filtAdmincitasTable;
    }

    public function collection()
    {
        return collect($this->filtAdmincitasTable);
    }

    public function headings(): array
    {
        return [
            'Cantidad (€)',
            'Ref',
            'Guía',
            'Cliente',
            'Visita',
            'Idioma',
            'Fecha',
            'Hora',
        ];
    }

    


}
