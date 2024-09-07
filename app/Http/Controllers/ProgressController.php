<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\NeedModel;
use Illuminate\Http\Request;
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
    public function index_admin()
    {
        try {
            $complaints = ComplaintModel::orderBy('priority_id', 'asc')
                ->where('status_id', '=', 2)
                ->get();

            $formattedComplaints = $complaints->map(function ($complaint) {
                $complaint->proceed_at_time = Carbon::parse($complaint->proceed_at)->format('H:i');
                $complaint->proceed_at_date = Carbon::parse($complaint->proceed_at)->format('Y-m-d');
                return $complaint;
            });

            $data = [
                'title' => 'On Progress',
                'complaint' => $formattedComplaints
            ];
            return view('admin/progress/index', compact('data'));
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function index_user()
    {
        try {
            $complaints = ComplaintModel::orderBy('priority_id', 'asc')
                ->where('status_id', '=', 2)
                ->get();

            $formattedComplaints = $complaints->map(function ($complaint) {
                $complaint->proceed_at_time = Carbon::parse($complaint->proceed_at)->format('H:i');
                $complaint->proceed_at_date = Carbon::parse($complaint->proceed_at)->format('Y-m-d');
                return $complaint;
            });

            $data = [
                'title' => 'On Progress',
                'complaint' => $formattedComplaints
            ];
            return view('user/progress/index', compact('data'));
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function progress_show_admin($id)
    {
        try {
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

            return view('admin.progress.show', compact('data'));
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function progress_show_user($id)
    {
        try {
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

            return view('user.progress.show', compact('data'));
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function progress_completed_create($id = null)
    {
        try {
            $complaints = ComplaintModel::with('priority')
                ->orderBy('complaint_id', 'desc')
                ->where('complaint_id', $id)
                ->get();

            $data = [
                'title' => 'Complaint Need',
                'complaints' => $complaints,
                'complaint_id' => $id,
            ];

            return view('admin/progress/completed', compact('data'));
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function progress_completed_store(Request $request)
    {
        try {
            Session::flash('txtTroubleCause', $request->txtTroubleCause);
            Session::flash('txtTroubleSolution', $request->txtTroubleSolution);
            Session::flash('selComplaint', $request->selComplaint);
            $complaint = DB::table('ms_complaint')->where('complaint_id', '=', $request->selComplaint)->first();
            if ($complaint) {
                Session::flash('txtComplaint', $complaint->complaint_name);
            }

            $request->validate([
                'txtTroubleCause' => 'required',
                'txtTroubleSolution' => 'required',
            ], [
                'txtTroubleCause.required' => 'Trouble Cause Required.',
                'txtTroubleSolution.required' => 'Trouble Solution Required.',

            ]);

            $complaint_id = $request->input('selComplaint');
            $complaint_cause = $request->input('txtTroubleCause');
            $complaint_solution = $request->input('txtTroubleSolution');
            $completed_at = now();

            $update = ComplaintModel::where('complaint_id', $complaint_id)
                ->update([
                    'complaint_cause' => $complaint_cause,
                    'complaint_solution' => $complaint_solution,
                    'completed_at' => $completed_at,
                ]);
            if ($update) {
                $completed = ComplaintModel::where('complaint_id', $complaint_id)
                    ->update([
                        'status_id' => '3',
                    ]);

                if ($completed) {
                    Session::flash('success', 'Data Progress Completed.');
                    return redirect()->route('admin.progress');
                }
            } else {
                Session::flash('failed', 'Data Failed to Insert.');
            }
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }


    // On Progress Cancel
    public function progress_cancel(Request $request, $id)
    {
        try {
            $complaint = ComplaintModel::find($id);
            if (!$complaint) {
                Session::flash('error', 'Complaint not found.');
                return redirect()->route('queue');
            }

            $complaint_name = $complaint->complaint_name;
            $complaint_reporter = $complaint->complaint_reporter;
            $complaint_location = $complaint->complaint_location;
            $complaint_time = $complaint->complaint_time;
            $complaint_date = $complaint->complaint_date;
            $complaint_desc = $complaint->complaint_desc;
            $compalint_priority = $complaint->priority_id;
            $status_id = '1';

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

            $update = $complaint->update($data);

            if ($update) {
                Session::flash('success', 'Data Progress Canceled.');
                return redirect()->route('admin.progress');
            } else {
                Session::flash('failed', 'Data Canceled Failed.');
            }
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function progress_hold_create($id = null)
    {
        try {
            $complaints = ComplaintModel::with('priority')
                ->orderBy('complaint_id', 'desc')
                ->get();

            $data = [
                'title' => 'Complaint Need',
                'complaints' => $complaints,
                'complaint_id' => $id,
            ];
            return view('admin/progress/add', compact('data'));
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function progress_hold_store(Request $request)
    {
        try {
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
            $need_qty = intval(str_replace(',', '',  $request->input('txtNeedQty')));
            $need_price = intval(str_replace(',', '',  $request->input('txtNeedPrice')));
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
                    return redirect()->route('admin.progress');
                }
            } else {
                Session::flash('failed', 'Data Failed to Insert.');
            }
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function progress_export()
    {
        try {
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

            return Excel::download(new ProgressExport($data), 'Progress-' . Carbon::now()->format('d-m-Y') . '.xlsx');
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }
}
