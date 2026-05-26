@extends('layouts.guest')

@section('title', 'Pesan Tiket Transportasi Online - Travelgo')

@section('content')
<div class="space-y-4">
    
    {{-- 1. HERO SECTION DENGAN SENTUHAN MODERN LIGHT MESH --}}
    <div class="relative pt-20 pb-44 sm:pt-28 sm:pb-52 overflow-hidden flex items-center justify-center text-center">
        <div class="absolute inset-0 opacity-50 pointer-events-none">
            <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Background" class="w-full h-full object-cover">
        </div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4 z-10">
            <h1 class="text-4xl sm:text-6xl font-black text-slate-900 tracking-tight leading-none drop-shadow-sm">
                Jelajahi Dunia, <span class="bg-gradient-to-r from-teal-500 to-indigo-600 bg-clip-text text-transparent">Mulai dari Sini</span>
            </h1>
            <p class="text-base sm:text-lg font-medium text-slate-900 max-w-2xl mx-auto leading-relaxed">
                Platform pemesanan tiket transportasi online terlengkap. Mudah, cepat, dan terpercaya untuk setiap langkah perjalanan berharga Anda.
            </p>
        </div>
    </div>

    {{-- 2. FLOATING BOX PANEL PENCARIAN TIKET SOFT-GLASSMOPHISM --}}
    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-36 sm:-mt-40 z-20">
        <div class="bg-white/80 border border-white/60 backdrop-blur-md rounded-3xl p-6 lg:p-8 shadow-xl shadow-zinc-200/50 space-y-6">
            
            {{-- Kategori Transportasi Tabs --}}
            <div class="flex space-x-2 border-b border-slate-100 pb-4 overflow-x-auto hide-scroll">
                <button type="button" onclick="switchHomeTransport('kereta', this)" class="home-tab-btn flex items-center space-x-2 px-4 py-2 rounded-xl text-xs font-bold bg-teal-500/10 text-teal-600 border border-teal-500/20 transition-all cursor-pointer focus:outline-none">
                    <i data-lucide="train" class="w-4 h-4"></i>
                    <span>Kereta Api</span>
                </button>
                <button type="button" onclick="switchHomeTransport('bus', this)" class="home-tab-btn flex items-center space-x-2 px-4 py-2 rounded-xl text-xs font-medium text-slate-500 hover:bg-slate-100 transition-all cursor-pointer focus:outline-none">
                    <i data-lucide="bus" class="w-4 h-4"></i>
                    <span>Bus & Travel</span>
                </button>
                <button type="button" onclick="switchHomeTransport('pesawat', this)" class="home-tab-btn flex items-center space-x-2 px-4 py-2 rounded-xl text-xs font-medium text-slate-500 hover:bg-slate-100 transition-all cursor-pointer focus:outline-none">
                    <i data-lucide="plane-takeoff" class="w-4 h-4"></i>
                    <span>Pesawat</span>
                </button>
            </div>

            {{-- Form Input Filter Pencarian --}}
            <form action="{{ route('ticket.search') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 lg:gap-5 items-end">
                <input type="hidden" name="jenis" id="home_selected_jenis" value="{{ $paramJenis ?? 'kereta' }}">

                <div class="md:col-span-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Input Kota Asal --}}
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Dari</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                            </span>
                            <input type="text" name="from" placeholder="Asal Keberangkatan" class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-800 font-bold focus:outline-none focus:border-teal-400 focus:bg-white transition-all" value="{{ $paramAsal ?? 'Jakarta' }}" required>
                        </div>
                    </div>
                    {{-- Input Kota Tujuan --}}
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Ke</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="crosshair" class="w-4 h-4"></i>
                            </span>
                            <input type="text" name="to" placeholder="Kota Tujuan" class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-800 font-bold focus:outline-none focus:border-teal-400 focus:bg-white transition-all" value="{{ $paramTujuan ?? 'Yogyakarta' }}" required>
                        </div>
                    </div>
                </div>

                {{-- Input Tanggal Pergi --}}
                <div class="md:col-span-3 space-y-1.5">
                    <label class="block text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Tanggal Pergi</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                        </span>
                        <input type="date" name="date" class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-800 font-bold focus:outline-none focus:border-teal-400 focus:bg-white transition-all" id="datePicker" value="{{ $paramTanggal ?? '' }}" required>
                    </div>
                </div>

                {{-- Tombol Submit Cari --}}
                <div class="md:col-span-3">
                    <button type="submit" class="w-full py-2.5 rounded-xl bg-gradient-to-r from-orange-500 to-red-500 hover:brightness-110 active:scale-95 transition-all text-sm font-extrabold text-white flex items-center justify-center space-x-2 shadow-lg shadow-orange-500/20 cursor-pointer h-[42px]">
                        <i data-lucide="search" class="w-4.5 h-4.5 stroke-[3px]"></i>
                        <span>Cari Tiket</span>
                        
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- 3. HASIL PENCARIAN JADWAL TIKET --}}
    <div id="jadwal" class="py-12 z-10 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(isset($pencarianSelesai))
                {{-- Header Status Hasil Pencarian --}}
                <div class="mb-8">
                    <span class="inline-flex items-center px-3 py-1 rounded-xl text-[10px] font-black bg-teal-500/10 text-teal-600 border border-teal-500/20 uppercase tracking-wider mb-2">Hasil Pencarian 🔍</span>
                    <p class="text-slate-500 text-sm">Menampilkan jadwal dari <span class="font-extrabold text-teal-600">{{ $paramAsal }}</span> ke <span class="font-extrabold text-teal-600">{{ $paramTujuan }}</span> pada <span class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($paramTanggal)->isoFormat('D MMMM YYYY') }}</span></p>
                </div>

                {{-- Grid Hasil Tiket --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($hasilPencarian as $jadwal)
                        <div class="bg-white/90 border border-white/60 backdrop-blur-md rounded-2xl overflow-hidden shadow-md flex flex-col justify-between hover:border-teal-500/30 group transition-all duration-300">
                            <div class="h-36 bg-slate-100 relative overflow-hidden">
                                <div class="absolute inset-0 bg-slate-950/10 z-0"></div>
                                <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-lg text-[10px] font-black text-teal-600 flex items-center shadow-sm border border-slate-100 z-10">
                                    <span class="mr-1">@if($jadwal->transportation->jenis == 'kereta')
                                        <i data-lucide="train" class="w-4 h-4"></i>
                                        @elseif($jadwal->transportation->jenis == 'bus') 
                                        <i data-lucide="bus" class="w-4 h-4"></i>
                                        @else 
                                        <i data-lucide="plane-takeoff" class="w-4 h-4"></i>
                                        @endif</span>
                                    {{ $jadwal->transportation->nama }}
                                </div>
                            </div>
                            
                            <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                                <div>
                                    <h3 class="font-extrabold text-slate-800 text-sm flex items-center truncate">
                                        {{ $jadwal->route->kota_asal }} <i data-lucide="arrow-right" class="mx-1 text-slate-400 w-3.5 h-3.5"></i> {{ $jadwal->route->kota_tujuan }}
                                    </h3>
                                    <div class="text-[11px] text-slate-400 font-medium mt-2 space-y-1 bg-slate-50 p-2.5 rounded-xl border border-slate-100 shadow-inner">
                                        <p class="flex items-center"><i data-lucide="clock" class="mr-1.5 w-3 h-3 text-slate-400"></i> Jam Berangkat: <span class="font-bold text-slate-700 ml-0.5">{{ substr($jadwal->departure_time, 0, 5) }} WIB</span></p>
                                        <p class="flex items-center"><i data-lucide="armchair" class="mr-1.5 w-3 h-3 text-slate-400"></i> Sisa Kursi: <span class="text-teal-600 font-bold ml-0.5">{{ $jadwal->remaining_seats }} / {{ $jadwal->total_seats }}</span></p>
                                    </div>
                                </div>
                                <div class="border-t border-slate-100 pt-3 flex justify-between items-center mt-2">
                                    <div>
                                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Tarif Tiket</p>
                                        <p class="text-orange-500 font-black text-sm">Rp {{ number_format($jadwal->price, 0, ',', '.') }}</p>
                                    </div>
                                    <button onclick="openDetailModal('{{ $jadwal->transportation->nama }}', '{{ $jadwal->route->kota_asal }} - {{ $jadwal->route->kota_tujuan }}', '{{ $jadwal->transportation->kelas }}', 'Rp {{ number_format($jadwal->price, 0, ',', '.') }}')" class="bg-teal-500/10 text-teal-600 border border-teal-500/20 hover:bg-teal-500 hover:text-white font-bold py-1.5 px-3 rounded-lg text-xs transition-all cursor-pointer">
                                        Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                   @empty
                        {{-- Hasil Kosong Kustom (Sudah Sinkron Tema & Variabel) --}}
                        <div class="col-span-1 sm:col-span-2 lg:col-span-4 bg-white/80 border border-slate-100 backdrop-blur-md rounded-3xl p-10 flex flex-col items-center justify-center text-center max-w-xl mx-auto space-y-4 shadow-xl shadow-zinc-100/30 my-4">
                            
                            <div class="w-16 h-16 rounded-full bg-orange-500/10 flex items-center justify-center border border-orange-500/20 text-orange-500 shadow-lg shadow-orange-500/5">
                                <i data-lucide="search-x" class="w-8 h-8 stroke-[2px]"></i>
                            </div>
                            
                            <div class="space-y-1.5">
                                <h3 class="text-lg font-black text-slate-800 tracking-wide">Tiket Tidak Ditemukan</h3>
                                <p class="text-sm text-slate-400 max-w-sm mx-auto leading-relaxed font-medium">
                                    Maaf, jadwal perjalanan atau tiket yang Anda cari saat ini tidak tersedia. Silakan coba ubah tanggal atau rute pencarian Anda.
                                </p>
                            </div>

                            <a href="{{ url('/') }}" class="mt-2 text-xs font-bold text-orange-500 hover:text-orange-600 transition-colors underline underline-offset-4 cursor-pointer">
                                Reset Pencarian
                            </a>
                        </div>
                    @endforelse
                </div>
            @else
                {{-- 4. JADWAL TERPOPULER SAAT INI (TAMPILAN DEFAULT SEBELUM CARI) --}}
                <div class="space-y-6">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight flex items-center"><span class="w-2 h-2 rounded-full bg-orange-500 mr-2 animate-pulse"></span> Rute Terpopuler Saat Ini 🔥</h2>
                        <p class="text-slate-400 text-sm mt-0.5">Rute perjalanan favorit yang paling banyak dibeli dan diminati oleh penumpang secara real-time.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($rutePopuler as $jadwal)
                            {{-- Kondisi Autentikasi Link Pembelian --}}
                            @auth
                                <a href="{{ route('passenger.seats.show', $jadwal->id) }}" class="bg-white/80 border border-white/50 backdrop-blur-md rounded-3xl overflow-hidden shadow-md flex flex-col justify-between hover:border-teal-500/30 hover:-translate-y-1.5 transition-all duration-300 group relative">
                            @else
                                <div onclick="openModal('loginModal')" class="cursor-pointer bg-white/80 border border-white/50 backdrop-blur-md rounded-3xl overflow-hidden shadow-md flex flex-col justify-between hover:border-teal-500/30 hover:-translate-y-1.5 transition-all duration-300 group relative">
                            @endauth

                                {{-- Badge Banyak Dipesan --}}
                                @if(($jadwal->total_seats - $jadwal->remaining_seats) >= 3)
                                    <div class="absolute top-[148px] right-3 bg-gradient-to-r from-orange-500 to-red-500 text-white text-[9px] font-black uppercase tracking-wider px-2 py-1 rounded-lg z-10 shadow-md">
                                        <i data-lucide="flame" class="w-3 h-3 inline mr-0.5"></i> Populer
                                    </div>
                                @endif

                                <div class="h-36 bg-slate-100 relative overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                    <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-lg text-[10px] font-black text-teal-600 flex items-center shadow-sm border border-slate-100">
                                        <span class="mr-1">
                                            @if($jadwal->transportation->jenis == 'kereta') 
                                            <i data-lucide="train" class="w-4 h-4"></i> 
                                            @elseif($jadwal->transportation->jenis == 'bus') 
                                            <i data-lucide="bus" class="w-4 h-4"></i> 
                                            @else <i data-lucide="plane-takeoff" class="w-4 h-4"></i> 
                                            @endif</span>
                                        {{ $jadwal->transportation->nama }}
                                        <span class="text-slate-400 font-semibold ml-1">({{ $jadwal->transportation->kelas }})</span>
                                    </div>
                                </div>

                                <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                                    <div>
                                        <h3 class="font-extrabold text-slate-800 text-sm flex items-center truncate">
                                            <span>{{ $jadwal->route->kota_asal }}</span> <i data-lucide="arrow-right" class="mx-1 text-slate-400 w-3.5 h-3.5"></i> <span>{{ $jadwal->route->kota_tujuan }}</span>
                                        </h3>
                                        <p class="text-[10px] text-slate-400 font-medium mt-1 truncate" title="{{ $jadwal->route->simpul_asal }} ➔ {{ $jadwal->route->simpul_tujuan }}">
                                            {{ $jadwal->route->simpul_asal }} ➔ {{ $jadwal->route->simpul_tujuan }}
                                        </p>
                                        <div class="flex items-center text-[10px] font-bold text-slate-500 space-x-3 bg-slate-50 p-2 rounded-xl mt-3 border border-slate-100">
                                            <span class="flex items-center"><i data-lucide="calendar-check" class="me-1 w-3 h-3 text-teal-500"></i> {{ \Carbon\Carbon::parse($jadwal->departure_date)->format('d M Y') }}</span>
                                            <span class="flex items-center"><i data-lucide="clock" class="me-1 w-3 h-3 text-teal-500"></i> {{ substr($jadwal->departure_time, 0, 5) }}</span>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between pt-3 border-t border-slate-100 mt-2">
                                        <span class="text-[9px] text-slate-400 font-extrabold uppercase tracking-widest">Tarif Tiket</span>
                                        <span class="text-base font-black text-orange-500">Rp {{ number_format($jadwal->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                            @auth </a> @else </div> @endauth
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- 5. SEKSYEN KARTU FASILITAS/KEUNGGULAN (GUEST PAGE LIFT UP) --}}
    <div class="py-16 bg-transparent z-10 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Mudahnya Perjalanan Bersama Travelgo</h2>
                <p class="text-sm text-slate-400 font-medium max-w-xl mx-auto mt-1">Sistem integrasi satu pintu yang dirancang khusus untuk mempermudah manajemen mobilisasi penumpang secara digital.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                <div class="p-5 border border-white/50 bg-white/60 backdrop-blur-md rounded-2xl hover:bg-white hover:shadow-xl transition duration-300 flex flex-col items-center">
                    <div class="w-12 h-12 bg-teal-500/10 text-teal-600 rounded-xl flex items-center justify-center text-xl mb-4 shadow-sm border border-teal-500/20">
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-base font-black text-slate-800 mb-2">Pencarian Multi-Armada</h3>
                    <p class="text-xs text-slate-400 font-medium leading-relaxed">Cari ketersediaan armada Kereta Api, Bus Eksekutif, hingga Pesawat Terbang dalam satu kali klik filter.</p>
                </div>
                <div class="p-5 border border-white/50 bg-white/60 backdrop-blur-md rounded-2xl hover:bg-white hover:shadow-xl transition duration-300 flex flex-col items-center">
                    <div class="w-12 h-12 bg-blue-500/10 text-blue-600 rounded-xl flex items-center justify-center text-xl mb-4 shadow-sm border border-blue-500/20">
                        <i data-lucide="wallet" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-base font-black text-slate-800 mb-2">Pembayaran Mudah dan Aman</h3>
                    <p class="text-xs text-slate-400 font-medium leading-relaxed">Proses pembayaran yang sederhana dan aman melalui berbagai metode pembayaran yang tersedia.</p>
                </div>
                <div class="p-5 border border-white/50 bg-white/60 backdrop-blur-md rounded-2xl hover:bg-white hover:shadow-xl transition duration-300 flex flex-col items-center">
                    <div class="w-12 h-12 bg-indigo-500/10 text-indigo-600 rounded-xl flex items-center justify-center text-xl mb-4 shadow-sm border border-indigo-500/20">
                        <i data-lucide="qr-code" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-base font-black text-slate-800 mb-2">E-Ticket & QR Scanner</h3>
                    <p class="text-xs text-slate-400 font-medium leading-relaxed">Tiket digital resmi beserta QR Code akan langsung terbit otomatis setelah pembayaran sukses diverifikasi.</p>
                </div>
                <div class="p-5 border border-white/50 bg-white/60 backdrop-blur-md rounded-2xl hover:bg-white hover:shadow-xl transition duration-300 flex flex-col items-center">
                    <div class="w-12 h-12 bg-rose-500/10 text-rose-600 rounded-xl flex items-center justify-center text-xl mb-4 shadow-sm border border-rose-500/20">
                        <i data-lucide="rotate-ccw" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-base font-black text-slate-800 mb-2">Batalkan kapan saja</h3>
                    <p class="text-xs text-slate-400 font-medium leading-relaxed">Pembatalan tiket kapan saja yang anda inginkan.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Atur default tanggal minimal adalah hari ini
            const today = new Date().toISOString().split('T')[0];
            const dp = document.getElementById('datePicker');
            if(dp && !dp.value) { dp.value = today; dp.min = today; }
            
            // Logika retensi tab aktif sewaktu reload/pencarian halaman selesai
            const currentJenis = document.getElementById('home_selected_jenis').value;
            const activeBtn = document.querySelector(`button[onclick*="${currentJenis}"]`);
            if(activeBtn) {
                document.querySelectorAll('.home-tab-btn').forEach(b => {
                    b.className = "home-tab-btn flex items-center space-x-2 px-4 py-2 rounded-xl text-xs font-medium text-slate-500 hover:bg-slate-100 transition-all cursor-pointer focus:outline-none";
                });
                activeBtn.className = "home-tab-btn flex items-center space-x-2 px-4 py-2 rounded-xl text-xs font-bold bg-teal-500/10 text-teal-600 border border-teal-500/20 transition-all cursor-pointer focus:outline-none";
            }

            // Menggulung halus otomatis ke bagian jadwal jika pencarian selesai dikirim
            @if(isset($pencarianSelesai))
                document.getElementById('jadwal').scrollIntoView({ behavior: 'smooth' });
            @endif
        });

        // Handler penukaran tab jenis pengangkutan
        function switchHomeTransport(jenis, element) {
            document.getElementById('home_selected_jenis').value = jenis;
            document.querySelectorAll('.home-tab-btn').forEach(btn => {
                btn.className = "home-tab-btn flex items-center space-x-2 px-4 py-2 rounded-xl text-xs font-medium text-slate-500 hover:bg-slate-100 transition-all cursor-pointer focus:outline-none";
            });
            element.className = "home-tab-btn flex items-center space-x-2 px-4 py-2 rounded-xl text-xs font-bold bg-teal-500/10 text-teal-600 border border-teal-500/20 transition-all cursor-pointer focus:outline-none";
        }
    </script>
@endsection