@extends('layouts.admin')

@section('title', 'Manajemen Tiket & Pesanan - Travelgo')

@section('content')
<div class="p-8 space-y-8 flex-1">
    
    {{-- Notifikasi Sukses Bergaya Kaca --}}
    @if(session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-xl flex items-center shadow-lg shadow-black/10">
            <i data-lucide="check-circle" class="mr-2.5 w-5 h-5"></i>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Atas Halaman --}}
    <div>
        <h1 class="text-3xl font-black text-white tracking-tight">Manajemen Tiket & Pesanan</h1>
        <p class="text-sm text-slate-400 mt-1">Pantau transaksi pembayaran, cetak manifest, dan lakukan validasi status tiket penumpang.</p>
    </div>

    {{-- Tiga Kartu Indikator Transaksi (Luminescent) --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 p-5 rounded-2xl flex items-center hover:border-teal-500/30 transition-all duration-300">
            <div class="w-12 h-12 rounded-xl bg-teal-500/10 border border-teal-500/20 flex items-center justify-center text-teal-400 mr-4 flex-shrink-0">
                <i data-lucide="receipt" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Total Pesanan Masuk</p>
                <h3 class="text-xl font-black text-slate-100 mt-0.5">{{ $total_pesanan }} Transaksi</h3>
            </div>
        </div>
        <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 p-5 rounded-2xl flex items-center hover:border-amber-500/30 transition-all duration-300">
            <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 mr-4 flex-shrink-0">
                <i data-lucide="loader-2" class="w-6 h-6 animate-spin"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Menunggu Pembayaran</p>
                <h3 class="text-xl font-black text-slate-100 mt-0.5">{{ $pesanan_pending }} Pending</h3>
            </div>
        </div>
        <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 p-5 rounded-2xl flex items-center hover:border-emerald-500/30 transition-all duration-300">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 mr-4 flex-shrink-0">
                <i data-lucide="banknote" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Total Omset Pendapatan</p>
                <h3 class="text-xl font-black text-slate-100 mt-0.5">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    {{-- Form Pencarian & Filter Status --}}
    <form action="{{ route('admin.orders.index') }}" method="GET" class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 p-4 rounded-t-2xl flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="flex space-x-2 w-full sm:w-auto">
            <select name="status" onchange="this.form.submit()" class="bg-slate-900 border border-slate-800 text-slate-300 text-sm rounded-xl focus:outline-none focus:border-teal-400 px-3 py-2 transition-all cursor-pointer">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </div>
        <div class="relative w-full sm:w-72">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-500">
                <i data-lucide="search" class="w-4 h-4"></i>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" class="w-full bg-slate-900 border border-slate-800 rounded-xl text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-teal-400 pl-10 p-2.5 transition-all" placeholder="Cari kode tiket atau nama...">
        </div>
    </form>

    {{-- Wadah Utama Tabel Konten --}}
    <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 rounded-b-2xl overflow-hidden shadow-xl shadow-black/10">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-950/20 text-[11px] text-slate-500 font-extrabold uppercase tracking-widest border-b border-slate-800">
                        <th class="py-4 px-6">ID Pesanan</th>
                        <th class="py-4 px-6">Nama Penumpang</th>
                        <th class="py-4 px-6">Rute & Armada</th>
                        <th class="py-4 px-6 text-center">Jumlah</th>
                        <th class="py-4 px-6">Total Bayar</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-800/40">
                    @forelse($orders as $item)
                        <tr class="text-slate-300 hover:bg-slate-900/30 transition group">
                            <td class="py-4 px-6 font-bold text-slate-200 group-hover:text-teal-400 tracking-wide transition-colors">{{ $item->order_code }}</td>
                            <td class="py-4 px-6">
                                <p class="font-semibold text-slate-200">{{ $item->user->name }}</p>
                                <p class="text-xs text-slate-500 mt-0.5 font-medium">{{ $item->user->email }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-200 flex items-center">
                                    <span>{{ $item->schedule->route->kota_asal }}</span> 
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 mx-1 text-slate-500"></i> 
                                    <span>{{ $item->schedule->route->kota_tujuan }}</span>
                                </p>
                                <p class="text-xs text-slate-400 mt-1 font-medium flex items-center">
                                    @if($item->schedule->transportation->jenis == 'kereta')
                                        <i data-lucide="train" class="text-teal-400 w-3.5 h-3.5 mr-1"></i>
                                    @elseif($item->schedule->transportation->jenis == 'bus')
                                        <i data-lucide="bus" class="text-teal-400 w-3.5 h-3.5 mr-1"></i>
                                    @else
                                        <i data-lucide="plane-takeoff" class="text-teal-400 w-3.5 h-3.5 mr-1"></i>
                                    @endif
                                    {{ $item->schedule->transportation->nama }} <span class="text-slate-500 mx-1">|</span> {{ $item->schedule->transportation->kelas }}
                                </p>
                            </td>
                            <td class="py-4 px-6 text-center font-bold text-slate-300">{{ $item->total_passengers }} Pax</td>
                            <td class="py-4 px-6 font-extrabold text-slate-200">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                            <td class="py-4 px-6">
                                @if($item->status == 'lunas')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Lunas</span>
                                @elseif($item->status == 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20 animate-pulse">Pending</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-500/10 text-rose-400 border border-rose-500/20">Batal</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button onclick="openDetailModal('{{ $item->id }}', '{{ $item->order_code }}', '{{ $item->user->name }}', '{{ $item->schedule->route->kota_asal }} ➔ {{ $item->schedule->route->kota_tujuan }}', '{{ $item->schedule->transportation->nama }}', '{{ \Carbon\Carbon::parse($item->schedule->departure_date)->format('d M Y') }}', '{{ substr($item->schedule->departure_time, 0, 5) }} WIB', '{{ $item->total_passengers }} Orang', 'Rp {{ number_format($item->total_price, 0, ',', '.') }}', '{{ $item->status }}')" class="p-2 rounded-lg bg-slate-900 border border-slate-800 text-slate-400 hover:text-teal-400 hover:border-teal-400 transition-all inline-flex items-center cursor-pointer" title="Detail & Validasi">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </button>
                                    <button onclick="confirmDelete('{{ $item->id }}')" class="p-2 rounded-lg bg-slate-900 border border-slate-800 text-slate-400 hover:text-rose-400 hover:border-rose-400 transition-all inline-flex items-center cursor-pointer" title="Hapus Permanen">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-500 font-medium">
                                <i data-lucide="folder-x" class="w-10 h-10 mx-auto mb-3 text-slate-600"></i>
                                Belum ada riwayat transaksi tiket dari penumpang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Paginasi Kontrol Gelap --}}
        <div class="px-6 py-4 border-t border-slate-800/60 bg-slate-950/20">
            {{ $orders->links() }}
        </div>
    </div>
</div>

{{-- OVERLAY MODAL MANIFEST GLOBAL --}}
<div id="modalOverlay" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    <div id="detailOrderModal" class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 hidden">
        
        <div class="p-5 border-b border-slate-800 flex justify-between items-center bg-slate-950/20">
            <h3 class="text-lg font-black text-slate-100 flex items-center">
                <i data-lucide="ticket" class="text-teal-400 mr-2.5 w-5 h-5"></i> Detail Transaksi & Manifest
            </h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-rose-400 transition-colors cursor-pointer"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        
        <form id="updateStatusForm" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-3.5 text-sm border-b pb-5 border-slate-800/60">
                <div class="flex justify-between"><span class="text-slate-400 font-medium">Kode Tiket</span><span id="md_code" class="font-bold text-slate-100"></span></div>
                <div class="flex justify-between"><span class="text-slate-400 font-medium">Nama Pemesan</span><span id="md_name" class="font-semibold text-slate-200"></span></div>
                <div class="flex justify-between"><span class="text-slate-400 font-medium">Jalur Operasional</span><span id="md_route" class="font-semibold text-slate-200"></span></div>
                <div class="flex justify-between"><span class="text-slate-400 font-medium">Armada Angkutan</span><span id="md_transport" class="text-slate-300 font-medium"></span></div>
                <div class="flex justify-between"><span class="text-slate-400 font-medium">Tanggal Keberangkatan</span><span id="md_date" class="text-slate-300 font-medium"></span></div>
                <div class="flex justify-between"><span class="text-slate-400 font-medium">Jam Operasional</span><span id="md_time" class="text-slate-300 font-medium"></span></div>
                <div class="flex justify-between"><span class="text-slate-400 font-medium">Kuantitas Kursi</span><span id="md_pax" class="font-bold text-slate-200"></span></div>
                <div class="flex justify-between border-t border-slate-800 pt-3.5 mt-2"><span class="text-slate-400 font-black">Total Pembayaran</span><span id="md_total" class="font-black text-amber-400 text-lg"></span></div>
            </div>

            <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-800">
                <label class="block text-xs font-bold text-teal-400 uppercase tracking-wider mb-2">Validasi Status Pembayaran</label>
                <select id="md_status_select" name="status" required class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2.5 font-bold text-slate-200 focus:outline-none focus:border-teal-400 cursor-pointer transition-all">
                    <option value="pending">Pending (Belum Bayar)</option>
                    <option value="lunas">Lunas (E-Ticket Terbit)</option>
                    <option value="dibatalkan">Dibatalkan (Kembalikan Kuota Kursi)</option>
                </select>
            </div>

            <div class="flex justify-end space-x-2 pt-2 border-t border-slate-800">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-xl border border-slate-700 bg-slate-800/20 text-slate-400 text-sm font-semibold hover:bg-slate-800/40 hover:text-slate-200 transition-all">Tutup</button>
                <button type="submit" class="flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-teal-400 to-cyan-500 text-slate-950 text-sm font-bold hover:brightness-110 transition-all shadow-lg shadow-teal-500/20 cursor-pointer">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- FORM DELETE SEMBUNYI --}}
<form id="deleteOrderForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
    let activeModal = null;

    function openModal(modalId) {
        const overlay = document.getElementById('modalOverlay');
        const modal = document.getElementById(modalId);
        
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

    function openDetailModal(id, code, name, route, transport, date, time, pax, total, status) {
        document.getElementById('md_code').innerText = code;
        document.getElementById('md_name').innerText = name;
        document.getElementById('md_route').innerText = route;
        document.getElementById('md_transport').innerText = transport;
        document.getElementById('md_date').innerText = date;
        document.getElementById('md_time').innerText = time;
        document.getElementById('md_pax').innerText = pax;
        document.getElementById('md_total').innerText = total;
        document.getElementById('md_status_select').value = status;

        document.getElementById('updateStatusForm').action = `/admin/orders/${id}`;
        openModal('detailOrderModal');
    }

    document.getElementById('modalOverlay').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus data riwayat pesanan ini secara permanen?')) {
            const deleteForm = document.getElementById('deleteOrderForm');
            deleteForm.action = `/admin/orders/${id}`;
            deleteForm.submit();
        }
    }
</script>
@endsection