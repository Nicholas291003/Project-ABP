@extends('layouts.admin')

@section('title', 'Manajemen Jadwal Perjalanan - Travelgo')

@section('content')
<div class="p-8 space-y-8 flex-1">
    
    {{-- Notifikasi Sukses Bergaya Kaca --}}
    @if(session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-xl flex items-center shadow-lg shadow-black/10">
            <i data-lucide="check-circle" class="mr-2.5 w-5 h-5"></i>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Atas Halaman & Tombol Tambah --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tight">Manajemen Jadwal</h1>
            <p class="text-sm text-slate-400 mt-1">Atur tanggal, jam operasional, kapasitas kursi, dan harga tiket rute aktif.</p>
        </div>
        <button onclick="openModal('createScheduleModal')" class="flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-teal-400 to-cyan-500 text-slate-950 text-sm font-bold hover:brightness-110 transition-all shadow-lg shadow-teal-500/20 cursor-pointer">
            <i data-lucide="plus" class="w-4.5 h-4.5 stroke-[3px]"></i>
            <span>Buat Jadwal Baru</span>
        </button>
    </div>

    {{-- Tiga Kartu Indikator Statistik (Luminescent) --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 p-5 rounded-2xl flex items-center hover:border-teal-500/30 transition-all duration-300">
            <div class="w-12 h-12 rounded-xl bg-teal-500/10 border border-teal-500/20 flex items-center justify-center text-teal-400 mr-4">
                <i data-lucide="calendar" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Total Jadwal Aktif</p>
                <h3 class="text-xl font-black text-slate-100 mt-0.5">{{ $total_jadwal }} Jadwal</h3>
            </div>
        </div>
        <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 p-5 rounded-2xl flex items-center hover:border-orange-500/30 transition-all duration-300">
            <div class="w-12 h-12 rounded-xl bg-orange-500/10 border border-orange-500/20 flex items-center justify-center text-orange-400 mr-4">
                <i data-lucide="clock" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Berangkat Hari Ini</p>
                <h3 class="text-xl font-black text-slate-100 mt-0.5">{{ $jadwal_hari_ini }} Armada</h3>
            </div>
        </div>
        <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 p-5 rounded-2xl flex items-center hover:border-emerald-500/30 transition-all duration-300">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 mr-4">
                <i data-lucide="armchair" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Kursi Dipesan</p>
                <h3 class="text-xl font-black text-slate-100 mt-0.5">{{ $total_kursi_terjual }} Kursi</h3>
            </div>
        </div>
    </div>

    {{-- Form Pencarian & Filter Bilah Kaca --}}
    <form action="{{ route('admin.schedule.index') }}" method="GET" class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 p-4 rounded-t-2xl flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="flex space-x-2 w-full sm:w-auto">
            <select name="status_waktu" onchange="this.form.submit()" class="bg-slate-900 border border-slate-800 text-slate-300 text-sm rounded-xl focus:outline-none focus:border-teal-400 px-3 py-2 transition-all cursor-pointer">
                <option value="">Semua Status Waktu</option>
                <option value="upcoming" {{ request('status_waktu') == 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
                <option value="past" {{ request('status_waktu') == 'past' ? 'selected' : '' }}>Sudah Terlewat</option>
            </select>
        </div>
        <div class="relative w-full sm:w-72">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-500">
                <i data-lucide="search" class="w-4 h-4"></i>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" onchange="this.form.submit()" class="w-full bg-slate-900 border border-slate-800 rounded-xl text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-teal-400 pl-10 p-2.5 transition-all" placeholder="Cari armada atau kota...">
        </div>
    </form>

    {{-- Wadah Utama Tabel Konten --}}
    <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 rounded-b-2xl overflow-hidden shadow-xl shadow-black/10">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-950/20 text-[11px] text-slate-500 font-extrabold uppercase tracking-widest border-b border-slate-800">
                        <th class="py-4 px-6">Armada / Jenis</th>
                        <th class="py-4 px-6">Rute Perjalanan</th>
                        <th class="py-4 px-6">Waktu Keberangkatan</th>
                        <th class="py-4 px-6 text-center">Sisa Kursi</th>
                        <th class="py-4 px-6">Harga Tiket</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-800/40">
                    @forelse($schedules as $item)
                        @php
                            $departureDateTime = \Carbon\Carbon::parse($item->departure_date . ' ' . $item->departure_time);
                            $isPast = $departureDateTime->isPast();
                        @endphp
                        
                        <tr class="transition {{ $isPast ? 'bg-slate-950/20 opacity-50 select-none' : 'hover:bg-gray-900/30 text-slate-300' }} group">
                            {{-- Kolom Nama & Jenis Armada --}}
                            <td class="py-4 px-6">
                                <p class="font-bold group-hover:text-teal-400 {{ $isPast ? 'text-slate-500 line-through' : 'text-slate-200' }} transition-colors">{{ $item->transportation->nama }}</p>
                                <span class="text-[10px] {{ $isPast ? 'bg-slate-800 text-slate-600' : 'bg-slate-900 text-slate-400 border border-slate-800' }} px-2 py-0.5 rounded font-bold block w-max mt-1.5 uppercase tracking-wider">
                                    {{ $item->transportation->jenis }} ({{ $item->transportation->kelas }})
                                </span>
                            </td>
                            
                            {{-- Kolom Detail Rute --}}
                            <td class="py-4 px-6">
                                <div class="font-bold flex items-center {{ $isPast ? 'text-slate-500' : 'text-slate-200' }}">
                                    <span>{{ $item->route->kota_asal }}</span>
                                    <span class="text-xs font-normal text-slate-500 mx-1">({{ $item->route->simpul_asal }})</span>
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 mx-1.5 text-slate-500"></i>
                                    <span>{{ $item->route->kota_tujuan }}</span>
                                    <span class="text-xs font-normal text-slate-500 mx-1">({{ $item->route->simpul_tujuan }})</span>
                                </div>
                                <p class="text-xs text-slate-500 mt-1 font-medium">
                                    <span class="font-bold text-slate-400 mr-1">{{ $item->route->kode_rute }}</span> 
                                    ({{ $item->route->estimasi_jam }}j {{ $item->route->estimasi_menit }}m | {{ $item->route->jarak }} KM)
                                </p>
                            </td>
                            
                            {{-- Kolom Tanggal & Jam --}}
                            <td class="py-4 px-6">
                                <p class="font-bold {{ $isPast ? 'text-slate-500' : 'text-slate-200' }}">{{ \Carbon\Carbon::parse($item->departure_date)->format('d M Y') }}</p>
                                <p class="text-xs text-slate-400 mt-1 font-medium flex items-center">
                                    <i data-lucide="clock" class="w-3.5 h-3.5 mr-1 text-slate-500"></i> 
                                    {{ substr($item->departure_time, 0, 5) }} - {{ substr($item->arrival_time, 0, 5) }}
                                </p>
                                
                                @if($isPast)
                                    <span class="text-[9px] bg-rose-500/10 text-rose-400 border border-rose-500/20 px-2 py-0.5 rounded font-bold block w-max mt-1.5 uppercase tracking-wide">
                                        Jadwal Terlewat
                                    </span>
                                @endif
                            </td>

                            {{-- Kolom Sisa Kuota Kursi --}}
                            <td class="py-4 px-6 text-center">
                                <p class="font-black {{ $isPast ? 'text-slate-500' : ($item->remaining_seats == 0 ? 'text-rose-400' : 'text-slate-300') }}">{{ $item->remaining_seats }} / {{ $item->total_seats }}</p>
                                <div class="w-20 bg-slate-900 h-1.5 rounded-full mx-auto mt-1.5 overflow-hidden border border-slate-800">
                                    <div class="h-full {{ $isPast ? 'bg-slate-700' : 'bg-gradient-to-r from-teal-400 to-cyan-500' }}" style="width: {{ ($item->remaining_seats / $item->total_seats) * 100 }}%"></div>
                                </div>
                            </td>

                            {{-- Kolom Harga Tiket --}}
                            <td class="py-4 px-6 font-extrabold text-amber-400">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            
                            {{-- Kolom Aksi --}}
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    @if(!$isPast)
                                        <button onclick="openEditModal('{{ $item->id }}', '{{ $item->route_id }}', '{{ $item->transportation_id }}', '{{ $item->departure_date }}', '{{ $item->departure_time }}', '{{ $item->arrival_time }}', '{{ $item->price }}', '{{ $item->total_seats }}')" class="p-2 rounded-lg bg-slate-900 border border-slate-800 text-slate-400 hover:text-teal-400 hover:border-teal-400 transition-all inline-flex items-center cursor-pointer" title="Edit Jadwal">
                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                        </button>
                                    @endif
                                    <button onclick="confirmDelete('{{ $item->id }}')" class="p-2 rounded-lg bg-slate-900 border border-slate-800 text-slate-400 hover:text-rose-400 hover:border-rose-400 transition-all inline-flex items-center cursor-pointer" title="Hapus Jadwal">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500 font-medium">
                                <i data-lucide="calendar-x" class="w-10 h-10 mx-auto mb-3 text-slate-600"></i>
                                Belum ada jadwal keberangkatan yang diterbitkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Gelap --}}
        <div class="px-6 py-4 border-t border-slate-800/60 bg-slate-950/20">
            {{ $schedules->links() }}
        </div>
    </div>
</div>

{{-- OVERLAY MODAL GLOBAL --}}
<div id="modalOverlay" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    
    {{-- MODAL: TAMBAH JADWAL BARU --}}
    <div id="createScheduleModal" class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-xl shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 hidden">
        <div class="p-6 border-b border-slate-800 flex justify-between items-center">
            <h3 class="text-xl font-black text-slate-100 flex items-center">
                <i data-lucide="plus-circle" class="text-teal-400 mr-2.5 w-5 h-5"></i> Terbitkan Jadwal Baru
            </h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-rose-400 transition-colors cursor-pointer"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <form action="{{ route('admin.schedule.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Pilih Rute Operasional <span class="text-rose-500">*</span></label>
                <select name="route_id" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all cursor-pointer">
                    <option value="" disabled selected>Pilih Rute Operasional</option>
                    @foreach($routes_list as $r)
                        <option value="{{ $r->id }}">{{ $r->kode_rute }} - {{ $r->kota_asal }} ke {{ $r->kota_tujuan }} ({{ $r->simpul_asal }} ➔ {{ $r->simpul_tujuan }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Pilih Armada / Kendaraan <span class="text-rose-500">*</span></label>
                <select name="transportation_id" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all cursor-pointer">
                    <option value="" disabled selected>Pilih Armada / Kendaraan</option>
                    @foreach($transportation_list as $trn)
                        <option value="{{ $trn->id }}">{{ $trn->kode }} - {{ $trn->nama }} ({{ $trn->kelas }})</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Tanggal Keberangkatan <span class="text-rose-500">*</span></label>
                <input type="date" name="departure_date" required min="{{ date('Y-m-d') }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Jam Berangkat <span class="text-rose-500">*</span></label>
                    <input type="time" name="departure_time" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Estimasi Jam Tiba <span class="text-rose-500">*</span></label>
                    <input type="time" name="arrival_time" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Harga Tiket (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" name="price" required placeholder="Contoh: 250000" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Total Kuota Kursi <span class="text-rose-500">*</span></label>
                    <input type="number" name="total_seats" required placeholder="Contoh: 50" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 pt-4 border-t border-slate-800">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-xl border border-slate-700 bg-slate-800/20 text-slate-400 text-sm font-semibold hover:bg-slate-800/40 hover:text-slate-200 transition-all">Batal</button>
                <button type="submit" class="flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-teal-400 to-cyan-500 text-slate-950 text-sm font-bold hover:brightness-110 transition-all shadow-lg shadow-teal-500/20 cursor-pointer">Terbitkan Jadwal</button>
            </div>
        </form>
    </div>

    {{-- MODAL: EDIT DATA JADWAL --}}
    <div id="editScheduleModal" class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-xl shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 hidden">
        <div class="p-6 border-b border-slate-800 flex justify-between items-center">
            <h3 class="text-xl font-black text-slate-100 flex items-center">
                <i data-lucide="edit-3" class="text-amber-400 mr-2.5 w-5 h-5"></i> Perbarui Jadwal Perjalanan
            </h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-rose-400 transition-colors cursor-pointer"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <form id="editScheduleForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Pilih Rute Operasional <span class="text-rose-500">*</span></label>
                <select name="route_id" id="edit_route_id" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all cursor-pointer">
                    <option value="" disabled>Pilih Rute Operasional</option>
                    @foreach($routes_list as $r)
                        <option value="{{ $r->id }}">{{ $r->kode_rute }} - {{ $r->kota_asal }} ke {{ $r->kota_tujuan }} ({{ $r->simpul_asal }} ➔ {{ $r->simpul_tujuan }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Pilih Armada / Kendaraan <span class="text-rose-500">*</span></label>
                <select name="transportation_id" id="edit_transportation_id" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all cursor-pointer">
                    <option value="" disabled>Pilih Armada / Kendaraan</option>
                    @foreach($transportation_list as $trn)
                        <option value="{{ $trn->id }}">{{ $trn->kode }} - {{ $trn->nama }} ({{ $trn->kelas }})</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Tanggal Keberangkatan <span class="text-rose-500">*</span></label>
                <input id="edit_departure_date" type="date" name="departure_date" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Jam Berangkat <span class="text-rose-500">*</span></label>
                    <input id="edit_departure_time" type="time" name="departure_time" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Estimasi Jam Tiba <span class="text-rose-500">*</span></label>
                    <input id="edit_arrival_time" type="time" name="arrival_time" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Harga Tiket (Rp) <span class="text-rose-500">*</span></label>
                    <input id="edit_price" type="number" name="price" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Total Kuota Kursi <span class="text-rose-500">*</span></label>
                    <input id="edit_total_seats" type="number" name="total_seats" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 pt-4 border-t border-slate-800">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-xl border border-slate-700 bg-slate-800/20 text-slate-400 text-sm font-semibold hover:bg-slate-800/40 hover:text-slate-200 transition-all">Batal</button>
                <button type="submit" class="flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-orange-500 to-red-500 text-white text-sm font-bold hover:brightness-110 transition-all shadow-lg shadow-orange-500/20 cursor-pointer">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- FORM DELETE SEMBUNYI --}}
<form id="deleteScheduleForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
    let activeModal = null;

    function openModal(modalId) {
        const overlay = document.getElementById('modalOverlay');
        const modal = document.getElementById(modalId);
        
        document.getElementById('createScheduleModal').classList.add('hidden');
        document.getElementById('editScheduleModal').classList.add('hidden');
        
        overlay.classList.remove('hidden');
        modal.classList.remove('hidden');
        
        setTimeout(() => {
            overlay.classList.remove('opacity-0');
            modal.classList.remove('scale-95', 'opacity-0');
            modal.classList.add('scale-100', 'opacity-100');
        }, 20);

        activeModal = modal;
    }

    function closeModal() {
        const overlay = document.getElementById('modalOverlay');
        if (activeModal) {
            activeModal.classList.remove('scale-100', 'opacity-100');
            activeModal.classList.add('scale-95', 'opacity-0');
        }
        overlay.classList.add('opacity-0');
        
        setTimeout(() => {
            overlay.classList.add('hidden');
            if (activeModal) activeModal.classList.add('hidden');
            activeModal = null;
        }, 300);
    }

    function openEditModal(id, routeId, transportationId, date, time, arrival, price, seats) {
        document.getElementById('edit_route_id').value = routeId;
        document.getElementById('edit_transportation_id').value = transportationId;
        document.getElementById('edit_departure_date').value = date;
        document.getElementById('edit_departure_time').value = time;
        document.getElementById('edit_arrival_time').value = arrival;
        document.getElementById('edit_price').value = price;
        document.getElementById('edit_total_seats').value = seats;

        document.getElementById('editScheduleForm').action = `/admin/schedule/${id}`;
        openModal('editScheduleModal');
    }

    document.getElementById('modalOverlay').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin membatalkan dan menghapus jadwal keberangkatan ini?')) {
            const deleteForm = document.getElementById('deleteScheduleForm');
            deleteForm.action = `/admin/schedule/${id}`;
            deleteForm.submit();
        }
    }
</script>
@endsection