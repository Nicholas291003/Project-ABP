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

        // --- 2. SEED DATA MASTER TRANSPORTASI (20 Kereta, 10 Pesawat, 10 Bus/Travel) ---
        $armada = [
            // ==================== 20 DATA KERETA API ====================
            [
                'kode' => 'KA-SNC', 'nama' => 'Sancaka', 'jenis' => 'kereta', 'kelas' => 'Eksekutif & Ekonomi Premium',
                'jumlah_kursi' => 80, 'status' => 'aktif', 'fasilitas' => 'AC, Reclining Seat, Colokan Listrik, Toilet'
            ],
            [
                'kode' => 'KA-STJ', 'nama' => 'Sri Tanjung', 'jenis' => 'kereta', 'kelas' => 'Ekonomi',
                'jumlah_kursi' => 106, 'status' => 'aktif', 'fasilitas' => 'AC Sentral, Stop Kontak, Toilet Bersih'
            ],
            [
                'kode' => 'KA-PRG', 'nama' => 'Progo', 'jenis' => 'kereta', 'kelas' => 'Ekonomi',
                'jumlah_kursi' => 106, 'status' => 'aktif', 'fasilitas' => 'AC, Stop Kontak, Layanan Restorasi'
            ],
            [
                'kode' => 'KA-TKS', 'nama' => 'Taksaka', 'jenis' => 'kereta', 'kelas' => 'Eksekutif & Luxury',
                'jumlah_kursi' => 40, 'status' => 'aktif', 'fasilitas' => 'Sleeper Seat, Wi-Fi, Personal TV, Minibar'
            ],
            [
                'kode' => 'KA-FJY', 'nama' => 'Fajar Utama YK', 'jenis' => 'kereta', 'kelas' => 'Eksekutif & Ekonomi Premium',
                'jumlah_kursi' => 80, 'status' => 'aktif', 'fasilitas' => 'AC, Reclining Seat, Meja Lipat'
            ],
            [
                'kode' => 'KA-MBE', 'nama' => 'Malioboro Ekspres', 'jenis' => 'kereta', 'kelas' => 'Eksekutif & Ekonomi Plus',
                'jumlah_kursi' => 80, 'status' => 'aktif', 'fasilitas' => 'AC, Gorden, Colokan Listrik, Bagasi Atas'
            ],
            [
                'kode' => 'KA-SJY', 'nama' => 'Senja Utama YK', 'jenis' => 'kereta', 'kelas' => 'Eksekutif & Ekonomi Premium',
                'jumlah_kursi' => 80, 'status' => 'aktif', 'fasilitas' => 'AC, Bantal (Sewa), Lampu Baca, Toilet'
            ],
            [
                'kode' => 'KA-JSK', 'nama' => 'Joglosemarkerto', 'jenis' => 'kereta', 'kelas' => 'Ekonomi Plus',
                'jumlah_kursi' => 80, 'status' => 'aktif', 'fasilitas' => 'AC, Charger Port, Kursi Hadap Depan'
            ],
            [
                'kode' => 'KA-PBW', 'nama' => 'Probowangi', 'jenis' => 'kereta', 'kelas' => 'Ekonomi',
                'jumlah_kursi' => 106, 'status' => 'aktif', 'fasilitas' => 'AC Sentral, Gantungan Baju, Toilet'
            ],
            [
                'kode' => 'KA-PSD', 'nama' => 'Pasundan', 'jenis' => 'kereta', 'kelas' => 'Ekonomi',
                'jumlah_kursi' => 106, 'status' => 'aktif', 'fasilitas' => 'AC, Stop Kontak per Kursi'
            ],
            [
                'kode' => 'KA-SGR', 'nama' => 'Songgoriti', 'jenis' => 'kereta', 'kelas' => 'Ekonomi Premium',
                'jumlah_kursi' => 80, 'status' => 'aktif', 'fasilitas' => 'AC, Reclining Seat, Desain Modern'
            ],
            [
                'kode' => 'KA-AWL', 'nama' => 'Argo Wilis', 'jenis' => 'kereta', 'kelas' => 'Eksekutif & Priority',
                'jumlah_kursi' => 50, 'status' => 'aktif', 'fasilitas' => 'Lounge Seat, Audio Video on Demand, Wi-Fi'
            ],
            [
                'kode' => 'KA-GBM', 'nama' => 'Gaya Baru Malam Selatan', 'jenis' => 'kereta', 'kelas' => 'Eksekutif & Ekonomi Plus',
                'jumlah_kursi' => 80, 'status' => 'aktif', 'fasilitas' => 'AC, Kursi 2-2 Modifikasi, Toilet'
            ],
            [
                'kode' => 'KA-JKT', 'nama' => 'Jayakarta', 'jenis' => 'kereta', 'kelas' => 'Ekonomi Premium',
                'jumlah_kursi' => 80, 'status' => 'aktif', 'fasilitas' => 'AC Sentral, Arm Rest, Port Charger'
            ],
            [
                'kode' => 'KA-BKT', 'nama' => 'Bangunkarta', 'jenis' => 'kereta', 'kelas' => 'Eksekutif & Priority',
                'jumlah_kursi' => 50, 'status' => 'aktif', 'fasilitas' => 'AC, LCD TV, Snack & Minum, Selimut'
            ],
            [
                'kode' => 'KA-TRG', 'nama' => 'Turangga', 'jenis' => 'kereta', 'kelas' => 'Eksekutif',
                'jumlah_kursi' => 50, 'status' => 'aktif', 'fasilitas' => 'AC, Reclining Seat Premium, Selimut, Bantal'
            ],
            [
                'kode' => 'KA-MTM', 'nama' => 'Mutiara Timur', 'jenis' => 'kereta', 'kelas' => 'Eksekutif & Ekonomi Premium',
                'jumlah_kursi' => 80, 'status' => 'aktif', 'fasilitas' => 'AC, Kursi Nyaman, Restorasi Kuliner'
            ],
            [
                'kode' => 'KA-LDY', 'nama' => 'Lodaya', 'jenis' => 'kereta', 'kelas' => 'Eksekutif & Ekonomi Premium',
                'jumlah_kursi' => 80, 'status' => 'aktif', 'fasilitas' => 'AC Sentral, Colokan Listrik, Gorden'
            ],
            [
                'kode' => 'KA-CRM', 'nama' => 'Ciremai', 'jenis' => 'kereta', 'kelas' => 'Eksekutif & Bisnis',
                'jumlah_kursi' => 64, 'status' => 'aktif', 'fasilitas' => 'AC, Kursi Bisa Diputar (Bisnis), Toilet'
            ],
            [
                'kode' => 'KA-HRN', 'nama' => 'Harina', 'jenis' => 'kereta', 'kelas' => 'Eksekutif & Ekonomi Premium',
                'jumlah_kursi' => 80, 'status' => 'aktif', 'fasilitas' => 'AC, Reclining Seat, Bagasi Luas'
            ],

            // ==================== 10 DATA PESAWAT ====================
            [
                'kode' => 'PW-GIA', 'nama' => 'Garuda Indonesia', 'jenis' => 'pesawat', 'kelas' => 'Ekonomi Premium',
                'jumlah_kursi' => 150, 'status' => 'aktif', 'fasilitas' => 'In-flight Meals, Bagasi 20kg, Entertainment Screen, Selimut'
            ],
            [
                'kode' => 'PW-LNI', 'nama' => 'Lion Air', 'jenis' => 'pesawat', 'kelas' => 'Ekonomi',
                'jumlah_kursi' => 180, 'status' => 'aktif', 'fasilitas' => 'Bagasi Kabin 7kg, Standard Ergonomic Seat'
            ],
            [
                'kode' => 'PW-CTV', 'nama' => 'Citilink', 'jenis' => 'pesawat', 'kelas' => 'Ekonomi',
                'jumlah_kursi' => 180, 'status' => 'aktif', 'fasilitas' => 'Bagasi Kabin 7kg, Free Mineral Water, Air-conditioned Cabin'
            ],
            [
                'kode' => 'PW-BTK', 'nama' => 'Batik Air', 'jenis' => 'pesawat', 'kelas' => 'Bisnis',
                'jumlah_kursi' => 120, 'status' => 'aktif', 'fasilitas' => 'Ruang Kaki Luas, Makanan Berat, USB Port, Prioritas Boarding'
            ],
            [
                'kode' => 'PW-SIA', 'nama' => 'Singapore Airlines', 'jenis' => 'pesawat', 'kelas' => 'Eksekutif Internasional',
                'jumlah_kursi' => 200, 'status' => 'aktif', 'fasilitas' => 'Premium Dining, Wi-Fi Onboard, Layar Sentuh HD, International Plug'
            ],
            [
                'kode' => 'PW-SCO', 'nama' => 'Scoot', 'jenis' => 'pesawat', 'kelas' => 'Ekonomi Low Cost',
                'jumlah_kursi' => 180, 'status' => 'aktif', 'fasilitas' => 'Baggage Purchase Option, Pre-book Meals, Clean Cabin'
            ],
            [
                'kode' => 'PW-MAS', 'nama' => 'Malaysia Airlines', 'jenis' => 'pesawat', 'kelas' => 'Ekonomi Premium',
                'jumlah_kursi' => 160, 'status' => 'aktif', 'fasilitas' => 'In-flight Snack, Bagasi 20kg, Selimut, Bantal'
            ],
            [
                'kode' => 'PW-AXA', 'nama' => 'AirAsia', 'jenis' => 'pesawat', 'kelas' => 'Ekonomi Hot Seat',
                'jumlah_kursi' => 180, 'status' => 'aktif', 'fasilitas' => 'Extra Legroom Option, Combo Meals Available, Cabin Baggage 7kg'
            ],
            [
                'kode' => 'PW-CPA', 'nama' => 'Cathay Pacific', 'jenis' => 'pesawat', 'kelas' => 'Bisnis Premium',
                'jumlah_kursi' => 220, 'status' => 'aktif', 'fasilitas' => 'Flat-bed Seat, Luxury Dining, Noise-cancelling Headphones, Lounge Access'
            ],
            [
                'kode' => 'PW-ANA', 'nama' => 'All Nippon Airways (ANA)', 'jenis' => 'pesawat', 'kelas' => 'Eksekutif Luxury',
                'jumlah_kursi' => 250, 'status' => 'aktif', 'fasilitas' => 'Japanese Hospitality, Five-star Dining, Premium Amenity Kit, Full Wi-Fi'
            ],

            // ==================== 10 DATA BUS & TRAVEL ====================
            [
                'kode' => 'BS-PMJ', 'nama' => 'Primajasa', 'jenis' => 'bus', 'kelas' => 'Eksekutif AC',
                'jumlah_kursi' => 40, 'status' => 'aktif', 'fasilitas' => 'Full AC, Reclining Seat 2-2, Toilet, Smoking Area'
            ],
            [
                'kode' => 'BS-XTR', 'nama' => 'XTrans Travel', 'jenis' => 'bus', 'kelas' => 'Point-to-Point Shuttle',
                'jumlah_kursi' => 10, 'status' => 'aktif', 'fasilitas' => 'AC, Captain Seat, Jalur Tol Bebas Hambatan'
            ],
            [
                'kode' => 'BS-CTT', 'nama' => 'Cititrans', 'jenis' => 'bus', 'kelas' => 'Executive Shuttle',
                'jumlah_kursi' => 12, 'status' => 'aktif', 'fasilitas' => 'Premium Ergonomic Chair, USB Charger Port, Air Mineral'
            ],
            [
                'kode' => 'BS-NST', 'nama' => 'PO Nusantara', 'jenis' => 'bus', 'kelas' => 'VIP Class',
                'jumlah_kursi' => 34, 'status' => 'aktif', 'fasilitas' => 'Full AC, Toilet, Leg Rest, Snack Box'
            ],
            [
                'kode' => 'BS-SJR', 'nama' => 'Sinar Jaya', 'jenis' => 'bus', 'kelas' => 'Suite Class Sleeper',
                'jumlah_kursi' => 22, 'status' => 'aktif', 'fasilitas' => 'Full Sleeper Cabin, Personal TV, Bantal & Selimut, USB Port'
            ],
            [
                'kode' => 'BS-RSL', 'nama' => 'Rosalia Indah', 'jenis' => 'bus', 'kelas' => 'Super Top Double Decker',
                'jumlah_kursi' => 30, 'status' => 'aktif', 'fasilitas' => 'Leg Rest, Sandaran Tangan, Service Makan Prasmanan, Toilet'
            ],
            [
                'kode' => 'BS-HDY', 'nama' => 'Handoyo', 'jenis' => 'bus', 'kelas' => 'Executive',
                'jumlah_kursi' => 38, 'status' => 'aktif', 'fasilitas' => 'AC, Toilet, Reclining Seat 2-2, Selimut Malam'
            ],
            [
                'kode' => 'BS-EKA', 'nama' => 'EKA Cepat', 'jenis' => 'bus', 'kelas' => 'Executive AC',
                'jumlah_kursi' => 40, 'status' => 'aktif', 'fasilitas' => 'Full AC, TV LCD, Makan Malam Gratis, Toilet'
            ],
            [
                'kode' => 'BS-SGH', 'nama' => 'Sugeng Rahayu', 'jenis' => 'bus', 'kelas' => 'Cepat Tarif Biasa',
                'jumlah_kursi' => 43, 'status' => 'aktif', 'fasilitas' => 'AC Sentral, Audio Musik, Konfigurasi Seat 2-2'
            ],
            [
                'kode' => 'BS-DMR', 'nama' => 'Damri', 'jenis' => 'bus', 'kelas' => 'Royal Class',
                'jumlah_kursi' => 28, 'status' => 'aktif', 'fasilitas' => 'Kursi Mewah Lebar, Wi-Fi, Coffee Maker, Toilet, Leg Rest'
            ],
        ];
        foreach ($armada as $a) {
            Transportation::create($a);
        }

        // --- 3. SEED DATA MASTER RUTE PERJALANAN (TOTAL 40 RUTE + KOLOM JENIS) ---
        $ruteData = [
            // ==================== 20 RUTE KERETA API ====================
            [
                'kode_rute' => 'R-TRN-01', 'jenis' => 'kereta', 'kota_asal' => 'Yogyakarta', 'simpul_asal' => 'Stasiun Tugu (YK)',
                'kota_tujuan' => 'Surabaya', 'simpul_tujuan' => 'Stasiun Gubeng (SGU)',
                'jarak' => 320, 'estimasi_jam' => 5, 'estimasi_menit' => 0, 'tarif_dasar' => 220000
            ],
            [
                'kode_rute' => 'R-TRN-02', 'jenis' => 'kereta', 'kota_asal' => 'Yogyakarta', 'simpul_asal' => 'Stasiun Lempuyangan (LPN)',
                'kota_tujuan' => 'Banyuwangi', 'simpul_tujuan' => 'Stasiun Ketapang (KTG)',
                'jarak' => 580, 'estimasi_jam' => 13, 'estimasi_menit' => 35, 'tarif_dasar' => 94000
            ],
            [
                'kode_rute' => 'R-TRN-03', 'jenis' => 'kereta', 'kota_asal' => 'Yogyakarta', 'simpul_asal' => 'Stasiun Lempuyangan (LPN)',
                'kota_tujuan' => 'Jakarta', 'simpul_tujuan' => 'Stasiun Pasar Senen (PSE)',
                'jarak' => 510, 'estimasi_jam' => 8, 'estimasi_menit' => 34, 'tarif_dasar' => 190000
            ],
            [
                'kode_rute' => 'R-TRN-04', 'jenis' => 'kereta', 'kota_asal' => 'Yogyakarta', 'simpul_asal' => 'Stasiun Tugu (YK)',
                'kota_tujuan' => 'Jakarta', 'simpul_tujuan' => 'Stasiun Gambir (GMR)',
                'jarak' => 520, 'estimasi_jam' => 7, 'estimasi_menit' => 42, 'tarif_dasar' => 450000
            ],
            [
                'kode_rute' => 'R-TRN-05', 'jenis' => 'kereta', 'kota_asal' => 'Yogyakarta', 'simpul_asal' => 'Stasiun Tugu (YK)',
                'kota_tujuan' => 'Jakarta', 'simpul_tujuan' => 'Stasiun Pasar Senen (PSE)',
                'jarak' => 515, 'estimasi_jam' => 8, 'estimasi_menit' => 11, 'tarif_dasar' => 280000
            ],
            [
                'kode_rute' => 'R-TRN-06', 'jenis' => 'kereta', 'kota_asal' => 'Yogyakarta', 'simpul_asal' => 'Stasiun Tugu (YK)',
                'kota_tujuan' => 'Malang', 'simpul_tujuan' => 'Stasiun Malang (ML)',
                'jarak' => 340, 'estimasi_jam' => 8, 'estimasi_menit' => 1, 'tarif_dasar' => 210000
            ],
            [
                'kode_rute' => 'R-TRN-07', 'jenis' => 'kereta', 'kota_asal' => 'Yogyakarta', 'simpul_asal' => 'Stasiun Tugu (YK)',
                'kota_tujuan' => 'Jakarta', 'simpul_tujuan' => 'Stasiun Pasar Senen (PSE)',
                'jarak' => 515, 'estimasi_jam' => 7, 'estimasi_menit' => 56, 'tarif_dasar' => 290000
            ],
            [
                'kode_rute' => 'R-TRN-08', 'jenis' => 'kereta', 'kota_asal' => 'Yogyakarta', 'simpul_asal' => 'Stasiun Tugu (YK)',
                'kota_tujuan' => 'Solo', 'simpul_tujuan' => 'Stasiun Balapan (SLO)',
                'jarak' => 60, 'estimasi_jam' => 0, 'estimasi_menit' => 57, 'tarif_dasar' => 40000
            ],
            [
                'kode_rute' => 'R-TRN-09', 'jenis' => 'kereta', 'kota_asal' => 'Surabaya', 'simpul_asal' => 'Stasiun Gubeng (SGU)',
                'kota_tujuan' => 'Banyuwangi', 'simpul_tujuan' => 'Stasiun Ketapang (KTG)',
                'jarak' => 290, 'estimasi_jam' => 7, 'estimasi_menit' => 30, 'tarif_dasar' => 60000
            ],
            [
                'kode_rute' => 'R-TRN-10', 'jenis' => 'kereta', 'kota_asal' => 'Surabaya', 'simpul_asal' => 'Stasiun Gubeng (SGU)',
                'kota_tujuan' => 'Bandung', 'simpul_tujuan' => 'Stasiun Kiaracondong (KAC)',
                'jarak' => 690, 'estimasi_jam' => 14, 'estimasi_menit' => 10, 'tarif_dasar' => 95000
            ],
            [
                'kode_rute' => 'R-TRN-11', 'jenis' => 'kereta', 'kota_asal' => 'Surabaya', 'simpul_asal' => 'Stasiun Gubeng (SGU)',
                'kota_tujuan' => 'Malang', 'simpul_tujuan' => 'Stasiun Malang Kotabaru (ML)',
                'jarak' => 95, 'estimasi_jam' => 2, 'estimasi_menit' => 19, 'tarif_dasar' => 40000
            ],
            [
                'kode_rute' => 'R-TRN-12', 'jenis' => 'kereta', 'kota_asal' => 'Surabaya', 'simpul_asal' => 'Stasiun Gubeng (SGU)',
                'kota_tujuan' => 'Jakarta', 'simpul_tujuan' => 'Stasiun Gambir (GMR)',
                'jarak' => 780, 'estimasi_jam' => 16, 'estimasi_menit' => 15, 'tarif_dasar' => 600000
            ],
            [
                'kode_rute' => 'R-TRN-13', 'jenis' => 'kereta', 'kota_asal' => 'Surabaya', 'simpul_asal' => 'Stasiun Gubeng (SGU)',
                'kota_tujuan' => 'Jakarta', 'simpul_tujuan' => 'Stasiun Pasar Senen (PSE)',
                'jarak' => 775, 'estimasi_jam' => 14, 'estimasi_menit' => 21, 'tarif_dasar' => 340000
            ],
            [
                'kode_rute' => 'R-TRN-14', 'jenis' => 'kereta', 'kota_asal' => 'Surabaya', 'simpul_asal' => 'Stasiun Gubeng (SGU)',
                'kota_tujuan' => 'Jakarta', 'simpul_tujuan' => 'Stasiun Jakarta Kota (JAKK)',
                'jarak' => 790, 'estimasi_jam' => 13, 'estimasi_menit' => 38, 'tarif_dasar' => 310000
            ],
            [
                'kode_rute' => 'R-TRN-15', 'jenis' => 'kereta', 'kota_asal' => 'Surabaya', 'simpul_asal' => 'Stasiun Gubeng (SGU)',
                'kota_tujuan' => 'Jakarta', 'simpul_tujuan' => 'Stasiun Gambir (GMR)',
                'jarak' => 780, 'estimasi_jam' => 12, 'estimasi_menit' => 53, 'tarif_dasar' => 480000
            ],
            [
                'kode_rute' => 'R-TRN-16', 'jenis' => 'kereta', 'kota_asal' => 'Surabaya', 'simpul_asal' => 'Stasiun Gubeng (SGU)',
                'kota_tujuan' => 'Jakarta', 'simpul_tujuan' => 'Stasiun Gambir (GMR)',
                'jarak' => 780, 'estimasi_jam' => 16, 'estimasi_menit' => 49, 'tarif_dasar' => 530000
            ],
            [
                'kode_rute' => 'R-TRN-17', 'jenis' => 'kereta', 'kota_asal' => 'Surabaya', 'simpul_asal' => 'Stasiun Gubeng (SGU)',
                'kota_tujuan' => 'Banyuwangi', 'simpul_tujuan' => 'Stasiun Ketapang (KTG)',
                'jarak' => 290, 'estimasi_jam' => 6, 'estimasi_menit' => 20, 'tarif_dasar' => 200000
            ],
            [
                'kode_rute' => 'R-TRN-18', 'jenis' => 'kereta', 'kota_asal' => 'Bandung', 'simpul_asal' => 'Stasiun Bandung (BD)',
                'kota_tujuan' => 'Jakarta', 'simpul_tujuan' => 'Stasiun Gambir (GMR)',
                'jarak' => 150, 'estimasi_jam' => 3, 'estimasi_menit' => 47, 'tarif_dasar' => 150000
            ],
            [
                'kode_rute' => 'R-TRN-19', 'jenis' => 'kereta', 'kota_asal' => 'Bandung', 'simpul_asal' => 'Stasiun Bandung (BD)',
                'kota_tujuan' => 'Solo', 'simpul_tujuan' => 'Stasiun Balapan (SLO)',
                'jarak' => 450, 'estimasi_jam' => 9, 'estimasi_menit' => 2, 'tarif_dasar' => 320000
            ],
            [
                'kode_rute' => 'R-TRN-20', 'jenis' => 'kereta', 'kota_asal' => 'Bandung', 'simpul_asal' => 'Stasiun Bandung (BD)',
                'kota_tujuan' => 'Semarang', 'simpul_tujuan' => 'Stasiun Tawang (SMT)',
                'jarak' => 380, 'estimasi_jam' => 7, 'estimasi_menit' => 43, 'tarif_dasar' => 280000
            ],

            // ==================== 10 RUTE PESAWAT ====================
            [
                'kode_rute' => 'R-FLT-01', 'jenis' => 'pesawat', 'kota_asal' => 'Jakarta', 'simpul_asal' => 'Bandara Soekarno-Hatta (CGK)',
                'kota_tujuan' => 'Makassar', 'simpul_tujuan' => 'Bandara Sultan Hasanuddin (UPG)',
                'jarak' => 1400, 'estimasi_jam' => 2, 'estimasi_menit' => 30, 'tarif_dasar' => 1200000
            ],
            [
                'kode_rute' => 'R-FLT-02', 'jenis' => 'pesawat', 'kota_asal' => 'Jakarta', 'simpul_asal' => 'Bandara Soekarno-Hatta (CGK)',
                'kota_tujuan' => 'Denpasar', 'simpul_tujuan' => 'Bandara Ngurah Rai (DPS)',
                'jarak' => 960, 'estimasi_jam' => 1, 'estimasi_menit' => 50, 'tarif_dasar' => 900000
            ],
            [
                'kode_rute' => 'R-FLT-03', 'jenis' => 'pesawat', 'kota_asal' => 'Jakarta', 'simpul_asal' => 'Bandara Soekarno-Hatta (CGK)',
                'kota_tujuan' => 'Surabaya', 'simpul_tujuan' => 'Bandara Juanda (SUB)',
                'jarak' => 690, 'estimasi_jam' => 1, 'estimasi_menit' => 30, 'tarif_dasar' => 750000
            ],
            [
                'kode_rute' => 'R-FLT-04', 'jenis' => 'pesawat', 'kota_asal' => 'Jakarta', 'simpul_asal' => 'Bandara Soekarno-Hatta (CGK)',
                'kota_tujuan' => 'Medan', 'simpul_tujuan' => 'Bandara Kualanamu (KNO)',
                'jarak' => 1420, 'estimasi_jam' => 2, 'estimasi_menit' => 15, 'tarif_dasar' => 1350000
            ],
            [
                'kode_rute' => 'R-FLT-05', 'jenis' => 'pesawat', 'kota_asal' => 'Surabaya', 'simpul_asal' => 'Bandara Juanda (SUB)',
                'kota_tujuan' => 'Makassar', 'simpul_tujuan' => 'Bandara Sultan Hasanuddin (UPG)',
                'jarak' => 840, 'estimasi_jam' => 1, 'estimasi_menit' => 40, 'tarif_dasar' => 850000
            ],
            [
                'kode_rute' => 'R-FLT-06', 'jenis' => 'pesawat', 'kota_asal' => 'Jakarta', 'simpul_asal' => 'Bandara Soekarno-Hatta (CGK)',
                'kota_tujuan' => 'Singapore', 'simpul_tujuan' => 'Changi Airport (SIN)',
                'jarak' => 890, 'estimasi_jam' => 1, 'estimasi_menit' => 45, 'tarif_dasar' => 1500000
            ],
            [
                'kode_rute' => 'R-FLT-07', 'jenis' => 'pesawat', 'kota_asal' => 'Jakarta', 'simpul_asal' => 'Bandara Soekarno-Hatta (CGK)',
                'kota_tujuan' => 'Kuala Lumpur', 'simpul_tujuan' => 'Kuala Lumpur Int. Airport (KUL)',
                'jarak' => 1100, 'estimasi_jam' => 2, 'estimasi_menit' => 0, 'tarif_dasar' => 1100000
            ],
            [
                'kode_rute' => 'R-FLT-08', 'jenis' => 'pesawat', 'kota_asal' => 'Jakarta', 'simpul_asal' => 'Bandara Soekarno-Hatta (CGK)',
                'kota_tujuan' => 'Hong Kong', 'simpul_tujuan' => 'Hong Kong Int. Airport (HKG)',
                'jarak' => 3260, 'estimasi_jam' => 4, 'estimasi_menit' => 50, 'tarif_dasar' => 3500000
            ],
            [
                'kode_rute' => 'R-FLT-09', 'jenis' => 'pesawat', 'kota_asal' => 'Jakarta', 'simpul_asal' => 'Bandara Soekarno-Hatta (CGK)',
                'kota_tujuan' => 'Tokyo', 'simpul_tujuan' => 'Narita International Airport (NRT)',
                'jarak' => 5780, 'estimasi_jam' => 7, 'estimasi_menit' => 15, 'tarif_dasar' => 6200000
            ],
            [
                'kode_rute' => 'R-FLT-10', 'jenis' => 'pesawat', 'kota_asal' => 'Jakarta', 'simpul_asal' => 'Bandara Soekarno-Hatta (CGK)',
                'kota_tujuan' => 'Sydney', 'simpul_tujuan' => 'Kingsford Smith Airport (SYD)',
                'jarak' => 5500, 'estimasi_jam' => 7, 'estimasi_menit' => 30, 'tarif_dasar' => 5900000
            ],

            // ==================== 10 RUTE BUS & TRAVEL ====================
            [
                'kode_rute' => 'R-BUS-01', 'jenis' => 'bus', 'kota_asal' => 'Jakarta', 'simpul_asal' => 'Terminal Pulo Gebang',
                'kota_tujuan' => 'Bandung', 'simpul_tujuan' => 'Terminal Leuwipanjang',
                'jarak' => 150, 'estimasi_jam' => 3, 'estimasi_menit' => 30, 'tarif_dasar' => 110000
            ],
            [
                'kode_rute' => 'R-BUS-02', 'jenis' => 'bus', 'kota_asal' => 'Jakarta', 'simpul_asal' => 'Terminal Kampung Rambutan',
                'kota_tujuan' => 'Semarang', 'simpul_tujuan' => 'Terminal Terboyo',
                'jarak' => 440, 'estimasi_jam' => 6, 'estimasi_menit' => 30, 'tarif_dasar' => 210000
            ],
            [
                'kode_rute' => 'R-BUS-03', 'jenis' => 'bus', 'kota_asal' => 'Jakarta', 'simpul_asal' => 'Terminal Kalideres',
                'kota_tujuan' => 'Yogyakarta', 'simpul_tujuan' => 'Terminal Giwangan',
                'jarak' => 530, 'estimasi_jam' => 8, 'estimasi_menit' => 30, 'tarif_dasar' => 240000
            ],
            [
                'kode_rute' => 'R-BUS-04', 'jenis' => 'bus', 'kota_asal' => 'Yogyakarta', 'simpul_asal' => 'Terminal Jombor',
                'kota_tujuan' => 'Semarang', 'simpul_tujuan' => 'Terminal Mangkang',
                'jarak' => 120, 'estimasi_jam' => 3, 'estimasi_menit' => 30, 'tarif_dasar' => 85000
            ],
            [
                'kode_rute' => 'R-BUS-05', 'jenis' => 'bus', 'kota_asal' => 'Surabaya', 'simpul_asal' => 'Terminal Purabaya',
                'kota_tujuan' => 'Malang', 'simpul_tujuan' => 'Terminal Arjosari',
                'jarak' => 90, 'estimasi_jam' => 2, 'estimasi_menit' => 0, 'tarif_dasar' => 50000
            ],
            [
                'kode_rute' => 'R-BUS-06', 'jenis' => 'bus', 'kota_asal' => 'Surabaya', 'simpul_asal' => 'Terminal Purabaya',
                'kota_tujuan' => 'Banyuwangi', 'simpul_tujuan' => 'Terminal Sritanjung',
                'jarak' => 290, 'estimasi_jam' => 7, 'estimasi_menit' => 30, 'tarif_dasar' => 140000
            ],
            [
                'kode_rute' => 'R-BUS-07', 'jenis' => 'bus', 'kota_asal' => 'Denpasar (Bali)', 'simpul_asal' => 'Terminal Ubung',
                'kota_tujuan' => 'Ubud', 'simpul_tujuan' => 'Puri Ubud Shuttle Point',
                'jarak' => 30, 'estimasi_jam' => 1, 'estimasi_menit' => 15, 'tarif_dasar' => 75000
            ],
            [
                'kode_rute' => 'R-BUS-08', 'jenis' => 'bus', 'kota_asal' => 'Medan', 'simpul_asal' => 'Terminal Amplas',
                'kota_tujuan' => 'Pematang Siantar', 'simpul_tujuan' => 'Terminal Tanjung Pinggir',
                'jarak' => 125, 'estimasi_jam' => 3, 'estimasi_menit' => 0, 'tarif_dasar' => 60000
            ],
            [
                'kode_rute' => 'R-BUS-09', 'jenis' => 'bus', 'kota_asal' => 'Bandung', 'simpul_asal' => 'Terminal Cicaheum',
                'kota_tujuan' => 'Tasikmalaya', 'simpul_tujuan' => 'Terminal Indihiang',
                'jarak' => 105, 'estimasi_jam' => 3, 'estimasi_menit' => 0, 'tarif_dasar' => 65000
            ],
            [
                'kode_rute' => 'R-BUS-10', 'jenis' => 'bus', 'kota_asal' => 'Jakarta', 'simpul_asal' => 'Terminal Pulo Gebang',
                'kota_tujuan' => 'Lampung', 'simpul_tujuan' => 'Terminal Rajabasa',
                'jarak' => 230, 'estimasi_jam' => 8, 'estimasi_menit' => 30, 'tarif_dasar' => 220000
            ],
        ];
        foreach ($ruteData as $r) {
            Route::create($r);
        }

        // --- 4. SEED DATA OPERASIONAL JADWAL (VALID & LOGIS) ---
        $allTransportation = Transportation::all();

        // Membuat 50 Jadwal dengan pencocokan kolom jenis secara langsung
        for ($i = 0; $i < 50; $i++) {
            $trans = $allTransportation->random();
            $route = Route::where('jenis', $trans->jenis)->inRandomOrder()->first();

            if ($route) {
                Schedule::factory()->create([
                    'route_id'          => $route->id,
                    'transportation_id' => $trans->id,
                    'total_seats'       => $trans->jumlah_kursi,
                    'remaining_seats'   => rand(5, $trans->jumlah_kursi),
                    'price'             => $route->tarif_dasar + match($trans->jenis) {
                        'pesawat' => rand(100000, 300000),
                        'kereta'  => rand(20000, 70000),
                        'bus'     => rand(10000, 30000),
                    },
                ]);
            }
        }

        // --- 5. SEED DATA ORDER ---
        Order::factory()->count(100)->create();
    }
}