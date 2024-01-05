<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\NeedModel;
use App\Exports\NeedExport;
use Illuminate\Http\Request;
use App\Models\ComplaintModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class NeedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $need = NeedModel::with('complaint')
            ->orderBy('need_id', 'asc')
            ->get();

        $data = [
            'title' => 'Need',
            'need' => $need
        ];
        return view('need/index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function need_create($id = null)
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
        return view('need/add', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function need_store(Request $request)
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
            Session::flash('success', 'Data successfully Inserted.');
            return redirect()->route('need');
        } else {
            Session::flash('failed', 'Data Failed to Insert.');
        }
    }

    public function need_export()
    {
        $columns = [
            'ms_need.*',
            'ms_complaint.complaint_name',
            'ms_priority.priority_name',
        ];

        $data = NeedModel::select($columns)
            ->join('ms_complaint', 'ms_need.complaint_id', '=', 'ms_complaint.complaint_id')
            ->join('ms_priority', 'ms_complaint.priority_id', '=', 'ms_priority.priority_id')
            ->get();
        // dd($data);
        return Excel::download(new NeedExport($data), 'Queue |' . Carbon::now()->timestamp . '.xlsx');
    }
}
