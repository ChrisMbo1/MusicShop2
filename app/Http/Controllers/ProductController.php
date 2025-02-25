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
            'image' => 'nullable|mimes:png,jpeg,jpg,webp',
        ]);

        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = $image->storeAs('uploads', $filename, 'public');  // This will save the file in 'storage/app/public/uploads'
        }
    
          // clean the input data so that it doenst contain any html tags
        $incomingData['name'] = strip_tags($incomingData['name']);
        $incomingData['description'] = strip_tags($incomingData['description']);
        $incomingData['image'] = $path ?? null;
        $incomingData['user_id'] = auth()->id();
    
        // new instrument
        Instrument::create($incomingData);
        return to_route('product');
    }

    // Show the form to edit an existing instrument on the HoMe page
    public function editItem($id)
    {
        $instrument = Instrument::findOrFail($id); // Find the instrument by ID
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
            'image' => 'nullable|mimes:png,jpeg,jpg,webp',
        ]);

        if ($request->has('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
        
          
            $path = $file->storeAs('uploads', $filename, 'public'); 
        
            // Store the pathw in the database
            $incomingData['image'] = $path; // Store the relative path (e.g., 'uploads/filename.jpg')
        }

      
        $incomingData['name'] = strip_tags($incomingData['name']);
        $incomingData['description'] = strip_tags($incomingData['description']);
        $incomingData['image'] = $path.$filename;
        // Find the existing instrument by ID and update it
        $instrument = Instrument::findOrFail($id);
        $instrument->update($incomingData);
        return to_route('product');
    }

    //delete an instrument
    public function deleteItem($id){
        $instrument = Instrument::findOrFail($id);
        $instrument->delete();
        return to_route('product');
    }
}
