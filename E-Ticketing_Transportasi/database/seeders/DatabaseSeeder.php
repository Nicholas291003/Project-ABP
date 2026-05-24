<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Transportation;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- 1. SEED DATA AKUN USER ---
        User::create([
            'name' => 'Super Admin TiketKuy',
            'email' => 'admin@tiketkuy.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $namaPassengers = ['Budi Santoso', 'Siti Aminah', 'Ahmad Fauzi', 'Dewi Lestari', 'Rian Hidayat', 'Mega Utami', 'Eko Prasetyo', 'Anisa Putri', 'Rizky Ramadhan', 'Fitriani'];
        foreach ($namaPassengers as $index => $nama) {
            User::create([
                'name' => $nama,
                'email' => 'penumpang' . ($index + 1) . '@email.com',
                'password' => Hash::make('password123'),
                'role' => 'penumpang',
            ]);
        }

        // --- 2. SEED DATA MASTER TRANSPORTASI ---
        $armada = [
            [
                'kode' => 'TRN-001',
                'nama' => 'Argo Parahyangan',
                'jenis' => 'kereta',
                'kelas' => 'Eksekutif',
                'jumlah_kursi' => 50,
                'status' => 'aktif',
                'fasilitas' => 'AC Sentral, Reclining Seat, Colokan Listrik, Makan Berat 1x, Selimut'
            ],
            [
                'kode' => 'TRN-002',
                'nama' => 'Argo Lawu',
                'jenis' => 'kereta',
                'kelas' => 'Eksekutif',
                'jumlah_kursi' => 50,
                'status' => 'aktif',
                'fasilitas' => 'AC, Toilet, Reclining Seat, Wi-Fi, Port Charger'
            ],
            [
                'kode' => 'TRN-003',
                'nama' => 'Argo Bromo Anggrek',
                'jenis' => 'kereta',
                'kelas' => 'Luxury',
                'jumlah_kursi' => 40,
                'status' => 'aktif',
                'fasilitas' => 'Sleeper Luxury Seat, Mini Bar, Entertainment Screen, Wi-Fi'
            ],
            [
                'kode' => 'BUS-012',
                'nama' => 'Sinar Jaya Raya',
                'jenis' => 'bus',
                'kelas' => 'Suite Class',
                'jumlah_kursi' => 32,
                'status' => 'aktif',
                'fasilitas' => 'Full AC, Sleeper Seat, Personal TV, Toilet, Bantal & Selimut'
            ],
            [
                'kode' => 'BUS-013',
                'nama' => 'DayTrans Travel',
                'jenis' => 'bus',
                'kelas' => 'Captain Seat',
                'jumlah_kursi' => 12,
                'status' => 'aktif',
                'fasilitas' => 'AC, Captain Seat Premium, Colokan USB Charger, Air Mineral'
            ],
            [
                'kode' => 'FLT-881',
                'nama' => 'Garuda Indonesia (GA-201)',
                'jenis' => 'pesawat',
                'kelas' => 'Ekonomi Premium',
                'jumlah_kursi' => 150,
                'status' => 'maintenance',
                'fasilitas' => 'In-flight Entertainment, Makan Berat Panas, Bagasi 20kg, Selimut'
            ],
        ];
        foreach ($armada as $a) {
            Transportation::create($a);
        }

        // --- 3. SEED DATA MASTER RUTE PERJALANAN ---
        $ruteData = [
            [
                'kode_rute' => 'RTE-001',
                'kota_asal' => 'Jakarta',
                'simpul_asal' => 'Stasiun Gambir (GMR)',
                'kota_tujuan' => 'Bandung',
                'simpul_tujuan' => 'Stasiun Bandung (BD)',
                'jarak' => 150,
                'estimasi_jam' => 3,
                'estimasi_menit' => 15,
                'tarif_dasar' => 150000
            ],
            [
                'kode_rute' => 'RTE-002',
                'kota_asal' => 'Jakarta',
                'simpul_asal' => 'Stasiun Gambir (GMR)',
                'kota_tujuan' => 'Yogyakarta',
                'simpul_tujuan' => 'Stasiun Tugu (YK)',
                'jarak' => 520,
                'estimasi_jam' => 7,
                'estimasi_menit' => 30,
                'tarif_dasar' => 300000
            ],
            [
                'kode_rute' => 'RTE-003',
                'kota_asal' => 'Jakarta',
                'simpul_asal' => 'Stasiun Gambir (GMR)',
                'kota_tujuan' => 'Solo',
                'simpul_tujuan' => 'Stasiun Balapan (SLO)',
                'jarak' => 550,
                'estimasi_jam' => 7,
                'estimasi_menit' => 15,
                'tarif_dasar' => 320000
            ],
            [
                'kode_rute' => 'RTE-004',
                'kota_asal' => 'Surabaya',
                'simpul_asal' => 'Stasiun Gubeng (SGU)',
                'kota_tujuan' => 'Jakarta',
                'simpul_tujuan' => 'Stasiun Pasar Senen (PSE)',
                'jarak' => 780,
                'estimasi_jam' => 8,
                'estimasi_menit' => 10,
                'tarif_dasar' => 250000
            ],
            [
                'kode_rute' => 'RTE-005',
                'kota_asal' => 'Bandung',
                'simpul_asal' => 'Stasiun Bandung (BD)',
                'kota_tujuan' => 'Semarang',
                'simpul_tujuan' => 'Stasiun Tawang (SMT)',
                'jarak' => 400,
                'estimasi_jam' => 7,
                'estimasi_menit' => 0,
                'tarif_dasar' => 200000
            ],
        ];
        foreach ($ruteData as $r) {
            Route::create($r);
        }

        // --- 4. SEED DATA DINAMIS VIA FACTORIES ---
        // Membuat 50 jadwal operasional otomatis
        Schedule::factory()->count(50)->create();

        // Membuat 100 riwayat pesanan tiket fiktif untuk simulasi ringkasan dashboard
        Order::factory()->count(100)->create();
    }
}