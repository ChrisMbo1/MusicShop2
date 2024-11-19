<?php
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Models\Instrument;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/product', function () {
    $instruments = Instrument::all();
    return view('pages.product', ['instruments' => $instruments]);
})->name('product');

// Routes for the cart page
Route::get('/cart', function () {
    return view('pages.cart');
})->name('cart');

// Group for authenticated users
Route::middleware(EnsureUserIsAdmin::class)->group(function () {
    Route::get('/create', [ProductController::class, 'makeNewItem'])->name('create');
    Route::post('/create', [ProductController::class, 'createNewItem']);
    Route::get('/edit/{id}', [ProductController::class, 'editItem'])->name('edit');
    Route::put('/edit/{id}', [ProductController::class, 'updateItem']);
    Route::delete('/edit/{id}', [ProductController::class, 'deleteItem'])->name('delete');
    Route::post('/cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route for the dashboard (only accessible for authenticated users)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
