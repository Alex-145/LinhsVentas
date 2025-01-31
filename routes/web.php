<?php


use App\Http\Controllers\Livewire\UserProfileController;
use App\Livewire\BrandCrud;
use App\Livewire\CategoryCrud;
use App\Livewire\ClientManager;
use App\Livewire\Pageweb\Contactenos;
use App\Livewire\Pageweb\Nosotros;
use App\Livewire\Pageweb\Products;
use App\Livewire\Pageweb\Service;
use App\Livewire\ProductManager;
use App\Livewire\Producto\ProductLowStock;
use App\Livewire\SalesComponent;
use App\Livewire\SalesList;
use App\Livewire\ServiceManager;
use App\Livewire\StockEntryComponent;
use App\Livewire\StockEntryList;
use App\Livewire\SupplierManager;
use App\Livewire\YourProfile;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

Route::get('/', function () {
    return view('livewire.pageweb.inicio');
});

Route::get('/sales/{sale}/pdf', [SalesList::class, 'generateSalePdf'])->name('sales.generatePdf');

Route::get('/wproducts', Products::class)->name('wproducts.index');
Route::get('/wservices', Service::class)->name('wservices.index');
Route::get('/wnosotros', Nosotros::class)->name('wnosotros.index');
Route::get('/wcontactenos', Contactenos::class)->name('wcontactenos.index');




// Route::get('/gas', Inicio::class)->name('inicio');
// Route::resource('clients', ClientController::class);

Route::middleware(['auth'])->group(function () {
    Route::get('/clients', ClientManager::class)->name('clients.index');
    Route::get('/user/profile', YourProfile::class)->name('profile.show');
    Route::get('/products', ProductManager::class)->name('products.index');
    Route::get('/sales/create', SalesComponent::class)->name('sales.create');
    Route::get('/sales', SalesList::class)->name('sales.index');
    Route::get('/brands', BrandCrud::class)->name('brands.index');
    Route::get('/categories', CategoryCrud::class)->name('categories.index');
    Route::get('/suppliers', SupplierManager::class)->name('suppliers.index');
    Route::get('/stockentries/create', StockEntryComponent::class)->name('stockentries.create');
    Route::get('/services', ServiceManager::class)->name('services.index');
    Route::get('/stockentries', StockEntryList::class)->name('stockentries.index');
    Route::get('/lowstock', ProductLowStock::class)->name('lowstock.index');


    // Ruta de registro protegida
    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register')
        ->middleware('auth');
    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('auth');
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
