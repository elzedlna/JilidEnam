<?php

namespace App\Http\Controllers;

use App\Models\OrderCust;
use App\Models\OrderMenu;
use Illuminate\Http\Request;

class OrderCustController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Example: Retrieve all order menu items
        $orderCust = OrderCust::all();
        return view('orderlists.index', compact('orderCust'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Example: Show a form to create a new order menu item
        return view('orderlists.create');
    }

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
            OrderCust::create([
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderCust $orderCust)
    {
        // Example: Show details of a specific order menu item
        return view('orderlists.show', compact('orderCust'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderCust $orderCust)
    {
        // Example: Show form to edit a specific order menu item
        return view('orderlists.edit', compact('orderCust'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderCust $orderCust)
    {
        // Example: Update a specific order menu item
        $data = $request->validate([
            'menuid' => 'required|exists:menu,id',
            'quantity' => 'required|integer|min:1',
            // Add more validation rules as needed
        ]);

        $orderCust->update([
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
    public function destroy(OrderCust $orderCust)
    {
        $orderCust->delete();

        return redirect()->route('orderlists.index')
                        ->with('success', 'Order menu item deleted successfully!');
    }
}
