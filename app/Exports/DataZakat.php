<?php

namespace App\Exports;

use App\Models\Zakat;
use Maatwebsite\Excel\Concerns\FromArray;

class DataZakat implements FromArray
{
    public function array() : array
    {
        $data = Zakat::select('nik', 'nama', 'zm', 'za', 'zf', 'total')->get()->toArray();

        return [
            ['nik', 'nama', "zakat ma'al", "zakat at-zira'ah", 'zakat fitrah', 'total'],
            ...$data
        ];
    }
}
