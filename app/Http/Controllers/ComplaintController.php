<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ComplaintModel;
use App\Exports\ComplaintExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class ComplaintController extends Controller
{
    public function index_admin()
    {
        try {
            $complaints = ComplaintModel::with('status')
                ->orderBy('priority_id', 'asc')
                ->orderBy('status_id', 'asc')
                ->get();

            $formattedComplaints = $complaints->map(function ($complaint) {
                if ($complaint->proceed_at) {
                    $complaint->proceed_at_time = Carbon::parse($complaint->proceed_at)->format('H:i');
                    $complaint->proceed_at_date = Carbon::parse($complaint->proceed_at)->format('Y-m-d');
                }

                if ($complaint->completed_at) {
                    $complaint->completed_at_time = Carbon::parse($complaint->completed_at)->format('H:i');
                    $complaint->completed_at_date = Carbon::parse($complaint->completed_at)->format('Y-m-d');
                }

                return $complaint;
            });

            $data = [
                'title' => 'Complaint',
                'complaint' => $formattedComplaints,
            ];

            return view('admin/complaint/index', compact('data'));
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function index_user()
    {
        try {
            $complaints = ComplaintModel::with('status')
                ->orderBy('priority_id', 'asc')
                ->orderBy('status_id', 'asc')
                ->get();

            $formattedComplaints = $complaints->map(function ($complaint) {
                if ($complaint->proceed_at) {
                    $complaint->proceed_at_time = Carbon::parse($complaint->proceed_at)->format('H:i');
                    $complaint->proceed_at_date = Carbon::parse($complaint->proceed_at)->format('Y-m-d');
                }

                if ($complaint->completed_at) {
                    $complaint->completed_at_time = Carbon::parse($complaint->completed_at)->format('H:i');
                    $complaint->completed_at_date = Carbon::parse($complaint->completed_at)->format('Y-m-d');
                }

                return $complaint;
            });

            $data = [
                'title' => 'Complaint',
                'complaint' => $formattedComplaints,
            ];

            return view('user/complaint/index', compact('data'));
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }


    public function complaint_show_admin($id)
    {
        try {
            //code...
            $complaint = ComplaintModel::with('status')
                ->with('priority')
                ->where('complaint_id', '=', $id)
                ->first();

            // Pemformatan waktu dan tanggal dari tabel ms_complaint
            $complaint->proceed_at_time = Carbon::parse($complaint->proceed_at)->format('H:i');
            $complaint->proceed_at_date = Carbon::parse($complaint->proceed_at)->format('Y-m-d');
            // Pastikan untuk memeriksa apakah completed_at tidak null sebelum memformat
            if ($complaint->completed_at) {
                $complaint->completed_at_time = Carbon::parse($complaint->completed_at)->format('H:i');
                $complaint->completed_at_date = Carbon::parse($complaint->completed_at)->format('Y-m-d');
            }

            $title = "Item Details";

            $data = [
                'complaint' => $complaint,
                'title' => $title,
            ];

            return view('admin.complaint.show', compact('data'));
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function complaint_show_user($id)
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

            return view('user.complaint.show', compact('data'));
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function complaint_export()
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
                ->orderBy('status_id', 'asc')
                ->get();

            return Excel::download(new ComplaintExport($data), 'All_complaint-' . Carbon::now()->format('d-m-Y') . '.xlsx');
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }
}
