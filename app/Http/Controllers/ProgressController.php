<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\NeedModel;
use Illuminate\Http\Request;
use App\Models\PriorityModel;
use App\Models\ComplaintModel;
use App\Exports\ProgressExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;


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
            Session::flash('success', 'Data Progress Canceled.');
            return redirect()->route('progress');
        } else {
            Session::flash('failed', 'Data Canceled Failed.');
        }
    }

    public function progress_hold_create($id = null)
    {
        // dd($id);
        // Gunakan $id untuk keperluan Anda, misalnya untuk penanganan khusus
        // atau filter data berdasarkan nilai $id

        $complaints = ComplaintModel::with('priority')
            ->orderBy('complaint_id', 'desc')
            ->get();

        $data = [
            'title' => 'Complaint Need',
            'complaints' => $complaints,
            'complaint_id' => $id, // Mengirim nilai $id ke view
        ];
        // dd($data);
        return view('progress/add', compact('data'));
    }

    public function progress_hold_store(Request $request)
    {
        Session::flash('txtNeedName', $request->txtNeedName);
        Session::flash('txtNeedQty', $request->txtNeedQty);
        Session::flash('txtNeedPrice', $request->txtNeedPrice);
        Session::flash('txtNeedDetail', $request->txtNeedDetail);


        Session::flash('selComplaint', $request->selComplaint);
        $complaint = DB::table('ms_complaint')->where('complaint_id', '=', $request->selComplaint)->first();
        if ($complaint) {
            Session::flash('txtComplaint', $complaint->complaint_name);
        }

        // dd($complaint);
        $request->validate([
            'txtNeedName' => 'required',
            'txtNeedQty' => 'required',
        ], [
            'txtNeedName.required' => 'Item Name Required.',
            'txtNeedQty.required' => 'Item Quantity Required.',

        ]);

        $complaint_id = $request->input('selComplaint');
        $need_item = $request->input('txtNeedName');
        $need_qty = $request->input('txtNeedQty');
        $need_price = $request->input('txtNeedPrice');
        $need_detail = $request->input('txtNeedDetail');
        $created_at = now();

        $data = [
            'complaint_id' => $complaint_id,
            'need_item' => $need_item,
            'need_qty' => $need_qty,
            'need_price' => $need_price,
            'need_detail' => $need_detail,
            'created_at' => $created_at,
        ];


        $NeedModel = new NeedModel();
        $insert = $NeedModel->insert($data);

        if ($insert) {

            $complaint = ComplaintModel::find($complaint_id);
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
            $status_id = '4'; // Anda mungkin ingin mengambil nilai ini dari input atau data lain

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
                Session::flash('success', 'Data Progress On Hold.');
                return redirect()->route('progress');
            }
        } else {
            Session::flash('failed', 'Data Failed to Insert.');
        }
    }

    // public function progress_hold(Request $request, $id)
    // {

    //     $complaint = ComplaintModel::find($id);
    //     // dd($complaint);
    //     if (!$complaint) {
    //         Session::flash('error', 'Complaint not found.');
    //         return redirect()->route('queue');
    //     }


    //     // Menggunakan data complaint langsung tanpa perlu foreach
    //     $complaint_name = $complaint->complaint_name;
    //     $complaint_reporter = $complaint->complaint_reporter;
    //     $complaint_location = $complaint->complaint_location;
    //     $complaint_time = $complaint->complaint_time;
    //     $complaint_date = $complaint->complaint_date;
    //     $complaint_desc = $complaint->complaint_desc;
    //     $compalint_priority = $complaint->priority_id;
    //     $status_id = '4'; // Anda mungkin ingin mengambil nilai ini dari input atau data lain

    //     $data = [
    //         'complaint_name' => $complaint_name,
    //         'complaint_reporter' => $complaint_reporter,
    //         'complaint_location' => $complaint_location,
    //         'complaint_time' => $complaint_time,
    //         'complaint_date' => $complaint_date,
    //         'priority_id' => $compalint_priority,
    //         'complaint_desc' => $complaint_desc,
    //         'status_id' => $status_id,
    //     ];
    //     // dd($data);

    //     $update = $complaint->update($data);
    //     // dd($update);

    //     if ($update) {
    //         Session::flash('success', 'Data Progress Canceled.');
    //         return redirect()->route('progress');
    //     } else {
    //         Session::flash('failed', 'Data Canceled Failed.');
    //     }
    // }

    public function progress_export()
    {
        $columns = [
            'ms_complaint.*',
            'ms_priority.priority_name',
            'ms_status.status_name',
        ];

        $data = ComplaintModel::select($columns)
            ->join('ms_priority', 'ms_complaint.priority_id', '=', 'ms_priority.priority_id')
            ->join('ms_status', 'ms_status.status_id', '=', 'ms_complaint.status_id')
            ->where('ms_status.status_id', '=', 2)
            ->get();

        return Excel::download(new ProgressExport($data), 'Progress |' . Carbon::now()->timestamp . '.xlsx');
    }
}
