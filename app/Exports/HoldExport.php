<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\HoldModel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

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
        return $this->data->map(function ($complaint, $index) {
            return [
                'No' => $index + 1,
                'Status' => $complaint->status->status_name,
                'Priority' => $complaint->priority->priority_name,
                'Complaint' => $complaint->complaint_name,
                'Reporter' => $complaint->complaint_reporter,
                'Location' => $complaint->complaint_location,
                'Description' => $complaint->complaint_desc,
                'Report Time' => $complaint->complaint_time,
                'Report Date' => $complaint->complaint_date,
                'Progress Time' => $complaint->proceed_at ? Carbon::parse($complaint->proceed_at)->format('H:i') : '',
                'Progress Date' => $complaint->proceed_at ? Carbon::parse($complaint->proceed_at)->format('d-m-y') : '',
            ];
        });
    }


    public function headings(): array
    {
        return [
            'No',
            'Status',
            'Priority',
            'Complaint',
            'Reporter',
            'Location',
            'Description',
            'Report Time',
            'Report Date',
            'Progress Time',
            'Progress Date',

        ];
    }
}
