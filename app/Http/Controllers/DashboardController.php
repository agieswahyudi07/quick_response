<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComplaintModel;
use App\Models\DashboardModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard_admin()
    {
        try {
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
        } catch (\Throwable $th) {
            Log::info(['result' => 'error', 'location' => 'dashboard_admin', 'message' => $th->getMessage()]);
            return redirect()->route('user.logout');
        }
    }

    public function dashboard_user()
    {
        try {
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
        } catch (\Throwable $th) {
            Log::info(['result' => 'error', 'location' => 'dashboard_user', 'message' => $th->getMessage()]);
            return redirect()->route('user.logout');
        }
    }
}
