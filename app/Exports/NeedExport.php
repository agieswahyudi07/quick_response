<?php

namespace App\Exports;

use App\Models\NeedModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NeedExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($need, $index) {

            return [
                'No' => $index + 1,
                'Item' => $need->need_item,
                'Quantity' => $need->need_qty,
                'Price' => $need->need_price,
                'Detail' => $need->need_desc,
                'Complaint' => $need->complaint->complaint_name,
                'Priority' => $need->priority_name,
            ];
        });
    }


    public function headings(): array
    {
        return [
            'No',
            'Item',
            'Quantity',
            'Price',
            'Detail',
            'Complaint',
            'Priority',
        ];
    }
}
