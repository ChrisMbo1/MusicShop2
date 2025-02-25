@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4" style="margin-left: 15px; font-size:30px; text-align: center; color: #333;">Shopping Cart</h1>
    <div class="row">
        <div class="wrapper">
            <article>
                <div style="padding: 20px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">
                    @if(session('cart') && count(session('cart')) > 0)
                        <ul style="list-style-type: none; padding: 0;">
                            @php $total = 0; @endphp <!-- total -->
                            @foreach(session('cart') as $id => $instrument)
                                <li style="padding: 10px; border-bottom: 1px solid #ccc;">
                                    <strong style="font-size: 18px; color: #007bff;">{{ $instrument['name'] }}</strong><br>
                                    <span style="color: #666;">Description: {{ $instrument['description'] ?? 'No description available.' }}</span><br>
                                    <span style="font-weight: bold;">Price: ${{ number_format($instrument['price'], 2) }}</span><br>
                                    <span style="font-weight: bold;">Quantity: {{ $instrument['quantity'] }}</span><br>
                                    @php $total += $instrument['price'] * $instrument['quantity']; @endphp <!-- Calculatetotal price -->
                                </li>
                            @endforeach
                        </ul>
                        <div style="margin-top: 15px; font-size: 18px; font-weight: bold; text-align: left;">
                            Total: ${{ number_format($total, 2) }} <!-- Display total -->
                        </div>
                    @else
                        <p style="text-align: center; font-size: 18px; color: #999;">Your cart is empty.</p>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; border-radius: 5px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Display checkout button only if cart has items -->
                    @if(session('cart') && count(session('cart')) > 0)
                        <div style="text-align: center; margin-top: 20px;">
                            <button style="padding: 10px 20px; font-size: 16px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                                Checkout
                            </button>
                        </div>
                    @endif
                </div>
            </article>
        </div>
    </div>
</div>
@endsection
