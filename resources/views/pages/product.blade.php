@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4" style="font-size: 36px; font-weight: bold; color: #333;">Instruments</h1>
        <div class="row">
            @foreach($instruments as $instrument)
                <div class="col-md-4 mb-4" style="padding: 15px;">
                    <div class="instrument-card" style="border: 1px solid #ddd; border-radius: 12px; padding: 20px; background-color: #f7f7f7; transition: transform 0.3s ease-in-out; box-sizing: border-box; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                        <h3 class="instrument-name" style="margin: 0; font-size: 24px; font-weight: bold; color: #444;">{{ $instrument->name }}</h3>
                        <p class="instrument-description" style="margin: 10px 0; font-size: 14px; color: #666;">{{ $instrument->description }}</p>
                        <p class="instrument-price" style="margin: 10px 0; font-size: 16px; font-weight: bold; color: #27ae60;">Price: ${{ number_format($instrument->price, 2) }}</p>
                        <p class="instrument-stock" style="margin: 10px 0; font-size: 14px; color: #e74c3c;">Stock: {{ $instrument->stock }}</p>
                        <img src="{{ asset('storage/' . $instrument->image) }}" style="max-height: 200px; max-width:200px; margin-top: 15px;"  alt="Instrument Image">




                        <!-- Button Styling -->
                        <form action="{{ route('cart.add', $instrument->id) }}" method="POST">
                            @csrf
                            <button style="padding: 3px; background-color: grey; border: none; color: white; cursor: pointer;" type="submit">Buy</button>
                        </form>
                        <!-- Edit button for Admins -->
                        @if(auth()->user() && auth()->user()->is_admin)
                            <a href="{{ route('edit', $instrument->id) }}" class="edit-btn" style="display: inline-block; margin-top: 10px; padding: 8px 16px; background-color: #2ecc71; border: none; color: white; cursor: pointer; border-radius: 6px; font-size: 14px; font-weight: bold; transition: background-color 0.3s ease;">
                                Edit
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
