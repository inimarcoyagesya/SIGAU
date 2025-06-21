<?php

use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Inventory2Controller;
use App\Http\Controllers\InventoryReportController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\UmkmPenaltyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromotionPageController;
use App\Http\Controllers\PublicMapController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\UmkmDashboardController;
use App\Http\Controllers\UmkmProfileController;
use App\Http\Controllers\UmkmTransactionController;
use App\Http\Controllers\UmkmInventoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

// Admin routes (hanya untuk role admin)
// Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
//     Route::get('/dashboard', [AdminDashboardController::class, 'index'])
//         ->name('admin.dashboard');
// });

Route::get('/premium', [PremiumController::class, 'index'])->name('umkm.premium');

// Dashboard UMKM
Route::middleware(['auth', 'verified', 'umkm.active'])->prefix('umkm')->group(function () {
    Route::get('/dashboard', [UmkmDashboardController::class, 'index'])->name('umkm.dashboard');

    Route::get('/subscription/{package}', [SubscriptionController::class, 'show'])->name('subscription.show');
    Route::post('/subscription/process/{package}', [SubscriptionController::class, 'process'])->name('subscription.process');
    Route::get('/packages', [PackageController::class, 'index2'])->name('packages.index2');

    // Callback Midtrans
    Route::post('/payment/callback', [SubscriptionController::class, 'callback']);
    
    Route::get('/transactions', [UmkmTransactionController::class, 'index'])->name('umkm.transactions.index');
    Route::get('/transactions/create', [UmkmTransactionController::class, 'create'])->name('umkm.transactions.create');
    Route::post('/transactions', [UmkmTransactionController::class, 'store'])->name('umkm.transactions.store');
    Route::get('/transactions/{transaction}', [UmkmTransactionController::class, 'show'])->name('umkm.transactions.show');
    Route::get('/transactions/{transaction}/edit', [UmkmTransactionController::class, 'edit'])->name('umkm.transactions.edit');
    Route::put('/transactions/{transaction}', [UmkmTransactionController::class, 'update'])->name('umkm.transactions.update');
    Route::delete('/transactions/{transaction}', [UmkmTransactionController::class, 'destroy'])->name('umkm.transactions.destroy');

    Route::post('/premium/subscribe', [PremiumController::class, 'subscribe'])->name('premium.subscribe');
    Route::get('/payment/{transaction}', [PremiumController::class, 'showPayment'])->name('payment.show');
    Route::post('/payment/{transaction}/complete', [PremiumController::class, 'completePayment'])->name('payment.complete');

    Route::get('/inventories', [UmkmInventoryController::class, 'index'])->name('umkm.inventories.index');
    Route::get('/inventories/create', [UmkmInventoryController::class, 'create'])->name('umkm.inventories.create');
    Route::post('/inventories', [UmkmInventoryController::class, 'store'])->name('umkm.inventories.store');
    Route::get('/inventories/{inventory}/edit', [UmkmInventoryController::class, 'edit'])->name('umkm.inventories.edit');
    Route::put('/inventories/{inventory}', [UmkmInventoryController::class, 'update'])->name('umkm.inventories.update');
    Route::delete('/inventories/{inventory}', [UmkmInventoryController::class, 'destroy'])->name('umkm.inventories.destroy');

    // Halaman Promosi UMKM
    Route::get('/umkm/{id}/promotion', [PromotionPageController::class, 'show'])->name('umkm.promotion.show');

    // Tracking Klik
    Route::post('/promotion/{promotion}/track-click', [PromotionPageController::class, 'trackClick'])->name('promotion.track-click');

    // Profil UMKM
    Route::get('/profile', [UmkmProfileController::class, 'edit'])->name('umkm.profile');
    Route::put('/profile', [UmkmProfileController::class, 'update'])->name('umkm.profile.update');
    Route::post('/profile/location', [UmkmProfileController::class, 'updateLocation'])->name('umkm.profile.location');

    Route::get('/umkm/penalty', [UmkmPenaltyController::class, 'show'])->name('umkm.penalty');
    Route::post('/umkm/penalty/pay', [UmkmPenaltyController::class, 'pay'])->name('umkm.penalty.payment');

    Route::get('/umkm/competitors', [UmkmController::class, 'competitors'])
    ->name('umkm.competitors');

    // Konfirmasi & pembayaran
    Route::prefix('umkm')->group(function () {
    Route::get('/umkm/packages', [PackageController::class, 'index'])->name('packages.index');
    Route::post('/packages/{package}/confirm', [TransactionController::class, 'confirm'])
        ->name('transactions.confirm');
});
Route::get('/umkm/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');

// Laporan transaksi
Route::get('/umkm/transactions/{transaction}/pdf', [TransactionController::class, 'pdf'])->name('transactions.pdf');
Route::get('/umkm/transactions/{transaction}/excel', [TransactionController::class, 'excel'])->name('transactions.excel');
});

// Dashboard Publik
Route::get('/peta-umkm', [PublicMapController::class, 'index'])->name('public.map');
// Route publik untuk profil UMKM
Route::get('/umkm/{id}', [UmkmProfileController::class, 'show'])->name('umkm.public');

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
    Route::get('/inventories/pdf-allphp', [InventoryReportController::class, 'generatePDF'])
     ->name('inventories.generate-pdf');  
     Route::get('inventories2/filter', [Inventory2Controller::class, 'filter'])->name('inventories2.filter');
     Route::post('/inventories/export-excel', [InventoryReportController::class, 'exportExcel'])
     ->name('inventories.export-excel');

    Route::get('/admin/packages', [PackageController::class, 'index'])->name('admin.packages.index');
    Route::get('/admin/packages/create', [PackageController::class, 'create'])->name('admin.packages.create');
    Route::post('/admin/packages', [PackageController::class, 'store'])->name('admin.packages.store');
    Route::get('/admin/packages/{package}/edit', [PackageController::class, 'edit'])->name('admin.packages.edit');
    Route::put('/admin/packages/{package}', [PackageController::class, 'update'])->name('admin.packages.update');
    Route::delete('/admin/packages/{package}', [PackageController::class, 'destroy'])->name('admin.packages.destroy');
    Route::post('/admin/packages/{package}/toggle', [PackageController::class, 'toggleStatus'])->name('admin.packages.toggle-status');

    Route::prefix('admin')->group(function () {
        Route::get('/transactions/create', [TransactionController::class, 'create'])->name('admin.transactions.create');
        Route::post('/transactions', [TransactionController::class, 'store'])->name('admin.transactions.store');
    });

    Route::get('/admin/transactions', [TransactionController::class, 'index'])->name('admin.transactions.index');
    Route::get('/admin/transactions/report', [TransactionController::class, 'report'])->name('admin.transactions.report');
    Route::get('/admin/transactions/report/pdf', [TransactionController::class, 'pdfReport'])->name('admin.transactions.report.pdf');
    Route::get('/admin/transactions/report/excel', [TransactionController::class, 'excelReport'])->name('admin.transactions.report.excel');

    
}
);

require __DIR__.'/auth.php';
