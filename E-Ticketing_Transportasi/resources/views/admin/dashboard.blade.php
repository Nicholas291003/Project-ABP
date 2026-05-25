@extends('layouts.admin')

@section('title', 'Dashboard - TravelGo Admin')

@section('content')
<div class="p-8 space-y-8 flex-1">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tight">Halo, {{ explode(' ', Auth::user()->name)[0] }}!</h1>
            <p class="text-slate-400 text-sm mt-1">Pantau performa dan aktivitas sistem E-Ticketing hari ini.</p>
        </div>
        <div class="flex items-center space-x-3">
            <button onclick="showToast('Mengunduh laporan... Berhasil!')" class="flex items-center space-x-2 px-4 py-2.5 rounded-xl border border-slate-700 bg-slate-800/40 text-slate-300 text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all">
                <i data-lucide="download" class="w-4 h-4"></i>
                <span>Unduh Laporan</span>
            </button>
            <a href="{{ route('admin.schedule.index') }}" class="flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-teal-400 to-cyan-500 text-slate-950 text-sm font-bold hover:brightness-110 transition-all shadow-lg shadow-teal-500/20">
                <i data-lucide="plus" class="w-4.5 h-4.5 stroke-[3px]"></i>
                <span>Buat Jadwal</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 rounded-2xl p-6 flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-teal-500/10 border border-teal-500/20 flex items-center justify-center text-teal-400">
                <i data-lucide="ticket" class="w-6 h-6"></i>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-semibold block">Total Tiket Terjual</span>
                <span class="text-2xl font-black text-slate-100 block mt-1">{{ $totalTiketTerjual }}</span>
            </div>
        </div>
        <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 rounded-2xl p-6 flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                <i data-lucide="wallet" class="w-6 h-6"></i>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-semibold block">Pendapatan Bulan Ini</span>
                <span class="text-xl font-black text-slate-100 block mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 rounded-2xl p-6 flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-semibold block">Total Penumpang Aktif</span>
                <span class="text-2xl font-black text-slate-100 block mt-1">{{ $totalPenumpang }} <span class="text-xs text-slate-400 font-normal">orang</span></span>
            </div>
        </div>
        <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 rounded-2xl p-6 flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400">
                <i data-lucide="map-pin" class="w-6 h-6"></i>
            </div>
            <div>
                <span class="text-xs text-slate-400 font-semibold block">Rute Aktif & Berjalan</span>
                <span class="text-2xl font-black text-slate-100 block mt-1">{{ $totalRute }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-slate-950/40 backdrop-blur-md border border-slate-800/80 rounded-2xl p-6 flex flex-col shadow-xl shadow-black/10">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg font-black text-slate-100 tracking-tight">Pesanan Tiket Terbaru</h2>
                    <p class="text-xs text-slate-400">Daftar reservasi dan status transaksi penumpang.</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="text-sm font-bold text-teal-400 hover:text-teal-300">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse" id="ticketTable">
                    <thead>
                        <tr class="border-b border-slate-800 text-[11px] text-slate-500 font-extrabold uppercase tracking-widest">
                            <th class="pb-3 pl-2">ID Pesanan</th>
                            <th class="pb-3">Penumpang</th>
                            <th class="pb-3">Rute & Transportasi</th>
                            <th class="pb-3 text-center">Status</th>
                            <th class="pb-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/40">
                        @forelse($pesananTerbaru as $pesanan)
                        <tr class="text-sm text-slate-300 hover:bg-slate-900/30 transition-colors group">
                            <td class="py-4 pl-2 font-bold text-slate-200 group-hover:text-teal-400">{{ $pesanan->order_code }}</td>
                            <td class="py-4 font-semibold">{{ $pesanan->user->name }}</td>
                            <td class="py-4">
                                <div class="font-bold text-slate-200 text-xs">{{ $pesanan->schedule->route->kota_asal }} → {{ $pesanan->schedule->route->kota_tujuan }}</div>
                                <div class="text-[11px] text-slate-400 mt-1">
                                    <span class="text-teal-400">
                                        @if($pesanan->schedule->transportation->jenis == 'kereta')
                                        <i data-lucide="train" class="w-3.5 h-3.5"></i> 
                                        @elseif($pesanan->schedule->transportation->jenis == 'bus')
                                        <i data-lucide="bus" class="w-3.5 h-3.5"></i> 
                                        @else
                                        <i data-lucide="plane-takeoff" class="w-3.5 h-3.5"></i> 
                                        @endif
                                    </span> 
                                    {{ $pesanan->schedule->transportation->nama }}
                                </div>
                            </td>
                            <td class="py-4 text-center">
                                @if($pesanan->status == 'lunas')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Lunas</span>
                                @elseif($pesanan->status == 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20 animate-pulse">Pending</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-500/10 text-rose-400 border border-rose-500/20">Batal</span>
                                @endif
                            </td>
                            <td class="py-4 text-center">
                                <a href="{{ route('admin.orders.index') }}" class="inline-block p-1.5 rounded-lg bg-slate-900 border border-slate-800 text-slate-400 hover:text-teal-400 hover:border-teal-400 transition-all">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-slate-500 text-sm">Belum ada pesanan terbaru.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 rounded-2xl p-6 flex flex-col shadow-xl shadow-black/10 justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        <i data-lucide="calendar" class="w-5 h-5 text-teal-400"></i>
                        <h2 class="text-lg font-black text-slate-100 tracking-tight">Monitoring Jadwal</h2>
                    </div>
                </div>
                
                <div class="grid grid-cols-3 gap-1 bg-slate-900/80 p-1 rounded-xl border border-slate-800/80 mb-5">
                    <button onclick="switchTab('hari-ini')" id="tab-hari-ini" class="py-1.5 text-[10px] sm:text-xs font-extrabold rounded-lg bg-gradient-to-tr from-teal-400 to-cyan-500 text-slate-950 transition-all">Hari Ini ({{ $jadwalHariIni->count() }})</button>
                    <button onclick="switchTab('mendatang')" id="tab-mendatang" class="py-1.5 text-[10px] sm:text-xs font-extrabold rounded-lg text-slate-400 hover:text-slate-200 transition-all">Mendatang</button>
                    <button onclick="switchTab('lewat')" id="tab-lewat" class="py-1.5 text-[10px] sm:text-xs font-extrabold rounded-lg text-slate-400 hover:text-slate-200 transition-all">Sudah Lewat</button>
                </div>

                <div id="content-hari-ini" class="space-y-4 max-h-[350px] overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($jadwalHariIni as $jadwal)
                    <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800/80 group hover:border-teal-500/30 transition-all">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-teal-400 bg-teal-500/10 px-2 py-0.5 rounded-md">{{ substr($jadwal->departure_time, 0, 5) }}</span>
                            <span class="text-[11px] font-bold {{ $jadwal->remaining_seats > 0 ? 'text-slate-400' : 'text-rose-400' }}">Sisa {{ $jadwal->remaining_seats }} / {{ $jadwal->total_seats }} Kursi</span>
                        </div>
                        <h3 class="text-sm font-black text-slate-100 group-hover:text-teal-300 transition-colors">{{ $jadwal->transportation->nama }}</h3>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $jadwal->route->kota_asal }} → {{ $jadwal->route->kota_tujuan }}</p>
                    </div>
                    @empty
                    <div class="text-center py-10">
                        <i data-lucide="calendar-x" class="w-10 h-10 text-slate-600 mx-auto mb-3"></i>
                        <p class="text-xs text-slate-500">Tidak ada jadwal hari ini.</p>
                    </div>
                    @endforelse
                </div>

                <div id="content-mendatang" class="space-y-4 max-h-[350px] overflow-y-auto pr-2 custom-scrollbar hidden">
                    @forelse($jadwalMendatang as $jadwal)
                    <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800/80 group hover:border-blue-500/30 transition-all">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded-md">{{ \Carbon\Carbon::parse($jadwal->departure_date)->format('d M') }}, {{ substr($jadwal->departure_time, 0, 5) }}</span>
                            <span class="text-[11px] font-bold text-slate-400">Sisa {{ $jadwal->remaining_seats }} Kursi</span>
                        </div>
                        <h3 class="text-sm font-black text-slate-100 group-hover:text-blue-300">{{ $jadwal->transportation->nama }}</h3>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $jadwal->route->kota_asal }} → {{ $jadwal->route->kota_tujuan }}</p>
                    </div>
                    @empty
                    <p class="text-xs text-slate-500 text-center py-6">Belum ada jadwal mendatang.</p>
                    @endforelse
                </div>

                <div id="content-lewat" class="space-y-4 max-h-[350px] overflow-y-auto pr-2 custom-scrollbar hidden">
                    @forelse($jadwalTerlewat as $jadwal)
                    <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800/80 opacity-60">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-slate-500 bg-slate-800/50 px-2 py-0.5 rounded-md">{{ \Carbon\Carbon::parse($jadwal->departure_date)->format('d M y') }}</span>
                            <span class="text-[11px] text-slate-500 font-bold ">Selesai</span>
                        </div>
                        <h3 class="text-sm font-black text-slate-400">{{ $jadwal->transportation->nama }}</h3>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $jadwal->route->kota_asal }} → {{ $jadwal->route->kota_tujuan }}</p>
                    </div>
                    @empty
                    <p class="text-xs text-slate-500 text-center py-6">Tidak ada histori jadwal.</p>
                    @endforelse
                </div>
            </div>
            
            <div class="mt-4 pt-4 border-t border-slate-800/60 text-center">
                <a href="{{ route('admin.schedule.index') }}" class="text-xs font-bold text-slate-400 hover:text-teal-400 transition-colors">Kelola Semua Jadwal →</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Agar scrollbar di kotak jadwal terlihat estetik dan gelap */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #475569; }
</style>
@endpush

@push('scripts')
<script>
    // Tab Logika
    function switchTab(tabName) {
        ['hari-ini', 'mendatang', 'lewat'].forEach(tab => {
            document.getElementById('content-' + tab).classList.add('hidden');
            document.getElementById('tab-' + tab).className = 'py-1.5 text-[10px] sm:text-xs font-extrabold rounded-lg text-slate-400 hover:text-slate-200 transition-all';
        });
        document.getElementById('content-' + tabName).classList.remove('hidden');
        document.getElementById('tab-' + tabName).className = 'py-1.5 text-[10px] sm:text-xs font-extrabold rounded-lg bg-gradient-to-tr from-teal-400 to-cyan-500 text-slate-950 transition-all';
    }

    // Filter Table Logika
    function filterTable() {
        let input = document.getElementById('tableSearch').value.toLowerCase();
        let rows = document.getElementById('ticketTable').getElementsByTagName('tr');
        for (let i = 1; i < rows.length; i++) { // Lewati baris 0 (Header)
            let idText = rows[i].getElementsByTagName('td')[0].textContent.toLowerCase();
            let nameText = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
            if (idText.includes(input) || nameText.includes(input)) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }
</script>
@endpush