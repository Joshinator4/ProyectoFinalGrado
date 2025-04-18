<?php
//Las rutas más básicas de Laravel aceptan una URI y un cierre, lo que proporciona un método muy simple y expresivo para definir rutas y comportamiento sin archivos de configuración de enrutamiento complicados

//acordarse de importar(use) las rutas de los controladores
//hay que tener cuidado con el orden de las rutas
//hay rutas de tipo get, post, patch, put, delete y match

use App\Http\Controllers\Panel\PanelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\ProductController;


// 🛑 Proteger las demás rutas con 'is.admin'
Route::middleware(['auth', 'is.admin', 'verified'])
->group(function () {
    Route::get('/', [PanelController::class, 'index'])->name('panel');

    // Declarar manualmente todas las rutas excepto `show`
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// ✅ Permitir ver productos SIN middleware 'is.admin'
Route::middleware(['auth'])->group(function () {
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
});

