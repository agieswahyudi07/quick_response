<?php

namespace App\Exports;

use App\Models\QueueModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QueueExport implements FromCollection, WithHeadings
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
        return $this->data->map(function ($queue, $index) {
            
            return [
                'No' => $index + 1,
                'Complaint' => $queue->complaint_name,
                'Reporter' => $queue->complaint_reporter,
                'Report Time' => $queue->complaint_time,
                'Report Date' => $queue->complaint_date,
                'Description' => $queue->complaint_desc,
                'Status' => $queue->status->status_name,
                'Priority' => $queue->priority->priority_name,
                'Location' => $queue->complaint_location,
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
