<?php

namespace App\Http\Controllers;
use App\Models\Instrument;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Show the form to create a new instrument
    public function makeNewItem()
    {
         // takes me to the create page where i can get access to a form to make a new instrument
        return view('pages.create'); 
       
    }
    // Store a new instrument
    public function createNewItem(Request $request)
    {
        $incomingData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        // clean the data
        $incomingData['name'] = strip_tags($incomingData['name']);
        $incomingData['description'] = strip_tags($incomingData['description']);
        $incomingData['user_id'] = auth()->id();
        // Create the new instrument
        Instrument::create($incomingData);
        // Redirect back to the product page
        return to_route('product');
    }

    // Show the form to edit an existing instrument
    public function editItem($id)
    {
        $instrument = Instrument::findOrFail($id); // Find the instrument by ID by using findorfail 
        return view('pages.edit', compact('instrument')); // Pass the instrument to the view
    }

    // Update an instrument
    public function updateItem(Request $request, $id)
    {
        $incomingData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        // clean the input data
        $incomingData['name'] = strip_tags($incomingData['name']);
        $incomingData['description'] = strip_tags($incomingData['description']);

        // Find the existing instrument by ID and update it
        $instrument = Instrument::findOrFail($id);
        $instrument->update($incomingData);

        // Redirect back to the product page
        return to_route('product');
    }

    //delete an instrument
    public function deleteItem($id){
        $instrument = Instrument::findOrFail($id);
        $instrument->delete();
        return to_route('product');
    }
}
