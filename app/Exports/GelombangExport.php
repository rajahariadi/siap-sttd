<?php

namespace App\Exports;

use App\Models\Gelombang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class GelombangExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Gelombang::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Gelombang',
            'Created At',
        ];
    }

    public function map($gelombang): array
    {
        static  $no = 1;
        return [
            $no++,
            $gelombang->name,
            $gelombang->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
