<?php

namespace App\Exports;

use App\Models\Gelombang;
use Maatwebsite\Excel\Concerns\FromCollection;

class GelombangExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Gelombang::all();
    }
}
