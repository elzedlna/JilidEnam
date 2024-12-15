<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcust');
    }

    public function dashboard()
{
    // Assuming you are using Auth to get the authenticated user
    $user = Auth::user();
    $breadcrumbs = [
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'Dashboard', 'url' => route('welcust')],
    ];

    return view('dashboard', compact('breadcrumbs'));
    return view('welcust', compact('user'));
}
}
