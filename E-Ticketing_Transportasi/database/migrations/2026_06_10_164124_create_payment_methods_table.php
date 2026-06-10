<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // Contoh: BCA-VA, GOPAY, QRIS-ALL
            $table->string('nama'); // Contoh: BCA Virtual Account, GoPay
            $table->enum('kategori', ['bank', 'virtual_account', 'ewallet', 'qris']);
            $table->string('nomor_tujuan'); // Nomor rekening atau nomor akun tujuan
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->text('instruksi_bayar')->nullable(); // Langkah-langkah pembayaran
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};