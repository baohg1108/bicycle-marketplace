<?php

use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\KycController;       
use App\Http\Controllers\Frontend\ProductPageController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\StoreController;
use App\Http\Controllers\Frontend\VendorDashboardController;
use App\Http\Controllers\Frontend\VendorProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('/products', [ProductPageController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductPageController::class, 'show'])->name('products.show');

// Cart routes
ROute::get('/cart', [CartController::class, 'index'])->name('cart.index');
 Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'profileUpdate'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'passwordUpdate'])->name('password.update');

    // KYC routes
    Route::get('/kyc-verification', [KycController::class, 'index'])->name('kyc.index');
    Route::post('/kyc-verification', [KycController::class, 'store'])->name('kyc.store');


});

// Vendor routes
Route::prefix('vendor')->name('vendor.')->middleware(['auth', 'verified', 'user_role:vendor'])->group(function () {
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');

    // Store profile
    Route::resource('store-profile', StoreController::class);

    // Products
    Route::get('/products', [VendorProductController::class, 'index'])->name('products.index');
    Route::get('/products/{type}/create', [VendorProductController::class, 'create'])->name('products.create');
    Route::post('/products/{type}/create', [VendorProductController::class, 'store'])->name('products.store');
    Route::get('/products/physical/{product}/edit', [VendorProductController::class, 'edit'])->name('products.edit');
    Route::post('/products/physical/{product}/update', [VendorProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [VendorProductController::class, 'destroy'])->name('products.destroy');

    // Product images
    Route::post('/products/images/upload/{product}', [VendorProductController::class, 'uploadImages'])->name('products.images.upload');
    Route::delete('/products/images/{image}', [VendorProductController::class, 'destroyImage'])->name('products.images.destroy');
    Route::post('/products/images/reorder', [VendorProductController::class, 'imagesReorder'])->name('products.images.reorder');

    // Product attributes
    Route::post('/products/attributes/{product}/store', [VendorProductController::class, 'storeAttributes'])->name('products.attributes.store');
    Route::delete('/products/attributes/{product}/{attribute}', [VendorProductController::class, 'destroyAttribute'])->name('products.attributes.destroy');

    // Product variants
    Route::post('/products/variants/{product}/update', [VendorProductController::class, 'updateVariants'])->name('products.variants.update');

    // Digital products
    Route::get('/products/digital/{product}/edit', [VendorProductController::class, 'editDigitalProduct'])->name('digital-products.edit');
    Route::post('/products/digital/file-upload', [VendorProductController::class, 'uploadDigitalProductFile'])->name('digital-products.file.upload');
    Route::delete('/products/digital/{product}/{file}', [VendorProductController::class, 'destroyDigitalProductFile'])->name('digital-products.file.destroy');
});

require __DIR__ . '/auth.php';