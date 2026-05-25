<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Penumpang') - Travelgo</title>
    
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Hack kecil untuk menyembunyikan scrollbar bawaan */
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-800 font-sans antialiased flex h-screen overflow-hidden relative">

    <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-emerald-300/15 blur-[120px] pointer-events-none z-0"></div>
    <div class="absolute bottom-[-10%] right-[-5%] w-[600px] h-[600px] rounded-full bg-teal-400/10 blur-[150px] pointer-events-none z-0"></div>
    <div class="absolute top-[20%] right-[30%] w-[400px] h-[400px] rounded-full bg-indigo-300/10 blur-[130px] pointer-events-none z-0"></div>

    <aside class="w-72 bg-white/60 backdrop-blur-xl border-r border-white/40 h-screen flex flex-col justify-between p-6 z-10 relative shadow-xl shadow-zinc-200/50">
        <div class="flex-1 flex flex-col min-h-0 overflow-y-auto hide-scroll">
            
            <div class="h-20 flex items-center px-2 flex-shrink-0">
                <a href="{{ route('passenger.dashboard') }}" class="block hover:opacity-90 transition-opacity">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-teal-400 to-indigo-500 flex items-center justify-center shadow-lg shadow-teal-300/40">
                            <i data-lucide="tickets" class="w-6 h-6 text-white"></i>
                        </div>
                        <div>
                            <div class="flex items-center space-x-1">
                                <span class="text-xl font-extrabold text-slate-900 tracking-wider">TRAVELGO</span>
                                <span class="text-teal-500 text-lg font-black">✦</span>
                            </div>
                            <p class="text-[9px] text-slate-400 font-bold tracking-widest uppercase">Penumpang</p>
                        </div>
                    </div>
                </a>
            </div>

            <nav class="flex-1 py-6 space-y-6">
                <div>
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider block mb-3 px-3">Menu Utama</span>
                    <div class="space-y-1">
                        <a href="{{ route('passenger.dashboard') }}" 
                           class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm transition-all {{ request()->routeIs('passenger.dashboard') ? 'bg-white/90 text-teal-600 shadow-sm border border-slate-100 font-bold' : 'text-slate-500 hover:bg-white/40 hover:text-slate-800 font-medium' }}">
                            <i data-lucide="home" class="w-4.5 h-4.5"></i>
                            <span>Beranda & Cari</span>
                        </a>
                        
                        <a href="{{ route('passenger.tickets') }}" 
                           class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm transition-all {{ request()->routeIs('passenger.tickets') || request()->routeIs('passenger.ticket.show') ? 'bg-white/90 text-teal-600 shadow-sm border border-slate-100 font-bold' : 'text-slate-500 hover:bg-white/40 hover:text-slate-800 font-medium' }}">
                            <i data-lucide="ticket" class="w-4.5 h-4.5"></i>
                            <span>Tiket Saya</span>
                        </a>
                        
                        <a href="{{ route('passenger.history') }}" 
                           class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm transition-all {{ request()->routeIs('passenger.history') ? 'bg-white/90 text-teal-600 shadow-sm border border-slate-100 font-bold' : 'text-slate-500 hover:bg-white/40 hover:text-slate-800 font-medium' }}">
                            <i data-lucide="history" class="w-4.5 h-4.5"></i>
                            <span>Riwayat Pemesanan</span>
                        </a>
                    </div>
                </div>

                <div>
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider block mb-3 px-3">Pengaturan</span>
                    <div class="space-y-1">
                        <a href="{{ route('passenger.profile') }}" 
                           class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm transition-all {{ request()->routeIs('passenger.profile') ? 'bg-white/90 text-teal-600 shadow-sm border border-slate-100 font-bold' : 'text-slate-500 hover:bg-white/40 hover:text-slate-800 font-medium' }}">
                            <i data-lucide="user-cog" class="w-4.5 h-4.5"></i>
                            <span>Kelola Profil</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <div class="pt-6 border-t border-slate-200/60 flex-shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-bold text-rose-500 hover:bg-rose-50 transition-all cursor-pointer">
                    <i data-lucide="log-out" class="w-4.5 h-4.5"></i>
                    <span>Log Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
        
        <header class="h-20 bg-white/45 backdrop-blur-md border-b border-slate-200/40 flex items-center justify-between px-4 sm:px-8 z-10 flex-shrink-0">
            <button class="md:hidden text-slate-600 hover:text-teal-600 text-2xl mr-4"><i data-lucide="menu" class="w-6 h-6"></i></button>
            <div class="hidden sm:block text-slate-800 font-bold text-lg tracking-tight">Dashboard Penumpang</div>
            
            <div class="flex items-center space-x-4 ml-auto">
                <button class="w-10 h-10 rounded-xl bg-white border border-slate-200/60 flex items-center justify-center text-slate-500 shadow-sm hover:scale-105 transition-transform relative cursor-pointer">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full"></span>
                </button>
                <div class="flex items-center space-x-3 border-l pl-4 border-slate-200">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1BA0E2&color=fff" alt="Avatar" class="w-10 h-10 rounded-xl shadow-md shadow-slate-200">
                    <div class="hidden sm:block text-right">
                        <p class="text-sm font-bold text-slate-800 leading-tight">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-400 font-semibold mt-0.5">Passenger</p>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-4 sm:p-8 lg:p-10 hide-scroll pb-24 bg-transparent">
            @yield('content')
        </main>
    </div>

    <div id="toast" class="fixed bottom-6 right-6 z-50 hidden">
        <div class="bg-white/90 border border-teal-500/30 backdrop-blur-md px-5 py-3.5 rounded-2xl shadow-xl flex items-center space-x-3 shadow-zinc-300/50 border-l-4 border-l-teal-500">
            <i data-lucide="check-circle" class="w-5 h-5 text-teal-500"></i>
            <p class="text-xs font-bold text-slate-800" id="toast-message">Notifikasi Berhasil</p>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            
            if (toast && toastMessage) {
                toastMessage.innerText = message;
                toast.classList.remove('hidden');
                
                setTimeout(() => { 
                    toast.classList.add('hidden'); 
                }, 3000);
            }
        }

        // Jalankan pemicu otomatis
        document.addEventListener('DOMContentLoaded', function() {
            @if(request()->routeIs('passenger.dashboard'))
                showToast('Selamat datang kembali di Travelgo!');
            @elseif(request()->routeIs('passenger.tickets'))
                showToast('Berhasil memuat Tiket Aktif Anda');
            @elseif(request()->routeIs('passenger.ticket.show'))
                showToast('Berhasil memuat Detail E-Ticket Boarding Pass');
            @elseif(request()->routeIs('passenger.history'))
                showToast('Berhasil memuat seluruh Riwayat Pemesanan');
            @elseif(request()->routeIs('passenger.profile'))
                showToast('Berhasil memuat Halaman Pengaturan Akun');
            @elseif(request()->routeIs('passenger.search'))
                showToast('Berhasil menemukan Jadwal Keberangkatan');
            @else
                // Fallback jika nama route tidak pas di atas, dia akan tetap muncul memberi tahu nama route saat ini
                showToast('Berhasil memuat halaman');
            @endif
        });
    </script>
    @stack('scripts')
</body>
</html>