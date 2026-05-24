@extends('layouts.passenger')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden mt-6">
    <div class="bg-primary p-4 text-white text-center font-bold text-sm tracking-wide">
        {{ $schedule->route->kota_asal }} ({{ $schedule->route->simpul_asal }}) ➔ {{ $schedule->route->kota_tujuan }}
    </div>

    <div class="p-5">
        <div class="flex space-x-4 border-b pb-2 mb-4 text-xs font-bold text-gray-400">
            <span class="border-b-2 border-orange-500 text-orange-500 pb-1 px-2 uppercase">{{ $schedule->transportation->kelas }}-1</span>
        </div>

        <div class="flex justify-center space-x-6 text-xs font-semibold text-gray-600 mb-6">
            <div class="flex items-center"><span class="w-4 h-4 rounded bg-blue-600 mr-1.5 block"></span> Dipilih</div>
            <div class="flex items-center"><span class="w-4 h-4 rounded bg-amber-700 mr-1.5 block"></span> Terisi</div>
            <div class="flex items-center"><span class="w-4 h-4 rounded bg-gray-300 mr-1.5 block"></span> Tersedia</div>
        </div>

        @include('passenger.components.seats.' . $schedule->transportation->jenis)

        <form action="{{ route('passenger.book') }}" method="POST" class="mt-6">
            @csrf
            <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
            <input type="hidden" name="coach_name" value="{{ $schedule->transportation->kelas }}-1">
            
            <div id="selectedSeatsInputs"></div>

            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-xl transition shadow-md tracking-wide">
                Simpan & Lanjutkan Pembayaran
            </button>
        </form>
    </div>
</div>

<script>
    // Ambil data array nomor kursi yang sudah terisi di database khusus untuk jadwal ini
    const kursiTerboking = @json($bookedSeats); 
    let listKursiPilihan = [];

    document.addEventListener("DOMContentLoaded", function() {
        // Warnai merah/cokelat dan kunci semua kursi yang sudah dipesan di database
        kursiTerboking.forEach(seat => {
            const el = document.getElementById(`seat-${seat}`);
            if (el) {
                el.classList.remove('bg-gray-300');
                el.classList.add('bg-amber-700', 'cursor-not-allowed');
                el.disabled = true; 
            }
        });
    });

    function toggleSeat(seatId) {
        const el = document.getElementById(`seat-${seatId}`);
        
        if (listKursiPilihan.includes(seatId)) {
            listKursiPilihan = listKursiPilihan.filter(item => item !== seatId);
            el.classList.remove('bg-blue-600');
            el.classList.add('bg-gray-300');
        } else {
            if (listKursiPilihan.length >= 4) {
                alert("Maksimal pemesanan adalah 4 kursi dalam satu transaksi kelompok.");
                return;
            }
            listKursiPilihan.push(seatId);
            el.classList.remove('bg-gray-300');
            el.classList.add('bg-blue-600');
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