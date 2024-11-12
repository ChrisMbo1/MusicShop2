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

    // Check if the instrument is in stock
    if ($instrument->stock > 0) {
        // Get the current cart from the session, or create an empty cart if none exists
        $cart = session()->get('cart', []);

        // Check if the instrument is already in the cart
        if (isset($cart[$id])) {
            // Increase the quantity if already in the cart
            if ($cart[$id]['quantity'] < $instrument->stock) { // Check if there is enough stock
                $cart[$id]['quantity']++;
            } else {
                return response()->json(['error' => 'Not enough stock available.'], 400);
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
        $instrument->stock--; // Decrement stock
        $instrument->save(); // Save the changes to the database

        return redirect()->route('cart');
    } else {
        return response()->json(['error' => 'Instrument is out of stock.'], 400);
    }
}
}