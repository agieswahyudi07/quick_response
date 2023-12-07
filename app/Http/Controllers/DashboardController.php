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
    public function index()
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

        $recent_activity = ComplaintModel::orderBy('status_id', 'asc')
            ->where('status_id', '=', 2)
            ->get();

        $recent_complaint = ComplaintModel::orderBy('complaint_id', 'desc')
            ->get();

        $data = [
            'title' => 'Complaint',
            'queue' => $queue->count(),
            'progress' => $progress->count(),
            'completed' => $completed->count(),
            'recent_activity' => $recent_activity,
            'recent_complaint' => $recent_complaint,
        ];
        return view('dashboard/dashboard', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DashboardModel $dashboardModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DashboardModel $dashboardModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DashboardModel $dashboardModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DashboardModel $dashboardModel)
    {
        //
    }
}
