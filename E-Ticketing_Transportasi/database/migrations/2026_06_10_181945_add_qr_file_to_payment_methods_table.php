<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            // Menambahkan kolom untuk menyimpan jalur/path file Gambar atau PDF QRIS
            $table->string('qr_file')->nullable()->after('nomor_tujuan');
        });
    }

    public function down(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn('qr_file');
        });
    }
};