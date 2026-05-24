@extends('layouts.admin')

@section('title', 'Manajemen Rute Perjalanan')

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
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Rute Perjalanan</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola daftar titik keberangkatan, tujuan, serta harga dasar tiket.</p>
        </div>
        <button onclick="openModal('createRouteModal')" class="bg-primary hover:bg-primaryDark text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition shadow-sm flex items-center">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Rute Baru
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center">
            <div class="w-12 h-12 rounded-full bg-blue-50 text-primary flex items-center justify-center text-xl mr-4 flex-shrink-0">
                <i class="fa-solid fa-route"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Total Rute Terdaftar</p>
                <h3 class="text-xl font-bold text-gray-800">{{ $total_rute }} Rute</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center">
            <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl mr-4 flex-shrink-0">
                <i class="fa-solid fa-city"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Kota yang Terhubung</p>
                <h3 class="text-xl font-bold text-gray-800">{{ $total_kota }} Kota</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center">
            <div class="w-12 h-12 rounded-full bg-orange-50 text-secondary flex items-center justify-center text-xl mr-4 flex-shrink-0">
                <i class="fa-solid fa-fire"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Rute Teraktif</p>
                <h3 class="text-xl font-bold text-gray-800">{{ $rute_teraktif }}</h3>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.routes.index') }}" method="GET" class="bg-white p-4 rounded-t-xl border border-gray-200 border-b-0 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="flex space-x-2 w-full sm:w-auto">
            <select name="filter_asal" onchange="this.form.submit()" class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-primary focus:border-primary block px-3 py-2">
                <option value="">Semua Kota Asal</option>
                @foreach($list_kota_asal as $kota)
                    <option value="{{ $kota }}" {{ request('filter_asal') == $kota ? 'selected' : '' }}>{{ $kota }}</option>
                @endforeach
            </select>
        </div>
        <div class="relative w-full sm:w-72">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full pl-10 p-2" placeholder="Cari rute...">
        </div>
    </form>

    <div class="bg-white rounded-b-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                        <th class="py-3 px-6 font-semibold">ID Rute</th>
                        <th class="py-3 px-6 font-semibold">Keberangkatan (Asal)</th>
                        <th class="py-3 px-6 font-semibold">Tujuan (Ke)</th>
                        <th class="py-3 px-6 font-semibold text-center">Jarak (Est)</th>
                        <th class="py-3 px-6 font-semibold">Tarif Dasar</th>
                        <th class="py-3 px-6 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    @forelse($routes as $route)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-6 font-semibold text-gray-900">{{ $route->kode_rute }}</td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-gray-800">{{ $route->kota_asal }}</p>
                                <p class="text-xs text-gray-500">{{ $route->simpul_asal }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-gray-800">{{ $route->kota_tujuan }}</p>
                                <p class="text-xs text-gray-500">{{ $route->simpul_tujuan }}</p>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <p class="font-semibold text-gray-700">{{ $route->jarak }} km</p>
                                <p class="text-xs text-gray-500">{{ $route->estimasi_jam }} jam {{ $route->estimasi_menit }} m</p>
                            </td>
                            <td class="py-4 px-6 font-bold text-secondary">Rp {{ number_format($route->tarif_dasar, 0, ',', '.') }}</td>
                            <td class="py-4 px-6 text-center">
                                <button onclick="openEditModal('{{ $route->id }}', '{{ $route->kode_rute }}', '{{ $route->kota_asal }}', '{{ $route->simpul_asal }}', '{{ $route->kota_tujuan }}', '{{ $route->simpul_tujuan }}', '{{ $route->jarak }}', '{{ $route->estimasi_jam }}', '{{ $route->estimasi_menit }}', '{{ $route->tarif_dasar }}')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-primary hover:bg-primary hover:text-white transition mx-1" title="Edit">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                                <button onclick="confirmDelete('{{ $route->id }}', '{{ $route->kode_rute }}')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition mx-1" title="Hapus">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-400">
                                <i class="fa-solid fa-folder-open text-3xl mb-2 block"></i>
                                Tidak ada data rute ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $routes->links() }}
        </div>
    </div>
</div>

<div id="modalOverlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    
    <div id="createRouteModal" class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800"><i class="fa-solid fa-circle-plus text-primary mr-2"></i> Tambah Rute Baru</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-red-500 text-xl"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('admin.routes.store') }}" method="POST" class="p-6">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">ID Rute <span class="text-red-500">*</span></label>
                    <input type="text" name="kode_rute" required placeholder="Contoh: RTE-004" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tarif Dasar (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="tarif_dasar" required placeholder="Contoh: 180000" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kota Asal <span class="text-red-500">*</span></label>
                    <input type="text" name="kota_asal" required placeholder="Contoh: Surabaya" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Stasiun / Terminal Asal <span class="text-red-500">*</span></label>
                    <input type="text" name="simpul_asal" required placeholder="Contoh: Stasiun Gubeng (SGU)" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kota Tujuan <span class="text-red-500">*</span></label>
                    <input type="text" name="kota_tujuan" required placeholder="Contoh: Jakarta" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Stasiun / Terminal Tujuan <span class="text-red-500">*</span></label>
                    <input type="text" name="simpul_tujuan" required placeholder="Contoh: Stasiun Pasar Senen (PSE)" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jarak (KM) <span class="text-red-500">*</span></label>
                    <input type="number" name="jarak" required placeholder="Contoh: 780" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Estimasi Durasi Perjalanan <span class="text-red-500">*</span></label>
                    <div class="flex space-x-2">
                        <input type="number" name="estimasi_jam" required placeholder="Jam" class="w-1/2 px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                        <input type="number" name="estimasi_menit" required placeholder="Menit" class="w-1/2 px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                    </div>
                </div>
            </div>
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition text-sm font-medium">Batal</button>
                <button type="submit" class="bg-primary hover:bg-primaryDark text-white px-5 py-2 rounded-lg text-sm font-bold shadow-md transition">Simpan Rute</button>
            </div>
        </form>
    </div>

    <div id="editRouteModal" class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800"><i class="fa-solid fa-pen-to-square text-secondary mr-2"></i> Edit Data Rute</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-red-500 text-xl"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="editRouteForm" method="POST" class="p-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">ID Rute</label>
                    <input id="edit_kode_rute" type="text" readonly class="w-full px-4 py-2 bg-gray-100 border border-gray-200 rounded-lg text-gray-500 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tarif Dasar (Rp) <span class="text-red-500">*</span></label>
                    <input id="edit_tarif" name="tarif_dasar" type="number" required class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kota Asal <span class="text-red-500">*</span></label>
                    <input id="edit_asal" name="kota_asal" type="text" required class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Stasiun / Terminal Asal <span class="text-red-500">*</span></label>
                    <input id="edit_simpul_asal" name="simpul_asal" type="text" required class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kota Tujuan <span class="text-red-500">*</span></label>
                    <input id="edit_tujuan" name="kota_tujuan" type="text" required class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Stasiun / Terminal Tujuan <span class="text-red-500">*</span></label>
                    <input id="edit_simpul_tujuan" name="simpul_tujuan" type="text" required class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jarak (KM) <span class="text-red-500">*</span></label>
                    <input id="edit_jarak" name="jarak" type="number" required class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Estimasi Durasi Perjalanan <span class="text-red-500">*</span></label>
                    <div class="flex space-x-2">
                        <input id="edit_jam" name="estimasi_jam" type="number" required placeholder="Jam" class="w-1/2 px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
                        <input id="edit_menit" name="estimasi_menit" type="number" required placeholder="Menit" class="w-1/2 px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition">
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

        // Set Action Form PUT Update secara dinamis
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