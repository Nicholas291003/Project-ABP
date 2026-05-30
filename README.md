✈️ Travelgo – Sistem E-Ticketing Transportasi Terintegrasi
Travelgo adalah platform pemesanan tiket perjalanan online (Bus, Kereta Api, dan Pesawat) berbasis full-stack. Platform ini memadukan Web Admin Panel sebagai sistem manajemen pusat (backend database & API provider) dan Mobile Client Application sebagai portal interaktif bagi penumpang untuk melakukan transaksi secara real-time.
Proyek ini terbagi menjadi dua sub-direktori utama di dalam repositori:
E-Ticketing_Transportasi : Aplikasi web berbasis framework Laravel 12.x yang bertugas mengelola data operasional admin dan menyediakan RESTful API.
travelgo_app : Aplikasi mobile berbasis framework Flutter (Dart) yang bertugas sebagai antarmuka pemesanan tiket bagi penumpang.
✨ Fitur Utama Sistem
1. 👨‍💼 Panel Manajemen Web Admin (Laravel 12.x)
Dashboard Finansial & Operasional : Menyajikan visualisasi ringkasan total armada aktif, koridor rute, dan grafik performa penjualan tiket.
Manajemen Armada Transportasi : Operasi CRUD data spesifikasi armada (Bus, Kereta, Pesawat), nomor lambung, total kapasitas kursi, kelas layanan, dan status kelayakan jalan (active/maintenance).
Manajemen Jaringan Rute : Operasi CRUD koridor perjalanan, koordinat stasiun/terminal asal dan tujuan, serta perhitungan jarak tempuh dan tarif dasar.
Manajemen Penjadwalan & Tarif : Pengaturan jam keberangkatan, estimasi waktu tiba, sisa kursi dinamis, serta penentuan harga tiket final.
Filter Multi-Kombinasi : Pencarian data rute dan armada yang responsif berdasarkan kota asal, kota tujuan, jenis transportasi, maupun kelas layanan secara real-time.
2. 👤 Portal Penumpang Mobile App (Flutter)
Autentikasi Aman : Fitur Login & Register yang terhubung langsung dengan keamanan token API Laravel Sanctum.
Beranda Bento Box UI : Tampilan beranda premium modern dengan integrasi indikator cuaca lokal dan daftar rekomendasi rute terlaris dari database.
Filter Pencarian Tiket Manual : Pencarian jadwal perjalanan yang fleksibel dengan pengisian nama kota mandiri dan pemilihan tanggal lewat kalender interaktif (datepicker).
Denah Kursi Interaktif : Antarmuka pemilihan nomor kursi gerbong/armada secara mandiri dengan pencegahan pemilihan kursi yang sudah terisi (booked).
Siklus Checkout & Transaksi Instan : Pembuatan pesanan langsung di database Laravel dengan status pembayaran yang berubah otomatis dari pending menjadi lunas.
E-Ticket & Boarding Pass Digital : Menghasilkan manifes tiket fisik digital yang rapi, lengkap dengan visualisasi Kode QR sebagai gerbang validasi masuk stasiun/bandara.
Manifes Riwayat Transaksi : Melacak rekam jejak pembelian tiket aktif maupun pembatalan (refund) pengguna.
🛠️ Teknologi yang Digunakan
Sisi Web Backend & API (Laravel)
Framework Utama : Laravel 12.x (PHP >= 8.2)
Sistem Keamanan : Laravel Breeze & Laravel Sanctum (Token-Based REST API)
Basis Data : MySQL
Antarmuka Web : Tailwind CSS & Bootstrap 5
Sisi Mobile Client (Flutter)
Bahasa & SDK : Flutter SDK & Dart Language
Komunikasi Jaringan : HTTP Client Package (REST API Integration)
Manajemen UI : Glassmorphic Premium UI & Fluent Custom Animation
🗄️ Struktur Basis Data (Tabel Utama MySQL)
users : Menyimpan kredensial akun pengguna, enkripsi password, dan klasifikasi hak akses (role: admin/penumpang).
transportations : Menyimpan data spesifikasi armada, kapasitas kursi, kelas layanan (Ekonomi, Bisnis, Eksekutif), fasilitas, dan status operasional.
routes (atau travel_routes) : Mencatat jaringan koridor perjalanan, kota asal, kota tujuan, simpul transit, jarak, dan tarif dasar.
schedules : Menghubungkan relasi armada dan rute untuk menentukan tanggal pergi, jam keberangkatan, jam tiba, dan sisa kursi dinamis.
orders (atau tickets) : Mencatatkan transaksi reservasi kursi, kode booking unik (TK-XXXXXX), total bayar, jumlah penumpang, dan status tagihan (pending/lunas).
🚀 Panduan Instalasi & Menjalankan Proyek
Bagian A: Menjalankan Server Web Backend (Laravel)
Buka terminal Anda dan masuk ke direktori proyek backend:
cd E-Ticketing_Transportasi


Pasang seluruh dependensi pustaka PHP:
composer install


Pasang dependensi Node.js untuk aset tampilan web:
npm install
npm run build


Konfigurasikan lingkungan database:
Salin file .env.example menjadi .env
Buka file .env dan sesuaikan koneksi database MySQL Anda (contoh nama database: travelgo_db).
Buat kunci enkripsi aplikasi, jalankan migrasi tabel database beserta pengisian data awal (seeder):
php artisan key:generate
php artisan migrate
php artisan db:seed


Nyalakan server lokal backend Laravel:
php artisan serve

Server backend akan berjalan secara default di port http://127.0.0.1:8000.
Bagian B: Menjalankan Aplikasi Mobile (Flutter)
Buka tab terminal baru, lalu masuk ke direktori aplikasi mobile:
cd travelgo_app


Ambil dan pasang paket dependensi Flutter:
flutter pub get


Pastikan emulator Android Anda sudah aktif atau perangkat HP fisik telah terhubung dalam mode USB Debugging.
Jalankan aplikasi ke perangkat target:
flutter run

(Catatan Jaringan: Aplikasi mobile dikonfigurasi menembak IP 10.0.2.2:8000 khusus emulator Android untuk menjangkau localhost server Laravel laptop Anda).
👥 Tim Pengembang (Project ABP)
Proyek integrasi sistem full-stack ini dikembangkan secara kolaboratif oleh:
Nicholas Aditya R. (1203230080) – Backend Engineering & Core Database Design
Arya Maulana (1203230120) – Backend Engineering & Security Core Architecture
Mukhlis Zahrawani Sutrisno (1203230065) – Web Frontend Engineering & Admin UI Design
Josefania Tirsa Putri Immanuely (1203230012) – Mobile Application Core Engineering (Flutter)
Muamar Haikal F. (1203230118) – Mobile Application Interface Engineering & State Management
Ahmad Wahyudi (1203230116) – RESTful API Bridging, System Integration Testing, & Documentation
Proyek ini disusun dan diselesaikan untuk memenuhi kriteria Tugas Besar Terintegrasi pada Program Studi S1 Informatika, Fakultas Informatika, Universitas Telkom Surabaya (2026).
