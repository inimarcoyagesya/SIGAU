<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Inventory2Controller;
use App\Http\Controllers\InventoryReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RentalTransactionController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/users/export', [UserController::class, 'export'])->name('users.export');
    Route::resource('/users', UserController::class);
    Route::resource('/searchs', SearchController::class);
    Route::resource('/umkms', UmkmController::class);
    Route::resource('/inventories', InventoryController::class);
    Route::resource('/inventories2', Inventory2Controller::class);
    Route::resource('/categories', CategoryController::class);
    Route::resource('/facilities', FacilityController::class);
    Route::resource('transactions', RentalTransactionController::class);
    Route::get('/transactions/get-inventories/{umkm}', [RentalTransactionController::class, 'getInventories'])
    ->name('transactions.get-inventories');
    Route::get('/inventories/preview', [InventoryReportController::class, 'generatePDF'])->name('inventories.preview');
    Route::post('/inventories/selected-pdf', [InventoryReportController::class, 'selectedPDF'])
     ->name('inventories.selected-pdf');
     Route::get('inventories2/filter', [Inventory2Controller::class, 'filter'])->name('inventories2.filter');

}
);

require __DIR__.'/auth.php';
