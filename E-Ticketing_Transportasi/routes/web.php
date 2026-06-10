<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

// Import Controller Halaman Umum
use App\Http\Controllers\HomeController;

// Import Controller Panel Penumpang
use App\Http\Controllers\Passenger\DashboardController as PassengerDashboardController;

// Import Controller Panel Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\TransportationController;
use App\Http\Controllers\Admin\RouteController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PaymentDashboardController;
use App\Http\Controllers\Admin\PaymentMethodController;

/*
|--------------------------------------------------------------------------
| Web Routes - TiketKuy E-Ticketing System
|--------------------------------------------------------------------------
*/

// ==========================================================
// 1. ROUTE HALAMAN UMUM / GUEST (Belum Login)
// ==========================================================
// Menampilkan Landing Page (welcome.blade.php)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Proses Pencarian Tiket dari Form di Landing Page
Route::get('/search', [HomeController::class, 'search'])->name('ticket.search');


// ==========================================================
// 2. ROUTE PROTECTED (Wajib Login / Middleware Auth)
// ==========================================================
Route::middleware(['auth'])->group(function () {

    // === RUTE PENGATUR LALU LINTAS SETELAH LOGIN ===
    Route::get('/dashboard', function () {
        // Cek jika yang login adalah admin
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        // Jika bukan admin, otomatis dilempar ke dashboard penumpang
        return redirect()->route('passenger.dashboard');
    })->name('dashboard');

    // ------------------------------------------------------
    // A. PANEL PENUMPANG (Prefix: /passenger, Name: passenger.*)
    // ------------------------------------------------------
    Route::prefix('passenger')->name('passenger.')->group(function () {
        
        // Beranda Penumpang & Form Cari Tiket Compact
        Route::get('/dashboard', [PassengerDashboardController::class, 'index'])->name('dashboard');
        
        // List Tiket Aktif Milik Penumpang
        Route::get('/tickets', [PassengerDashboardController::class, 'myTickets'])->name('tickets');

        // Pencarian ticket berdasarkan filter
        Route::get('/search-results', [PassengerDashboardController::class, 'searchTickets'])->name('search');
        
        // Riwayat Transaksi/Pemesanan Masa Lalu
        Route::get('/history', [PassengerDashboardController::class, 'history'])->name('history');
        
        // Halaman pemilihan kursi
        Route::get('/select-seat/{schedule_id}', [PassengerDashboardController::class, 'showSeatSelection'])->name('seats.show');

        // Proses Mengklik "Pilih Tiket" / Booking
        Route::post('/book', [PassengerDashboardController::class, 'bookTicket'])->name('book');
        
        // Proses Pembayaran Tiket (Simulasi)
        Route::get('/payment/{order_code}', [PassengerDashboardController::class, 'showPayment'])->name('payment.show');
        Route::post('/payment/{order_code}', [PassengerDashboardController::class, 'processPayment'])->name('payment.process');
        // Menampilkan E-Ticket Detail & QR Code
        Route::get('/ticket/{order_code}', [PassengerDashboardController::class, 'showTicket'])->name('ticket.show');

        // Pembatalan tiket
        Route::post('/ticket/{order_code}/cancel', [PassengerDashboardController::class, 'cancelTicket'])->name('ticket.cancel');

        // Halaman Kelola Profil & Proses Update
        Route::get('/profile', [PassengerDashboardController::class, 'profile'])->name('profile');
        Route::put('/profile', [PassengerDashboardController::class, 'updateProfile'])->name('profile.update');
    });

    // ------------------------------------------------------
    // B. PANEL ADMIN (Prefix: /admin, Name: admin.*)
    // ------------------------------------------------------
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // Dashboard Utama Admin (Statistik, Grafik, Pesanan Terbaru)
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // CRUD Otomatis Menggunakan Route Resource untuk Setiap Entitas
        Route::resource('transportations', TransportationController::class); // Kelola Armada
        Route::resource('routes', RouteController::class);                   // Kelola Rute Perjalanan
        Route::resource('schedules', ScheduleController::class)->names('schedule');             // Kelola Jadwal & Harga
        Route::resource('users', UserController::class);                     // Kelola Data Pengguna
        
        // Kelola Pesanan Tiket (Tanpa halaman 'create' & 'store' karena dibuat oleh penumpang)
        Route::resource('orders', OrderController::class)->only(['index', 'show', 'update', 'destroy']);
        // Kelola Pembayaran Tiket
        Route::get('/payments', [PaymentDashboardController::class, 'index'])->name('payments.index');
        Route::resource('payment-methods', PaymentMethodController::class);
        Route::get('payments/invoice/{id}', [PaymentDashboardController::class, 'showInvoice'])->name('payments.invoice');

        // Halaman Web Service API Log (Untuk Monitoring & Debugging API)
        Route::get('/api-service', [AdminDashboardController::class, 'apiService'])->name('api.service');
    });

});

// Rute Autentikasi Manual TiketKuy
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}