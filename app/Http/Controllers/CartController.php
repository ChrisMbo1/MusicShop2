<?php

namespace App\Http\Controllers;
use App\Models\Instrument;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart($id)
    {
        // Get the instrument by ID
        $instrument = Instrument::findOrFail($id);
    
        // Check if the user is logged in
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You need to log in to add items to the cart.');
        }
    
        // Check if the instrument is in stock
        if ($instrument->stock >= 1) {
            // Get the current cart from the session, or create an empty cart if none exists
            $cart = session()->get('cart', []);
    
            // Check if the instrument is already in the cart
            if (isset($cart[$id])) {
                // Ensure quantity doesn't exceed stock
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
    
            // Decrease the stock of the instrument in the database
            $instrument->decrement('stock');
    
            return redirect()->route('cart')->with('success', 'Item added to cart.');
        } else {
            return back()->with('error', 'Instrument is out of stock.');
        }
    }
    
}