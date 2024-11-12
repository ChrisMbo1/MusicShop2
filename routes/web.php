<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Models\Instrument;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.home');})->name('home');

    Route::get('/product', function () {
        $instruments = Instrument::all();
        return view('pages/product', ['instruments' => $instruments]);
    })->name('product');
    
    // Route for the cart page
    Route::get('/cart', function () {
        return view('pages.cart');})->name('cart');
    
    
    // Route to show the form to create a new instrument
    Route::get('/create', [ProductController::class, 'makeNewItem'])->name('create');
    
    // Route to store the new instrument
    Route::post('/create', [ProductController::class, 'createNewItem']);
    
    // Route to show the edit form for a specific instrument
    Route::get('/edit/{id}', [ProductController::class, 'editItem'])->name('edit');
    
    // Route to update the instrument
    Route::put('/edit/{id}', [ProductController::class, 'updateItem']);
    
    //Route for the delete function
    Route::delete('/edit/{id}', [ProductController::class, 'deleteItem'])->name('delete');

    // Route to add an instrument to the cart
Route::post('/cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');


// Route to remove an instrument from the cart
Route::delete('/cart/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
