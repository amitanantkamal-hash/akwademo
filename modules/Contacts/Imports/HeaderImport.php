<?php

namespace Modules\Contacts\Imports;

use Maatwebsite\Excel\HeadingRowImport;

class HeaderImport implements HeadingRowImport {
    public function headings(): array {
        return []; // This will be populated with the header names
    }
}
