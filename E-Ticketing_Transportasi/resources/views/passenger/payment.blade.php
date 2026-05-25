@extends('layouts.passenger')

@section('title', 'Pembayaran Tiket')

@section('content')
<div class="max-w-4xl mx-auto pb-24 space-y-6">
    
    {{-- Header Halaman --}}
    <div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Pembayaran</h1>
        <p class="text-sm text-slate-500 mt-1">Selesaikan pembayaran untuk mengamankan nomor kursi dan menerbitkan E-Ticket Anda.</p>
    </div>

    {{-- Layout Grid Utama (Kiri: Metode, Kanan: Ringkasan) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        {{-- SISI KIRI: PEMILIHAN METODE (2/3 Kolom) --}}
        <div class="lg:col-span-2">
            <form action="{{ route('passenger.payment.process', $order->order_code) }}" method="POST" id="paymentForm">
                @csrf
                
                <div class="bg-white/80 border border-white/50 backdrop-blur-md rounded-3xl p-6 shadow-xl shadow-zinc-200/40 space-y-5">
                    <h3 class="text-base font-black text-slate-800 flex items-center">
                        <i data-lucide="credit-card" class="text-teal-500 mr-2.5 w-5 h-5"></i>
                        <span>Pilih Metode Pembayaran</span>
                    </h3>
                    
                    <div class="space-y-3">
                        {{-- Pilihan 1: BCA VA --}}
                        <label class="flex items-center justify-between p-4 bg-slate-50/60 border-2 border-transparent rounded-2xl hover:border-teal-500/20 cursor-pointer transition-all has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/20 shadow-sm group">
                            <div class="flex items-center">
                                <div class="w-12 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-teal-600 font-black text-xs mr-3.5 shadow-sm group-hover:scale-105 transition-transform">BCA</div>
                                <div>
                                    <p class="text-sm font-black text-slate-800">BCA Virtual Account</p>
                                    <p class="text-xs text-slate-400 font-medium">Transfer dicek otomatis</p>
                                </div>
                            </div>
                            <input type="radio" name="payment_method" value="BCA VA" checked class="w-4 h-4 text-teal-500 focus:ring-teal-500 cursor-pointer">
                        </label>

                        {{-- Pilihan 2: Mandiri VA --}}
                        <label class="flex items-center justify-between p-4 bg-slate-50/60 border-2 border-transparent rounded-2xl hover:border-teal-500/20 cursor-pointer transition-all has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/20 shadow-sm group">
                            <div class="flex items-center">
                                <div class="w-12 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-blue-700 font-black text-xs mr-3.5 shadow-sm group-hover:scale-105 transition-transform">Mandiri</div>
                                <div>
                                    <p class="text-sm font-black text-slate-800">Mandiri Virtual Account</p>
                                    <p class="text-xs text-slate-400 font-medium">Transfer dari bank mandiri</p>
                                </div>
                            </div>
                            <input type="radio" name="payment_method" value="Mandiri VA" class="w-4 h-4 text-teal-500 focus:ring-teal-500 cursor-pointer">
                        </label>

                        {{-- Pilihan 3: GoPay / E-Wallet --}}
                        <label class="flex items-center justify-between p-4 bg-slate-50/60 border-2 border-transparent rounded-2xl hover:border-teal-500/20 cursor-pointer transition-all has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/20 shadow-sm group">
                            <div class="flex items-center">
                                <div class="w-12 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-emerald-500 text-lg mr-3.5 shadow-sm group-hover:scale-105 transition-transform">
                                    <i data-lucide="wallet" class="w-5 h-5 text-emerald-500"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-800">GoPay / E-Wallet</p>
                                    <p class="text-xs text-slate-400 font-medium">Konfirmasi instan via saldo smartphone</p>
                                </div>
                            </div>
                            <input type="radio" name="payment_method" value="GOPAY" class="w-4 h-4 text-teal-500 focus:ring-teal-500 cursor-pointer">
                        </label>
                    </div>
                </div>

                {{-- Tombol Konfirmasi Bayar --}}
                <button type="submit" class="w-full mt-4 py-3.5 rounded-2xl bg-gradient-to-r from-orange-500 to-red-500 hover:brightness-110 active:scale-95 transition-all text-sm font-extrabold text-white flex items-center justify-center space-x-2 shadow-lg shadow-orange-500/20 cursor-pointer">
                    <i data-lucide="check-circle" class="w-4.5 h-4.5 stroke-[2.5px]"></i>
                    <span>Bayar Sekarang</span>
                </button>
            </form>
        </div>

        {{-- SISI KANAN: RINGKASAN TIKET (1/3 Kolom) --}}
        <div class="lg:col-span-1 bg-white/80 border border-white/50 backdrop-blur-md rounded-3xl shadow-xl shadow-zinc-200/40 overflow-hidden">
            <div class="bg-slate-50/80 px-5 py-4 border-b border-slate-100 flex items-center space-x-2">
                <i data-lucide="receipt" class="w-4.5 h-4.5 text-slate-400"></i>
                <h3 class="font-black text-slate-800 text-sm">Ringkasan Tiket</h3>
            </div>
            
            <div class="p-5 space-y-4 text-sm">
                {{-- Detail Kendaraan --}}
                <div>
                    <p class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider">Armada</p>
                    <p class="font-black text-slate-800 mt-0.5">{{ $order->schedule->transportation->nama }}</p>
                    <p class="text-xs text-slate-400 font-medium capitalize flex items-center mt-0.5">
                        <span class="mr-1">
                            @if($order->schedule->transportation->jenis == 'kereta')
                                <i data-lucide="train" class="w-4 h-4"></i>
                            @elseif($order->schedule->transportation->jenis == 'bus')
                                <i data-lucide="bus" class="w-4 h-4"></i>
                            @else
                                <i data-lucide="plane-takeoff" class="w-4 h-4"></i>
                            @endif
                        </span>
                        {{ $order->schedule->transportation->jenis }} ({{ $order->schedule->transportation->kelas }})
                    </p>
                </div>

                {{-- Detail Jalur --}}
                <div>
                    <p class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider">Rute Perjalanan</p>
                    <p class="font-bold text-slate-800 mt-0.5 flex items-center">
                        <span>{{ $order->schedule->route->kota_asal }}</span>
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5 mx-1 text-slate-400"></i>
                        <span>{{ $order->schedule->route->kota_tujuan }}</span>
                    </p>
                </div>

                {{-- Grid Gerbong & Nomor Tempat Duduk --}}
                <div class="grid grid-cols-2 gap-2 border-t pt-3 border-slate-100">
                    <div>
                        <p class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider">Gerbong</p>
                        <p class="font-bold text-slate-700 mt-0.5">{{ $order->seatBookings->first()->coach_name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider">Nomor Kursi</p>
                        <p class="font-black text-teal-600 mt-0.5 tracking-wide">
                            @foreach($order->seatBookings as $seat)
                                {{ $seat->seat_number }}@if(!$loop->last), @endif
                            @endforeach
                        </p>
                    </div>
                </div>

                {{-- Kotak Tagihan Akhir (Gaya Glowing Soft Glass) --}}
                <div class="border-t pt-4 border-slate-100 flex justify-between items-center bg-orange-500/5 -mx-5 -mb-5 p-5 border-t border-orange-500/10">
                    <div>
                        <p class="text-[10px] text-slate-500 font-black uppercase tracking-wider">Total Tagihan</p>
                        <p class="text-[10px] text-slate-400 font-semibold mt-0.5">({{ $order->total_passengers }} Pax x Rp {{ number_format($order->schedule->price, 0, ',', '.') }})</p>
                    </div>
                    <p class="text-xl font-black text-orange-500">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection