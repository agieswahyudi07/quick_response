<?php

namespace App\Http\Controllers;

use App\Models\ComplaintModel;
use App\Models\CompletedModel;
use App\Models\PriorityModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


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

    public function index_()
    {
        // $ComplaintModel = new ComplaintModel;
        $complaint = ComplaintModel::orderBy('priority_id', 'asc')
            ->where('status_id', '=', 3)
            ->get();
        $data = [
            'title' => 'Completed',
            'complaint' => $complaint
        ];
        return view('completed/index', compact('data'));
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
    public function show(CompletedModel $completedModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompletedModel $completedModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CompletedModel $completedModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompletedModel $completedModel)
    {
        //
    }
}
