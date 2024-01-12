<?php

namespace App\Http\Controllers;

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

        $title = "Item Details";

        $data = [
            'complaint'        => $complaint,
            'title'       => $title,
        ];
        // dd($data);
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
