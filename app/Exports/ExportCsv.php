<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ExportCsv implements FromCollection
{
    public $value;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->value;
    }

    public function data($response)
    {
        $this->value = $response;
    }
}
