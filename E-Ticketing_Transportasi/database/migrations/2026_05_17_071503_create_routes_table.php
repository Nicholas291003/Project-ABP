<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('kode_rute')->unique(); // Contoh: RTE-004
            $table->string('jenis');              // Contoh: kereta, bus, pesawat
            $table->string('kota_asal');          // Contoh: Surabaya
            $table->string('simpul_asal');        // Contoh: Stasiun Gubeng (SGU)
            $table->string('kota_tujuan');        // Contoh: Jakarta
            $table->string('simpul_tujuan');      // Contoh: Stasiun Pasar Senen (PSE)
            $table->integer('jarak');             // Dalam KM
            $table->integer('estimasi_jam');
            $table->integer('estimasi_menit');
            $table->integer('tarif_dasar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
