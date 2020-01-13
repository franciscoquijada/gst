<?php

namespace App\Exports;

use App\Department;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DepartmentExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return [
            'Nombre',
            'Fecha de Creacion',
            'Usuarios',
            'Centros de Costos',
        ];
    }

    public function collection()
    {
        return Department::select('name','created_at')->withCount(['users', 'cost_centers'])->get();
    }
}
