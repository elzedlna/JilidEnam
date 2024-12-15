<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Session;

class CartController extends Controller
{
    public function submitOrder(Request $request)
    {
        $userId = auth()->id(); // Get the authenticated user's ID
        $menuItems = $request->input('menu_items');
        $totalBill = $request->input('totalbill');

        foreach ($menuItems as $item) {
            Cart::create([
                'cartid' => null, // Will be set automatically
                'quantity' => $item['quantity'],
                'totalprice' => $item['price'] * $item['quantity'],
                'userid' => $userId,
                'menuitemid' => $item['id'],
            ]);
        }

        // Clear the cart session after order submission
        Session::forget('cart');

        return redirect()->route('cart')->with('success', 'Order submitted successfully!');
    }

    public function index()
    {
        return view('cart', ['newCart' => Cart::latest()->first()]);
    }

    public function addToCart(Request $request)
    {
        $menu = $request->input('menu');

        // Get the current cart session or initialize a new one
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$menu['id']])) {
            $cart[$menu['id']]['quantity'] += 1;
        } else {
            $cart[$menu['id']] = [
                'menuid' => $menu['id'],
                'name' => $menu['name'],
                'price' => $menu['price'],
                'quantity' => 1,
                'image' => $menu['image'],
            ];
        }

        // Save the cart back to the session
        $request->session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Item added to cart successfully!');
    }

    public function removeFromCart(Request $request, $itemId)
    {
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$itemId])) {
            unset($cart[$itemId]);
            $request->session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item removed from cart successfully!');
    }
}
