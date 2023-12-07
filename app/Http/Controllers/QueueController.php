<?php

namespace App\Http\Controllers;

use App\Models\ComplaintModel;
use App\Models\PriorityModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class QueueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        // $ComplaintModel = new ComplaintModel;
        $complaint = ComplaintModel::orderBy('priority_id', 'asc')
            ->where('status_id', '=', 1)
            ->get();
        $data = [
            'title' => 'Queue',
            'complaint' => $complaint
        ];
        return view('queue/index', compact('data'));
    }

    public function queue()
    {

        // $ComplaintModel = new ComplaintModel;
        $complaint = ComplaintModel::orderBy('priority_id', 'asc')
            ->where('status_id', '=', 1)
            ->get();
        $data = [
            'title' => 'Queue',
            'complaint' => $complaint
        ];
        return view('queue/queue', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function queue_create()
    {

        $ComplaintModel = new ComplaintModel;
        $priority = PriorityModel::all();
        $data = [
            'title' => 'Queue',
            'priority' => $priority
        ];
        return view('queue/add', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function queue_store(Request $request)
    {
        Session::flash('txtComplaintName', $request->txtComplaintName);
        Session::flash('txtComplaintReporter', $request->txtComplaintReporter);
        Session::flash('txtComplaintLocation', $request->txtComplaintLocation);
        Session::flash('txtComplaintTime', $request->txtComplaintTime);
        Session::flash('txtComplaintDate', $request->txtComplaintDate);
        Session::flash('txtComplaintDesc', $request->txtComplaintDesc);

        Session::flash('selPriority', $request->selPriority);
        $priority = DB::table('ms_priority')->where('priority_id', '=', $request->selPriority)->first();
        if ($priority) {
            Session::flash('txtPriority', $priority->priority_name);
        }

        $request->validate([
            'txtComplaintName' => 'required',
            'txtComplaintReporter' => 'required',
            'txtComplaintLocation' => 'required',
            'txtComplaintTime' => 'required',
            'txtComplaintDate' => 'required',
            'selPriority' => 'required',

        ], [
            'txtComplaintName.required' => 'Complaint Required.',
            'txtComplaintReporter.required' => 'Complaint Reporter Required.',
            'txtComplaintLocation.required' => 'Complaint Location Required.',
            'txtComplaintTime.required' => 'Complaint Time Required.',
            'txtComplaintDate.required' => 'Complaint Date Required.',
            'selPriority.required' => 'Complaint Priority Required.',
        ]);

        $complaint_name = $request->input('txtComplaintName');
        $complaint_reporter = $request->input('txtComplaintReporter');
        $complaint_location = $request->input('txtComplaintLocation');
        $complaint_time = $request->input('txtComplaintTime');
        $complaint_date = $request->input('txtComplaintDate');
        $compalint_desc = $request->input('txtComplaintDesc');
        $compalint_priority = $request->input('selPriority');
        $status_id = "1";
        $created_at = now();

        $data = [
            'complaint_name' => $complaint_name,
            'complaint_reporter' => $complaint_reporter,
            'complaint_location' => $complaint_location,
            'complaint_time' => $complaint_time,
            'complaint_date' => $complaint_date,
            'priority_id' => $compalint_priority,
            'complaint_desc' => $compalint_desc,
            'status_id' => $status_id,
            'created_at' => $created_at,
        ];


        $ComplaintModel = new ComplaintModel();
        $insert = $ComplaintModel->insert($data);

        if ($insert) {
            Session::flash('success', 'Data successfully Inserted.');
            return redirect()->route('queue');
        } else {
            Session::flash('failed', 'Data Failed to Insert.');
        }
    }

    public function queue_process(Request $request, $id)
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
        $status_id = '2'; // Anda mungkin ingin mengambil nilai ini dari input atau data lain
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
        // dd($data);

        $update = $complaint->update($data);
        // dd($update);

        if ($update) {
            Session::flash('success', 'Data successfully Proceed.');
            return redirect()->route('queue');
        } else {
            Session::flash('failed', 'Data Failed to Insert.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ComplaintModel $ComplaintModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function queue_edit($id)
    {
        $complaint = DB::table('ms_complaint')->where('complaint_id', '=', $id)->first();
        $priority = PriorityModel::all();

        $data = [
            'title' => 'Queue',
            'complaint' => $complaint,
            'priority' => $priority
        ];

        return view('queue/edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function queue_update(Request $request, $id)
    {
        $queue = ComplaintModel::find($id);
        if (!$queue) {
            Session::flash('error', 'Queue not found.');
            return redirect()->route('/queue.index');
        }

        $request->validate([
            'txtComplaintName' => 'required',
            'txtComplaintReporter' => 'required',
            'txtComplaintLocation' => 'required',
            'txtComplaintTime' => 'required',
            'txtComplaintDate' => 'required',
            'selPriority' => 'required',

        ], [
            'txtComplaintName.required' => 'Complaint Required.',
            'txtComplaintReporter.required' => 'Complaint Reporter Required.',
            'txtComplaintLocation.required' => 'Complaint Location Required.',
            'txtComplaintTime.required' => 'Complaint Time Required.',
            'txtComplaintDate.required' => 'Complaint Date Required.',
            'selPriority.required' => 'Complaint Priority Required.',
        ]);

        Session::flash('txtComplaintName', $request->txtComplaintName);
        Session::flash('txtComplaintReporter', $request->txtComplaintReporter);
        Session::flash('txtComplaintLocation', $request->txtComplaintLocation);
        Session::flash('txtComplaintTime', $request->txtComplaintTime);
        Session::flash('txtComplaintDate', $request->txtComplaintDate);
        Session::flash('txtComplaintDesc', $request->txtComplaintDesc);
        Session::flash('selPriority', $request->selPriority);
        $priority = DB::table('ms_priority')->where('priority_id', '=', $request->selPriority)->first();
        if ($priority) {
            Session::flash('txtPriority', $priority->priority_name);
        }


        $data = [
            'complaint_name' => $request->input('txtComplaintName'),
            'complaint_reporter' => $request->input('txtComplaintReporter'),
            'complaint_location' => $request->input('txtComplaintLocation'),
            'complaint_time' => $request->input('txtComplaintTime'),
            'complaint_date' => $request->input('txtComplaintDate'),
            'priority_id' => $request->input('selPriority'),
            'complaint_desc' => $request->input('txtComplaintDesc'),
        ];

        $update = $queue->update($data);

        Session::flash('success', 'Data successfully updated.');
        return redirect()->route('queue');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function queue_destroy($id)
    {
        ComplaintModel::find($id)->delete();
        Session::flash('success', 'Data successfully deleted.');
        return redirect()->route('queue');
    }
}
