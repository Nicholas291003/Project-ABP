<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Penumpang') - Travelgo</title>
    
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], },
                    colors: { primary: '#1BA0E2', primaryDark: '#0D7BBA', secondary: '#FF5E1F', secondaryDark: '#E04A0D', }
                }
            }
        }
    </script>
    <style>
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased flex h-screen overflow-hidden">

    <aside class="bg-white w-64 shadow-xl hidden md:flex flex-col z-20 transition-all duration-300 relative flex-shrink-0 border-r border-gray-100">
        <div class="h-20 flex items-center px-6 border-b border-gray-100">
            <a href="{{ route('passenger.dashboard') }}">
                @include('layouts.partials.logo')
            </a>
        </div>

        <nav class="flex-1 overflow-y-auto py-6 space-y-1">
            <div class="px-6 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu Utama</div>
            
            <a href="{{ route('passenger.dashboard') }}" class="flex items-center px-6 py-3 font-medium transition {{ request()->routeIs('passenger.dashboard') ? 'bg-blue-50 text-primary border-r-4 border-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">
                <i class="fa-solid fa-house w-5 mr-3"></i> Beranda & Cari
            </a>
            
            <a href="{{ route('passenger.tickets') }}" class="flex items-center px-6 py-3 font-medium transition {{ request()->routeIs('passenger.tickets') || request()->routeIs('passenger.ticket.show') ? 'bg-blue-50 text-primary border-r-4 border-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">
                <i class="fa-solid fa-ticket w-5 mr-3"></i> Tiket Saya
            </a>
            
            <a href="{{ route('passenger.history') }}" class="flex items-center px-6 py-3 font-medium transition {{ request()->routeIs('passenger.history') ? 'bg-blue-50 text-primary border-r-4 border-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">
                <i class="fa-solid fa-clock-rotate-left w-5 mr-3"></i> Riwayat Pemesanan
            </a>

            <div class="px-6 mt-8 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Pengaturan</div>
            
            <a href="{{ route('passenger.profile') }}" class="flex items-center px-6 py-3 font-medium transition {{ request()->routeIs('passenger.profile') ? 'bg-blue-50 text-primary border-r-4 border-primary' : 'text-gray-600 hover:bg-gray-50 hover:text-primary' }}">
                <i class="fa-solid fa-user-gear w-5 mr-3"></i> Kelola Profil
            </a>
        </nav>

        <div class="p-6 border-t border-gray-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center text-red-500 hover:text-red-700 font-medium transition">
                    <i class="fa-solid fa-arrow-right-from-bracket w-5 mr-3"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
        <header class="h-20 bg-white shadow-sm flex items-center justify-between px-4 sm:px-8 z-10 flex-shrink-0">
            <button class="md:hidden text-gray-600 hover:text-primary text-2xl mr-4"><i class="fa-solid fa-bars"></i></button>
            <div class="hidden sm:block text-gray-800 font-semibold text-lg">Dashboard Penumpang</div>
            
            <div class="flex items-center space-x-4 ml-auto">
                <button class="text-gray-400 hover:text-primary transition relative">
                    <i class="fa-regular fa-bell text-xl"></i>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                <div class="flex items-center space-x-3 border-l pl-4 border-gray-200">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1BA0E2&color=fff" alt="Avatar" class="w-10 h-10 rounded-full shadow-sm">
                    <div class="hidden sm:block text-right">
                        <p class="text-sm font-bold text-gray-800 leading-tight">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">Passenger</p>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-4 sm:p-8 lg:p-10 hide-scroll pb-24 bg-gray-50">
            @yield('content')
        </main>
    </div>

</body>
</html>