<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReminderExport implements FromArray, WithHeadings
{
    protected $reminder;
    public function headings(): array
    {
        $headings = [
            'id',
            'company',
            'name',
            'source',
            'type',
            'time',
            'time_type',
            'status',
            'campaign_id',
        ];
        return $headings;
    }
    public function __construct(array $reminder)
    {
        $this->reminder = $reminder;
    }
    public function array(): array
    {
        return $this->reminder;
    }
}
