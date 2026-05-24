<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Travelgo</title>
    
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], },
                    colors: {
                        primary: '#1BA0E2',
                        primaryDark: '#0D7BBA',
                        secondary: '#FF5E1F',
                        secondaryDark: '#E04A0D',
                        adminSidebar: '#0F172A', /* Slate 900 */
                        adminHover: '#1E293B', /* Slate 800 */
                    }
                }
            }
        }
    </script>
    <style>
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans antialiased flex h-screen overflow-hidden">

    <aside class="bg-adminSidebar text-gray-300 w-64 flex-shrink-0 hidden md:flex flex-col h-full transition-all duration-300 relative z-20 shadow-xl">
        <div class="h-16 flex items-center px-6 bg-gray-900 border-b border-gray-800 justify-between">
            <a href="{{ route('admin.dashboard') }}">
                @include('layouts.partials.logo')
            </a>
            <span class="text-[10px] text-primary font-bold bg-blue-950/80 border border-blue-800 px-2 py-0.5 rounded">Admin</span>
        </div>

        <nav class="flex-1 overflow-y-auto py-6 space-y-1 hide-scroll">
            <div class="px-6 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Main Menu</div>
            
            <a href="#" class="flex items-center px-6 py-3 bg-adminHover text-white border-l-4 border-primary transition">
                <i class="fa-solid fa-chart-pie w-6"></i> 
                <span class="font-medium">Dashboard</span>
            </a>
            
            <div class="px-6 mt-6 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Manajemen Data</div>
            
            <a href="{{ route('admin.transportations.index') }}" class="flex items-center px-6 py-3 hover:bg-adminHover hover:text-white transition group">
                <i class="fa-solid fa-bus w-6 text-gray-400 group-hover:text-primary transition"></i> 
                <span class="font-medium">Transportasi</span>
            </a>
            
            <a href="{{ route('admin.routes.index') }}" class="flex items-center px-6 py-3 hover:bg-adminHover hover:text-white transition group">
                <i class="fa-solid fa-route w-6 text-gray-400 group-hover:text-primary transition"></i> 
                <span class="font-medium">Rute Perjalanan</span>
            </a>

            <a href="{{ route('admin.schedule.index') }}" class="flex items-center px-6 py-3 hover:bg-adminHover hover:text-white transition group">
                <i class="fa-solid fa-calendar-days w-6 text-gray-400 group-hover:text-primary transition"></i> 
                <span class="font-medium">Jadwal</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="flex items-center px-6 py-3 hover:bg-adminHover hover:text-white transition group">
                <i class="fa-solid fa-ticket w-6 text-gray-400 group-hover:text-primary transition"></i> 
                <span class="font-medium">Tiket & Pesanan</span>
            </a>

            <div class="px-6 mt-6 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Akses & Sistem</div>

            <a href="#" class="flex items-center px-6 py-3 hover:bg-adminHover hover:text-white transition group">
                <i class="fa-solid fa-users w-6 text-gray-400 group-hover:text-primary transition"></i> 
                <span class="font-medium">Manajemen User</span>
            </a>

            <a href="#" class="flex items-center px-6 py-3 hover:bg-adminHover hover:text-white transition group">
                <i class="fa-solid fa-code w-6 text-gray-400 group-hover:text-primary transition"></i> 
                <span class="font-medium">Web Service API</span>
            </a>
        </nav>

        <div class="p-4 bg-gray-900 border-t border-gray-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center text-gray-400 hover:text-red-400 transition w-full p-2 rounded hover:bg-adminHover">
                    <i class="fa-solid fa-arrow-right-from-bracket w-6"></i>
                    <span class="font-medium">Keluar Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden relative w-full">
        
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-4 sm:px-6 lg:px-8 z-10">
            <div class="flex items-center">
                <button class="md:hidden text-gray-600 hover:text-primary focus:outline-none text-xl mr-4">
                    <i class="fa-solid fa-bars"></i>
                </button>
                
                <div class="hidden sm:flex items-center bg-gray-100 rounded-lg px-3 py-2 w-64 border border-transparent focus-within:border-primary focus-within:bg-white transition">
                    <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                    <input type="text" placeholder="Cari Data/ID Pesanan..." class="bg-transparent border-none focus:outline-none text-sm ml-2 w-full text-gray-700">
                </div>
            </div>

            <div class="flex items-center space-x-4 sm:space-x-5">
                <button class="text-gray-400 hover:text-primary transition relative">
                    <i class="fa-regular fa-bell text-xl"></i>
                    <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                </button>
                
                <div class="h-8 w-px bg-gray-200"></div>

                <div class="flex items-center space-x-3 cursor-pointer hover:opacity-80 transition">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-gray-800 leading-tight">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1BA0E2&color=fff" alt="Admin Avatar" class="w-9 h-9 rounded-full shadow-sm">
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50 pb-24">
            
            <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Halo, {{ explode(' ', Auth::user()->name)[0] }}!</h1>
                    <p class="text-sm text-gray-500 mt-1">Pantau performa dan aktivitas sistem E-Ticketing hari ini.</p>
                </div>
                <div class="flex space-x-2">
                    <button class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                        <i class="fa-solid fa-download mr-1"></i> Unduh Laporan
                    </button>
                    <a href="{{ route('admin.schedule.index') }}" class="bg-primary hover:bg-primaryDark text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm flex items-center">
                        <i class="fa-solid fa-plus mr-1"></i> Buat Jadwal
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center">
                    <div class="w-12 h-12 rounded-full bg-blue-50 text-primary flex items-center justify-center text-xl mr-4 flex-shrink-0">
                        <i class="fa-solid fa-ticket"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium mb-1">Total Tiket Terjual</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $totalTiketTerjual }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center">
                    <div class="w-12 h-12 rounded-full bg-orange-50 text-secondary flex items-center justify-center text-xl mr-4 flex-shrink-0">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium mb-1">Pendapatan Bulan Ini</p>
                        <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center">
                    <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl mr-4 flex-shrink-0">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium mb-1">Total Penumpang Aktif</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $totalPenumpang }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center">
                    <div class="w-12 h-12 rounded-full bg-purple-50 text-purple-500 flex items-center justify-center text-xl mr-4 flex-shrink-0">
                        <i class="fa-solid fa-route"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium mb-1">Rute Aktif & Berjalan</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $totalRute }}</h3>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                        <h2 class="text-lg font-bold text-gray-800">Pesanan Tiket Terbaru</h2>
                        <a href="{{ route('admin.orders.index') }}" class="text-sm text-primary font-medium hover:underline">Kelola Tiket</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                                    <th class="py-3 px-6 font-medium">ID Pesanan</th>
                                    <th class="py-3 px-6 font-medium">Penumpang</th>
                                    <th class="py-3 px-6 font-medium">Rute & Transportasi</th>
                                    <th class="py-3 px-6 font-medium">Status</th>
                                    <th class="py-3 px-6 font-medium text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-100">
                                @foreach($pesananTerbaru as $pesanan)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-4 px-6 font-medium text-gray-900">{{ $pesanan->order_code }}</td>
                                    <td class="py-4 px-6 text-gray-600">{{ $pesanan->user->name }}</td>
                                    <td class="py-4 px-6">
                                        <p class="font-medium text-gray-800">
                                            {{ $pesanan->schedule->route->kota_asal }} - {{ $pesanan->schedule->route->kota_tujuan }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            <i class="fa-solid @if($pesanan->schedule->transportation->jenis == 'kereta') fa-train @elseif($pesanan->schedule->transportation->jenis == 'bus') fa-bus @else fa-plane @endif text-primary"></i> 
                                            {{ $pesanan->schedule->transportation->nama }}
                                        </p>
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($pesanan->status == 'lunas')
                                            <span class="bg-green-100 text-green-700 text-xs font-bold px-2.5 py-1 rounded-full">Lunas</span>
                                        @elseif($pesanan->status == 'pending')
                                            <span class="bg-orange-100 text-orange-700 text-xs font-bold px-2.5 py-1 rounded-full">Pending</span>
                                        @else
                                            <span class="bg-red-100 text-red-700 text-xs font-bold px-2.5 py-1 rounded-full">Dibatalkan</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <a href="{{ route('admin.orders.index') }}" class="text-gray-400 hover:text-primary transition mx-1" title="Detail"><i class="fa-regular fa-eye"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-sm font-bold text-gray-800"><i class="fa-solid fa-business-time text-primary mr-1.5"></i> Monitoring Jadwal Perjalanan</h2>
                    </div>
                    
                    <div class="flex border-b border-gray-100 text-center text-xs font-bold text-gray-400 bg-white">
                        <button onclick="switchDashboardTab('hari-ini', this)" class="tab-dash-btn flex-1 py-3 border-b-2 border-primary text-primary transition focus:outline-none">
                            Hari Ini ({{ $jadwalHariIni->count() }})
                        </button>
                        <button onclick="switchDashboardTab('mendatang', this)" class="tab-dash-btn flex-1 py-3 hover:text-gray-600 transition focus:outline-none">
                            Mendatang
                        </button>
                        <button onclick="switchDashboardTab('terlewat', this)" class="tab-dash-btn flex-1 py-3 hover:text-gray-600 transition focus:outline-none">
                            Sudah Lewat
                        </button>
                    </div>
                    
                    <div class="p-5 space-y-5 flex-1 overflow-y-auto max-h-[380px] hide-scroll">
                        
                        <div id="dash-list-hari-ini" class="dash-schedule-list space-y-4">
                            @forelse($jadwalHariIni as $jadwal)
                                <div class="flex items-start">
                                    <div class="flex flex-col items-center mr-3 flex-shrink-0">
                                        <span class="text-[10px] font-extrabold text-gray-600 bg-gray-100 px-1.5 py-0.5 rounded">{{ substr($jadwal->departure_time, 0, 5) }}</span>
                                        <div class="w-px h-8 bg-gray-200 my-1 @if($loop->last) bg-transparent @endif"></div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center mb-0.5">
                                            <span class="w-2 h-2 rounded-full @if($jadwal->transportation->jenis == 'kereta') bg-primary @elseif($jadwal->transportation->jenis == 'bus') bg-secondary @else bg-emerald-500 @endif mr-1.5 flex-shrink-0"></span>
                                            <h4 class="font-bold text-xs text-gray-800 truncate">{{ $jadwal->transportation->nama }}</h4>
                                        </div>
                                        <p class="text-[11px] text-gray-500 truncate">{{ $jadwal->route->kota_asal }} - {{ $jadwal->route->kota_tujuan }}</p>
                                        <p class="text-[10px] text-primary font-semibold mt-0.5">Sisa {{ $jadwal->remaining_seats }} / {{ $jadwal->total_seats }} Kursi</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 text-center py-8">Tidak ada jadwal keberangkatan untuk hari ini.</p>
                            @endforelse
                        </div>

                        <div id="dash-list-mendatang" class="dash-schedule-list space-y-4 hidden">
                            @forelse($jadwalMendatang as $jadwal)
                                <div class="flex items-start">
                                    <div class="flex flex-col items-center mr-3 flex-shrink-0">
                                        <span class="text-[10px] font-extrabold text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded">{{ substr($jadwal->departure_time, 0, 5) }}</span>
                                        <div class="w-px h-8 bg-gray-200 my-1 @if($loop->last) bg-transparent @endif"></div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center mb-0.5">
                                            <span class="w-2 h-2 rounded-full @if($jadwal->transportation->jenis == 'kereta') bg-primary @elseif($jadwal->transportation->jenis == 'bus') bg-secondary @else bg-emerald-500 @endif mr-1.5 flex-shrink-0"></span>
                                            <h4 class="font-bold text-xs text-gray-800 truncate">{{ $jadwal->transportation->nama }}</h4>
                                        </div>
                                        <p class="text-[11px] text-gray-500 truncate">{{ $jadwal->route->kota_asal }} - {{ $jadwal->route->kota_tujuan }}</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5"><i class="fa-regular fa-calendar text-[9px] mr-0.5"></i> {{ \Carbon\Carbon::parse($jadwal->departure_date)->format('d M Y') }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 text-center py-8">Belum ada agenda jadwal mendatang.</p>
                            @endforelse
                        </div>

                        <div id="dash-list-terlewat" class="dash-schedule-list space-y-4 hidden">
                            @forelse($jadwalTerlewat as $jadwal)
                                <div class="flex items-start opacity-60">
                                    <div class="flex flex-col items-center mr-3 flex-shrink-0">
                                        <span class="text-[10px] font-bold text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded">{{ substr($jadwal->departure_time, 0, 5) }}</span>
                                        <div class="w-px h-8 bg-gray-200 my-1 @if($loop->last) bg-transparent @endif"></div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center mb-0.5">
                                            <span class="w-2 h-2 rounded-full bg-gray-300 mr-1.5 flex-shrink-0"></span>
                                            <h4 class="font-bold text-xs text-gray-400 truncate line-through">{{ $jadwal->transportation->nama }}</h4>
                                        </div>
                                        <p class="text-[11px] text-gray-400 truncate">{{ $jadwal->route->kota_asal }} - {{ $jadwal->route->kota_tujuan }}</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($jadwal->departure_date)->format('d M Y') }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 text-center py-8">Tidak ada riwayat perjalanan yang terlewat.</p>
                            @endforelse
                        </div>

                    </div>
                    
                    <div class="p-3 border-t border-gray-100 text-center bg-gray-50 rounded-b-xl flex-shrink-0">
                        <a href="{{ route('admin.schedule.index') }}" class="text-xs font-semibold text-primary hover:underline">Kelola Semua Jadwal</a>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script>
        function switchDashboardTab(targetList, element) {
            // 1. Sembunyikan ketiga kontainer list data terlebih dahulu
            document.querySelectorAll('.dash-schedule-list').forEach(list => {
                list.classList.add('hidden');
            });
            
            // 2. Munculkan secara instan list target yang dipilih admin
            document.getElementById(`dash-list-${targetList}`).classList.remove('hidden');

            // 3. Reset gaya warna semua tombol tab menjadi abu-abu pudar
            document.querySelectorAll('.tab-dash-btn').forEach(btn => {
                btn.classList.remove('border-b-2', 'border-primary', 'text-primary');
                btn.classList.add('text-gray-400', 'hover:text-gray-600');
            });
            
            // 4. Nyalakan warna biru aktif khusus pada tombol tab yang diklik oleh admin
            element.classList.remove('text-gray-400', 'hover:text-gray-600');
            element.classList.add('border-b-2', 'border-primary', 'text-primary');
        }
    </script>
</body>
</html>