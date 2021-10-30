<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InventoryExport implements WithHeadings, FromArray, ShouldAutoSize, WithStyles
{
    protected $data;
    protected $columns;
    public function __construct($data, $columns)
    {
        $this->data = $data;
        $this->columns= $columns;
    }
    //export as array
    public function array(): array
    {
        return  $this->data;
    }
    //with headers
    public function headings(): array
    {
        return $this->columns;
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(1)->getAlignment()->applyFromArray(
            array('horizontal' => 'center')
        );
        $sheet->getStyle(1)->getAlignment()->applyFromArray(
            array('vertical' => 'center')
        );
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
