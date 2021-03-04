<?php

namespace App\Exports;

use App\Group;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GroupExport implements FromCollection,WithHeadings
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
        ];
    }

    public function collection()
    {
        return Group::select('name','created_at')
            ->withCount(['users'])
            ->get();
    }
}
