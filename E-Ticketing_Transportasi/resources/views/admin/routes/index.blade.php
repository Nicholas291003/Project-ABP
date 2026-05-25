@extends('layouts.admin')

@section('title', 'Manajemen Rute Perjalanan - Travelgo')

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
            <h1 class="text-3xl font-black text-white tracking-tight">Manajemen Rute</h1>
            <p class="text-sm text-slate-400 mt-1">Kelola daftar titik keberangkatan, stasiun/terminal tujuan, serta harga dasar tiket.</p>
        </div>
        <button onclick="openModal('createRouteModal')" class="flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-teal-400 to-cyan-500 text-slate-950 text-sm font-bold hover:brightness-110 transition-all shadow-lg shadow-teal-500/20 cursor-pointer">
            <i data-lucide="plus" class="w-4.5 h-4.5 stroke-[3px]"></i>
            <span>Tambah Rute Baru</span>
        </button>
    </div>

    {{-- Tiga Kartu Indikator Statistik (Luminescent) --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 p-5 rounded-2xl flex items-center hover:border-teal-500/30 transition-all duration-300">
            <div class="w-12 h-12 rounded-xl bg-teal-500/10 border border-teal-500/20 flex items-center justify-center text-teal-400 mr-4">
                <i data-lucide="route" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Total Rute Terdaftar</p>
                <h3 class="text-xl font-black text-slate-100 mt-0.5">{{ $total_rute }} Rute</h3>
            </div>
        </div>
        <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 p-5 rounded-2xl flex items-center hover:border-indigo-500/30 transition-all duration-300">
            <div class="w-12 h-12 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 mr-4">
                <i data-lucide="building-2" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Kota Terhubung</p>
                <h3 class="text-xl font-black text-slate-100 mt-0.5">{{ $total_kota }} Kota</h3>
            </div>
        </div>
        <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 p-5 rounded-2xl flex items-center hover:border-amber-500/30 transition-all duration-300">
            <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 mr-4">
                <i data-lucide="zap" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Rute Teraktif</p>
                <h3 class="text-xl font-black text-slate-100 mt-0.5 truncate max-w-[180px]">{{ $rute_teraktif }}</h3>
            </div>
        </div>
    </div>

    {{-- Form Pencarian & Filter Bilah Kaca --}}
    <form action="{{ route('admin.routes.index') }}" method="GET" class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 p-4 rounded-t-2xl flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="flex space-x-2 w-full sm:w-auto">
            <select name="filter_asal" onchange="this.form.submit()" class="bg-slate-900 border border-slate-800 text-slate-300 text-sm rounded-xl focus:outline-none focus:border-teal-400 px-3 py-2 transition-all cursor-pointer">
                <option value="">Semua Kota Asal</option>
                @foreach($list_kota_asal as $kota)
                    <option value="{{ $kota }}" {{ request('filter_asal') == $kota ? 'selected' : '' }}>{{ $kota }}</option>
                @endforeach
            </select>
        </div>
        <div class="relative w-full sm:w-72">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-500">
                <i data-lucide="search" class="w-4 h-4"></i>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" class="w-full bg-slate-900 border border-slate-800 rounded-xl text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-teal-400 pl-10 p-2.5 transition-all" placeholder="Cari rute...">
        </div>
    </form>

    {{-- Wadah Utama Tabel Konten --}}
    <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 rounded-b-2xl overflow-hidden shadow-xl shadow-black/10">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-950/20 text-[11px] text-slate-500 font-extrabold uppercase tracking-widest border-b border-slate-800">
                        <th class="py-4 px-6">ID Rute</th>
                        <th class="py-4 px-6">Keberangkatan (Asal)</th>
                        <th class="py-4 px-6">Tujuan (Ke)</th>
                        <th class="py-4 px-6 text-center">Jarak (Est)</th>
                        <th class="py-4 px-6">Tarif Dasar</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-800/40">
                    @forelse($routes as $route)
                        <tr class="text-slate-300 hover:bg-slate-900/30 transition group">
                            <td class="py-4 px-6 font-bold text-slate-200 group-hover:text-teal-400 transition-colors">{{ $route->kode_rute }}</td>
                            <td class="py-4 px-6">
                                <p class="font-black text-slate-200">{{ $route->kota_asal }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $route->simpul_asal }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-black text-slate-200">{{ $route->kota_tujuan }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $route->simpul_tujuan }}</p>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <p class="font-bold text-slate-200">{{ $route->jarak }} km</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $route->estimasi_jam }} jam {{ $route->estimasi_menit }} m</p>
                            </td>
                            <td class="py-4 px-6 font-extrabold text-amber-400">Rp {{ number_format($route->tarif_dasar, 0, ',', '.') }}</td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button onclick="openEditModal('{{ $route->id }}', '{{ $route->kode_rute }}', '{{ $route->kota_asal }}', '{{ $route->simpul_asal }}', '{{ $route->kota_tujuan }}', '{{ $route->simpul_tujuan }}', '{{ $route->jarak }}', '{{ $route->estimasi_jam }}', '{{ $route->estimasi_menit }}', '{{ $route->tarif_dasar }}')" class="p-2 rounded-lg bg-slate-900 border border-slate-800 text-slate-400 hover:text-teal-400 hover:border-teal-400 transition-all inline-flex items-center cursor-pointer" title="Edit Rute">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </button>
                                    <button onclick="confirmDelete('{{ $route->id }}', '{{ $route->kode_rute }}')" class="p-2 rounded-lg bg-slate-900 border border-slate-800 text-slate-400 hover:text-rose-400 hover:border-rose-400 transition-all inline-flex items-center cursor-pointer" title="Hapus Rute">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500 font-medium">
                                <i data-lucide="folder-open" class="w-10 h-10 mx-auto mb-3 text-slate-600"></i>
                                Tidak ada data rute perjalanan yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Gelap --}}
        <div class="px-6 py-4 border-t border-slate-800/60 bg-slate-950/20">
            {{ $routes->links() }}
        </div>
    </div>
