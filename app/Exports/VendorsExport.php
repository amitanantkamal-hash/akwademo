<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VendorsExport implements FromArray, WithHeadings
{
    protected $vendors;

    public function headings(): array
    {
        return [
            'sr.no',
            'business_name',
            'created',
            'owner_name',
            'owner_email',
            'phone_number'
        ];
    }

    public function __construct(array $vendors)
    {
        $this->vendors = $vendors;
    }

    public function array(): array
    {
        return $this->vendors;
    }
}
