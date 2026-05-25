<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pesan Tiket Transportasi Online') - Travelgo</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
        input[type="date"]::-webkit-calendar-picker-indicator { cursor: pointer; opacity: 0.6; }
    </style>
    @yield('styles')
</head>
<body class="bg-slate-100 text-slate-800 font-sans antialiased flex flex-col min-h-screen relative overflow-x-hidden">

    <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-emerald-300/15 blur-[120px] pointer-events-none z-0"></div>
    <div class="absolute bottom-[20%] right-[-5%] w-[600px] h-[600px] rounded-full bg-teal-400/10 blur-[150px] pointer-events-none z-0"></div>
    <div class="absolute top-[40%] left-[20%] w-[400px] h-[400px] rounded-full bg-indigo-300/10 blur-[130px] pointer-events-none z-0"></div>

    <nav id="navbar" class="fixed w-full z-50 bg-white/60 backdrop-blur-xl border-b border-white/40 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="block hover:opacity-90 transition-opacity">
                        @include('layouts.partials.logo')
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-6">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-teal-500/10 border border-teal-500/20 text-teal-600 font-extrabold px-5 py-2.5 rounded-xl transition-all hover:bg-teal-500/20 flex items-center text-sm shadow-sm">
                            <i data-lucide="layout-dashboard" class="w-4 h-4 mr-2"></i> Portal Saya
                        </a>
                    @else
                        <button onclick="openModal('loginModal')" class="text-teal-600 font-extrabold text-sm hover:bg-teal-500/10 px-5 py-2.5 rounded-xl transition-all cursor-pointer">
                            Masuk
                        </button>
                        <button onclick="openModal('registerModal')" class="bg-gradient-to-r from-teal-400 to-cyan-500 text-slate-950 font-black text-sm px-6 py-2.5 rounded-xl shadow-md shadow-teal-500/10 hover:brightness-110 active:scale-95 transition-all cursor-pointer">
                            Daftar
                        </button>
                    @endauth
                </div>

                <div class="md:hidden flex items-center">
                    <button class="text-slate-700 hover:text-teal-600 focus:outline-none transition-colors">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-1 pt-20 z-10 relative">
        @yield('content')
    </main>

    <footer class="bg-white/40 border-t border-white/60 backdrop-blur-md text-slate-600 pt-16 pb-8 z-10 relative mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div class="space-y-4">
                    <div class="flex items-center">
                        @include('layouts.partials.logo')
                    </div>
                    <p class="text-xs text-slate-400 font-medium leading-relaxed">Teman perjalanan Anda yang handal, menyediakan tiket transportasi dengan aman dan nyaman.</p>
                </div>
                <div>
                    <h4 class="text-slate-900 font-extrabold text-sm mb-4 uppercase tracking-wider">Produk</h4>
                    <ul class="space-y-2 text-xs font-semibold text-slate-500">
                        <li><a href="#" class="hover:text-teal-600 transition-colors flex items-center">
                            <span class="mr-1.5"><i data-lucide="train" class="w-4 h-4"></i></span> Tiket Kereta Api</a></li>
                        <li><a href="#" class="hover:text-teal-600 transition-colors flex items-center">
                            <span class="mr-1.5"><i data-lucide="bus" class="w-4 h-4"></i></span> Tiket Bus & Travel</a></li>
                        <li><a href="#" class="hover:text-teal-600 transition-colors flex items-center">
                            <span class="mr-1.5"><i data-lucide="plane-takeoff" class="w-4 h-4"></i></span> Tiket Pesawat</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-slate-900 font-extrabold text-sm mb-4 uppercase tracking-wider">Dukungan</h4>
                    <ul class="space-y-2 text-xs font-semibold text-slate-500">
                        <li><a href="#" class="hover:text-teal-600 transition-colors flex items-center">
                            <span class="mr-1.5"><i data-lucide="help-circle" class="w-4 h-4"></i></span> Pusat Bantuan</a></li>
                        <li><a href="#" class="hover:text-teal-600 transition-colors flex items-center">
                            <span class="mr-1.5"><i data-lucide="file-text" class="w-4 h-4"></i></span> Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-teal-600 transition-colors flex items-center">
                            <span class="mr-1.5"><i data-lucide="shield" class="w-4 h-4"></i></span> Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-slate-900 font-extrabold text-sm mb-4 uppercase tracking-wider">Ikuti Kami</h4>
                    <div class="flex space-x-3">
                        
                        <a href="#" class="w-9 h-9 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-500 hover:bg-teal-500 hover:text-slate-950 hover:border-teal-500 shadow-sm transition-all group" title="Instagram">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:scale-110">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                            </svg>
                        </a>

                        <a href="#" class="w-9 h-9 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-500 hover:bg-teal-500 hover:text-slate-950 hover:border-teal-500 shadow-sm transition-all group" title="X (Twitter)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" class="transition-transform group-hover:scale-110">
                                <path d="M12.6 .75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
                            </svg>
                        </a>

                        <a href="#" class="w-9 h-9 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-500 hover:bg-teal-500 hover:text-slate-950 hover:border-teal-500 shadow-sm transition-all group" title="Facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:scale-110">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                            </svg>
                        </a>

                    </div>
                </div>
            </div>
            <div class="border-t border-slate-200/60 pt-8 text-center text-xs text-slate-400 font-medium">
                &copy; 2026 Travelgo E-Ticketing Transportasi. Dikembangkan oleh Mahasiswa Telkom University.
            </div>
        </div>
    </footer>

    {{-- OVERLAY MODAL KACA INTERAKTIF --}}
    <div id="modalOverlay" class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300">
        
        {{-- MODAL 1: MASUK (LOGIN) --}}
        <div id="loginModal" class="bg-white/90 border border-white/60 backdrop-blur-md rounded-3xl w-full max-w-md shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 hidden">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black text-slate-800 tracking-tight">Masuk Akun</h3>
                    <button onclick="closeModal()" class="text-slate-400 hover:text-rose-500 transition-colors cursor-pointer"><i data-lucide="x" class="w-5 h-5"></i></button>
                </div>
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Alamat Email</label>
                        <input type="email" name="email" required placeholder="user@email.com" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 font-bold focus:outline-none focus:border-teal-400 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Kata Sandi</label>
                            <a href="#" class="text-xs font-bold text-teal-600 hover:text-teal-700">Lupa password?</a>
                        </div>
                        <input type="password" name="password" required placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 font-bold focus:outline-none focus:border-teal-400 focus:bg-white transition-all">
                    </div>
                    <button type="submit" class="w-full mt-2 py-3 rounded-xl bg-gradient-to-r from-teal-400 to-cyan-500 text-slate-950 font-black text-sm shadow-md shadow-teal-500/10 hover:brightness-110 active:scale-95 transition-all cursor-pointer">Login</button>
                </form>
                <div class="mt-6 text-center text-xs text-slate-400 font-semibold">
                    Belum punya akun? <a href="#" onclick="switchModal('registerModal')" class="text-teal-600 font-black hover:text-teal-700 ml-0.5">Daftar sekarang</a>
                </div>
            </div>
        </div>

        {{-- MODAL 2: DAFTAR AKUN --}}
        <div id="registerModal" class="bg-white/90 border border-white/60 backdrop-blur-md rounded-3xl w-full max-w-md shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 hidden">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black text-slate-800 tracking-tight">Daftar Akun Baru</h3>
                    <button onclick="closeModal()" class="text-slate-400 hover:text-rose-500 transition-colors cursor-pointer"><i data-lucide="x" class="w-5 h-5"></i></button>
                </div>
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Lengkap</label>
                        <input type="text" name="name" required placeholder="Sesuai KTP / Identitas" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 font-bold focus:outline-none focus:border-teal-400 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Alamat Email</label>
                        <input type="email" name="email" required placeholder="user@email.com" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 font-bold focus:outline-none focus:border-teal-400 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Buat Password</label>
                        <input type="password" name="password" required placeholder="Minimal 8 karakter" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 font-bold focus:outline-none focus:border-teal-400 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required placeholder="Ulangi password Anda" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 font-bold focus:outline-none focus:border-teal-400 focus:bg-white transition-all">
                    </div>
                    <button type="submit" class="w-full mt-2 py-3 rounded-xl bg-gradient-to-r from-orange-500 to-red-500 text-white font-black text-sm shadow-md shadow-orange-500/10 hover:brightness-110 active:scale-95 transition-all cursor-pointer">Daftar Sekarang</button>
                </form>
                <div class="mt-6 text-center text-xs text-slate-400 font-semibold">
                    Sudah punya akun? <a href="#" onclick="switchModal('loginModal')" class="text-teal-600 font-black hover:text-teal-700 ml-0.5">Masuk di sini</a>
                </div>
            </div>
        </div>

        {{-- MODAL 3: DETAIL FASILITAS & MANIFEST JADWAL --}}
        <div id="detailModal" class="bg-white/95 border border-white/60 backdrop-blur-md rounded-3xl w-full max-w-2xl shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 hidden flex-col max-h-[90vh]">
            <div class="p-6 border-b border-slate-100 flex justify-between items-start sticky top-0 bg-white/80 backdrop-blur-md z-10">
                <div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 text-xs font-bold mb-2">Tersedia</span>
                    <h3 id="modalTransName" class="text-xl font-black text-slate-800 tracking-tight">Nama Transportasi</h3>
                    <p id="modalTransClass" class="text-slate-400 text-xs font-semibold mt-0.5">Kelas Transportasi</p>
                </div>
                <button onclick="closeModal()" class="text-slate-400 hover:text-rose-500 text-xl bg-slate-50 border border-slate-200/60 rounded-full w-9 h-9 flex items-center justify-center transition-colors cursor-pointer"><i data-lucide="x" class="w-4 h-4"></i></button>
            </div>
            
            <div class="p-6 overflow-y-auto space-y-6 hide-scroll">
                {{-- Alur Timeline Jalur Perjalanan --}}
                <div class="bg-teal-500/5 border border-teal-500/10 rounded-2xl p-5 relative">
                    <div class="absolute left-7 top-10 bottom-10 w-0.5 bg-dashed bg-teal-300"></div>
                    
                    <div class="flex relative mb-8">
                        <div class="w-4 h-4 rounded-full bg-teal-500 mt-1 mr-4 ring-4 ring-teal-100 relative z-10 shadow-sm"></div>
                        <div>
                            <p class="font-black text-sm text-slate-800">Jam Operasional Keberangkatan</p>
                            <p class="text-slate-400 text-xs font-medium mt-0.5" id="modalTransAsal">Keberangkatan</p>
                        </div>
                    </div>
                    
                    <div class="flex relative">
                        <div class="w-4 h-4 rounded-full border-2 border-orange-500 bg-white mt-1 mr-4 ring-4 ring-orange-50 relative z-10 shadow-sm"></div>
                        <div>
                            <p class="font-black text-sm text-slate-800">Estimasi Jam Tiba di Tujuan</p>
                            <p class="text-slate-400 text-xs font-medium mt-0.5" id="modalTransTujuan">Tujuan</p>
                        </div>
                    </div>
                </div>

                {{-- Grid Fasilitas Luminescent --}}
                <div class="space-y-2.5">
                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-wider">Fasilitas Kendaraan</h4>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div class="text-center p-3.5 border border-slate-100 rounded-2xl bg-slate-50/50 shadow-sm flex flex-col items-center justify-center">
                            <i data-lucide="snowflake" class="text-teal-500 w-5 h-5 mb-2"></i>
                            <p class="text-xs text-slate-600 font-bold">Full AC</p>
                        </div>
                        <div class="text-center p-3.5 border border-slate-100 rounded-2xl bg-slate-50/50 shadow-sm flex flex-col items-center justify-center">
                            <i data-lucide="utensils" class="text-teal-500 w-5 h-5 mb-2"></i>
                            <p class="text-xs text-slate-600 font-bold">Makan / Snack</p>
                        </div>
                        <div class="text-center p-3.5 border border-slate-100 rounded-2xl bg-slate-50/50 shadow-sm flex flex-col items-center justify-center">
                            <i data-lucide="wifi" class="text-teal-500 w-5 h-5 mb-2"></i>
                            <p class="text-xs text-slate-600 font-bold">Free WiFi</p>
                        </div>
                        <div class="text-center p-3.5 border border-slate-100 rounded-2xl bg-slate-50/50 shadow-sm flex flex-col items-center justify-center">
                            <i data-lucide="plug" class="text-teal-500 w-5 h-5 mb-2"></i>
                            <p class="text-xs text-slate-600 font-bold">Stop Kontak</p>
                        </div>
                    </div>
                </div>

                {{-- Kebijakan Penumpang --}}
                <div class="space-y-2.5">
                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-wider">Kebijakan Penumpang</h4>
                    <ul class="list-none text-xs text-slate-500 font-medium space-y-2 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <li class="flex items-start"><span class="text-teal-500 font-bold mr-2">✓</span> Wajib membawa identitas asli resmi (KTP/SIM/Paspor) saat check-in.</li>
                        <li class="flex items-start"><span class="text-teal-500 font-bold mr-2">✓</span> Tiba di terminal / stasiun keberangkatan minimal 30 menit sebelum jam berangkat.</li>
                        <li class="flex items-start"><span class="text-teal-500 font-bold mr-2">✓</span> Tiket resmi dapat dibatalkan atau refund otomatis lewat panel kontrol penumpang.</li>
                    </ul>
                </div>
            </div>
            
            {{-- Bagian Tarif Bawah --}}
            <div class="p-5 border-t border-slate-100 bg-slate-50/80 backdrop-blur-md flex justify-between items-center mt-auto">
                <div>
                    <p class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider">Harga Per Orang</p>
                    <p id="modalTransPrice" class="text-xl font-black text-orange-500">Rp 0</p>
                </div>
                @auth
                    <a href="{{ route('passenger.dashboard') }}" class="inline-flex items-center space-x-1.5 bg-gradient-to-r from-teal-400 to-cyan-500 text-slate-950 font-black text-xs px-6 py-3 rounded-xl shadow-md shadow-teal-500/10 hover:brightness-110 active:scale-95 transition-all">
                        <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                        <span>Pesan Sekarang</span>
                    </a>
                @else
                    <button onclick="switchModal('loginModal')" class="bg-gradient-to-r from-orange-500 to-red-500 text-white font-black text-xs px-6 py-3 rounded-xl shadow-md shadow-orange-500/10 hover:brightness-110 active:scale-95 transition-all cursor-pointer">
                        Pilih Tiket
                    </button>
                @endauth
            </div>
        </div>

    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

        let currentOpenModal = null;

        function openModal(modalId) {
            const overlay = document.getElementById('modalOverlay');
            const modal = document.getElementById(modalId);
            
            document.getElementById('loginModal').classList.add('hidden');
            document.getElementById('registerModal').classList.add('hidden');
            document.getElementById('detailModal').classList.add('hidden');
            
            overlay.classList.remove('hidden');
            modal.classList.remove('hidden');
            
            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                modal.classList.remove('scale-95', 'opacity-0');
                modal.classList.add('scale-100', 'opacity-100');
            }, 20);
            
            currentOpenModal = modal;
        }

        function closeModal() {
            const overlay = document.getElementById('modalOverlay');
            if(currentOpenModal) {
                currentOpenModal.classList.remove('scale-100', 'opacity-100');
                currentOpenModal.classList.add('scale-95', 'opacity-0');
            }
            overlay.classList.add('opacity-0');
            
            setTimeout(() => {
                overlay.classList.add('hidden');
                if(currentOpenModal) currentOpenModal.classList.add('hidden');
                currentOpenModal = null;
            }, 300);
        }

        function switchModal(targetModalId) {
            if(currentOpenModal) {
                currentOpenModal.classList.add('hidden');
                currentOpenModal.classList.remove('scale-100', 'opacity-100');
                currentOpenModal.classList.add('scale-95', 'opacity-0');
            }
            const target = document.getElementById(targetModalId);
            target.classList.remove('hidden');
            setTimeout(() => {
                target.classList.remove('scale-95', 'opacity-0');
                target.classList.add('scale-100', 'opacity-100');
            }, 10);
            currentOpenModal = target;
        }

        function openDetailModal(name, route, typeClass, price) {
            document.getElementById('modalTransName').innerText = name;
            document.getElementById('modalTransClass').innerText = typeClass;
            const routes = route.split('-');
            document.getElementById('modalTransAsal').innerText = "Berangkat dari: " + routes[0].trim();
            document.getElementById('modalTransTujuan').innerText = "Tiba di: " + (routes[1] ? routes[1].trim() : '-');
            document.getElementById('modalTransPrice').innerText = price;
            openModal('detailModal');
        }

        document.getElementById('modalOverlay').addEventListener('click', function(e) {
            if(e.target === this) closeModal();
        });
    </script>
    @yield('scripts')
</body>
</html>