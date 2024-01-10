<?php

namespace App\Http\Controllers;

use App\Models\DashboardModel;
use App\Models\ComplaintModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard_admin()
    {

        // $complaintModel = new ComplaintModel;
        $queue = ComplaintModel::orderBy('priority_id', 'asc')
            ->where('status_id', '=', 1)
            ->get();

        $progress = ComplaintModel::orderBy('priority_id', 'asc')
            ->where('status_id', '=', 2)
            ->get();

        $completed = ComplaintModel::orderBy('priority_id', 'asc')
            ->where('status_id', '=', 3)
            ->get();

        $complaint = ComplaintModel::orderBy('priority_id', 'asc')
            ->get();

        $recent_activity = ComplaintModel::orderBy('status_id', 'asc')
            ->where('status_id', '=', 2)
            ->get();

        $recent_complaint = ComplaintModel::orderBy('complaint_id', 'desc')
            ->get();

        $data = [
            'title' => 'Complaint',
            'queue' => $queue->count(),
            'progress' => $progress->count(),
            'complaint' => $complaint->count(),
            'completed' => $completed->count(),
            'recent_activity' => $recent_activity,
            'recent_complaint' => $recent_complaint,
        ];
        return view('admin/dashboard/dashboard', compact('data'));
    }

    public function dashboard_user()
    {

        // $complaintModel = new ComplaintModel;
        $queue = ComplaintModel::orderBy('priority_id', 'asc')
            ->where('status_id', '=', 1)
            ->get();

        $progress = ComplaintModel::orderBy('priority_id', 'asc')
            ->where('status_id', '=', 2)
            ->get();

        $completed = ComplaintModel::orderBy('priority_id', 'asc')
            ->where('status_id', '=', 3)
            ->get();

        $complaint = ComplaintModel::orderBy('priority_id', 'asc')
            ->get();

        $recent_activity = ComplaintModel::orderBy('status_id', 'asc')
            ->where('status_id', '=', 2)
            ->get();

        $recent_complaint = ComplaintModel::orderBy('complaint_id', 'desc')
            ->get();

        $data = [
            'title' => 'Complaint',
            'queue' => $queue->count(),
            'progress' => $progress->count(),
            'complaint' => $complaint->count(),
            'completed' => $completed->count(),
            'recent_activity' => $recent_activity,
            'recent_complaint' => $recent_complaint,
        ];
        return view('user/dashboard/dashboard', compact('data'));
    }
}
