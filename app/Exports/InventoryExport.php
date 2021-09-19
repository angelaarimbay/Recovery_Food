<?php

namespace App\Exports;
 
use Maatwebsite\Excel\Concerns\FromArray;  
use Maatwebsite\Excel\Concerns\WithHeadings; 

class InventoryExport implements  WithHeadings,FromArray
{
    protected $data; 
    protected $columns; 
    function __construct($data,$columns) {
        $this->data = $data;   
        $this->columns= $columns;    
    }
     //export as array 
     public function array(): array{  
        return  $this->data;
    }
    //with headers
    public function headings(): array{
        return $this->columns; 
    }
}
