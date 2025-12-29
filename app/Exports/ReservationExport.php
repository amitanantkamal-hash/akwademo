<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReservationExport implements FromArray, WithHeadings
{
    protected $reservation;
    public function headings(): array
    {
        $headings = [
            'id',
            'company',
            'contact',
            'source',
            'external_id',
            'notes',
            'start_date',
            'end_date',
        ];
        return $headings;
    }
    public function __construct(array $reservation)
    {
        $this->reservation = $reservation;
    }
    public function array(): array
    {
        return $this->reservation;
    }
}
