@extends('layouts.passenger')

@section('title', 'Pilih Kursi Perjalanan')

@section('content')
<div class="max-w-md mx-auto space-y-6">

    {{-- Tombol Kembali --}}
    <div class="flex items-center">
        <a href="{{ url()->previous() }}" class="flex items-center space-x-2 text-xs font-bold text-slate-500 hover:text-teal-600 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali</span>
        </a>
    </div>

    {{-- KARTU UTAMA PEMILIHAN KURSI --}}
    <div class="bg-white/80 border border-white/50 backdrop-blur-md rounded-3xl shadow-xl shadow-zinc-200/40 overflow-hidden">
        
        {{-- Header Jalur Perjalanan --}}
        <div class="bg-gradient-to-r from-teal-500 to-cyan-500 p-4 text-slate-950 text-center font-black text-sm tracking-tight flex items-center justify-center space-x-2">
            <i data-lucide="armchair" class="w-4.5 h-4.5"></i>
            <span>{{ $schedule->route->kota_asal }}</span>
            <i data-lucide="arrow-right" class="w-3.5 h-3.5 mx-0.5"></i>
            <span>{{ $schedule->route->kota_tujuan }}</span>
        </div>

        <div class="p-6 space-y-6">
            {{-- Detail Kelas Layanan --}}
            <div class="flex justify-center border-b border-slate-100 pb-3">
                <span class="px-3 py-1 rounded-full text-[10px] font-black bg-orange-500/10 text-orange-600 border border-orange-500/20 uppercase tracking-wider">
                    {{ $schedule->transportation->kelas }} - 1
                </span>
            </div>

            {{-- Legenda Indikator Status Kursi --}}
            <div class="flex justify-center space-x-6 text-xs font-bold text-slate-500 bg-slate-50 p-3 rounded-2xl border border-slate-100 shadow-inner">
                <div class="flex items-center">
                    <span class="w-4 h-4 rounded-md bg-teal-500 mr-2 block shadow-sm shadow-teal-500/20"></span> 
                    <span>Dipilih</span>
                </div>
                <div class="flex items-center">
                    <span class="w-4 h-4 rounded-md bg-slate-800 mr-2 block"></span> 
                    <span>Terisi</span>
                </div>
                <div class="flex items-center">
                    <span class="w-4 h-4 rounded-md bg-slate-200 mr-2 block"></span> 
                    <span>Tersedia</span>
                </div>
            </div>

            {{-- Tempat Duduk Kendaraan Sesuai Jenis (Include Dinamis) --}}
            <div class="py-2">
                @include('passenger.components.seats.' . $schedule->transportation->jenis)
            </div>

            {{-- Form Pengiriman Data Pemesanan --}}
            <form action="{{ route('passenger.book') }}" method="POST" class="pt-2">
                @csrf
                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                <input type="hidden" name="coach_name" value="{{ $schedule->transportation->kelas }}-1">
                
                {{-- Input Hidden Dinamis untuk Menyimpan Nomor Kursi --}}
                <div id="selectedSeatsInputs"></div>

                <button type="submit" class="w-full py-3 rounded-2xl bg-gradient-to-r from-orange-500 to-red-500 hover:brightness-110 active:scale-95 transition-all text-sm font-extrabold text-white flex items-center justify-center space-x-2 shadow-lg shadow-orange-500/20 cursor-pointer">
                    <i data-lucide="credit-card" class="w-4.5 h-4.5"></i>
                    <span>Simpan & Lanjutkan Pembayaran</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Ambil data array nomor kursi yang sudah terisi di database khusus untuk jadwal ini
    const kursiTerboking = @json($bookedSeats);
    let listKursiPilihan = [];

    document.addEventListener("DOMContentLoaded", function() {
        // Kunci dan tandai abu-abu gelap semua kursi yang sudah terisi di database
        kursiTerboking.forEach(seat => {
            const el = document.getElementById(`seat-${seat}`);
            if (el) {
                el.classList.remove('bg-slate-200', 'text-slate-600', 'hover:bg-slate-300');
                el.classList.add('bg-slate-800', 'text-slate-500', 'cursor-not-allowed', 'opacity-30');
                el.disabled = true;
            }
        });
    });

    function toggleSeat(seatId) {
        const el = document.getElementById(`seat-${seatId}`);
        
        if (listKursiPilihan.includes(seatId)) {
            // Batalkan pilihan jika diklik ulang
            listKursiPilihan = listKursiPilihan.filter(item => item !== seatId);
            el.classList.remove('bg-teal-500', 'text-slate-950', 'shadow-md', 'shadow-teal-500/20');
            el.classList.add('bg-slate-200', 'text-slate-600');
        } else {
            // Batasi maksimal pemesanan kelompok 4 kursi
            if (listKursiPilihan.length >= 4) {
                alert("Maksimal pemesanan adalah 4 kursi dalam satu transaksi kelompok.");
                return;
            }
            listKursiPilihan.push(seatId);
            el.classList.remove('bg-slate-200', 'text-slate-600');
            el.classList.add('bg-teal-500', 'text-slate-950', 'shadow-md', 'shadow-teal-500/20');
        }

        // Tulis input hidden dinamis ke HTML agar terbaca oleh request POST Laravel
        const container = document.getElementById('selectedSeatsInputs');
        container.innerHTML = '';
        listKursiPilihan.forEach(seat => {
            container.innerHTML += `<input type="hidden" name="selected_seats[]" value="${seat}">`;
        });
    }
</script>
@endsection