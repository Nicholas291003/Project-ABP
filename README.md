## Travelg✦ Sistem E-Ticketing Transportasi

Travelg✦ Sistem E-Ticketing Transportasi adalah aplikasi berbasis web dan app yang dirancang untuk mempermudah proses pemesanan tiket perjalanan (Bus, Kereta Api, Travel, dan Pesawat) secara *online*. Proyek ini dibangun menggunakan *framework* Laravel dan mengimplementasikan arsitektur peran (Role-Based Access Control) untuk Admin dan Penumpang.

## ✨ Fitur Utama

### 👨‍💼 Panel Admin

- **Dashboard Admin:** Ringkasan data sistem.
- **Manajemen Transportasi:** CRUD data armada (Bus, Kereta, Travel, Pesawat) beserta kapasitasnya.
- **Manajemen Rute:** CRUD data asal, tujuan, dan jarak tempuh perjalanan.
- **Manajemen Jadwal:** Mengatur waktu keberangkatan dan penetapan harga tiket.

### 👤 Portal Penumpang (User / Guest)

- **Pencarian Tiket Terintegrasi:** Mencari jadwal keberangkatan berdasarkan kota asal, kota tujuan, dan tanggal keberangkatan.
- **Pemesanan Kursi:** Pemilihan nomor kursi secara spesifik sesuai kapasitas armada.
- **Simulasi Pembayaran:** Proses *checkout* dengan berbagai pilihan metode pembayaran (Transfer Bank, E-Wallet).
- **Cetak E-Ticket:** Pembuatan *Boarding Pass* digital yang interaktif.
- **Riwayat Pemesanan:** Melacak status tiket (Booked / Paid).

## 🛠️ Teknologi yang Digunakan

- **Backend:** Laravel 12.x (PHP 8.2)
- **Database:** MySQL
- **Frontend / UI:** Bootstrap 5 & Tailwind CSS
- **Authentication:** Laravel Breeze

## 📋 Prasyarat

Sebelum menjalankan proyek ini, pastikan komputer Anda telah terinstal:
- [PHP](https://www.php.net/) (Minimal versi 8.2)
- [Composer](https://getcomposer.org/)
- [Node.js & NPM](https://nodejs.org/)
- [MySQL](https://www.mysql.com/) / XAMPP / Laragon

## 🚀 Panduan Instalasi

Ikuti langkah-langkah berikut untuk menjalankan program:

1. **Clone repositori ini atau ekstrak folder proyek:**
   ```bash
   git clone <link-repositori-anda>
   cd <nama-folder-proyek>
   ```
 2. **Instal dependensi PHP:**
    ```bash
    composer install
    ```
 3. **Instal dependensi Node.js & compile aset frontend:**
    ```bash
    npm install
    npm run build
    ```
 4. **Konfigurasi Environment:**
    ### Salin file .env.example menjadi .env.
    ```bash
    cp .env.example .env
    ```
    ### Buka file .env dan sesuaikan konfigurasi database Anda:
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_anda
    DB_USERNAME=root
    DB_PASSWORD=
    ```
 5. **Generate Application Key:**
    ```bash
    php artisan key:generate
    ```
 6. **Migrasi Database:**
    ### Jalankan perintah ini untuk membuat seluruh tabel: users, transports, travel_routes, schedules, tickets, payments
    ```bash
    php artisan migrate
    ```
 7. **Jalankan Aplikasi:**
    ```bash
    php artisan serve
    ``` 
----

## 🗄️ Struktur Database (Tabel Utama)
1. users - Menyimpan data pengguna dan hak akses (admin/user).
2. transports - Data armada transportasi.
3. travel_routes - Data rute perjalanan (asal, tujuan, jarak).
4. schedules - Jadwal keberangkatan yang menghubungkan transportasi dan rute.
5. tickets - Data transaksi pemesanan kursi penumpang.
6. payments - Data simulasi status pembayaran tiket.

----

## 👥 Tim Pengembang
Proyek ini disusun dan dikembangkan oleh:
1. Nicholas Aditya R. (1203230080) - Backend Development & Database Design
2. Arya Maulana (1203230120) - Backend Development & Database Design
3. Mukhlis Zahrawani Sutrisno (1203230065) - Web Frontend Development
4. Josefania Tirsa Putri Immanuely (1203230012) - Mobile App Development (Flutter)
5. Muamar Haikal F. (1203230118) - Mobile App Development (Flutter)
6. Ahmad Wahyudi (1203230116) - API Integration, Testing, & Dokumentasi
----
## Dibuat untuk memenuhi Tugas/Proyek Program Studi Informatika, Fakultas Informatika, Universitas Telkom Surabaya (2026).
