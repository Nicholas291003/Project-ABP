@extends('layouts.admin')

@section('title', 'Metode & Keuangan Billing - Travelgo')

@section('content')
<div class="p-8 space-y-8 flex-1 w-full text-slate-300">
    
    {{-- Header Judul Halaman --}}
    <div class="mb-6">
        <h1 class="text-3xl font-black text-white tracking-tight">Ikhtisar Transaksi & Billing</h1>
        <p class="text-sm text-slate-400 mt-1">Pantau saluran masuk pembayaran, log invoice otomatis, dan verifikasi manifest keuangan.</p>
    </div>

    {{-- BARIS GRID 1: Kartu Kredit, Statistik, dan Invoice Ringkas --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Sektor Kiri: Simulasi Kartu & Pengaturan Metode Pembayaran --}}
        <div class="space-y-6">
            {{-- Komponen Kartu Kredit Fisik Premium Glass --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-teal-950 to-slate-950 border border-teal-500/30 rounded-2xl p-6 h-52 flex flex-col justify-between shadow-xl shadow-teal-950/20 group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-teal-400/10 rounded-full blur-3xl group-hover:bg-teal-400/20 transition-all duration-500"></div>
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] font-extrabold text-teal-400 tracking-widest uppercase">Travelgo Corporate Card</p>
                        <h4 class="text-xl font-mono font-bold text-white mt-2 tracking-widest">4562 1122 4594 7852</h4>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-xs font-black text-slate-400 italic">Mastercard</span>
                        <div class="w-8 h-6 bg-amber-500/80 rounded-md opacity-80 mt-1"></div>
                    </div>
                </div>
                <div class="flex justify-between items-end">
                    <div>
                        <p class="text-[9px] text-slate-500 font-bold uppercase tracking-wider">Card Holder</p>
                        <p class="text-sm font-bold text-slate-200">Travelgo Admin Pusat</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[9px] text-slate-500 font-bold uppercase tracking-wider">Expires</p>
                        <p class="text-sm font-mono font-bold text-slate-200">12/29</p>
                    </div>
                </div>
            </div>

            {{-- Komponen List Metode Pembayaran Aktif Sistem --}}
            <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 rounded-2xl p-5 space-y-4">
                <div class="flex justify-between items-center border-b border-slate-800/60 pb-2">
                    <h3 class="text-sm font-bold text-slate-200 uppercase tracking-wider">Metode Pembayaran</h3>
                    <a href="{{ route('admin.payment-methods.index') }}" class="text-xs font-bold text-teal-400 hover:underline">
                        Kelola
                    </a>
                </div>
                <div class="flex items-center justify-between p-3 bg-slate-900/60 border border-slate-800 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-blue-500/10 text-blue-400 rounded-lg text-xs font-black">BCA</div>
                        <div>
                            <p class="text-xs font-bold text-slate-200">Bank Virtual Account</p>
                            <p class="text-[11px] text-slate-500">**** **** **** 7852</p>
                        </div>
                    </div>
                    <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i>
                </div>
                <div class="flex items-center justify-between p-3 bg-slate-900/60 border border-slate-800 rounded-xl">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-orange-500/10 text-orange-400 rounded-lg text-xs font-black">GPY</div>
                        <div>
                            <p class="text-xs font-bold text-slate-200">GoPay / E-Wallet Gateway</p>
                            <p class="text-[11px] text-slate-500">Instant Check-out</p>
                        </div>
                    </div>
                    <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i>
                </div>
            </div>
        </div>

        {{-- Sektor Tengah: Dua Boks Mini Stats Saldo/Pendapatan Terbuka --}}
        <div class="flex flex-col justify-between gap-6">
            {{-- Boks Pendapatan Utama Lunas --}}
            <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 rounded-2xl p-6 flex flex-col justify-between items-center text-center flex-1">
                <div class="p-3 bg-teal-500/10 text-teal-400 rounded-2xl mb-2">
                    <i data-lucide="wallet" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Pendapatan Masuk</p>
                    <p class="text-[11px] text-slate-500 mt-0.5">Seluruh tiket manifest lunas</p>
                    <h2 class="text-3xl font-black text-white mt-3 tracking-tight">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h2>
                </div>
                <div class="text-emerald-400 text-xs font-bold flex items-center mt-2 bg-emerald-500/10 px-3 py-1 rounded-full border border-emerald-500/20">
                    <i data-lucide="arrow-up-right" class="w-3.5 h-3.5 mr-1"></i> +100% Valid Data
                </div>
            </div>

            {{-- Boks Penjualan Tertunda / Pending Ticket --}}
            <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 rounded-2xl p-6 flex flex-col justify-between items-center text-center flex-1">
                <div class="p-3 bg-amber-500/10 text-amber-400 rounded-2xl mb-2">
                    <i data-lucide="clock" class="w-6 h-6"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Dana Tertahan (Pending)</p>
                    <p class="text-[11px] text-slate-500 mt-0.5">Menunggu konfirmasi pembayaran Oleh Penumpang</p>
                    <h2 class="text-2xl font-black text-slate-200 mt-3">Rp {{ number_format($dana_pending, 0, ',', '.') }}</h2>
                </div>
                <div class="text-amber-400 text-xs font-bold flex items-center mt-2 bg-amber-500/10 px-3 py-1 rounded-full border border-amber-500/20">
                    Siklus Berjalan
                </div>
            </div>
        </div>

        {{-- Sektor Kanan: Invoices Listing Log --}}
        <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 rounded-2xl p-6 flex flex-col justify-between">
            <div class="flex justify-between items-center border-b border-slate-800/60 pb-3 mb-4">
                <h3 class="text-sm font-extrabold text-slate-200 uppercase tracking-wider flex items-center">
                    <i data-lucide="file-text" class="w-4 h-4 text-teal-400 mr-2"></i> Riwayat Invoice
                </h3>
                <button class="text-xs font-bold border border-slate-700 px-2.5 py-1 rounded-lg bg-slate-900/60 text-slate-400 hover:text-white transition-all">Lihat Semua</button>
            </div>
            <div class="space-y-3.5 flex-1 overflow-y-auto pr-1">
                @forelse($invoices as $inv)
                <div class="flex justify-between items-center text-xs group">
                    <div>
                        <p class="font-bold text-slate-300 group-hover:text-teal-400 transition-colors">{{ $inv->order_code }}</p>
                        <p class="text-[11px] text-slate-500 mt-0.5">{{ $inv->created_at->format('M d, Y - H:i') }}</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="font-extrabold text-slate-200">Rp {{ number_format($inv->total_price, 0, ',', '.') }}</span>
                        <a href="{{ route('admin.payments.invoice', $inv->id) }}" target="_blank" class="text-slate-500 hover:text-white transition-colors" title="Buka Detail Invoice">
                            <i data-lucide="download" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>
                @empty
                <p class="text-xs text-slate-600 text-center py-8">Belum ada invoice transaksi terekam.</p>
                @endforelse
            </div>
        </div>

    </div>

    {{-- BARIS GRID 2: Detail Informasi Pembayar & Log Riwayat Transaksi --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Kiri-Bawah: Informasi Detail Pembayar Terbaru (Billing Information) --}}
        <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 rounded-2xl p-6 lg:col-span-1 space-y-4">
            <h3 class="text-sm font-extrabold text-slate-200 uppercase tracking-wider border-b border-slate-800/60 pb-3 mb-2 flex items-center">
                <i data-lucide="user-check" class="w-4 h-4 text-teal-400 mr-2"></i> Data Pembayar Terkini
            </h3>
            
            <div class="space-y-4 overflow-y-auto max-h-[360px] pr-1">
                @forelse($billing_infos as $info)
                <div class="p-4 bg-slate-900/40 border border-slate-800/80 rounded-xl space-y-2 text-xs">
                    <div class="flex justify-between items-center">
                        <p class="font-black text-slate-200 text-sm">{{ $info->user->name ?? 'Penumpang Anonim' }}</p>
                        <span class="px-2 py-0.5 text-[9px] font-black bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded">SUCCESS</span>
                    </div>
                    <div class="text-slate-400 space-y-1 font-medium">
                        <p><span class="text-slate-500 font-bold">Email:</span> {{ $info->user->email ?? '-' }}</p>
                        <p><span class="text-slate-500 font-bold">Kode Tiket:</span> {{ $info->order_code }}</p>
                        <p><span class="text-slate-500 font-bold">Kuantitas:</span> {{ $info->total_passengers }} Penumpang</p>
                    </div>
                </div>
                @empty
                <p class="text-xs text-slate-600 text-center py-12">Belum ada data pembayaran terverifikasi.</p>
                @endforelse
            </div>
        </div>

        {{-- Kanan-Bawah: Log Riwayat Aktivitas Seluruh Transaksi Komplit --}}
        <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 rounded-2xl p-6 lg:col-span-2 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-center border-b border-slate-800/60 pb-3 mb-4">
                    <h3 class="text-sm font-extrabold text-slate-200 uppercase tracking-wider flex items-center">
                        <i data-lucide="activity" class="w-4 h-4 text-teal-400 mr-2"></i> Log Aliran Transaksi Masuk
                    </h3>
                    <span class="text-[11px] font-bold text-slate-500 tracking-wider">Riwayat Transaksi</span>
                </div>

                <div class="space-y-3">
                    @forelse($transactions as $tx)
                    @php 
                        $isLunas = in_array($tx->status, ['lunas', 'sukses']);
                    @endphp
                    <div class="flex items-center justify-between p-3 bg-slate-900/20 hover:bg-slate-900/50 border border-slate-800/40 rounded-xl transition-all text-xs">
                        <div class="flex items-center space-x-3.5">
                            {{-- Simbol Indikator Status Warna Bulat --}}
                            <div class="w-2.5 h-2.5 rounded-full {{ $isLunas ? 'bg-emerald-500 shadow-lg shadow-emerald-500/40' : 'bg-amber-500 shadow-lg shadow-amber-500/40' }}"></div>
                            <div>
                                <p class="font-bold text-slate-200">
                                    {{ $tx->schedule->route->kota_asal ?? 'Asal' }} ➔ {{ $tx->schedule->route->kota_tujuan ?? 'Tujuan' }}
                                </p>
                                <p class="text-[11px] text-slate-500 mt-0.5">
                                    {{ $tx->schedule->transportation->name ?? 'Armada' }} • {{ $tx->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right flex items-center space-x-4">
                            <div>
                                <p class="font-black {{ $isLunas ? 'text-emerald-400' : 'text-amber-500' }}">
                                    {{ $isLunas ? '+' : '' }}Rp {{ number_format($tx->total_price, 0, ',', '.') }}
                                </p>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">{{ $tx->order_code }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-slate-600 text-center py-16">Tidak ditemukan aktivitas log pembelian.</p>
                    @endforelse
                </div>
            </div>

            {{-- Kontrol Navigasi Halaman Log Keuangan --}}
            <div class="mt-4 border-t border-slate-800/40 pt-3">
                {{ $transactions->links() }}
            </div>
        </div>

    </div>

</div>
@endsection