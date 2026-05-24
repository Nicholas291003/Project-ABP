<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transit_points', function (Blueprint $table) {
            $table->id();
            // Menghubungkan titik transit ke ID rute utamanya
            $table->foreignId('route_id')->constrained()->onDelete('cascade');
            
            $table->string('name'); // Nama stasiun / terminal transit (misal: Stasiun Tawang)
            
            // Menggunakan tipe data desimal untuk akurasi koordinat GPS peta
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            
            $table->integer('stop_order'); // Urutan pemberhentian (misal: 1 untuk transit pertama, 2 untuk kedua)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transit_points');
    }
};
