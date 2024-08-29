<?php

namespace App\Http\Controllers;

use App\Models\SesiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SesiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sesi/login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login(Request $request)
    {
        try {
            Session::flash('email', $request->email);

            $request->validate([
                'email' => 'required',
                'password' => 'required',
            ], [
                'email.required' => 'Please fill the email.',
                'password.required' => 'Please fill the password.',
            ]);

            $login = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            if (Auth::attempt($login)) {
                if (Auth::user()->role == 'admin') {
                    return redirect()->route('admin.dashboard');
                } elseif (Auth::user()->role == 'user') {
                    return redirect()->route('user.dashboard');
                }
            } else {
                Session::flash('failed', 'email or password is invalid');
                return redirect()->route('login');
            }
        } catch (\Throwable $th) {
            Session::flash($th->getMessage());
            return redirect()->route('login')->withErrors($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    /**
     * Display the specified resource.
     */
    public function show(SesiModel $sesiModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SesiModel $sesiModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SesiModel $sesiModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SesiModel $sesiModel)
    {
        //
    }
}
