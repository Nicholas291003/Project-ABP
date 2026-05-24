@extends('layouts.guest')

@section('title', 'Pesan Tiket Transportasi Online Terbaik')

@section('content')
    <div class="relative bg-gradient-to-r from-blue-800 to-primary pt-24 pb-48 sm:pt-32 sm:pb-56 overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Background" class="w-full h-full object-cover">
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white z-10">
            <h1 class="text-3xl sm:text-5xl font-bold mb-4 sm:mb-6 drop-shadow-md">
                Jelajahi Dunia, Mulai dari Sini
            </h1>
            <p class="text-lg sm:text-xl font-light opacity-90 mb-8 max-w-2xl mx-auto drop-shadow-md">
                Platform pemesanan tiket transportasi. Mudah, cepat, dan terpercaya untuk setiap perjalanan Anda.
            </p>
        </div>
    </div>

    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-32 sm:-mt-40 z-20">
        <div class="bg-white rounded-2xl shadow-xl p-4 sm:p-6 lg:p-8">
            <div class="flex space-x-2 sm:space-x-4 border-b pb-4 mb-6 overflow-x-auto hide-scroll">
                <button type="button" onclick="switchHomeTransport('kereta', this)" class="home-tab-btn flex items-center space-x-2 pb-2 border-b-2 border-primary text-primary font-semibold whitespace-nowrap px-2 focus:outline-none">
                    <i class="fa-solid fa-train"></i> <span>Kereta Api</span>
                </button>
                <button type="button" onclick="switchHomeTransport('bus', this)" class="home-tab-btn flex items-center space-x-2 pb-2 text-gray-500 hover:text-primary whitespace-nowrap px-2 transition focus:outline-none">
                    <i class="fa-solid fa-bus"></i> <span>Bus & Travel</span>
                </button>
                <button type="button" onclick="switchHomeTransport('pesawat', this)" class="home-tab-btn flex items-center space-x-2 pb-2 text-gray-500 hover:text-primary whitespace-nowrap px-2 transition focus:outline-none">
                    <i class="fa-solid fa-plane"></i> <span>Pesawat</span>
                </button>
            </div>

            <form action="{{ route('ticket.search') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 lg:gap-6 items-end">
                <input type="hidden" name="jenis" id="home_selected_jenis" value="{{ $paramJenis ?? 'kereta' }}">

                <div class="md:col-span-5 relative grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="relative">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Dari</label>
                        <div class="relative">
                            <i class="fa-solid fa-location-dot absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="from" placeholder="Asal Keberangkatan" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition text-sm font-medium" value="{{ $paramAsal ?? 'Jakarta' }}" required>
                        </div>
                    </div>
                    <div class="relative">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Ke</label>
                        <div class="relative">
                            <i class="fa-solid fa-location-crosshairs absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="to" placeholder="Kota Tujuan" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition text-sm font-medium" value="{{ $paramTujuan ?? 'Yogyakarta' }}" required>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-3">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Pergi</label>
                    <div class="relative">
                        <input type="date" name="date" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition text-sm font-medium" id="datePicker" value="{{ $paramTanggal ?? '' }}" required>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <button type="submit" class="w-full bg-secondary hover:bg-secondaryDark text-white font-bold py-3 sm:py-4 rounded-xl shadow-lg transform transition hover:-translate-y-1 flex items-center justify-center h-full sm:h-[50px] mt-[22px]">
                        <i class="fa-solid fa-magnifying-glass mr-2"></i> Cari Tiket
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="jadwal" class="bg-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(isset($pencarianSelesai))
                <div class="mb-8">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Hasil Pencarian Tiket 🔍</h2>
                    <p class="text-gray-600">Menampilkan jadwal dari <span class="font-semibold text-primary">{{ $paramAsal }}</span> ke <span class="font-semibold text-primary">{{ $paramTujuan }}</span> pada {{ \Carbon\Carbon::parse($paramTanggal)->isoFormat('D MMMM YYYY') }}</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($hasilPencarian as $jadwal)
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 group flex flex-col justify-between">
                            <div class="h-40 bg-gray-300 relative overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded text-xs font-bold text-primary flex items-center">
                                    <i class="fa-solid @if($jadwal->transportation->jenis == 'kereta') fa-train @elseif($jadwal->transportation->jenis == 'bus') fa-bus @else fa-plane @endif mr-1.5 text-[10px]"></i> 
                                    {{ $jadwal->transportation->nama }}
                                </div>
                            </div>
                            <div class="p-5 flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="font-bold text-base text-gray-800 flex items-center truncate">
                                        {{ $jadwal->route->kota_asal }} <i class="fa-solid fa-arrow-right mx-1.5 text-gray-400 text-xs"></i> {{ $jadwal->route->kota_tujuan }}
                                    </h3>
                                    <div class="text-xs text-gray-500 mt-2 mb-4 space-y-1">
                                        <p><i class="fa-regular fa-clock mr-1"></i> Jam Berangkat: <span class="font-bold text-gray-700">{{ substr($jadwal->departure_time, 0, 5) }} WIB</span></p>
                                        <p><i class="fa-solid fa-chair mr-1"></i> Sisa Kursi: <span class="text-primary font-bold">{{ $jadwal->remaining_seats }} / {{ $jadwal->total_seats }}</span></p>
                                    </div>
                                </div>
                                <div class="border-t border-gray-100 pt-3 flex justify-between items-center mt-2">
                                    <div>
                                        <p class="text-[10px] text-gray-400">Tarif Tiket</p>
                                        <p class="text-secondary font-black text-base">Rp {{ number_format($jadwal->price, 0, ',', '.') }}</p>
                                    </div>
                                    <button onclick="openDetailModal('{{ $jadwal->transportation->nama }}', '{{ $jadwal->route->kota_asal }} - {{ $jadwal->route->kota_tujuan }}', '{{ $jadwal->transportation->kelas }}', 'Rp {{ number_format($jadwal->price, 0, ',', '.') }}')" class="bg-blue-50 text-primary hover:bg-primary hover:text-white font-bold py-2 px-3 rounded-lg text-xs transition">
                                        Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 sm:col-span-2 lg:col-span-4 bg-white rounded-2xl p-12 text-center shadow-sm border border-gray-100">
                            <i class="fa-solid fa-calendar-xmark text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-600 font-medium">Maaf, tiket tidak ditemukan atau sudah habis.</p>
                        </div>
                    @endforelse
                </div>
            @else
                <div class="flex justify-between items-end mb-8">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Jadwal Terpopuler Saat Ini 🔥</h2>
                        <p class="text-gray-600">Rute perjalanan masa depan yang paling banyak dibeli dan diminati oleh penumpang lain secara real-time.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($rutePopuler as $jadwal)
                    {{-- 
                        Logika:
                        Jika sudah Login (@auth), ke halaman pilih kursi.
                        Jika belum (@else), kartu adalah div yang jika diklik memicu modal login.
                    --}}
                    @auth
                        <a href="{{ route('passenger.seats.show', $jadwal->id) }}" class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition duration-300 group relative flex flex-col justify-between border border-transparent hover:border-primary/20">
                    @else
                        <div onclick="openModal('loginModal')" class="cursor-pointer bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition duration-300 group relative flex flex-col justify-between border border-transparent hover:border-primary/20">
                    @endauth

                        @if(($jadwal->total_seats - $jadwal->remaining_seats) >= 3)
                            <div class="absolute bottom-[170px] right-3 bg-orange-600 text-white text-[9px] font-black uppercase tracking-wider px-2.5 py-1.5 rounded-lg z-10 shadow-lg animate-bounce">
                                <i class="fa-solid fa-fire mr-0.5"></i> Banyak Dipesan
                            </div>
                        @endif

                        <div class="h-44 bg-gray-300 relative overflow-hidden">
                            <img src="{{ asset('gambar1.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            <div class="absolute top-3 left-3 bg-white/95 backdrop-blur-sm px-2.5 py-1.5 rounded-lg text-[10px] font-bold text-primary flex items-center gap-1.5 shadow-sm border border-blue-50">
                                <i class="fa-solid @if($jadwal->transportation->jenis == 'kereta') fa-train @elseif($jadwal->transportation->jenis == 'bus') fa-bus @else fa-plane @endif"></i>
                                {{ $jadwal->transportation->nama }} 
                                <span class="text-gray-400 font-normal">({{ $jadwal->transportation->kelas }})</span>
                            </div>
                        </div>

                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-base text-gray-800 flex flex-wrap items-center gap-1">
                                    <span>{{ $jadwal->route->kota_asal }}</span>
                                    <i class="fa-solid fa-arrow-right mx-1 text-gray-400 text-xs"></i>
                                    <span>{{ $jadwal->route->kota_tujuan }}</span>
                                </h3>
                                <p class="text-[10px] text-gray-400 mt-1 mb-3 leading-relaxed">
                                    {{ $jadwal->route->simpul_asal }} ➔ {{ $jadwal->route->simpul_tujuan }}
                                </p>
                                <div class="flex items-center text-[11px] text-gray-500 space-x-3 bg-gray-50 p-2 rounded-lg">
                                    <span><i class="fa-regular fa-calendar-check me-1 text-primary"></i> {{ \Carbon\Carbon::parse($jadwal->departure_date)->format('d M Y') }}</span>
                                    <span><i class="fa-regular fa-clock me-1 text-primary"></i> {{ substr($jadwal->departure_time, 0, 5) }}</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-4 border-t border-gray-100 mt-4">
                                <span class="text-[10px] text-gray-400 font-medium uppercase tracking-widest">Tarif Tiket</span>
                                <span class="text-base font-black text-secondary">Rp {{ number_format($jadwal->price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                    @auth </a> @else </div> @endauth
                    @endforeach
                </div>

            @endif

        </div>
    </div>

    <div class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-2xl sm:text-4xl font-extrabold text-gray-800 mb-2">Mudahnya Perjalanan Bersama TiketKuy</h2>
                <p class="text-sm text-gray-500 max-w-xl mx-auto">Sistem integrasi satu pintu yang dirancang khusus untuk mempermudah manajemen mobilisasi penumpang secara digital.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                <div class="p-5 border border-gray-100 bg-gray-50/50 rounded-2xl hover:bg-white hover:shadow-xl transition duration-300">
                    <div class="w-14 h-14 mx-auto bg-blue-100 text-primary rounded-full flex items-center justify-center text-xl mb-4 shadow-sm">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Pencarian Multi-Armada</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">Cari ketersediaan armada Kereta Api, Bus Eksekutif, hingga Pesawat Terbang dalam satu kali klik pencarian filter.</p>
                </div>
                <div class="p-5 border border-gray-100 bg-gray-50/50 rounded-2xl hover:bg-white hover:shadow-xl transition duration-300">
                    <div class="w-14 h-14 mx-auto bg-orange-100 text-secondary rounded-full flex items-center justify-center text-xl mb-4 shadow-sm">
                        <i class="fa-solid fa-chair"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Pilih Kursi Interaktif</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">Penumpang bebas memilih nomor kursi favorit secara mandiri lewat denah tata letak boks gerbong secara realtime.</p>
                </div>
                <div class="p-5 border border-gray-100 bg-gray-50/50 rounded-2xl hover:bg-white hover:shadow-xl transition duration-300">
                    <div class="w-14 h-14 mx-auto bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xl mb-4 shadow-sm">
                        <i class="fa-solid fa-qrcode"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">E-Ticket & QR Scanner</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">Tiket digital yang sah beserta QR Code akan langsung terbit otomatis pasca simulasi pembayaran sukses diverifikasi.</p>
                </div>
                <div class="p-5 border border-gray-100 bg-gray-50/50 rounded-2xl hover:bg-white hover:shadow-xl transition duration-300">
                    <div class="w-14 h-14 mx-auto bg-red-100 text-red-500 rounded-full flex items-center justify-center text-xl mb-4 shadow-sm">
                        <i class="fa-solid fa-rotate-left"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Cancel & Refund Mandiri</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">Penumpang dapat membatalkan tiket langsung dari aplikasi. Sistem otomatis mengembalikan sisa kuota kursi ke jadwal asal.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const today = new Date().toISOString().split('T')[0];
            const dp = document.getElementById('datePicker');
            if(dp && !dp.value) { dp.value = today; dp.min = today; }
            
            const currentJenis = document.getElementById('home_selected_jenis').value;
            const activeBtn = document.querySelector(`button[onclick*="${currentJenis}"]`);
            if(activeBtn) {
                document.querySelectorAll('.home-tab-btn').forEach(b => {
                    b.classList.remove('border-b-2', 'border-primary', 'text-primary', 'font-semibold');
                    b.classList.add('text-gray-500');
                });
                activeBtn.classList.remove('text-gray-500');
                activeBtn.classList.add('border-b-2', 'border-primary', 'text-primary', 'font-semibold');
            }

            @if(isset($pencarianSelesai))
                document.getElementById('jadwal').scrollIntoView({ behavior: 'smooth' });
            @endif
        });

        function switchHomeTransport(jenis, element) {
            document.getElementById('home_selected_jenis').value = jenis;
            document.querySelectorAll('.home-tab-btn').forEach(btn => {
                btn.classList.remove('border-b-2', 'border-primary', 'text-primary', 'font-semibold');
                btn.classList.add('text-gray-500');
            });
            element.classList.remove('text-gray-500');
            element.classList.add('border-b-2', 'border-primary', 'text-primary', 'font-semibold');
        }
    </script>
@endsection