<?php

namespace App\Http\Controllers;

use App\Models\ComplaintModel;
use App\Models\HoldModel;
use Illuminate\Http\Request;

class HoldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $ComplaintModel = new ComplaintModel;        
        $complaint = ComplaintModel::orderBy('priority_id', 'asc')
            ->where('status_id', '=', 4)
            ->get();

        $data = [
            'title' => 'On Hold',
            'complaint' => $complaint
        ];
        return view('hold/index', compact('data'));
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
    public function show(HoldModel $holdModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HoldModel $holdModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HoldModel $holdModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HoldModel $holdModel)
    {
        //
    }
}
