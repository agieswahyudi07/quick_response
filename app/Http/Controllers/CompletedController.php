<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ComplaintModel;
use App\Exports\CompletedExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class CompletedController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index_admin(Request $request)
    {
        try {
            $query = ComplaintModel::query();

            if (!empty($request->filterFromDateInput) && !empty($request->filterToDateInput)) {
                $filterFromDateInput = Carbon::createFromFormat('Y-m-d', $request->filterFromDateInput);
                $filterToDateInput = Carbon::createFromFormat('Y-m-d', $request->filterToDateInput);

                if ($filterFromDateInput > $filterToDateInput) {
                    return redirect()->back()->withErrors('from date cannot be grater than to date.');
                }

                Session::flash('dateFromFilter', $filterFromDateInput->format('Y-m-d'));
                Session::flash('dateToFilter', $filterToDateInput->format('Y-m-d'));

                $query->whereBetween('completed_at', [$filterFromDateInput->startOfDay(), $filterToDateInput->endOfDay()]);
            } else {
                $query->where('status_id', '=', 3)
                    ->orderBy('priority_id', 'asc');

                Session::forget(['dateFromFilter', 'dateToFilter']);
            }

            $complaints = $query->get();
            $formattedComplaints = $complaints->map(function ($complaint) {
                $complaint->proceed_at_time = Carbon::parse($complaint->proceed_at)->format('H:i');
                $complaint->proceed_at_date = Carbon::parse($complaint->proceed_at)->format('Y-m-d');
                $complaint->completed_at_time = Carbon::parse($complaint->completed_at)->format('H:i');
                $complaint->completed_at_date = Carbon::parse($complaint->completed_at)->format('Y-m-d');
                return $complaint;
            });

            $data = [
                'title' => 'Completed',
                'complaint' => $formattedComplaints,
            ];

            return view('admin/completed/index', compact('data'));
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function index_admin_filter(Request $request)
    {
        try {
            $query = ComplaintModel::query();

            if (!empty($request->filterFromDateInput) && !empty($request->filterToDateInput)) {
                $filterFromDateInput = Carbon::createFromFormat('Y-m-d', $request->filterFromDateInput);
                $filterToDateInput = Carbon::createFromFormat('Y-m-d', $request->filterToDateInput);

                if ($filterFromDateInput > $filterToDateInput) {
                    return redirect()->back()->withErrors('from date cannot be grater than to date.');
                }

                Session::flash('dateFromFilter', $filterFromDateInput->format('Y-m-d'));
                Session::flash('dateToFilter', $filterToDateInput->format('Y-m-d'));

                $query->whereBetween('completed_at', [$filterFromDateInput->startOfDay(), $filterToDateInput->endOfDay()]);
            } else {
                $query->where('status_id', '=', 3)
                    ->orderBy('priority_id', 'asc');

                Session::forget(['dateFromFilter', 'dateToFilter']);
            }

            $complaints = $query->get();
            $formattedComplaints = $complaints->map(function ($complaint) {
                $complaint->proceed_at_time = Carbon::parse($complaint->proceed_at)->format('H:i');
                $complaint->proceed_at_date = Carbon::parse($complaint->proceed_at)->format('Y-m-d');
                $complaint->completed_at_time = Carbon::parse($complaint->completed_at)->format('H:i');
                $complaint->completed_at_date = Carbon::parse($complaint->completed_at)->format('Y-m-d');
                return $complaint;
            });

            $data = [
                'title' => 'Completed',
                'complaint' => $formattedComplaints,
            ];

            return view('admin/completed/index', compact('data'));
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }


    public function index_user(Request $request)
    {
        try {
            //code...
            $query = ComplaintModel::orderBy('priority_id', 'asc')
                ->where('status_id', '=', 3);

            // Filter berdasarkan tanggal jika ada dalam request
            if ($request->has('filter_date')) {
                $filterDate = $request->input('filter_date');

                // Jika filter_date kosong, abaikan filter tanggal
                if (!empty($filterDate)) {
                    $query->whereDate('completed_at', '=', $filterDate);
                }
            }

            $complaints = $query->get();

            $formattedComplaints = $complaints->map(function ($complaint) {
                $complaint->proceed_at_time = Carbon::parse($complaint->proceed_at)->format('H:i');
                $complaint->proceed_at_date = Carbon::parse($complaint->proceed_at)->format('Y-m-d');
                $complaint->completed_at_time = Carbon::parse($complaint->completed_at)->format('H:i');
                $complaint->completed_at_date = Carbon::parse($complaint->completed_at)->format('Y-m-d');
                return $complaint;
            });

            $data = [
                'title' => 'Completed',
                'complaint' => $formattedComplaints,
                'complaint_date_filter' => $complaints, // Memasukkan hasil query tanpa format
            ];

            return view('user/completed/index', compact('data'));
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }


    public function completed_show_admin($id)
    {
        try {
            $complaint = ComplaintModel::with('status')
                ->with('priority')
                ->where('complaint_id', '=', $id)
                ->first();

            $complaint->proceed_at_time = Carbon::parse($complaint->proceed_at)->format('H:i');
            $complaint->proceed_at_date = Carbon::parse($complaint->proceed_at)->format('Y-m-d');

            if ($complaint->completed_at) {
                $complaint->completed_at_time = Carbon::parse($complaint->completed_at)->format('H:i');
                $complaint->completed_at_date = Carbon::parse($complaint->completed_at)->format('Y-m-d');
            }

            $title = "Item Details";

            $data = [
                'complaint' => $complaint,
                'title' => $title,
            ];

            return view('admin.completed.show', compact('data'));
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }

    public function completed_show_user($id)
    {
        try {
            //code...
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

            return view('user.completed.show', compact('data'));
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }



    public function completed_export()
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
                ->where('ms_status.status_id', '=', 3)
                ->get();

            return Excel::download(new CompletedExport($data), 'Completed-' . Carbon::now()->format('d-m-Y') . '.xlsx');
        } catch (\Throwable $th) {
            Session::flash('failed', $th->getMessage());
            return redirect()->back();
        }
    }
}
