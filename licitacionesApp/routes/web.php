<?php

use App\Http\Controllers\GeneralQuerys;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function(){
    return redirect()->route('productos');
})->name('home');

Route::get('/version', function(){
    return response()->json(['version' => config('app.version')]);
})->name('version');

Route::middleware('auth')->group(function () {

    Route::get('/productos', function(){
        return Inertia::render('Productos', [
            'currentRoute' => 'productos',
            'products'   => Product::all(),
        ]);
    })->name('productos');

    Route::get('/proveedores', function(){
        return Inertia::render('Proveedores', [
            'currentRoute'  => 'proveedores',
            'suppliers'     => Supplier::all(),
        ]);
    })->name('proveedores');

    Route::get('/cotizaciones', function(){
        return Inertia::render('Cotizaciones', [
            'currentRoute' => 'cotizaciones'
        ]);
    })->name('cotizaciones');

    /* Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); */
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {

    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::put('/product/{product}', [ProductController::class, 'replace'])->name('product.replace');

    Route::get('/files/product/{product}', [ProductController::class, 'download'])->name('product.download');

    Route::post('/quotation/products', [ProductController::class, 'quotation'])->name('product.quotation');

    Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
    Route::put('/supplier/{supplier}', [SupplierController::class, 'replace'])->name('supplier.replace');
    Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');

    Route::get('/search', [ProductController::class, 'search'])->name('product.search');

    Route::get('/list', [GeneralQuerys::class, 'list'])->name('list');
    
});