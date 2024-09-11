<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        try {
            $complaint = ComplaintModel::orderBy('priority_id', 'asc')
                ->where('status_id', '=', 4)
                ->get();

            $data = [
                'title' => 'On Hold',
                'complaint' => $complaint
            ];
            return view('admin/hold/index', compact('data'));
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
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
        try {
            $complaint = ComplaintModel::find($id);
            if (!$complaint) {
                Session::flash('error', 'Complaint not found.');
                return redirect()->route('admin.queue');
            }

            $complaint_name = $complaint->complaint_name;
            $complaint_reporter = $complaint->complaint_reporter;
            $complaint_location = $complaint->complaint_location;
            $complaint_time = $complaint->complaint_time;
            $complaint_date = $complaint->complaint_date;
            $complaint_desc = $complaint->complaint_desc;
            $compalint_priority = $complaint->priority_id;
            $status_id = '2';
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

            $update = $complaint->update($data);

            if ($update) {
                Session::flash('success', 'Data successfully Proceed.');
                return redirect()->route('admin.hold');
            } else {
                Session::flash('failed', 'Data Failed to Insert.');
            }
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function hold_show_admin($id)
    {
        try {

            $complaint = ComplaintModel::with('status')
                ->with('priority')
                ->where('complaint_id', '=', $id)
                ->first();

            $complaint->proceed_at_time = Carbon::parse($complaint->proceed_at)->format('H:i');
            $complaint->proceed_at_date = Carbon::parse($complaint->proceed_at)->format('Y-m-d');

            if ($complaint->completed_at) {
                $complaint->completed_at_time = Carbon::parse($complaint->completed_at)->format('H:i');
                $complaint->completed_at_date = Carbon::parse($complaint->completed_at)->format('Y-m-d');
            }

            $title = "Item Details";

            $data = [
                'complaint' => $complaint,
                'title' => $title,
            ];

            return view('admin.hold.show', compact('data'));
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function hold_show_user($id)
    {
        try {
            $complaint = ComplaintModel::with('status')
                ->with('priority')
                ->where('complaint_id', '=', $id)
                ->first();

            $complaint->proceed_at_time = Carbon::parse($complaint->proceed_at)->format('H:i');
            $complaint->proceed_at_date = Carbon::parse($complaint->proceed_at)->format('Y-m-d');

            if ($complaint->completed_at) {
                $complaint->completed_at_time = Carbon::parse($complaint->completed_at)->format('H:i');
                $complaint->completed_at_date = Carbon::parse($complaint->completed_at)->format('Y-m-d');
            }

            $title = "Item Details";

            $data = [
                'complaint' => $complaint,
                'title' => $title,
            ];

            return view('user.hold.show', compact('data'));
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function hold_export()
    {
        try {
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

            return Excel::download(new HoldExport($data), 'Hold-' . Carbon::now()->format('d-m-Y') . '.xlsx');
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }
}
