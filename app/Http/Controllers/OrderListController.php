<?php

namespace App\Http\Controllers;

use App\Models\OrderCust;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\OrderMenu;


class OrderListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderlist = OrderCust::all();
        return view('orderlists.index',compact('orderlist'));
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
        // Validate incoming request data
        $request->validate([
            // Add validation rules here if needed
        ]);

        // Retrieve or create an OrderCust record
        $orderCust = OrderCust::create([
            'userid' => Auth::custid(), // Assuming you have authentication and user id
            'orderdate' => now()->toDateString(),
            'ordertime' => now()->toTimeString(),
            // Add other fields as needed
        ]);

        // Now handle the order items (menu items) and store them in ordermenu table
        if ($orderCust) {
            $cart = $request->session()->get('cart', []);

            foreach ($cart as $itemId => $item) {
                $menu = Menu::find($itemId);

                if ($menu) {
                    OrderCust::create([
                        'ordercustid' => $orderCust->ordercustid,
                        'menuid' => $menu->menuid,
                        'quantity' => $item['quantity'],
                        // Add other fields as needed
                    ]);
                }
            }

            // Optionally, clear the cart session after storing the order
            $request->session()->forget('cart');

            return redirect()->route('payment')->with('success', 'Order details stored successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to store order details.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderCust $orderlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderCust $orderList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderCust $orderList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderCust $orderCust)
    {
        $orderCust->delete();

        return redirect()->route('orderlists.index')->with('success', 'Order menu item deleted successfully!');
    }
}
