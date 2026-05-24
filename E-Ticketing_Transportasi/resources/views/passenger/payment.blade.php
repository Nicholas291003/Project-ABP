@extends('layouts.passenger')

@section('title', 'Pembayaran Tiket')

@section('content')
<div class="max-w-4xl mx-auto pb-24">
    
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Pembayaran</h1>
        <p class="text-sm text-gray-500 mt-1">Selesaikan pembayaran untuk mengamankan nomor kursi dan menerbitkan E-Ticket Anda.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <div class="lg:col-span-2 space-y-6">
            <form action="{{ route('passenger.payment.process', $order->order_code) }}" method="POST" id="paymentForm">
                @csrf
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fa-solid fa-credit-card text-primary mr-2"></i> Pilih Metode Pembayaran
                    </h3>
                    
                    <div class="space-y-3">
                        <label class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border-2 border-transparent hover:border-primary/20 cursor-pointer transition has-[:checked]:border-primary has-[:checked]:bg-blue-50/30">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-white rounded-lg border flex items-center justify-center text-primary font-bold text-xs mr-3 shadow-sm">BCA</div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800">BCA Virtual Account</p>
                                    <p class="text-xs text-gray-400">Transfer dicek otomatis</p>
                                </div>
                            </div>
                            <input type="radio" name="payment_method" value="BCA VA" checked class="w-4 h-4 text-primary focus:ring-primary">
                        </label>

                        <label class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border-2 border-transparent hover:border-primary/20 cursor-pointer transition has-[:checked]:border-primary has-[:checked]:bg-blue-50/30">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-white rounded-lg border flex items-center justify-center text-blue-800 font-bold text-xs mr-3 shadow-sm">Mandiri</div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800">Mandiri Virtual Account</p>
                                    <p class="text-xs text-gray-400">Transfer dari bank mandiri</p>
                                </div>
                            </div>
                            <input type="radio" name="payment_method" value="Mandiri VA" class="w-4 h-4 text-primary focus:ring-primary">
                        </label>

                        <label class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border-2 border-transparent hover:border-primary/20 cursor-pointer transition has-[:checked]:border-primary has-[:checked]:bg-blue-50/30">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-white rounded-lg border flex items-center justify-center text-emerald-500 text-lg mr-3 shadow-sm"><i class="fa-solid fa-wallet"></i></div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800">GoPay / E-Wallet</p>
                                    <p class="text-xs text-gray-400">Konfirmasi instan via saldo smartphone</p>
                                </div>
                            </div>
                            <input type="radio" name="payment_method" value="GOPAY" class="w-4 h-4 text-primary focus:ring-primary">
                        </label>
                    </div>
                </div>

                <button type="submit" class="w-full mt-4 bg-secondary hover:bg-secondaryDark text-white font-bold py-3.5 rounded-2xl shadow-lg transition tracking-wide text-sm flex items-center justify-center">
                    <i class="fa-solid fa-circle-check mr-2"></i> Bayar Sekarang
                </button>
            </form>
        </div>

        <div class="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 px-5 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-800 text-sm">Ringkasan Tiket</h3>
            </div>
            <div class="p-5 space-y-4 text-sm">
                <div>
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Armada</p>
                    <p class="font-bold text-gray-800 mt-0.5">{{ $order->schedule->transportation->nama }}</p>
                    <p class="text-xs text-gray-500 capitalize">{{ $order->schedule->transportation->jenis }} ({{ $order->schedule->transportation->kelas }})</p>
                </div>

                <div>
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Rute Perjalanan</p>
                    <p class="font-semibold text-gray-800 mt-0.5">{{ $order->schedule->route->kota_asal }} ➔ {{ $order->schedule->route->kota_tujuan }}</p>
                </div>

                <div class="grid grid-cols-2 gap-2 border-t pt-3 border-gray-100">
                    <div>
                        <p class="text-xs text-gray-400 font-semibold">Gerbong</p>
                        <p class="font-bold text-gray-700">{{ $order->seatBookings->first()->coach_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold">Nomor Kursi</p>
                        <p class="font-bold text-primary">
                            @foreach($order->seatBookings as $seat)
                                {{ $seat->seat_number }}@if(!$loop->last), @endif
                            @endforeach
                        </p>
                    </div>
                </div>

                <div class="border-t pt-4 border-gray-100 flex justify-between items-center bg-orange-50/50 -mx-5 -mb-5 p-5">
                    <div>
                        <p class="text-xs text-gray-500 font-bold">Total Tagihan</p>
                        <p class="text-xs text-gray-400">({{ $order->total_passengers }} Pax x Rp {{ number_format($order->schedule->price, 0, ',', '.') }})</p>
                    </div>
                    <p class="text-lg font-black text-secondary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection