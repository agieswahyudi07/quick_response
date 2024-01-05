<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PriorityModel;
use App\Models\ComplaintModel;
use App\Models\CompletedModel;
use App\Exports\CompletedExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;


class CompletedController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {

        $complaint = ComplaintModel::orderBy('priority_id', 'asc')
            ->where('status_id', '=', 3)
            ->get();

        $query = ComplaintModel::orderBy('priority_id', 'asc')
            ->where('status_id', '=', 3);

        // Filter berdasarkan tanggal jika ada dalam request
        if ($request->has('filter_date')) {
            $filterDate = $request->input('filter_date');

            // Jika filter_date kosong, abaikan filter tanggal
            if (!empty($filterDate)) {
                $query->whereDate('complaint_completed_date', '=', $filterDate);
            }
        }

        $complaint_date_filter = $query->get();

        $data = [
            'title' => 'Completed',
            'complaint' => $complaint,
            'complaint_date_filter' => $complaint_date_filter,
        ];

        return view('completed/index', compact('data'));
    }

    public function completed_export()
    {
        $columns = [
            'ms_complaint.*',
            'ms_priority.priority_name',
            'ms_status.status_name',
        ];

        $data = ComplaintModel::select($columns)
            ->join('ms_priority', 'ms_complaint.priority_id', '=', 'ms_priority.priority_id')
            ->join('ms_status', 'ms_status.status_id', '=', 'ms_complaint.status_id')
            ->where('ms_status.status_id', '=', 3)
            ->get();

        return Excel::download(new CompletedExport($data), 'Completed |' . Carbon::now()->timestamp . '.xlsx');
    }
}
