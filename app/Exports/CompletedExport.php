<?php

namespace App\Exports;

use App\Models\CompletedModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompletedExport implements FromCollection, WithHeadings
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
        return $this->data->map(function ($completed, $index) {

            return [
                'No' => $index + 1,
                'Complaint' => $completed->complaint_name,
                'Reporter' => $completed->complaint_reporter,
                'Report Time' => $completed->complaint_time,
                'Report Date' => $completed->complaint_date,
                'Description' => $completed->complaint_desc,
                'Status' => $completed->status->status_name,
                'Priority' => $completed->priority->priority_name,
                'Location' => $completed->complaint_location,
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
