<?php

namespace App\Http\Controllers;

use App\Models\ComplaintModel;
use App\Models\PriorityModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class ProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $ComplaintModel = new ComplaintModel;
        $complaint = ComplaintModel::orderBy('priority_id', 'asc')
            ->where('status_id', '=', 2)
            ->get();
        $data = [
            'title' => 'On Progress',
            'complaint' => $complaint
        ];
        return view('progress/index', compact('data'));
    }

    // On Progress Complete
    public function progress_completed(Request $request, $id)
    {

        $complaint = ComplaintModel::find($id);
        // dd($complaint);
        if (!$complaint) {
            Session::flash('error', 'Complaint not found.');
            return redirect()->route('queue');
        }


        // Menggunakan data complaint langsung tanpa perlu foreach
        $complaint_name = $complaint->complaint_name;
        $complaint_reporter = $complaint->complaint_reporter;
        $complaint_location = $complaint->complaint_location;
        $complaint_time = $complaint->complaint_time;
        $complaint_date = $complaint->complaint_date;
        $complaint_desc = $complaint->complaint_desc;
        $compalint_priority = $complaint->priority_id;
        $status_id = '3'; // Anda mungkin ingin mengambil nilai ini dari input atau data lain
        $today = Carbon::today();
        $complaint_completed_date = $today->toDateString();

        $data = [
            'complaint_name' => $complaint_name,
            'complaint_reporter' => $complaint_reporter,
            'complaint_location' => $complaint_location,
            'complaint_time' => $complaint_time,
            'complaint_date' => $complaint_date,
            'priority_id' => $compalint_priority,
            'complaint_desc' => $complaint_desc,
            'status_id' => $status_id,
            'complaint_completed_date' => $complaint_completed_date,
        ];
        // dd($data);

        $update = $complaint->update($data);
        // dd($update);

        if ($update) {
            Session::flash('success', 'Data successfully Completed.');
            return redirect()->route('progress');
        } else {
            Session::flash('failed', 'Data Failed to Insert.');
        }
    }

    // On Progress Cancel
    public function progress_cancel(Request $request, $id)
    {

        $complaint = ComplaintModel::find($id);
        // dd($complaint);
        if (!$complaint) {
            Session::flash('error', 'Complaint not found.');
            return redirect()->route('queue');
        }


        // Menggunakan data complaint langsung tanpa perlu foreach
        $complaint_name = $complaint->complaint_name;
        $complaint_reporter = $complaint->complaint_reporter;
        $complaint_location = $complaint->complaint_location;
        $complaint_time = $complaint->complaint_time;
        $complaint_date = $complaint->complaint_date;
        $complaint_desc = $complaint->complaint_desc;
        $compalint_priority = $complaint->priority_id;
        $status_id = '1'; // Anda mungkin ingin mengambil nilai ini dari input atau data lain

        $data = [
            'complaint_name' => $complaint_name,
            'complaint_reporter' => $complaint_reporter,
            'complaint_location' => $complaint_location,
            'complaint_time' => $complaint_time,
            'complaint_date' => $complaint_date,
            'priority_id' => $compalint_priority,
            'complaint_desc' => $complaint_desc,
            'status_id' => $status_id,
        ];
        // dd($data);

        $update = $complaint->update($data);
        // dd($update);

        if ($update) {
            Session::flash('success', 'Data successfully Completed.');
            return redirect()->route('progress');
        } else {
            Session::flash('failed', 'Data Failed to Insert.');
        }
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
