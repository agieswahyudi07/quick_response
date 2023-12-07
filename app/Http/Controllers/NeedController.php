<?php

namespace App\Http\Controllers;

use App\Models\NeedModel;
use Illuminate\Http\Request;

class NeedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function need_create()
    {
        $data = [
            'title' => 'Complaint Need'
        ];
        return view('need/add', compact('data'));
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
    public function show(NeedModel $needModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NeedModel $needModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NeedModel $needModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NeedModel $needModel)
    {
        //
    }
}
