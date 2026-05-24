<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Travelgo Admin Dashboard')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @theme {
            --color-primary: #1BA0E2;
            --color-primaryDark: #0D7BBA;
            --color-secondary: #FF5E1F;
            --color-secondaryDark: #E04A0D;
        }

        /* Hack kecil untuk menyembunyikan scrollbar bawaan */
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-900 text-slate-800 relative overflow-hidden flex">

    <div class="absolute top-[-20%] left-[-10%] w-[600px] h-[600px] rounded-full bg-teal-500/20 blur-[150px] pointer-events-none z-0"></div>
    <div class="absolute bottom-[-10%] right-[-5%] w-[500px] h-[500px] rounded-full bg-violet-600/20 blur-[150px] pointer-events-none z-0"></div>
    <div class="absolute top-[30%] right-[20%] w-[400px] h-[400px] rounded-full bg-amber-400/10 blur-[120px] pointer-events-none z-0"></div>

    <aside class="w-72 bg-slate-950/60 backdrop-blur-xl border-r border-slate-800/40 min-h-screen flex flex-col justify-between p-6 z-10 relative">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="block hover:opacity-90 transition-opacity">
                <div class="flex items-center space-x-3 mb-8 px-2">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-teal-400 to-cyan-500 flex items-center justify-center shadow-lg shadow-teal-500/30">
                        <i data-lucide="compass" class="w-6 h-6 text-slate-950"></i>
                    </div>
                    <div>
                        <div class="flex items-center space-x-1">
                            <span class="text-xl font-black text-white tracking-wider">TRAVELG</span>
                            <span class="text-teal-400 text-lg font-black">✦</span>
                        </div>
                        <p class="text-[10px] text-slate-400 font-semibold tracking-widest uppercase">E-Ticketing System</p>
                    </div>
                </div>
            </a>

            <div class="mb-8 p-3 bg-slate-900/40 rounded-xl border border-slate-800/50 flex items-center space-x-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1BA0E2&color=fff" alt="Admin Avatar" class="w-10 h-10 rounded-full shadow-sm">
                <div class="min-w-0 flex-1">
                    <p class="text-[10px] text-slate-400 font-medium">Masuk Sebagai</p>
                    <h4 class="text-sm font-bold text-slate-100 truncate">{{ explode(' ', Auth::user()->name)[0] }}</h4>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-semibold bg-teal-500/10 text-teal-300 mt-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-400 mr-1 animate-pulse"></span>
                        Administrator
                    </span>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-widest block mb-3 px-3">Main Menu</span>
                    <nav class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-bold bg-gradient-to-r from-teal-500/15 to-teal-500/5 text-teal-400 border-l-4 border-teal-400 transition-all">
                            <i data-lucide="layout-dashboard" class="w-4.5 h-4.5"></i>
                            <span>Dashboard</span>
                        </a>
                    </nav>
                </div>

                <div>
                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-widest block mb-3 px-3">Manajemen Data</span>
                    <nav class="space-y-1">
                        <a href="{{ route('admin.transportations.index') }}" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-400 hover:bg-slate-800/30 hover:text-slate-200 transition-all">
                            <i data-lucide="bus" class="w-4.5 h-4.5"></i>
                            <span>Transportasi</span>
                        </a>
                        <a href="{{ route('admin.routes.index') }}" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-400 hover:bg-slate-800/30 hover:text-slate-200 transition-all">
                            <i data-lucide="map-pin" class="w-4.5 h-4.5"></i>
                            <span>Rute Perjalanan</span>
                        </a>
                        <a href="{{ route('admin.schedule.index') }}" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-400 hover:bg-slate-800/30 hover:text-slate-200 transition-all">
                            <i data-lucide="calendar" class="w-4.5 h-4.5"></i>
                            <span>Jadwal</span>
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium text-slate-400 hover:bg-slate-800/30 hover:text-slate-200 transition-all">
                            <div class="flex items-center space-x-3">
                                <i data-lucide="ticket" class="w-4.5 h-4.5"></i>
                                <span>Tiket & Pesanan</span>
                            </div>
                            <span class="bg-amber-500/10 text-amber-400 text-[10px] px-2 py-0.5 rounded-full font-bold">Baru</span>
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <div class="pt-6 border-t border-slate-800/60">
            <button onclick="toggleModal('modal-logout', true)" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold text-rose-400 hover:bg-rose-500/10 transition-all cursor-pointer">
                <i data-lucide="log-out" class="w-4.5 h-4.5"></i>
                <span>Keluar Sistem</span>
            </button>
        </div>
    </aside>

    <main class="flex-1 flex flex-col min-h-screen z-10 relative overflow-y-auto">
        
        <header class="h-20 border-b border-slate-800/40 bg-slate-950/40 backdrop-blur-md px-8 flex items-center justify-between">
            <div class="relative w-96">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <i data-lucide="search" class="h-4 w-4 text-slate-500"></i>
                </div>
                <input type="text" id="tableSearch" onkeyup="if(typeof filterTable === 'function') filterTable()" placeholder="Cari ID Pesanan atau Penumpang..." class="w-full pl-10 pr-4 py-2 bg-slate-900/60 border border-slate-800 rounded-xl text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-teal-400 transition-all">
            </div>

            <div class="flex items-center space-x-6">
                <div class="relative cursor-pointer" onclick="showToast('Belum ada notifikasi baru')">
                    <div class="w-10 h-10 rounded-xl bg-slate-900/60 border border-slate-800/80 flex items-center justify-center text-slate-400">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                    </div>
                    <span class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full bg-rose-500 text-[10px] font-black text-white flex items-center justify-center border-2 border-slate-950">3</span>
                </div>
                <div class="flex items-center space-x-3 border-l border-slate-800 pl-6">
                    <div class="text-right">
                        <h3 class="text-sm font-bold text-slate-100">{{ Auth::user()->name }}</h3>
                        <p class="text-xs text-slate-400 font-medium">Administrator</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1BA0E2&color=fff" alt="Admin Avatar" class="w-10 h-10 rounded-xl shadow-sm">
                </div>
            </div>
        </header>

        @yield('content')

        <footer class="h-20 border-t border-slate-800/40 bg-slate-950/40 backdrop-blur-md px-8 flex items-center justify-between text-xs md:text-sm text-slate-400 mt-auto">
            <p>© 2026 <span class="text-slate-200 font-semibold">Travelgo</span> E-Ticketing System.</p>
            <p class="text-right">
                Dikembangkan oleh 
                <span class="text-slate-300 font-medium hover:text-indigo-400 transition-colors duration-200">
                    Mahasiswa Teknik Informatika Telkom University Surabaya
                </span>
            </p>
        </footer>
    </main>

    <div id="modal-logout" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-sm p-6 shadow-2xl text-center">
            <div class="w-12 h-12 rounded-full bg-rose-500/10 mx-auto flex items-center justify-center text-rose-500 mb-3">
                <i data-lucide="log-out" class="w-6 h-6"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-100">Keluar dari Sistem?</h3>
            <p class="text-xs text-slate-400 mb-6">Anda harus login kembali untuk masuk ke aplikasi.</p>
            <div class="flex space-x-3">
                <button onclick="toggleModal('modal-logout', false)" class="flex-1 py-2.5 rounded-xl border border-slate-700 text-slate-300 text-sm font-semibold hover:bg-slate-800 cursor-pointer">Batal</button>
                
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full py-2.5 rounded-xl bg-rose-500 text-white text-sm font-bold hover:bg-rose-600 cursor-pointer">Keluar</button>
                </form>
            </div>
        </div>
    </div>

    <div id="toast" class="fixed bottom-6 right-6 z-50 hidden">
        <div class="bg-slate-900/90 border border-teal-500/30 text-teal-200 backdrop-blur-md px-5 py-3.5 rounded-2xl shadow-xl flex items-center space-x-3">
            <i data-lucide="check-circle" class="w-5 h-5 text-teal-400"></i>
            <p class="text-xs font-bold" id="toast-message">Notifikasi Berhasil</p>
        </div>
    </div>

    @yield('modals')

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

        function toggleModal(id, show) {
            const modal = document.getElementById(id);
            if(show) modal.classList.remove('hidden');
            else modal.classList.add('hidden');
        }

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            document.getElementById('toast-message').innerText = message;
            toast.classList.remove('hidden');
            setTimeout(() => { toast.classList.add('hidden'); }, 3000);
        }
    </script>
    
    @stack('scripts')

</body>
</html>