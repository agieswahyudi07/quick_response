<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\HoldModel;
use App\Exports\HoldExport;
use Illuminate\Http\Request;
use App\Models\ComplaintModel;
use Maatwebsite\Excel\Facades\Excel;

class HoldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $ComplaintModel = new ComplaintModel;        
        $complaint = ComplaintModel::orderBy('priority_id', 'asc')
            ->where('status_id', '=', 4)
            ->get();

        $data = [
            'title' => 'On Hold',
            'complaint' => $complaint
        ];
        return view('hold/index', compact('data'));
    }

    public function hold_export()
    {
        $columns = [
            'ms_complaint.*',
            'ms_priority.priority_name',
            'ms_status.status_name',
        ];

        $data = ComplaintModel::select($columns)
            ->join('ms_priority', 'ms_complaint.priority_id', '=', 'ms_priority.priority_id')
            ->join('ms_status', 'ms_status.status_id', '=', 'ms_complaint.status_id')
            ->where('ms_status.status_id', '=', 4)
            ->get();

        return Excel::download(new HoldExport($data), 'Queue |' . Carbon::now()->timestamp . '.xlsx');
    }
}
