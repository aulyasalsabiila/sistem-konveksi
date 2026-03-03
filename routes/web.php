<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    PesananController,
    BahanBakuController,
    ProduksiController,
    LaporanController,
    CustomerController,
    ActivityLogController,
    ProfileController,
    SettingsController
};
use App\Http\Controllers\Auth\{
    LoginController,
    RegisterController,
    ForgotPasswordController
};

/*
|--------------------------------------------------------------------------
| Guest Routes (Before Login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/', fn () => redirect()->route('login'));

    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Forgot Password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Reset Password
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Protected Routes (After Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    /*
    | Profile
    */
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    /*
    | Settings
    */
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

    /*
    | Activity History
    */
    Route::get('/history', [ActivityLogController::class, 'index'])->name('history.index');

    /*
    | Pesanan
    */
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/create', [PesananController::class, 'create'])->name('pesanan.create');
    Route::post('/pesanan', [PesananController::class, 'store'])->name('pesanan.store');
    Route::get('/pesanan/{pesanan}', [PesananController::class, 'show'])->name('pesanan.show');
    Route::get('/pesanan/{pesanan}/edit', [PesananController::class, 'edit'])->name('pesanan.edit');
    Route::put('/pesanan/{pesanan}', [PesananController::class, 'update'])->name('pesanan.update');
    Route::delete('/pesanan/{pesanan}', [PesananController::class, 'destroy'])->name('pesanan.destroy');
    Route::patch('/pesanan/{pesanan}/status', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');

    /*
    | Bahan Baku
    */
    Route::prefix('bahan-baku')->name('bahan-baku.')->group(function () {
        Route::get('/', [BahanBakuController::class, 'index'])->name('index');
        Route::get('/create', [BahanBakuController::class, 'create'])->name('create');
        Route::post('/', [BahanBakuController::class, 'store'])->name('store');

        Route::get('/{bahanBaku}', [BahanBakuController::class, 'show'])->name('show');
        Route::get('/{bahanBaku}/edit', [BahanBakuController::class, 'edit'])->name('edit');
        Route::put('/{bahanBaku}', [BahanBakuController::class, 'update'])->name('update');

        Route::get('/{bahanBaku}/restock', [BahanBakuController::class, 'restockForm'])->name('restock.form');
        Route::post('/{bahanBaku}/restock', [BahanBakuController::class, 'restock'])->name('restock');

        Route::middleware('role:admin')->group(function () {Route::delete('/{bahanBaku}', [BahanBakuController::class, 'destroy'])->name('destroy');
    });
});

    /*
    | Produksi
    */
    Route::prefix('produksi')->name('produksi.')->group(function () {
        // Semua user bisa akses
        Route::get('/timeline/active', [ProduksiController::class, 'timeline'])->name('timeline');
        Route::get('/', [ProduksiController::class, 'index'])->name('index');
        Route::get('/create', [ProduksiController::class, 'create'])->name('create');
        Route::post('/', [ProduksiController::class, 'store'])->name('store');
        Route::get('/{produksi}', [ProduksiController::class, 'show'])->name('show');
        Route::get('/{produksi}/edit', [ProduksiController::class, 'edit'])->name('edit');
        Route::put('/{produksi}', [ProduksiController::class, 'update'])->name('update');
        Route::patch('/{produksi}/stage', [ProduksiController::class, 'updateStage'])->name('update-stage');
        Route::patch('/{produksi}/progress', [ProduksiController::class, 'updateProgress'])->name('update-progress');
        
        // Hanya Admin bisa delete
        Route::middleware('role:admin')->group(function () {
            Route::delete('/{produksi}', [ProduksiController::class, 'destroy'])->name('destroy');
        });
    });

    /*
    | Laporan
    */
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/pesanan/pdf', [LaporanController::class, 'laporanPesanan'])->name('pesanan');
        Route::get('/stok/pdf', [LaporanController::class, 'laporanStok'])->name('stok');
        Route::get('/produksi/pdf', [LaporanController::class, 'laporanProduksi'])->name('produksi');
    });

    /*
    | Customers
    */
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('/history', [CustomerController::class, 'history'])->name('history');
        Route::get('/{customer}', [CustomerController::class, 'show'])->name('show');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Only Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
});