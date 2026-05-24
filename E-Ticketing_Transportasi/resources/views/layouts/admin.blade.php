<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - TiketKuy</title>
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
        <div class="h-16 flex items-center px-6 bg-gray-900 border-b border-gray-800">
            <i class="fa-solid fa-plane-departure text-primary text-xl mr-2"></i>
            <span class="font-bold text-lg text-white tracking-tight">TiketKuy <span class="text-xs text-primary font-normal bg-blue-900/50 px-2 py-0.5 rounded ml-1">Admin</span></span>
        </div>

        <nav class="flex-1 overflow-y-auto py-6 space-y-1 hide-scroll">
            <div class="px-6 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Main Menu</div>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 transition {{ request()->routeIs('admin.dashboard') ? 'bg-adminHover text-white border-l-4 border-primary' : 'hover:bg-adminHover hover:text-white' }}">
                <i class="fa-solid fa-chart-pie w-6"></i> 
                <span class="font-medium">Dashboard</span>
            </a>
            
            <div class="px-6 mt-6 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Manajemen Data</div>
            
            <a href="{{ route('admin.transportations.index') }}" class="flex items-center px-6 py-3 transition group {{ request()->routeIs('admin.transportations.*') ? 'bg-adminHover text-white border-l-4 border-primary' : 'hover:bg-adminHover hover:text-white' }}">
                <i class="fa-solid fa-bus w-6 {{ request()->routeIs('admin.transportations.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary' }} transition"></i> 
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

        @yield('content')

    </main>

</body>
</html>