<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Exports\QueueExport;
use Illuminate\Http\Request;
use App\Models\PriorityModel;
use App\Models\ComplaintModel;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;


class QueueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_admin()
    {

        // $ComplaintModel = new ComplaintModel;
        $complaint = ComplaintModel::orderBy('priority_id', 'asc')
            ->where('status_id', '=', 1)
            ->get();
        $data = [
            'title' => 'Queue',
            'complaint' => $complaint
        ];
        return view('admin/queue/index', compact('data'));
    }

    public function index_user()
    {

        // $ComplaintModel = new ComplaintModel;
        $complaint = ComplaintModel::orderBy('priority_id', 'asc')
            ->where('status_id', '=', 1)
            ->get();
        $data = [
            'title' => 'Queue',
            'complaint' => $complaint
        ];
        return view('user/queue/index', compact('data'));
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
        return view('admin/queue/add', compact('data'));
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
            return redirect()->route('admin.queue');
        } else {
            Session::flash('failed', 'Data Failed to Insert.');
        }
    }

    public function queue_show_admin($id)
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

        return view('admin.queue.show', compact('data'));
    }

    public function queue_show_user($id)
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

        return view('user.queue.show', compact('data'));
    }

    public function queue_process(Request $request, $id)
    {

        $complaint = ComplaintModel::find($id);
        // dd($complaint);
        if (!$complaint) {
            Session::flash('error', 'Complaint not found.');
            return redirect()->route('admin.queue');
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
        $proceed_at = now()->format('Y-m-d H:i:s');
        // dd($proceed_at);
        $data = [
            'complaint_name' => $complaint_name,
            'complaint_reporter' => $complaint_reporter,
            'complaint_location' => $complaint_location,
            'complaint_time' => $complaint_time,
            'complaint_date' => $complaint_date,
            'priority_id' => $compalint_priority,
            'complaint_desc' => $complaint_desc,
            'status_id' => $status_id,
            'proceed_at' => $proceed_at,
        ];
        // dd($data);

        $update = $complaint->update($data);
        // dd($update);

        if ($update) {
            Session::flash('success', 'Data successfully Proceed.');
            return redirect()->route('admin.queue');
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

        return view('admin/queue/edit', compact('data'));
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
        return redirect()->route('admin.queue');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function queue_destroy($id)
    {
        ComplaintModel::find($id)->delete();
        Session::flash('success', 'Data successfully deleted.');
        return redirect()->route('admin.queue');
    }

    public function queue_export()
    {
        $columns = [
            'ms_complaint.*',
            'ms_priority.priority_name',
            'ms_status.status_name',
        ];

        $data = ComplaintModel::select($columns)
            ->join('ms_priority', 'ms_complaint.priority_id', '=', 'ms_priority.priority_id')
            ->join('ms_status', 'ms_status.status_id', '=', 'ms_complaint.status_id')
            ->where('ms_status.status_id', '=', 1)
            ->get();

        return Excel::download(new QueueExport($data), 'Queue-' . Carbon::now()->format('d-m-Y') . '.xlsx');
    }
}
