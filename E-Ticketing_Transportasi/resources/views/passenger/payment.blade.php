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
                
                <div class="bg-white/80 border border-white/50 backdrop-blur-md rounded-3xl p-6 shadow-xl shadow-zinc-200/40 space-y-6">
                    <h3 class="text-base font-black text-slate-800 flex items-center">
                        <i data-lucide="credit-card" class="text-teal-500 mr-2.5 w-5 h-5"></i>
                        <span>Pilih Metode Pembayaran</span>
                    </h3>
                    
                    {{-- AREA DAFTAR METODE PEMBAYARAN DINAMIS DARI DATABASE --}}
                    <div class="space-y-3">
                        @forelse($payment_methods as $index => $method)
                            <label class="payment-method-item flex items-center justify-between p-4 bg-slate-50/60 border-2 border-transparent rounded-2xl hover:border-teal-500/20 cursor-pointer transition-all has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/20 shadow-sm group"
                                   data-instruksi="{{ $method->instruksi_bayar }}" 
                                   data-kategori="{{ $method->kategori }}"
                                   data-qr="{{ $method->qr_file ? asset($method->qr_file) : '' }}">
                                
                                <div class="flex items-center">
                                    {{-- Kotak Inisial Logo Otomatis --}}
                                    <div class="w-12 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-teal-600 font-black text-[10px] mr-3.5 shadow-sm group-hover:scale-105 transition-transform uppercase">
                                        {{ substr($method->kode, 0, 4) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-800">{{ $method->nama }}</p>
                                        <p class="text-xs text-slate-400 font-medium capitalize">{{ str_replace('_', ' ', $method->kategori) }}</p>
                                    </div>
                                </div>
                                {{-- Atribut name disesuaikan menjadi payment_method_id untuk dibaca Controller --}}
                                <input type="radio" name="payment_method_id" value="{{ $method->id }}" {{ $index == 0 ? 'checked' : '' }} class="w-4 h-4 text-teal-500 focus:ring-teal-500 cursor-pointer">
                            </label>
                        @empty
                            <p class="text-xs text-slate-400 text-center py-6">Belum ada metode pembayaran aktif yang tersedia.</p>
                        @endforelse
                    </div>

                    {{-- BOXY AREA: DETAIL PETUNJUK & PREVIEW QRIS (INTERAKTIF JAVASCRIPT) --}}
                    <div class="border-t border-slate-100 pt-5 space-y-4">
                        <h4 class="text-xs font-extrabold text-slate-400 uppercase tracking-wider flex items-center">
                            <i data-lucide="info" class="w-4 h-4 mr-1.5 text-teal-500"></i>
                            <span>Petunjuk Transaksi</span>
                        </h4>
                        
                        {{-- Tempat Teks Instruksi --}}
                        <div class="p-4 bg-slate-50/40 border border-slate-100 rounded-2xl">
                            <p id="text_instruksi" class="text-xs text-slate-600 leading-relaxed whitespace-pre-line">-</p>
                        </div>

                        {{-- Tempat Gambar/PDF QRIS --}}
                        <div id="box_qris_display" class="hidden flex flex-col items-center justify-center p-6 bg-white border border-slate-100 rounded-2xl max-w-sm mx-auto shadow-inner text-center">
                            <p class="text-[9px] font-black tracking-widest text-slate-800 mb-3">SCAN BARCODE REKENING TRAVELGO</p>
                            
                            {{-- Preview Gambar QR Code --}}
                            <img id="img_qris_target" src="" alt="QRIS Barcode" class="w-44 h-44 object-cover rounded-xl mb-3 hidden">
                            
                            {{-- Preview Dokumen PDF QR Code --}}
                            <a id="link_pdf_target" href="#" target="_blank" class="hidden items-center space-x-2 px-4 py-2 bg-rose-500 hover:bg-rose-600 text-white font-black text-xs rounded-xl transition-all shadow-md">
                                <span>Buka Dokumen PDF QRIS</span>
                            </a>
                        </div>
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
                        <p class="font-bold text-slate-700 mt-0.5">{{ $order->seatBookings->first()->coach_name ?? 'Gerbong 1' }}</p>
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

                {{-- Kotak Tagihan Akhir --}}
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

{{-- JAVASCRIPT LOGIKA SAKLAR TOGGLE DAN RENDERING KATEGORI MEDIA --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const items = document.querySelectorAll('.payment-method-item');
        const textInstruksi = document.getElementById('text_instruksi');
        const boxQrisDisplay = document.getElementById('box_qris_display');
        const imgQrisTarget = document.getElementById('img_qris_target');
        const linkPdfTarget = document.getElementById('link_pdf_target');

        function updatePaymentDetails(element) {
            if (!element) return;
            
            // Ambil variabel dari komponen HTML data-attributes
            const instruksi = element.getAttribute('data-instruksi');
            const kategori = element.getAttribute('data-kategori');
            const qrUrl = element.getAttribute('data-qr');
            const inputRadio = element.querySelector('input[type="radio"]');
            
            // Tandai checked secara programatik
            inputRadio.checked = true;

            // Render teks petunjuk instruksi
            textInstruksi.textContent = instruksi ? instruksi.trim() : 'Silakan selesaikan pembayaran sesuai instruksi dari channel pilihan Anda.';
            
            // Logika Evaluasi Khusus Media File QRIS
            if (kategori === 'qris' && qrUrl !== '') {
                boxQrisDisplay.classList.remove('hidden');
                
                if (qrUrl.toLowerCase().endsWith('.pdf')) {
                    linkPdfTarget.href = qrUrl;
                    linkPdfTarget.classList.remove('hidden');
                    imgQrisTarget.classList.add('hidden');
                } else {
                    imgQrisTarget.src = qrUrl;
                    imgQrisTarget.classList.remove('hidden');
                    linkPdfTarget.classList.add('hidden');
                }
            } else {
                boxQrisDisplay.classList.add('hidden');
                imgQrisTarget.classList.add('hidden');
                linkPdfTarget.classList.add('hidden');
            }
        }

        const defaultChecked = document.querySelector('.payment-method-item input[type="radio"]:checked');
        if (defaultChecked) {
            updatePaymentDetails(defaultChecked.closest('.payment-method-item'));
        }

        items.forEach(item => {
            item.addEventListener('click', function() {
                updatePaymentDetails(this);
            });
        });
    });
</script>
@endsection