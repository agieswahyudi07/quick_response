<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ComplaintModel;

class ComplaintController extends Controller
{
    public function index_admin()
    {

        // $ComplaintModel = new ComplaintModel;
        $complaint = ComplaintModel::with('status')
            ->orderBy('priority_id', 'asc')
            ->orderBy('status_id', 'asc')
            ->get();
        $data = [
            'title' => 'Complaint',
            'complaint' => $complaint
        ];
        return view('admin/complaint/index', compact('data'));
    }

    public function index_user()
    {

        // $ComplaintModel = new ComplaintModel;
        $complaint = ComplaintModel::with('status')
            ->orderBy('priority_id', 'asc')
            ->orderBy('status_id', 'asc')
            ->get();
        $data = [
            'title' => 'Complaint',
            'complaint' => $complaint
        ];
        return view('user/complaint/index', compact('data'));
    }

    public function complaint_show_admin($id)
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

        return view('admin.complaint.show', compact('data'));
    }

    public function complaint_show_user($id)
    {

        $complaint = ComplaintModel::with('status')
            ->with('priority')
            ->where('complaint_id', '=', $id)
            ->first();

        $title = "Item Details";

        $data = [
            'complaint'        => $complaint,
            'title'       => $title,
        ];
        // dd($data);
        return view('user.complaint.show', compact('data'));
    }
}
