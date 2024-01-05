<?php

namespace App\Exports;

use App\Models\ProgressModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProgressExport implements FromCollection, WithHeadings
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
        return $this->data->map(function ($progress, $index) {

            return [
                'No' => $index + 1,
                'Complaint' => $progress->complaint_name,
                'Reporter' => $progress->complaint_reporter,
                'Report Time' => $progress->complaint_time,
                'Report Date' => $progress->complaint_date,
                'Description' => $progress->complaint_desc,
                'Status' => $progress->status->status_name,
                'Priority' => $progress->priority->priority_name,
                'Location' => $progress->complaint_location,
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
