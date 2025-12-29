<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SourcesExport implements FromArray, WithHeadings
{
    protected $sources;
    public function headings(): array
    {
        $headings= [
            'id',
            'name',
            'created_at'
        ];
        return $headings;
    }
    public function __construct(array $sources)
    {
        $this->sources = $sources;
    }
    public function array(): array
    {
        return $this->sources;
    }
}
