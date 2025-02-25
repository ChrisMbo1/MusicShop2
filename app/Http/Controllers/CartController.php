<?php

namespace App\Http\Controllers;
use App\Models\Instrument;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart($id)
    {
        // get ID
        $instrument = Instrument::findOrFail($id);
    
        // check if logged in
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You need to log in to add items to the cart.');
        }
    
        // Check if the instrument is in stock
        if ($instrument->stock >= 1) {
            // Get the current cart from the session, or create an empty cart if it doesnt  exists
            $cart = session()->get('cart', []);
    
            // Check if the instrument is already in the cart
            if (isset($cart[$id])) {
                // make it so that if quantity is 0 you cant put anymore in cart
                if ($cart[$id]['quantity'] < $instrument->stock) {
                    $cart[$id]['quantity']++;
                } else {
                    return back()->with('error', 'Not enough stock available.');
                }
            } else {
                // Add new item to the cart
                $cart[$id] = [
                    'name' => $instrument->name,
                    'description' => $instrument->description,
                    'quantity' => 1,
                    'price' => $instrument->price,
                    'stock' => $instrument->stock,
                ];
            }
    
            // Save the cart back to the session
            session()->put('cart', $cart);
    
            // Decrease the stockin the database
            $instrument->decrement('stock');
    
            return redirect()->route('cart')->with('success', 'Item added to cart.');
        } else {
            return back()->with('error', 'Instrument is out of stock.');
        }
    }
    
}