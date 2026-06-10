<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        // 1. KATEGORI: BANK TRANSFER (MANUAL CHECK)
        PaymentMethod::create([
            'kode' => 'BANK-BCA',
            'nama' => 'BCA Transfer Manual',
            'kategori' => 'bank',
            'nomor_tujuan' => '8410928131',
            'status' => 'aktif',
            'instruksi_bayar' => "1. Kirim dana ke Rekening BCA resmi Travelgo.\n2. Upload foto bukti transfer di aplikasi.\n3. Tunggu verifikasi admin maks 15 menit.",
        ]);

        PaymentMethod::create([
            'kode' => 'BANK-MANDIRI',
            'nama' => 'Mandiri Transfer Manual',
            'kategori' => 'bank',
            'nomor_tujuan' => '1420019283112',
            'status' => 'aktif',
            'instruksi_bayar' => "1. Lakukan transfer ke Rekening Mandiri Travelgo.\n2. Simpan struk dan unggah bukti di menu pesanan.\n3. Tiket diterbitkan setelah dana terverifikasi.",
        ]);

        // 2. KATEGORI: VIRTUAL ACCOUNT (OTOMATIS)
        PaymentMethod::create([
            'kode' => 'BCA-VA',
            'nama' => 'BCA Virtual Account',
            'kategori' => 'virtual_account',
            'nomor_tujuan' => '88320812345678',
            'status' => 'aktif',
            'instruksi_bayar' => "1. Pilih menu Transfer > Virtual Account.\n2. Masukkan nomor VA yang tertera.\n3. Tagihan akan otomatis keluar, konfirmasi PIN Anda.",
        ]);

        PaymentMethod::create([
            'kode' => 'MANDIRI-VA',
            'nama' => 'Mandiri Virtual Account',
            'kategori' => 'virtual_account',
            'nomor_tujuan' => '89230812345678',
            'status' => 'aktif',
            'instruksi_bayar' => "1. Masuk ke Livin by Mandiri, pilih menu Bayar.\n2. Masukkan kode perusahaan dan nomor akun VA.\n3. Verifikasi nominal transaksi dan selesaikan pembayaran.",
        ]);

        // 3. KATEGORI: DIGITAL E-WALLET
        PaymentMethod::create([
            'kode' => 'GOPAY',
            'nama' => 'GoPay Wallet',
            'kategori' => 'ewallet',
            'nomor_tujuan' => '081234567890',
            'status' => 'aktif',
            'instruksi_bayar' => "1. Aplikasi akan mengarahkan Anda langsung ke aplikasi Gojek.\n2. Periksa detail tagihan Travelgo.\n3. Klik Bayar dan masukkan PIN GoPay Anda.",
        ]);

        PaymentMethod::create([
            'kode' => 'DANA',
            'nama' => 'DANA Wallet',
            'kategori' => 'ewallet',
            'nomor_tujuan' => '081234567890',
            'status' => 'aktif',
            'instruksi_bayar' => "1. Masukkan nomor HP DANA Anda pada form gateway.\n2. Input PIN DANA dan kode OTP yang dikirim melalui SMS.\n3. Saldo DANA akan terpotong secara instan.",
        ]);

        PaymentMethod::create([
            'kode' => 'OVO',
            'nama' => 'OVO Cash',
            'kategori' => 'ewallet',
            'nomor_tujuan' => '081234567890',
            'status' => 'aktif',
            'instruksi_bayar' => "1. Buka aplikasi OVO Anda melalui push notification.\n2. Pilih metode pembayaran OVO Cash.\n3. Klik Bayar untuk menyelesaikan transaksi.",
        ]);

        PaymentMethod::create([
            'kode' => 'SHOPEEPAY',
            'nama' => 'ShopeePay',
            'kategori' => 'ewallet',
            'nomor_tujuan' => '081234567890',
            'status' => 'aktif',
            'instruksi_bayar' => "1. Pastikan aplikasi Shopee terpasang di perangkat.\n2. Konfirmasi pembayaran Travelgo pada halaman ShopeePay.\n3. Masukkan PIN ShopeePay Anda.",
        ]);
    }
}