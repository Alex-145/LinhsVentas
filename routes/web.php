<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Livewire\UserProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Livewire\BrandCrud;
use App\Livewire\CategoryCrud;
use App\Livewire\ClientManager;
use App\Livewire\ProductManager;
use App\Livewire\SalesComponent;
use App\Livewire\SalesList;
use App\Livewire\ServiceManager;
use App\Livewire\StockEntryComponent;
use App\Livewire\SupplierManager;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::resource('clients', ClientController::class);


Route::get('/clients', ClientManager::class)->name('clients.index');
Route::get('/products', ProductManager::class)->name('products.index');
Route::get('/sales/create', SalesComponent::class)->name('sales.create');
Route::get('/sales', SalesList::class)->name('sales.index');
Route::get('/brands', BrandCrud::class)->name('brands.index');
Route::get('/categories', CategoryCrud::class)->name('categories.index');
Route::get('/suppliers', SupplierManager::class)->name('suppliers.index');
Route::get('/stockentries/create', StockEntryComponent::class)->name('stockentries.create');
Route::get('/services', ServiceManager::class)->name('services.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/user/profilet', [UserProfileController::class, 'show'])->name('profile.showt');
});
// Route::resource('brands', BrandController::class);
// Route::resource('categories', CategoryController::class);

// Route::resource('products', ProductController::class);
// Route::resource('sales', SaleController::class);
// Route::get('/sales/products/search', [SaleController::class, 'searchProducts'])->name('sales.products.search');
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
