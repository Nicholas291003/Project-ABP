@extends('layouts.passenger')

@section('content')
<div class="mb-10">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Halo, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h1>
    <p class="text-gray-600 mb-8">Mau ke mana hari ini? Yuk cari tiket perjalananmu sekarang.</p>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <div class="flex space-x-2 sm:space-x-4 border-b pb-4 mb-6 overflow-x-auto hide-scroll">
            <button type="button" onclick="switchTransport('kereta', this)" id="tab-kereta" class="tab-btn flex items-center space-x-2 pb-2 border-b-2 border-primary text-primary font-semibold whitespace-nowrap px-2">
                <i class="fa-solid fa-train"></i> <span>Kereta Api</span>
            </button>
            <button type="button" onclick="switchTransport('bus', this)" id="tab-bus" class="tab-btn flex items-center space-x-2 pb-2 text-gray-500 hover:text-primary transition whitespace-nowrap px-2">
                <i class="fa-solid fa-bus"></i> <span>Bus & Travel</span>
            </button>
            <button type="button" onclick="switchTransport('pesawat', this)" id="tab-pesawat" class="tab-btn flex items-center space-x-2 pb-2 text-gray-500 hover:text-primary transition whitespace-nowrap px-2">
                <i class="fa-solid fa-plane"></i> <span>Pesawat</span>
            </button>
        </div>

        <form action="{{ route('passenger.search') }}" method="GET" class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-end">
        
            <input type="hidden" name="jenis" id="selected_jenis" value="kereta">

            <div class="lg:col-span-4 relative">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Dari</label>
                <div class="relative">
                    <i class="fa-solid fa-location-dot absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="kota_asal" required placeholder="Asal Keberangkatan" class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary transition" value="{{ request('kota_asal', 'Jakarta') }}">
                </div>
            </div>
            
            <div class="lg:col-span-4 relative">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Ke</label>
                <div class="relative">
                    <i class="fa-solid fa-location-crosshairs absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="kota_tujuan" required placeholder="Kota Tujuan" class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary transition" value="{{ request('kota_tujuan', 'Yogyakarta') }}">
                </div>
            </div>

            <div class="lg:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary transition" id="datePicker" value="{{ request('tanggal') }}">
            </div>

            <div class="lg:col-span-2">
                <button type="submit" class="w-full bg-secondary hover:bg-secondaryDark text-white font-bold py-3 rounded-xl shadow-md transform transition hover:-translate-y-1 flex items-center justify-center h-[48px]">
                    <i class="fa-solid fa-magnifying-glass mr-2"></i> Cari
                </button>
            </div>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    
    <div class="xl:col-span-2">
        <div class="flex justify-between items-end mb-4">
            <h2 class="text-xl font-bold text-gray-800">
                <i class="fa-solid fa-ticket text-primary mr-2"></i> E-Ticket Aktif Anda
            </h2>
            <a href="{{ route('passenger.tickets') }}" class="text-sm text-primary font-semibold hover:underline">Lihat Semua</a>
        </div>
        
        @if($ticketAktif)
            <div class="bg-gradient-to-r from-blue-600 to-primary rounded-2xl p-1 shadow-lg">
                <div class="bg-white rounded-xl p-0 flex flex-col md:flex-row overflow-hidden relative">
                    <div class="p-6 flex-1 border-b md:border-b-0 md:border-r border-gray-200 border-dashed relative">
                        <div class="flex justify-between items-center mb-4">
                            <span class="bg-blue-100 text-primary text-xs font-bold px-3 py-1 rounded-full capitalize">
                                <i class="fa-solid @if($ticketAktif->schedule->transportation->jenis == 'kereta') fa-train @elseif($ticketAktif->schedule->transportation->jenis == 'bus') fa-bus @else fa-plane @endif mr-1"></i> 
                                {{ $ticketAktif->schedule->transportation->jenis }}
                            </span>
                            <span class="text-gray-500 text-sm font-medium">Order ID: {{ $ticketAktif->order_code }}</span>
                        </div>
                        
                        <h3 class="font-bold text-lg text-gray-800 mb-1">
                            {{ $ticketAktif->schedule->transportation->nama }} 
                            <span class="text-sm font-normal text-gray-500">({{ $ticketAktif->schedule->transportation->kelas }})</span>
                        </h3>
                        <p class="text-sm text-gray-500 mb-6">
                            {{ \Carbon\Carbon::parse($ticketAktif->schedule->departure_date)->isoFormat('dddd, D MMMM YYYY') }}
                        </p>
                        
                        <div class="flex items-center justify-between relative">
                            <div class="text-left">
                                <p class="text-2xl font-bold text-gray-800">{{ substr($ticketAktif->schedule->departure_time, 0, 5) }}</p>
                                <p class="text-sm font-semibold text-gray-700">{{ $ticketAktif->schedule->route->kota_asal }}</p>
                                <p class="text-[11px] text-gray-400 leading-tight max-w-[120px]">{{ $ticketAktif->schedule->route->simpul_asal }}</p>
                            </div>
                            <div class="flex-1 px-4 relative flex items-center justify-center">
                                <div class="h-0.5 w-full bg-gray-300 border-dashed border-t-2"></div>
                                <i class="fa-solid fa-arrow-right absolute text-gray-400 bg-white px-2 text-sm"></i>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-gray-800">{{ substr($ticketAktif->schedule->arrival_time, 0, 5) }}</p>
                                <p class="text-sm font-semibold text-gray-700">{{ $ticketAktif->schedule->route->kota_tujuan }}</p>
                                <p class="text-[11px] text-gray-400 leading-tight max-w-[120px]">{{ $ticketAktif->schedule->route->simpul_tujuan }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 w-full md:w-64 bg-gray-50 flex flex-col items-center justify-center">
                        <p class="text-xs text-gray-500 font-semibold mb-1 uppercase tracking-wide">Status Tiket</p>
                        <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full mb-4">
                            <i class="fa-solid fa-circle-check mr-1"></i> Telah Dibayar
                        </span>
                        <div class="w-28 h-28 bg-white border border-gray-200 rounded-lg p-2 mb-4 flex items-center justify-center shadow-sm">
                            <i class="fa-solid fa-qrcode text-6xl text-gray-800"></i>
                        </div>
                        <a href="{{ route('passenger.ticket.show', $ticketAktif->order_code) }}" class="w-full text-center bg-primary hover:bg-primaryDark text-white font-semibold py-2 rounded-lg transition text-sm shadow-sm">
                            Tampilkan E-Ticket
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl p-8 text-center border border-gray-100 shadow-sm flex flex-col items-center justify-center h-64">
                <div class="w-14 h-14 bg-blue-50 text-primary rounded-full flex items-center justify-center text-xl mb-3"><i class="fa-solid fa-ticket-simple"></i></div>
                <p class="text-gray-600 font-medium">Belum ada tiket aktif.</p>
            </div>
        @endif
    </div>

    <div class="xl:col-span-1">
        <div class="flex justify-between items-end mb-4">
            <h2 class="text-xl font-bold text-gray-800">
                <i class="fa-solid fa-clock-rotate-left text-gray-400 mr-2"></i> Riwayat Terakhir
            </h2>
            <a href="{{ route('passenger.history') }}" class="text-sm text-primary font-semibold hover:underline">Semua</a>
        </div>
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 space-y-4">
            @forelse($riwayatTerakhir as $riwayat)
                <div class="flex items-start pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                    <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center mr-4 flex-shrink-0">
                        <i class="fa-solid @if($riwayat->schedule->transportation->jenis == 'kereta') fa-train @elseif($riwayat->schedule->transportation->jenis == 'bus') fa-bus @else fa-plane @endif"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-sm text-gray-800 truncate">{{ $riwayat->schedule->transportation->name }}</h4>
                        <p class="text-xs text-gray-500 truncate mb-1.5">{{ $riwayat->schedule->route->kota_asal }} - {{ $riwayat->schedule->route->kota_tujuan }}</p>
                        
                        @if($riwayat->status == 'lunas')
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-green-100 text-green-700">Selesai</span>
                        @elseif($riwayat->status == 'pending')
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-orange-100 text-orange-700">Pending</span>
                        @else
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-red-100 text-red-700">Batal</span>
                        @endif
                    </div>
                    <div class="text-right flex-shrink-0 pl-2">
                        <p class="text-[11px] text-gray-400 mb-0.5">{{ \Carbon\Carbon::parse($riwayat->created_at)->format('d M Y') }}</p>
                        <p class="text-sm font-bold text-gray-800">Rp {{ number_format($riwayat->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-gray-400 text-sm flex flex-col items-center justify-center">
                    <i class="fa-solid fa-folder-open text-2xl mb-2 text-gray-300"></i> Belum ada riwayat.
                </div>
            @endforelse
        </div>
    </div>

</div>

<script>
    function switchTransport(jenis, element) {
        // 1. Ubah nilai input hidden agar terbaca oleh backend Laravel
        document.getElementById('selected_jenis').value = jenis;

        // 2. Hapus class aktif dari semua button tab terlebih dahulu
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('border-b-2', 'border-primary', 'text-primary', 'font-semibold');
            btn.classList.add('text-gray-500', 'hover:text-primary');
        });

        // 3. Tambahkan class aktif pada button tab yang baru saja diklik
        element.classList.remove('text-gray-500', 'hover:text-primary');
        element.classList.add('border-b-2', 'border-primary', 'text-primary', 'font-semibold');
    }
</script>
@endsection