<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\HoldModel;
use App\Exports\HoldExport;
use Illuminate\Http\Request;
use App\Models\ComplaintModel;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class HoldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_admin()
    {
        // $ComplaintModel = new ComplaintModel;        
        $complaint = ComplaintModel::orderBy('priority_id', 'asc')
            ->where('status_id', '=', 4)
            ->get();

        $data = [
            'title' => 'On Hold',
            'complaint' => $complaint
        ];
        return view('admin/hold/index', compact('data'));
    }

    public function index_user()
    {
        // $ComplaintModel = new ComplaintModel;        
        $complaint = ComplaintModel::orderBy('priority_id', 'asc')
            ->where('status_id', '=', 4)
            ->get();

        $data = [
            'title' => 'On Hold',
            'complaint' => $complaint
        ];
        return view('user/hold/index', compact('data'));
    }

    public function hold_process(Request $request, $id)
    {

        $complaint = ComplaintModel::find($id);
        // dd($complaint);
        if (!$complaint) {
            Session::flash('error', 'Complaint not found.');
            return redirect()->route('admin.queue');
        }


        // Menggunakan data complaint langsung tanpa perlu foreach
        $complaint_name = $complaint->complaint_name;
        $complaint_reporter = $complaint->complaint_reporter;
        $complaint_location = $complaint->complaint_location;
        $complaint_time = $complaint->complaint_time;
        $complaint_date = $complaint->complaint_date;
        $complaint_desc = $complaint->complaint_desc;
        $compalint_priority = $complaint->priority_id;
        $status_id = '2'; // Anda mungkin ingin mengambil nilai ini dari input atau data lain
        $proceed_at = now();

        $data = [
            'complaint_name' => $complaint_name,
            'complaint_reporter' => $complaint_reporter,
            'complaint_location' => $complaint_location,
            'complaint_time' => $complaint_time,
            'complaint_date' => $complaint_date,
            'priority_id' => $compalint_priority,
            'complaint_desc' => $complaint_desc,
            'status_id' => $status_id,
            'created_at' => $proceed_at,
        ];
        // dd($data);

        $update = $complaint->update($data);
        // dd($update);

        if ($update) {
            Session::flash('success', 'Data successfully Proceed.');
            return redirect()->route('admin.hold');
        } else {
            Session::flash('failed', 'Data Failed to Insert.');
        }
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

        return Excel::download(new HoldExport($data), 'Hold |' . Carbon::now()->timestamp . '.xlsx');
    }
}
