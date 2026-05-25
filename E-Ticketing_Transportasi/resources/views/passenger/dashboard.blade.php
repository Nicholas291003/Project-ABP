@extends('layouts.passenger')

@section('content')
<div class="space-y-8">
    
    {{-- Sambutan Pengguna & Widget Cuaca Asli Foto 6 --}}
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Halo, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h1>
            <p class="text-slate-500 text-sm mt-1">Mau ke mana hari ini? Yuk cari tiket perjalananmu sekarang.</p>
        </div>

        {{-- WIDGET CUACA INDONESIA (Gaya Foto ke-6) --}}
        <div class="bg-white/80 border border-white/50 backdrop-blur-md rounded-2xl px-5 py-3 flex items-center space-x-4 shadow-sm shadow-zinc-200/40">
            <div class="w-10 h-10 rounded-xl bg-sky-100 flex items-center justify-center text-sky-500">
                <i data-lucide="cloud-sun" class="w-6 h-6"></i>
            </div>
            <div>
                <div class="flex items-center space-x-1.5">
                    <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Cuaca Hari Ini</span>
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                </div>
                <div class="flex items-baseline space-x-2">
                    <span class="text-base font-black text-slate-800">Surabaya</span>
                    <span class="text-sm font-bold text-slate-600">29°C</span>
                    <span class="text-[10px] text-slate-400 font-medium">(Berawan)</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. BOX PANEL PENCARIAN TIKET SOFT-GLASSMOPHISM --}}
    <div class="bg-white/80 border border-white/50 backdrop-blur-md rounded-3xl p-6 shadow-xl shadow-zinc-200/40">
        
        {{-- Tab Transportasi Interaktif --}}
        <div class="flex items-center space-x-2 border-b border-slate-100 pb-4 mb-6 overflow-x-auto hide-scroll">
            <button type="button" onclick="switchTransport('kereta', this)" id="tab-kereta" class="tab-btn flex items-center space-x-2 px-4 py-2 rounded-xl text-xs font-bold bg-teal-500/10 text-teal-600 border border-teal-500/20 transition-all cursor-pointer">
                <i data-lucide="train" class="w-4 h-4"></i>
                <span>Kereta Api</span>
            </button>
            <button type="button" onclick="switchTransport('bus', this)" id="tab-bus" class="tab-btn flex items-center space-x-2 px-4 py-2 rounded-xl text-xs font-medium text-slate-500 hover:bg-slate-100 transition-all cursor-pointer">
                <i data-lucide="bus" class="w-4 h-4"></i>
                <span>Bus & Travel</span>
            </button>
            <button type="button" onclick="switchTransport('pesawat', this)" id="tab-pesawat" class="tab-btn flex items-center space-x-2 px-4 py-2 rounded-xl text-xs font-medium text-slate-500 hover:bg-slate-100 transition-all cursor-pointer">
                <i data-lucide="plane-takeoff" class="w-4 h-4"></i>
                <span>Pesawat</span>
            </button>
        </div>

        {{-- Form Pencarian Tiket --}}
        <form action="{{ route('passenger.search') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <input type="hidden" name="jenis" id="selected_jenis" value="kereta">

            <div class="space-y-1.5">
                <label class="block text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Dari</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                    </span>
                    <input type="text" name="kota_asal" required placeholder="Asal Keberangkatan" class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-800 font-bold focus:outline-none focus:border-teal-400 focus:bg-white transition-all" value="{{ request('kota_asal', 'Jakarta') }}">
                </div>
            </div>
            
            <div class="space-y-1.5">
                <label class="block text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Ke</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                    </span>
                    <input type="text" name="kota_tujuan" required placeholder="Kota Tujuan" class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-800 font-bold focus:outline-none focus:border-teal-400 focus:bg-white transition-all" value="{{ request('kota_tujuan', 'Yogyakarta') }}">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Tanggal</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                    </span>
                    <input type="date" name="tanggal" required class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-800 font-bold focus:outline-none focus:border-teal-400 focus:bg-white transition-all" id="datePicker" value="{{ request('tanggal') }}">
                </div>
            </div>

            <button type="submit" class="w-full py-2.5 rounded-xl bg-gradient-to-r from-orange-500 to-red-500 hover:brightness-110 active:scale-95 transition-all text-sm font-extrabold text-white flex items-center justify-center space-x-2 shadow-lg shadow-orange-500/20 cursor-pointer h-[42px]">
                <i data-lucide="search" class="w-4.5 h-4.5 stroke-[3px]"></i>
                <span>Cari Tiket</span>
            </button>
        </form>
    </div>

    {{-- SEKSI BAWAH: TIKET AKTIF & RIWAYAT TERAKHIR --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- 4. E-TICKET AKTIF --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-black text-slate-800 tracking-tight flex items-center space-x-2">
                    <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                    <span>E-Ticket Aktif Anda</span>
                </h2>
                <a href="{{ route('passenger.tickets') }}" class="text-xs font-bold text-teal-600 hover:text-teal-700">Lihat Semua</a>
            </div>
            
            @if($ticketAktif)
                <div class="bg-white/90 border border-teal-500/20 backdrop-blur-md rounded-3xl p-6 shadow-xl shadow-zinc-200/40 relative overflow-hidden flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="absolute -right-10 -bottom-10 opacity-5 pointer-events-none">
                        <i data-lucide="bus" class="w-48 h-48"></i>
                    </div>

                    <div class="flex-1 space-y-4 w-full">
                        <div class="flex items-center justify-between md:justify-start space-x-3">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black bg-teal-500/10 text-teal-600 border border-teal-500/20 flex items-center space-x-1 capitalize">
                                <span>
                                    @if($ticketAktif->schedule->transportation->jenis == 'kereta') 🚄 @elseif($ticketAktif->schedule->transportation->jenis == 'bus') 🚌 @else ✈️ @endif
                                </span>
                                <span>{{ $ticketAktif->schedule->transportation->jenis }}</span>
                            </span>
                            <span class="text-xs text-slate-400 font-bold">Order ID: {{ $ticketAktif->order_code }}</span>
                        </div>
                        
                        <div>
                            <h3 class="text-xl font-extrabold text-slate-800">{{ $ticketAktif->schedule->transportation->nama }}</h3>
                            <p class="text-xs text-slate-400 font-medium mt-0.5">{{ $ticketAktif->schedule->transportation->kelas }} • {{ \Carbon\Carbon::parse($ticketAktif->schedule->departure_date)->isoFormat('dddd, D MMMM YYYY') }}</p>
                        </div>
                        
                        {{-- Timeline Rute Perjalanan --}}
                        <div class="flex items-center space-x-4 pt-2">
                            <div>
                                <h4 class="text-lg font-black text-slate-800">{{ substr($ticketAktif->schedule->departure_time, 0, 5) }}</h4>
                                <p class="text-[11px] text-slate-500 font-bold">{{ $ticketAktif->schedule->route->kota_asal }}</p>
                                <p class="text-[9px] text-slate-400 leading-tight max-w-[120px] mt-0.5">{{ $ticketAktif->schedule->route->simpul_asal }}</p>
                            </div>
                            <div class="flex-1 px-4 relative flex items-center justify-center">
                                <div class="w-full h-[2px] bg-dashed bg-slate-200 relative flex items-center justify-center">
                                    <div class="absolute w-2 h-2 rounded-full bg-teal-400"></div>
                                    <div class="absolute text-[15px] text-slate-300 translate-y-[-1px]">➔</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <h4 class="text-lg font-black text-slate-800">{{ substr($ticketAktif->schedule->arrival_time, 0, 5) }}</h4>
                                <p class="text-[11px] text-slate-500 font-bold">{{ $ticketAktif->schedule->route->kota_tujuan }}</p>
                                <p class="text-[9px] text-slate-400 leading-tight max-w-[120px] mt-0.5">{{ $ticketAktif->schedule->route->simpul_tujuan }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="hidden md:block w-[1px] h-32 bg-slate-100"></div>

                    <div class="flex flex-col items-center justify-center space-y-3 w-full md:w-44 text-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-600 border border-emerald-500/20">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1"></span> Telah Dibayar
                        </span>
                        <div class="w-16 h-16 bg-slate-50 border border-slate-200 rounded-xl p-1.5 flex items-center justify-center shadow-inner">
                            <i data-lucide="qr-code" class="w-full h-full text-slate-700"></i>
                        </div>
                        <a href="{{ route('passenger.ticket.show', $ticketAktif->order_code) }}" class="w-full text-center bg-teal-500 hover:bg-teal-600 text-white font-bold py-2 rounded-xl transition text-xs shadow-md shadow-teal-500/10">
                            Tampilkan E-Ticket
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-white/80 border border-white/50 backdrop-blur-md rounded-3xl p-8 text-center shadow-md flex flex-col items-center justify-center h-64">
                    <div class="w-14 h-14 bg-teal-50 text-teal-500 rounded-full flex items-center justify-center text-xl mb-3"><i data-lucide="ticket" class="w-6 h-6"></i></div>
                    <p class="text-slate-500 font-bold text-sm">Belum ada tiket aktif.</p>
                </div>
            @endif
        </div>

        {{-- 5. RIWAYAT TERAKHIR --}}
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-black text-slate-800 tracking-tight flex items-center space-x-2">
                    <i data-lucide="history" class="w-5 h-5 text-slate-400"></i>
                    <span>Riwayat Terakhir</span>
                </h2>
                <a href="{{ route('passenger.history') }}" class="text-xs font-bold text-teal-600 hover:text-teal-700">Semua</a>
            </div>
            
            <div class="bg-white/80 border border-white/50 backdrop-blur-md rounded-3xl p-4 space-y-3 shadow-xl shadow-zinc-200/30">
                @forelse($riwayatTerakhir as $riwayat)
                    <div class="p-3 bg-white/50 border border-slate-100 rounded-2xl flex items-center justify-between shadow-sm transition hover:border-slate-200">
                        <div class="flex items-center space-x-3 min-w-0">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 flex-shrink-0">
                                @if($riwayat->schedule->transportation->jenis == 'kereta')
                                    <i data-lucide="train" class="w-5 h-5"></i>
                                @elseif($riwayat->schedule->transportation->jenis == 'bus')
                                    <i data-lucide="bus" class="w-5 h-5"></i>
                                @else
                                    <i data-lucide="plane-takeoff" class="w-5 h-5"></i>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-bold text-sm text-slate-800 truncate">{{ $riwayat->schedule->transportation->nama }}</h4>
                                <p class="text-xs text-slate-400 truncate mt-0.5">{{ $riwayat->schedule->route->kota_asal }} - {{ $riwayat->schedule->route->kota_tujuan }}</p>
                                
                                <div class="mt-1.5">
                                    @if($riwayat->status == 'lunas')
                                        <span class="text-[9px] font-extrabold px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-600 border border-emerald-500/10">Selesai</span>
                                    @elseif($riwayat->status == 'pending')
                                        <span class="text-[9px] font-extrabold px-2 py-0.5 rounded bg-amber-500/10 text-amber-600 border border-amber-500/10">Pending</span>
                                    @else
                                        <span class="text-[9px] font-extrabold px-2 py-0.5 rounded bg-rose-500/10 text-rose-600 border border-rose-500/10">Batal</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0 pl-2">
                            <p class="text-[10px] text-slate-400 font-bold mb-0.5">{{ \Carbon\Carbon::parse($riwayat->created_at)->format('d M Y') }}</p>
                            <p class="text-sm font-black text-slate-800">Rp {{ number_format($riwayat->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-slate-400 text-sm flex flex-col items-center justify-center">
                        <i data-lucide="folder" class="w-8 h-8 mb-2 text-slate-300"></i>
                        <span class="font-medium">Belum ada riwayat.</span>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function switchTransport(jenis, element) {
        document.getElementById('selected_jenis').value = jenis;

        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.className = "tab-btn flex items-center space-x-2 px-4 py-2 rounded-xl text-xs font-medium text-slate-500 hover:bg-slate-100 transition-all cursor-pointer";
        });

        element.className = "tab-btn flex items-center space-x-2 px-4 py-2 rounded-xl text-xs font-bold bg-teal-500/10 text-teal-600 border border-teal-500/20 transition-all cursor-pointer";
    }
</script>
@endpush