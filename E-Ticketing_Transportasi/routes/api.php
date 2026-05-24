<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\OrderController;

// Endpoint uji coba koneksi
Route::get('/ping', function () {
    return response()->json([
        'status' => 'sukses',
        'pesan' => 'Jembatan Koneksi Berhasil Terhubung!',
        'waktu'  => now()->toDateTimeString()
    ], 200);
});
// Rute Publik untuk otentikasi (login & register)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Rute untuk fitur yang memerlukan login user
Route::middleware('auth:sanctum')->group(function () {
    // Endpoint untuk menampilkan rute populer
    Route::get('jadwal/populer', [ScheduleController::class, 'rutePopuler']);
    // Endpoint untuk menampilkan titik transit berdasarkan rute
    Route::get('/rute/{id}/transit', [ScheduleController::class, 'ruteTransit']);
    // Endpoint untuk mencari tiket berdasarkan asal, tujuan, dan tanggal
    Route::get('/jadwal/search', [ScheduleController::class, 'search']);
    // Endpoint untuk membuat pesanan tiket
    Route::post('/order', [OrderController::class, 'buatPesanan']);
    // Endpoint untuk melihat riwayat pesanan (Tiket Saya)
    Route::get('/pesanan/riwayat', [OrderController::class, 'riwayat']);
    // Endpoint untuk Logout
    Route::post('/logout', [AuthController::class, 'logout']);
    // Endpoint untuk melakukan pembayaran pesanan
    Route::post('/order/{id}/bayar', [OrderController::class, 'bayar']);
    

});
