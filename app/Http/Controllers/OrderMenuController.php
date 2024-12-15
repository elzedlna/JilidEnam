<?php

namespace App\Http\Controllers;

use App\Models\OrderMenu; // Import the OrderMenu model
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class OrderMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function showStatus()
     {
         // Fetch order details from database (assuming OrderMenu model)
         $orders = OrderMenu::latest()->get();
 
         // Pass data to view
         return view('status', ['orders' => $orders]);
     }

    public function index()
    {
        // Example: Retrieve all order menu items
        $orderMenus = OrderMenu::all();
        return view('orderlists.index', compact('orderMenus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Example: Show a form to create a new order menu item
        return view('orderlists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function submitOrder(Request $request)
    {
        $data = $request->validate([
            'menu_items' => 'required|array',
            'menu_items.*.name' => 'required|string',
            'menu_items.*.price' => 'required|numeric|min:0',
            'menu_items.*.quantity' => 'required|integer|min:1',
            'menu_items.*.id' => 'required|exists:menu,menuid',
            'totalbill' => 'required|numeric|min:0',
            'ordermethod' => 'required|string',
        ]);

        foreach ($data['menu_items'] as $menuItem) {
            OrderMenu::create([
                'name' => $menuItem['name'],
                'price' => $menuItem['price'],
                'quantity' => $menuItem['quantity'],
                'menuid' => $menuItem['id'],
                'orderdate' => now()->toDateString(),
                'ordertime' => now()->toTimeString(),
                'ordermethod' => $data['ordermethod'],
                'menuname' => $menuItem['name'],
                'totalbill' => $data['totalbill'],
            ]);
        }

        return redirect()->route('status')->with('success', 'Order menu items created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(OrderMenu $orderMenu)
    {
        // Example: Show details of a specific order menu item
        return view('orderlists.show', compact('orderMenu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderMenu $orderMenu)
    {
        // Example: Show form to edit a specific order menu item
        return view('orderlists.edit', compact('orderMenu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderMenu $orderMenu)
    {
        // Example: Update a specific order menu item
        $data = $request->validate([
            'menuid' => 'required|exists:menu,id',
            'quantity' => 'required|integer|min:1',
            // Add more validation rules as needed
        ]);

        $orderMenu->update([
            'menuid' => $data['menuid'],
            'quantity' => $data['quantity'],
            // Update more fields as needed
        ]);

        return redirect()->route('orderlists.index')
                         ->with('success', 'Order menu item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderMenu $orderMenu)
    {
        $orderMenu->delete();

        return redirect()->route('orderlists.index')
                        ->with('success', 'Order menu item deleted successfully!');
    }
}
