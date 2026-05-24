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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained()->onDelete('cascade'); // Terhubung ke rute & armada
            $table->foreignId('transportation_id')->constrained()->onDelete('cascade'); // Terhubung ke rute & armada
            $table->date('departure_date');      // Tanggal Berangkat
            $table->time('departure_time');      // Jam Berangkat
            $table->time('arrival_time');        // Jam Tiba
            $table->integer('price');            // Harga Tiket
            $table->integer('total_seats');      // Total Kapasitas Kursi
            $table->integer('remaining_seats');  // Sisa Kursi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
