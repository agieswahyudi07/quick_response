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

    public function index_admin(Request $request)
    {
        $query = ComplaintModel::orderBy('priority_id', 'asc')
            ->where('status_id', '=', 3);

        // Filter berdasarkan tanggal jika ada dalam request
        if ($request->has('filter_date')) {
            $filterDate = $request->input('filter_date');

            // Jika filter_date kosong, abaikan filter tanggal
            if (!empty($filterDate)) {
                $query->whereDate('completed_at', '=', $filterDate);
            }
        }

        $complaints = $query->get();

        $formattedComplaints = $complaints->map(function ($complaint) {
            $complaint->proceed_at_time = Carbon::parse($complaint->proceed_at)->format('H:i');
            $complaint->proceed_at_date = Carbon::parse($complaint->proceed_at)->format('Y-m-d');
            $complaint->completed_at_time = Carbon::parse($complaint->completed_at)->format('H:i');
            $complaint->completed_at_date = Carbon::parse($complaint->completed_at)->format('Y-m-d');
            return $complaint;
        });

        $data = [
            'title' => 'Completed',
            'complaint' => $formattedComplaints,
            'complaint_date_filter' => $complaints, // Memasukkan hasil query tanpa format
        ];

        return view('admin/completed/index', compact('data'));
    }

    public function index_user(Request $request)
    {
        $query = ComplaintModel::orderBy('priority_id', 'asc')
            ->where('status_id', '=', 3);

        // Filter berdasarkan tanggal jika ada dalam request
        if ($request->has('filter_date')) {
            $filterDate = $request->input('filter_date');

            // Jika filter_date kosong, abaikan filter tanggal
            if (!empty($filterDate)) {
                $query->whereDate('completed_at', '=', $filterDate);
            }
        }

        $complaints = $query->get();

        $formattedComplaints = $complaints->map(function ($complaint) {
            $complaint->proceed_at_time = Carbon::parse($complaint->proceed_at)->format('H:i');
            $complaint->proceed_at_date = Carbon::parse($complaint->proceed_at)->format('Y-m-d');
            $complaint->completed_at_time = Carbon::parse($complaint->completed_at)->format('H:i');
            $complaint->completed_at_date = Carbon::parse($complaint->completed_at)->format('Y-m-d');
            return $complaint;
        });

        $data = [
            'title' => 'Completed',
            'complaint' => $formattedComplaints,
            'complaint_date_filter' => $complaints, // Memasukkan hasil query tanpa format
        ];

        return view('user/completed/index', compact('data'));
    }


    public function completed_show_admin($id)
    {
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

        return view('admin.completed.show', compact('data'));
    }

    public function completed_show_user($id)
    {
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

        return view('user.completed.show', compact('data'));
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

        return Excel::download(new CompletedExport($data), 'Completed-' . Carbon::now()->format('d-m-Y') . '.xlsx');
    }
}