</div>

{{-- OVERLAY MODAL GLOBAL --}}
<div id="modalOverlay" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    
    {{-- MODAL: TAMBAH RUTE BARU --}}
    <div id="createRouteModal" class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-2xl shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 hidden">
        <div class="p-6 border-b border-slate-800 flex justify-between items-center">
            <h3 class="text-xl font-black text-slate-100 flex items-center">
                <i data-lucide="plus-circle" class="text-teal-400 mr-2.5 w-5 h-5"></i> Tambah Rute Baru
            </h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-rose-400 transition-colors cursor-pointer"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <form action="{{ route('admin.routes.store') }}" method="POST" class="p-6 space-y-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">ID Rute <span class="text-rose-500">*</span></label>
                    <input type="text" name="kode_rute" required placeholder="Contoh: RTE-004" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Tarif Dasar (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" name="tarif_dasar" required placeholder="Contoh: 180000" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Kota Asal <span class="text-rose-500">*</span></label>
                    <input type="text" name="kota_asal" required placeholder="Contoh: Surabaya" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Stasiun / Terminal Asal <span class="text-rose-500">*</span></label>
                    <input type="text" name="simpul_asal" required placeholder="Contoh: Stasiun Gubeng (SGU)" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Kota Tujuan <span class="text-rose-500">*</span></label>
                    <input type="text" name="kota_tujuan" required placeholder="Contoh: Jakarta" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Stasiun / Terminal Tujuan <span class="text-rose-500">*</span></label>
                    <input type="text" name="simpul_tujuan" required placeholder="Contoh: Stasiun Pasar Senen (PSE)" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Jarak (KM) <span class="text-rose-500">*</span></label>
                    <input type="number" name="jarak" required placeholder="Contoh: 780" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Estimasi Durasi Perjalanan <span class="text-rose-500">*</span></label>
                    <div class="flex space-x-3">
                        <input type="number" name="estimasi_jam" required placeholder="Jam" class="w-1/2 bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                        <input type="number" name="estimasi_menit" required placeholder="Menit" class="w-1/2 bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                    </div>
                </div>
            </div>
            <div class="flex justify-end space-x-3 pt-4 border-t border-slate-800">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-xl border border-slate-700 bg-slate-800/20 text-slate-400 text-sm font-semibold hover:bg-slate-800/40 hover:text-slate-200 transition-all">Batal</button>
                <button type="submit" class="flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-teal-400 to-cyan-500 text-slate-950 text-sm font-bold hover:brightness-110 transition-all shadow-lg shadow-teal-500/20 cursor-pointer">Simpan Rute</button>
            </div>
        </form>
    </div>

    {{-- MODAL: EDIT DATA RUTE --}}
    <div id="editRouteModal" class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-2xl shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 hidden">
        <div class="p-6 border-b border-slate-800 flex justify-between items-center">
            <h3 class="text-xl font-black text-slate-100 flex items-center">
                <i data-lucide="edit-3" class="text-amber-400 mr-2.5 w-5 h-5"></i> Edit Data Rute
            </h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-rose-400 transition-colors cursor-pointer"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <form id="editRouteForm" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">ID Rute (Read Only)</label>
                    <input id="edit_kode_rute" type="text" readonly class="w-full bg-slate-950/60 border border-slate-800 text-slate-500 rounded-xl px-4 py-2.5 text-sm cursor-not-allowed outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Tarif Dasar (Rp) <span class="text-rose-500">*</span></label>
                    <input id="edit_tarif" name="tarif_dasar" type="number" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 tracking-wider mb-2">Kota Asal <span class="text-rose-500">*</span></label>
                    <input id="edit_asal" name="kota_asal" type="text" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Stasiun / Terminal Asal <span class="text-rose-500">*</span></label>
                    <input id="edit_simpul_asal" name="simpul_asal" type="text" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Kota Tujuan <span class="text-rose-500">*</span></label>
                    <input id="edit_tujuan" name="kota_tujuan" type="text" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Stasiun / Terminal Tujuan <span class="text-rose-500">*</span></label>
                    <input id="edit_simpul_tujuan" name="simpul_tujuan" type="text" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Jarak (KM) <span class="text-rose-500">*</span></label>
                    <input id="edit_jarak" name="jarak" type="number" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Estimasi Durasi Perjalanan <span class="text-rose-500">*</span></label>
                    <div class="flex space-x-3">
                        <input id="edit_jam" name="estimasi_jam" type="number" required placeholder="Jam" class="w-1/2 bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                        <input id="edit_menit" name="estimasi_menit" type="number" required placeholder="Menit" class="w-1/2 bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                    </div>
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
<form id="deleteRouteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
    let activeModal = null;

    function openModal(modalId) {
        const overlay = document.getElementById('modalOverlay');
        const modal = document.getElementById(modalId);
        
        document.getElementById('createRouteModal').classList.add('hidden');
        document.getElementById('editRouteModal').classList.add('hidden');
        
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

    function openEditModal(id, kodeRute, asal, simpulAsal, tujuan, simpulTujuan, jarak, jam, menit, tarif) {
        document.getElementById('edit_kode_rute').value = kodeRute;
        document.getElementById('edit_asal').value = asal;
        document.getElementById('edit_simpul_asal').value = simpulAsal;
        document.getElementById('edit_tujuan').value = tujuan;
        document.getElementById('edit_simpul_tujuan').value = simpulTujuan;
        document.getElementById('edit_jarak').value = jarak;
        document.getElementById('edit_jam').value = jam;
        document.getElementById('edit_menit').value = menit;
        document.getElementById('edit_tarif').value = tarif;

        document.getElementById('editRouteForm').action = `/admin/routes/${id}`;

        openModal('editRouteModal');
    }

    document.getElementById('modalOverlay').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    function confirmDelete(id, kodeRute) {
        if (confirm(`Apakah Anda yakin ingin menghapus rute ${kodeRute}?`)) {
            const deleteForm = document.getElementById('deleteRouteForm');
            deleteForm.action = `/admin/routes/${id}`;
            deleteForm.submit();
        }
    }
</script>
@endsection