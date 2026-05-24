@extends('layouts.admin')

@section('title', 'Manajemen Jadwal Keberangkatan')

@section('content')
<div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50 pb-24">
    
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-xl flex items-center shadow-sm">
            <i class="fa-solid fa-circle-check text-xl mr-3 text-emerald-500"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Jadwal Perjalanan</h1>
            <p class="text-sm text-gray-500 mt-1">Atur tanggal, jam operasional, kapasitas kursi, dan harga tiket rute aktif.</p>
        </div>
        <button onclick="openModal('createScheduleModal')" class="bg-primary hover:bg-primaryDark text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition shadow-sm flex items-center">
            <i class="fa-solid fa-plus mr-2"></i> Buat Jadwal Baru
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center">
            <div class="w-12 h-12 rounded-full bg-blue-50 text-primary flex items-center justify-center text-xl mr-4 flex-shrink-0">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Total Jadwal Aktif</p>
                <h3 class="text-xl font-bold text-gray-800">{{ $total_jadwal }} Jadwal</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center">
            <div class="w-12 h-12 rounded-full bg-orange-50 text-secondary flex items-center justify-center text-xl mr-4 flex-shrink-0">
                <i class="fa-solid fa-business-time"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Berangkat Hari Ini</p>
                <h3 class="text-xl font-bold text-gray-800">{{ $jadwal_hari_ini }} Armada</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center">
            <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl mr-4 flex-shrink-0">
                <i class="fa-solid fa-chair"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Kursi yang sudah dipesan</p>
                <h3 class="text-xl font-bold text-gray-800">{{ $total_kursi_terjual }} Kursi</h3>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.schedule.index') }}" method="GET" class="bg-white p-4 rounded-t-xl border border-gray-200 border-b-0 flex flex-col sm:flex-row justify-between items-center gap-4">
        
        <div class="flex items-center space-x-2 w-full sm:w-auto">
            <select name="status_waktu" onchange="this.form.submit()" class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-primary focus:border-primary block px-3 py-2 font-medium">
                <option value="">Semua Status Waktu</option>
                <option value="upcoming" {{ request('status_waktu') == 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
                <option value="past" {{ request('status_waktu') == 'past' ? 'selected' : '' }}>Sudah Terlewat</option>
            </select>
        </div>

        <div class="relative w-full sm:w-72">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" onchange="this.form.submit()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full pl-10 p-2" placeholder="Cari armada atau kota...">
        </div>
    </form>

    <div class="bg-white rounded-b-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                        <th class="py-3 px-6 font-semibold">Armada / Jenis</th>
                        <th class="py-3 px-6 font-semibold">Rute Perjalanan</th>
                        <th class="py-3 px-6 font-semibold">Waktu Keberangkatan</th>
                        <th class="py-3 px-6 font-semibold text-center">Sisa Kursi</th>
                        <th class="py-3 px-6 font-semibold">Harga Tiket</th>
                        <th class="py-3 px-6 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    @forelse($schedules as $item)
                        @php
                            $departureDateTime = \Carbon\Carbon::parse($item->departure_date . ' ' . $item->departure_time);
                            $isPast = $departureDateTime->isPast();
                        @endphp
                        
                        <tr class="transition {{ $isPast ? 'bg-gray-100/70 opacity-60 select-none' : 'hover:bg-gray-50' }}">
                            <td class="py-4 px-6">
                                <p class="font-bold {{ $isPast ? 'text-gray-400 line-through' : 'text-gray-800' }}">{{ $item->transportation->nama }}</p>
                                <span class="text-[11px] {{ $isPast ? 'bg-gray-200 text-gray-500' : 'bg-slate-100 text-slate-600' }} px-2 py-0.5 rounded font-medium capitalize">
                                    {{ $item->transportation->jenis }} ({{ $item->transportation->kelas }})
                                </span>
                            </td>
                            
                            <td class="py-4 px-6">
                                <p class="font-semibold {{ $isPast ? 'text-gray-400' : 'text-gray-800' }}">
                                    {{ $item->route->kota_asal }} <span class="text-xs font-normal text-gray-400">({{ $item->route->simpul_asal }})</span>
                                    <i class="fa-solid fa-arrow-right mx-1 text-gray-400 text-xs"></i>
                                    {{ $item->route->kota_tujuan }} <span class="text-xs font-normal text-gray-400">({{ $item->route->simpul_tujuan }})</span>
                                </p>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    <span class="font-medium {{ $isPast ? 'text-gray-400' : 'text-gray-600' }}">{{ $item->route->kode_rute }}</span> 
                                    ({{ $item->route->estimasi_jam }}j {{ $item->route->estimasi_menit }}m | {{ $item->route->jarak }} KM)
                                </p>
                            </td>
                            
                            <td class="py-4 px-6">
                                <p class="font-medium {{ $isPast ? 'text-gray-400' : 'text-gray-800' }}">{{ \Carbon\Carbon::parse($item->departure_date)->format('d M Y') }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    <i class="fa-regular fa-clock text-[11px] mr-0.5"></i> 
                                    {{ substr($item->departure_time, 0, 5) }} - {{ substr($item->arrival_time, 0, 5) }}
                                </p>
                                
                                @if($isPast)
                                    <span class="text-[10px] bg-gray-200 text-gray-600 border border-gray-300 px-2 py-0.5 rounded font-bold block w-max mt-1.5 uppercase tracking-wide">
                                        <i class="fa-solid fa-calendar-xmark mr-1"></i> Jadwal Terlewat
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <p class="font-bold {{ $isPast ? 'text-gray-400' : ($item->remaining_seats == 0 ? 'text-red-500' : 'text-gray-700') }}">{{ $item->remaining_seats }} / {{ $item->total_seats }}</p>
                                <div class="w-20 bg-gray-200 h-1.5 rounded-full mx-auto mt-1 overflow-hidden">
                                    <div class="h-full {{ $isPast ? 'bg-gray-400' : 'bg-primary' }}" style="width: {{ ($item->remaining_seats / $item->total_seats) * 100 }}%"></div>
                                </div>
                            </td>
                            <td class="py-4 px-6 font-bold {{ $isPast ? 'text-gray-400' : 'text-secondary' }}">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="py-4 px-6 text-center">
                                @if(!$isPast)
                                    <button onclick="openEditModal('{{ $item->id }}', '{{ $item->route_id }}', '{{ $item->departure_date }}', '{{ $item->departure_time }}', '{{ $item->arrival_time }}', '{{ $item->price }}', '{{ $item->total_seats }}')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-primary hover:bg-primary hover:text-white transition mx-1" title="Edit">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                @endif
                                <button onclick="confirmDelete('{{ $item->id }}')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition mx-1" title="Hapus">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-400">Belum ada jadwal keberangkatan yang diterbitkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $schedules->links() }}
        </div>
    </div>
</div>

<div id="modalOverlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    
    <div id="createScheduleModal" class="bg-white rounded-2xl w-full max-w-xl shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800"><i class="fa-solid fa-circle-plus text-primary mr-2"></i> Terbitkan Jadwal Baru</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-red-500 text-xl"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('admin.schedule.store') }}" method="POST" class="p-6">
            @csrf
            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Pilih Rute Operasional <span class="text-red-500">*</span></label>
                    <select name="route_id" required class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                        <option value="" disabled selected>Pilih Rute Operasional</option>
                        @foreach($routes_list as $r)
                            <option value="{{ $r->id }}">{{ $r->kode_rute }} - {{ $r->kota_asal }} ke {{ $r->kota_tujuan }} ({{ $r->simpul_asal }} ➔ {{ $r->simpul_tujuan }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Pilih Armada / Kendaraan <span class="text-red-500">*</span></label>
                    <select name="transportation_id" required class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                        <option value="" disabled selected>Pilih Armada / Kendaraan</option>
                        @foreach($transportation_list as $trn)
                            <option value="{{ $trn->id }}">{{ $trn->kode }} - {{ $trn->nama }} ({{ $trn->kelas }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Keberangkatan <span class="text-red-500">*</span></label>
                    <input type="date" name="departure_date" required min="{{ date('Y-m-d') }}" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jam Berangkat <span class="text-red-500">*</span></label>
                        <input type="time" name="departure_time" required class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Estimasi Jam Tiba <span class="text-red-500">*</span></label>
                        <input type="time" name="arrival_time" required class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Harga Tiket (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="price" required placeholder="Contoh: 250000" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Total Kuota Kursi <span class="text-red-500">*</span></label>
                        <input type="number" name="total_seats" required placeholder="Contoh: 50" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                    </div>
                </div>
            </div>
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition text-sm font-medium">Batal</button>
                <button type="submit" class="bg-primary hover:bg-primaryDark text-white px-5 py-2 rounded-lg text-sm font-bold shadow-md transition">Terbitkan Jadwal</button>
            </div>
        </form>
    </div>

    <div id="editScheduleModal" class="bg-white rounded-2xl w-full max-w-xl shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800"><i class="fa-solid fa-pen-to-square text-secondary mr-2"></i> Perbarui Jadwal</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-red-500 text-xl"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="editScheduleForm" method="POST" class="p-6">
            @csrf
            @method('PUT')
            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Pilih Rute Operasional <span class="text-red-500">*</span></label>
                    <select name="route_id" id="edit_route_id" required class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                        <option value="" disabled>Pilih Rute Operasional</option>
                        @foreach($routes_list as $r)
                            <option value="{{ $r->id }}">{{ $r->kode_rute }} - {{ $r->kota_asal }} ke {{ $r->kota_tujuan }} ({{ $r->simpul_asal }} ➔ {{ $r->simpul_tujuan }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Pilih Armada / Kendaraan <span class="text-red-500">*</span></label>
                    <select name="transportation_id" id="edit_transportation_id" required class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                        <option value="" disabled>Pilih Armada / Kendaraan</option>
                        @foreach($transportation_list as $trn)
                            <option value="{{ $trn->id }}">{{ $trn->kode }} - {{ $trn->nama }} ({{ $trn->kelas }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Keberangkatan <span class="text-red-500">*</span></label>
                    <input id="edit_departure_date" type="date" name="departure_date" required class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jam Berangkat <span class="text-red-500">*</span></label>
                        <input id="edit_departure_time" type="time" name="departure_time" required class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Estimasi Jam Tiba <span class="text-red-500">*</span></label>
                        <input id="edit_arrival_time" type="time" name="arrival_time" required class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Harga Tiket (Rp) <span class="text-red-500">*</span></label>
                        <input id="edit_price" type="number" name="price" required class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Total Kuota Kursi <span class="text-red-500">*</span></label>
                        <input id="edit_total_seats" type="number" name="total_seats" required class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                    </div>
                </div>
            </div>
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition text-sm font-medium">Batal</button>
                <button type="submit" class="bg-secondary hover:bg-secondaryDark text-white px-5 py-2 rounded-lg text-sm font-bold shadow-md transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

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

        document.getElementById('editScheduleForm').action = `/admin/schedules/${id}`;
        openModal('editScheduleModal');
    }

    document.getElementById('modalOverlay').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin membatalkan dan menghapus jadwal keberangkatan ini?')) {
            const deleteForm = document.getElementById('deleteScheduleForm');
            deleteForm.action = `/admin/schedules/${id}`;
            deleteForm.submit();
        }
    }
</script>
@endsection