<?php

namespace App\Exports;

use App\Models\HoldModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HoldExport implements FromCollection, WithHeadings
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
        return $this->data->map(function ($hold, $index) {

            return [
                'No' => $index + 1,
                'Complaint' => $hold->complaint_name,
                'Reporter' => $hold->complaint_reporter,
                'Report Time' => $hold->complaint_time,
                'Report Date' => $hold->complaint_date,
                'Description' => $hold->complaint_desc,
                'Status' => $hold->status->status_name,
                'Priority' => $hold->priority->priority_name,
                'Location' => $hold->complaint_location,
            ];
        });
    }


    public function headings(): array
    {
        return [
            'No',
            'Complaint',
            'Reporter',
            'Report Time',
            'Report Date',
            'Description',
            'Status',
            'Priority',
            'Location',
        ];
    }
}
