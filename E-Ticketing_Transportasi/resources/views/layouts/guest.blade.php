<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pesan Tiket Transportasi Online') - Travelgo </title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: '#1BA0E2',
                        primaryDark: '#0D7BBA',
                        secondary: '#FF5E1F',
                        secondaryDark: '#E04A0D',
                    }
                }
            }
        }
    </script>
    <style>
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
        input[type="date"]::-webkit-calendar-picker-indicator { cursor: pointer; opacity: 0.6; }
    </style>
    @yield('styles')
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased flex flex-col min-h-screen">

    <nav id="navbar" class="fixed w-full z-50 bg-white shadow-md transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 sm:h-20">
                <div class="h-20 flex items-center px-4 border-b border-transparent">
                    <a href="{{ url('/') }}">
                        @include('layouts.partials.logo')
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-6">
                    <a href="#jadwal" class="text-gray-600 hover:text-primary font-medium transition">Cek Jadwal</a>
                    <a href="#" class="text-gray-600 hover:text-primary font-medium transition">Bantuan</a>
                    
                    <div class="h-6 w-px bg-gray-300 mx-2"></div>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-blue-50 text-primary font-bold px-5 py-2 rounded-lg transition duration-200 flex items-center">
                            <i class="fa-solid fa-gauge mr-2"></i> Panel Saya
                        </a>
                    @else
                        <button onclick="openModal('loginModal')" class="text-primary font-semibold hover:bg-blue-50 px-5 py-2 rounded-lg transition duration-200">
                            Masuk
                        </button>
                        <button onclick="openModal('registerModal')" class="bg-primary hover:bg-primaryDark text-white font-semibold px-5 py-2 rounded-lg shadow-sm transition duration-200">
                            Daftar
                        </button>
                    @endauth
                </div>

                <div class="md:hidden flex items-center">
                    <button class="text-gray-600 hover:text-primary focus:outline-none text-2xl">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-gray-300 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center mb-4">
                        @include('layouts.partials.logo')
                    </div>
                    <p class="text-sm text-gray-400 mb-4">Teman perjalanan Anda yang handal, menyediakan tiket transportasi terlengkap se-Indonesia.</p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Produk</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-primary transition">Tiket Kereta Api</a></li>
                        <li><a href="#" class="hover:text-primary transition">Tiket Bus & Travel</a></li>
                        <li><a href="#" class="hover:text-primary transition">Tiket Pesawat</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Dukungan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-primary transition">Pusat Bantuan</a></li>
                        <li><a href="#" class="hover:text-primary transition">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-primary transition">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Ikuti Kami</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary hover:text-white transition"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary hover:text-white transition"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-primary hover:text-white transition"><i class="fa-brands fa-facebook-f"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm text-gray-500">
                &copy; 2026 TiketKuy E-Ticketing System. All rights reserved.
            </div>
        </div>
    </footer>

    <div id="modalOverlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300">
        
        <div id="loginModal" class="bg-white rounded-2xl w-full max-w-md shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 hidden">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Masuk</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-red-500 text-xl"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf 
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" required placeholder="Contoh: user@email.com" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition">
                    </div>
                    <div class="mb-6">
                        <div class="flex justify-between mb-2">
                            <label class="block text-sm font-semibold text-gray-700">Password</label>
                            <a href="#" class="text-sm text-primary hover:underline">Lupa password?</a>
                        </div>
                        <input type="password" name="password" required placeholder="Masukkan password" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition">
                    </div>
                    <button type="submit" class="w-full bg-primary hover:bg-primaryDark text-white font-bold py-3 rounded-xl transition duration-200">Login</button>
                </form>
                <div class="mt-6 text-center text-sm text-gray-600">
                    Belum punya akun? <a href="#" onclick="switchModal('registerModal')" class="text-primary font-bold hover:underline">Daftar sekarang</a>
                </div>
            </div>
        </div>

        <div id="registerModal" class="bg-white rounded-2xl w-full max-w-md shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 hidden">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Daftar Akun</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-red-500 text-xl"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" required placeholder="Sesuai KTP/Identitas" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" required placeholder="Contoh: user@email.com" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Buat Password</label>
                        <input type="password" name="password" required placeholder="Minimal 8 karakter" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required placeholder="Ulangi password Anda" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition">
                    </div>
                    <button type="submit" class="w-full bg-secondary hover:bg-secondaryDark text-white font-bold py-3 rounded-xl transition duration-200">Daftar</button>
                </form>
                <div class="mt-6 text-center text-sm text-gray-600">
                    Sudah punya akun? <a href="#" onclick="switchModal('loginModal')" class="text-primary font-bold hover:underline">Masuk di sini</a>
                </div>
            </div>
        </div>

        <div id="detailModal" class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 hidden flex-col max-h-[90vh]">
            <div class="p-6 border-b border-gray-100 flex justify-between items-start sticky top-0 bg-white z-10">
                <div>
                    <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded mb-2 inline-block">Tersedia</span>
                    <h3 id="modalTransName" class="text-2xl font-bold text-gray-800">Nama Transportasi</h3>
                    <p id="modalTransClass" class="text-gray-500 text-sm">Kelas Transportasi</p>
                </div>
                <button onclick="closeModal()" class="text-gray-400 hover:text-red-500 text-2xl bg-gray-50 rounded-full w-10 h-10 flex items-center justify-center"><i class="fa-solid fa-xmark"></i></button>
            </div>
            
            <div class="p-6 overflow-y-auto">
                <div class="bg-blue-50 rounded-xl p-5 mb-6 relative">
                    <div class="absolute left-7 top-10 bottom-10 w-0.5 bg-blue-300 border-dashed border-l-2"></div>
                    
                    <div class="flex relative mb-8">
                        <div class="w-4 h-4 rounded-full bg-primary mt-1 mr-4 ring-4 ring-blue-100 relative z-10"></div>
                        <div>
                            <p class="font-bold text-gray-800">Jam Operasional</p>
                            <p class="text-gray-600 text-sm" id="modalTransAsal">Keberangkatan</p>
                        </div>
                    </div>
                    
                    <div class="flex relative">
                        <div class="w-4 h-4 rounded-full border-2 border-secondary bg-white mt-1 mr-4 ring-4 ring-orange-50 relative z-10"></div>
                        <div>
                            <p class="font-bold text-gray-800">Estimasi Tiba</p>
                            <p class="text-gray-600 text-sm" id="modalTransTujuan">Tujuan</p>
                        </div>
                    </div>
                </div>

                <h4 class="font-bold text-gray-800 mb-4">Fasilitas Kendaraan</h4>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                    <div class="text-center p-3 border rounded-xl bg-gray-50">
                        <i class="fa-solid fa-snowflake text-primary text-xl mb-2"></i>
                        <p class="text-xs text-gray-600">Full AC</p>
                    </div>
                    <div class="text-center p-3 border rounded-xl bg-gray-50">
                        <i class="fa-solid fa-utensils text-primary text-xl mb-2"></i>
                        <p class="text-xs text-gray-600">Makan/Snack</p>
                    </div>
                    <div class="text-center p-3 border rounded-xl bg-gray-50">
                        <i class="fa-solid fa-wifi text-primary text-xl mb-2"></i>
                        <p class="text-xs text-gray-600">Free WiFi</p>
                    </div>
                    <div class="text-center p-3 border rounded-xl bg-gray-50">
                        <i class="fa-solid fa-plug text-primary text-xl mb-2"></i>
                        <p class="text-xs text-gray-600">Stop Kontak</p>
                    </div>
                </div>

                <h4 class="font-bold text-gray-800 mb-2">Kebijakan Penumpang</h4>
                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                    <li>Wajib membawa identitas asli (KTP/SIM/Paspor).</li>
                    <li>Tiba di titik keberangkatan minimal 30 menit sebelum berangkat.</li>
                    <li>Tiket dapat dibatalkan (syarat & ketentuan berlaku).</li>
                </ul>
            </div>
            
            <div class="p-6 border-t border-gray-100 bg-gray-50 flex justify-between items-center mt-auto">
                <div>
                    <p class="text-sm text-gray-500">Harga Per Orang</p>
                    <p id="modalTransPrice" class="text-2xl font-bold text-secondary">Rp 0</p>
                </div>
                @auth
                    <a href="{{ route('passenger.dashboard') }}" class="bg-secondary hover:bg-secondaryDark text-white font-bold py-3 px-8 rounded-xl shadow-md transition duration-200">
                        Pesan Sekarang
                    </a>
                @else
                    <button onclick="switchModal('loginModal')" class="bg-secondary hover:bg-secondaryDark text-white font-bold py-3 px-8 rounded-xl shadow-md transition duration-200">
                        Pilih Tiket
                    </button>
                @endauth
            </div>
        </div>

    </div>

    <script>
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 10) { nav.classList.add('shadow-md'); } 
            else { nav.classList.remove('shadow-md'); }
        });

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
            }, 10);
            
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