# ✈️ Travelgo – Sistem E-Ticketing Transportasi Terintegrasi

Travelgo Sistem E-Ticketing Transportasi adalah aplikasi berbasis web dan mobile app yang dirancang untuk mempermudah proses pemesanan tiket perjalanan secara *online*. Platform ini mencakup pemesanan tiket untuk berbagai armada seperti Bus, Kereta Api, Travel, dan Pesawat. Proyek ini dibangun dengan menggunakan *framework* Laravel serta mengimplementasikan arsitektur hak akses (Role-Based Access Control) terpisah untuk Admin dan Penumpang.

---

## 💻 Website Travelgo

### ✨ Fitur Utama

#### 👨‍💼 Panel Admin
* **Dashboard Admin:** Menyajikan ringkasan visual seluruh data operasional sistem.
* **Manajemen Transportasi:** Operasi CRUD untuk mengelola data spesifikasi armada (Bus, Kereta, Travel, Pesawat) beserta kapasitas kursinya.
* **Manajemen Rute:** Operasi CRUD data wilayah keberangkatan asal, titik stasiun/terminal tujuan, serta jarak tempuh perjalanan.
* **Manajemen Jadwal:** Mengatur rincian waktu keberangkatan armada serta penetapan harga tarif dasar tiket.
* **Filter Multi-Kombinasi:** Fitur pencarian data rute dan armada yang responsif berdasarkan kota asal, kota tujuan, jenis transportasi, maupun kelas layanan secara real-time.

#### 👤 Portal Penumpang (User / Guest)
* **Pencarian Tiket Terintegrasi:** Memungkinkan pencarian jadwal keberangkatan aktif berdasarkan filter kota asal, kota tujuan, dan tanggal pergi.
* **Pemesanan Kursi:** Menyediakan antarmuka pemilihan nomor kursi secara spesifik sesuai sisa kapasitas gerbong armada.
* **Simulasi Pembayaran:** Menyediakan alur proses *checkout* terpadu dengan berbagai pilihan metode pembayaran seperti Transfer Bank Virtual Account dan E-Wallet.
* **Cetak E-Ticket:** Menghasilkan slip *Boarding Pass* digital interaktif yang dilengkapi dengan data manifes penumpang .
* **Riwayat Pemesanan:** Berfungsi untuk melacak rekam jejak status pembayaran tiket pengguna (Booked / Paid) .

---

## 📱 App Travelgo 
Aplikasi mobile built-in menggunakan framework Flutter untuk memudahkan penumpang melakukan manajemen transaksi langsung dari smartphone mereka. Fitur-fitur utama meliputi:
* **Autentikasi Sanctum Token:** Sistem Login & Register terintegrasi langsung dengan server backend Laravel.
* **Beranda Bento Box UI:** Tampilan visual dashboard modern yang menampilkan rekomendasi rute terlaris secara dinamis dari database.
* **Kalender Interaktif:** Memilih tanggal perjalanan secara manual menggunakan komponen *datepicker* bawaan Android/iOS.
* **Real-time Seat Selection:** Memilih tempat duduk mandiri dengan penguncian data kursi otomatis agar tidak bentrok dengan penumpang lain.
* **Boarding Pass & QR Code:** Menerbitkan kode QR unik dari database setelah status tagihan berubah menjadi lunas untuk keperluan validasi gerbang masuk.

---

## 🛠️ Teknologi yang Digunakan 
* **Backend Framework:** Laravel 12.x menggunakan PHP 8.2 .
- **Mobile Framework:** Flutter SDK menggunakan bahasa pemrograman Dart.
* **Basis Data:** MySQL .
* **Antarmuka Web UI:** Bootstrap 5 & Tailwind CSS .
* **Sistem Keamanan Auth:** Laravel Breeze  & Laravel Sanctum API Tokens.

---

## 📋 Prasyarat Sistem 
Sebelum menjalankan proyek ini, pastikan komputer Anda telah terinstal:
* PHP dengan versi minimal 8.2 .
* [Composer](https://getcomposer.org/) .
* [Node.js & NPM](https://nodejs.org/) .
* [MySQL](https://www.mysql.com/) & paket server lokal XAMPP .
* Flutter SDK (untuk menjalankan sisi mobile client).

---

## 🚀 Panduan Instalasi & Eksekusi 

### Bagian 1: Pengaturan Server Web Backend (Laravel)
1. **Masuk ke dalam direktori proyek web:**
```bash
   cd E-Ticketing_Transportasi
   composer install
   ```
2. **Instal seluruh dependensi paket PHP:**
```bash
   composer install
   ``` 
3. **Instal dependensi Node.js & kompilasi aset frontend:**
```bash
   npm install
   npm run build
   ``` 
4. **Konfigurasi Environment Aplikasi:**
   Salin berkas konfigurasi sampel menjadi berkas lingkungan lokal :
```bash
   cp .env.example .env
   ``` 
   Buka berkas `.env` dan sesuaikan detail pengaturan koneksi database MySQL Anda :
```text
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=travelgo_db
   DB_USERNAME=root
   DB_PASSWORD=
   ``` 
5. **Generate Application Key:**
```bash
   php artisan key:generate
   ``` 
6. **Migrasi Database & Data Awal (Seeder):**
   Jalankan perintah ini untuk membangun seluruh struktur tabel sistem (users, transports, travel_routes, schedules, tickets, payments) beserta records simulasi data awal :
```bash
   php artisan migrate --seed
   ``` 
7. **Nyalakan Server Lokal Laravel:**
```bash
   php artisan serve
   ``` 

### Bagian 2: Pengaturan Mobile Client App (Flutter)
1. **Buka tab terminal baru dan masuk ke direktori proyek mobile:**
```bash
   cd travelgo_app
   ```
2. **Unduh dependensi pub package Dart:**
```bash
  flutter pub get
  ```
3. **Jalankan aplikasi ke Emulator atau Perangkat HP Fisik:**
```bash
  flutter run
  ```

---

### 🗄️ Struktur Basis Data (Tabel Utama)
1. **users** Menyimpan informasi akun pengguna beserta pembagian level hak akses (admin/user).
2. **transports** Menyimpan data spesifikasi teknis dan nama armada transportasi.
3. **travel_routes** Mencatat data jaringan rute koridor yang meliputi kota asal, tujuan, dan jarak tempuh.
4. **schedules** Menyimpan data jadwal keberangkatan yang menghubungkan armada transportasi dengan rute tujuan.
5. **tickets** Menyimpan data transaksi pemesanan manifes kursi milik penumpang.
6. **payments** Mencatat status konfirmasi data simulasi pembayaran tiket pengguna.

---

###  👥 Tim Pengembang
Proyek kolaborasi terintegrasi ini disusun dan dikembangkan oleh:
1. Nicholas Aditya R. (1203230080) - Backend Development & Database Design 
2. Arya Maulana (1203230120) - Backend Development & Database Design 
3. Mukhlis Zahrawani Sutrisno (1203230065) - Web Frontend Development 
4. Josefania Tirsa Putri Immanuely (1203230012) - Mobile App Development (Flutter) 
5. Muamar Haikal F. (1203230118) - Mobile App Development (Flutter) 
6. Ahmad Wahyudi (1203230116) - API Integration, Testing, & Dokumentasi

---

Dibuat untuk memenuhi Tugas/Proyek Program Studi Informatika, Fakultas Informatika, Universitas Telkom Surabaya (2026).
 
