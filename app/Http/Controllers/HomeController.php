<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Menu;
use App\Models\OrderList;
use App\Models\OrderMenu;
use App\Models\OrderCust;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
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
        return view('home');
    }

    public function home()
    {
        $userCount = User::count();
        $menuCount = Menu::count();
        $eventCount = Event::count();
        $orderListCount = OrderCust::count();

        return view('home', compact('userCount', 'menuCount', 'eventCount', 'orderListCount'));
    }
}
