@extends('layouts.admin')

@section('title', 'Manajemen Tiket & Pesanan')

@section('content')
<div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50 pb-24">
    
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-xl flex items-center shadow-sm">
            <i class="fa-solid fa-circle-check text-xl mr-3 text-emerald-500"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Tiket & Pesanan</h1>
        <p class="text-sm text-gray-500 mt-1">Pantau transaksi pembayaran, cetak manifest, dan validasi status tiket penumpang.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center">
            <div class="w-12 h-12 rounded-full bg-blue-50 text-primary flex items-center justify-center text-xl mr-4 flex-shrink-0">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Total Pesanan Masuk</p>
                <h3 class="text-xl font-bold text-gray-800">{{ $total_pesanan }} Transaksi</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center">
            <div class="w-12 h-12 rounded-full bg-orange-50 text-secondary flex items-center justify-center text-xl mr-4 flex-shrink-0">
                <i class="fa-solid fa-spinner animate-spin"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Menunggu Pembayaran</p>
                <h3 class="text-xl font-bold text-gray-800">{{ $pesanan_pending }} Pending</h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center">
            <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl mr-4 flex-shrink-0">
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">Total Omset Pendapatan</p>
                <h3 class="text-xl font-bold text-gray-800">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.orders.index') }}" method="GET" class="bg-white p-4 rounded-t-xl border border-gray-200 border-b-0 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="flex space-x-2 w-full sm:w-auto">
            <select name="status" onchange="this.form.submit()" class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-primary focus:border-primary block px-3 py-2">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </div>
        <div class="relative w-full sm:w-72">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full pl-10 p-2" placeholder="Cari kode tiket atau nama...">
        </div>
    </form>

    <div class="bg-white rounded-b-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                        <th class="py-3 px-6 font-semibold">ID Pesanan</th>
                        <th class="py-3 px-6 font-semibold">Nama Penumpang</th>
                        <th class="py-3 px-6 font-semibold">Rute & Armada</th>
                        <th class="py-3 px-6 text-center font-semibold">Jumlah</th>
                        <th class="py-3 px-6 font-semibold">Total Bayar</th>
                        <th class="py-3 px-6 font-semibold">Status</th>
                        <th class="py-3 px-6 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    @forelse($orders as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-6 font-bold text-gray-900 tracking-wide">{{ $item->order_code }}</td>
                            <td class="py-4 px-6 font-medium text-gray-700">
                                {{ $item->user->name }}
                                <span class="text-xs text-gray-400 font-normal block mt-0.5">{{ $item->user->email }}</span>
                            </td>
                            <td class="py-4 px-6">
                                {{-- Penyesuaian Variabel Baru Rute --}}
                                <p class="font-semibold text-gray-800">
                                    {{ $item->schedule->route->kota_asal }} <i class="fa-solid fa-arrow-right mx-0.5 text-gray-400 text-xs"></i> {{ $item->schedule->route->kota_tujuan }}
                                </p>
                                {{-- Penyesuaian Relasi Langsung dari Schedule ke Transportation --}}
                                <p class="text-xs text-gray-500 mt-0.5">
                                    <i class="fa-solid @if($item->schedule->transportation->jenis == 'kereta') fa-train @elseif($item->schedule->transportation->jenis == 'bus') fa-bus @else fa-plane @endif text-primary text-[10px] mr-0.5"></i> 
                                    {{ $item->schedule->transportation->nama }} ({{ $item->schedule->transportation->kelas }})
                                </p>
                            </td>
                            <td class="py-4 px-6 text-center font-medium">{{ $item->total_passengers }} Pax</td>
                            <td class="py-4 px-6 font-bold text-gray-800">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                            <td class="py-4 px-6">
                                @if($item->status == 'lunas')
                                    <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full border border-green-200">Lunas</span>
                                @elseif($item->status == 'pending')
                                    <span class="bg-orange-100 text-orange-700 text-xs font-bold px-3 py-1 rounded-full border border-orange-200">Pending</span>
                                @else
                                    <span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full border border-red-200">Batal</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <button onclick="openDetailModal('{{ $item->id }}', '{{ $item->order_code }}', '{{ $item->user->name }}', '{{ $item->schedule->route->kota_asal }} ➔ {{ $item->schedule->route->kota_tujuan }}', '{{ $item->schedule->transportation->nama }}', '{{ \Carbon\Carbon::parse($item->schedule->departure_date)->format('d M Y') }}', '{{ substr($item->schedule->departure_time, 0, 5) }} WIB', '{{ $item->total_passengers }} Orang', 'Rp {{ number_format($item->total_price, 0, ',', '.') }}', '{{ $item->status }}')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-primary hover:bg-primary hover:text-white transition mx-1" title="Detail & Validasi">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                                <button onclick="confirmDelete('{{ $item->id }}')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition mx-1" title="Hapus Permanen">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-gray-400">Belum ada riwayat transaksi tiket dari penumpang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $orders->links() }}
        </div>
    </div>
</div>

<div id="modalOverlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    <div id="detailOrderModal" class="bg-white rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 hidden">
        <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800"><i class="fa-solid fa-ticket text-primary mr-2"></i> Detail Transaksi & Manifest</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-red-500 text-xl"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="updateStatusForm" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-3.5 mb-6 text-sm border-b pb-5 border-gray-100">
                <div class="flex justify-between"><span class="text-gray-400">Kode Tiket</span><span id="md_code" class="font-bold text-gray-900"></span></div>
                <div class="flex justify-between"><span class="text-gray-400">Nama Pemesan</span><span id="md_name" class="font-semibold text-gray-800"></span></div>
                <div class="flex justify-between"><span class="text-gray-400">Jalur Operasional</span><span id="md_route" class="font-semibold text-gray-800"></span></div>
                <div class="flex justify-between"><span class="text-gray-400">Armada Angkutan</span><span id="md_transport" class="text-gray-700"></span></div>
                <div class="flex justify-between"><span class="text-gray-400">Tanggal Keberangkatan</span><span id="md_date" class="text-gray-700"></span></div>
                <div class="flex justify-between"><span class="text-gray-400">Jam Operasional</span><span id="md_time" class="text-gray-700"></span></div>
                <div class="flex justify-between"><span class="text-gray-400">Kuantitas Kursi</span><span id="md_pax" class="font-medium text-gray-800"></span></div>
                <div class="flex justify-between border-t pt-3 mt-2"><span class="text-gray-500 font-bold">Total Pembayaran</span><span id="md_total" class="font-extrabold text-secondary text-base"></span></div>
            </div>

            <div class="mb-6 bg-blue-50/50 p-4 rounded-xl border border-blue-100">
                <label class="block text-xs font-bold text-primary uppercase tracking-wide mb-2">Validasi Status Pembayaran</label>
                <select id="md_status_select" name="status" required class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary font-semibold text-gray-700">
                    <option value="pending">Pending (Belum Bayar)</option>
                    <option value="lunas">Lunas (E-Ticket Terbit)</option>
                    <option value="dibatalkan">Dibatalkan (Kembalikan Kuota Kursi)</option>
                </select>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-500 hover:bg-gray-100 rounded-lg text-sm font-medium transition">Tutup</button>
                <button type="submit" class="bg-primary hover:bg-primaryDark text-white px-5 py-2 rounded-lg text-sm font-bold shadow-md transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

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