@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4" style="margin-left: 15px; font-size:30px;">Edit Instrument</h1>
    <div class="row">
        <form action="{{ route('edit', $instrument->id) }}" method="POST" style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; background-color: #f9f9f9;">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 15px;">
                <label for="name" style="display: block; font-weight: bold; margin-bottom: 5px;">Name</label>
                <input type="text" id="name" name="name" placeholder="Instrument Name" required value="{{ old('name', $instrument->name) }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label for="price" style="display: block; font-weight: bold; margin-bottom: 5px;">Price</label>
                <input type="text" id="price" name="price" placeholder="Instrument Price" required value="{{ old('price', $instrument->price) }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label for="stock" style="display: block; font-weight: bold; margin-bottom: 5px;">Stock</label>
                <input type="text" id="stock" name="stock" placeholder="Instrument Stock" required value="{{ old('stock', $instrument->stock) }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="description" style="display: block; font-weight: bold; margin-bottom: 5px;">Description</label>
                <textarea id="description" name="description" placeholder="Instrument Description" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px;">{{ old('description', $instrument->description) }}</textarea>
            </div>

            <button type="submit" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer;">
                Save
            </button>
        </form>

        <!-- Delete section -->
        <form action="{{ route('edit', $instrument->id) }}" method="POST" style="margin-top: 20px;">
            @csrf
            @method('DELETE')
            <button type="submit" style="margin-left: 980px; padding: 10px 20px; background-color: red; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer;">
                Delete
            </button>
        </form>
    </div>
</div>
@endsection
