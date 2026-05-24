@extends('layouts.admin')

@section('content')
<div class="flex-1 overflow-y-auto p-6 lg:p-8 bg-gray-50 pb-24">
    
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-xl flex items-center">
            <i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Transportasi</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola data seluruh armada kendaraan yang tersedia.</p>
        </div>
        <a href="{{ route('admin.transportations.create') }}" class="bg-primary hover:bg-primaryDark text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition shadow-sm flex items-center">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Armada
        </a>
    </div>

    <div class="bg-white p-4 rounded-t-xl border border-gray-200 border-b-0 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="flex space-x-2 w-full sm:w-auto">
            <select class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-primary focus:border-primary block px-3 py-2">
                <option value="">Semua Jenis</option>
                <option value="kereta">Kereta Api</option>
                <option value="bus">Bus / Travel</option>
                <option value="pesawat">Pesawat</option>
            </select>
        </div>
        <div class="relative w-full sm:w-72">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
            </div>
            <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full pl-10 p-2" placeholder="Cari nama atau kode...">
        </div>
    </div>

    <div class="bg-white rounded-b-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                        <th class="py-3 px-6 font-semibold">Kode</th>
                        <th class="py-3 px-6 font-semibold">Nama Transportasi</th>
                        <th class="py-3 px-6 font-semibold">Jenis & Kelas</th>
                        <th class="py-3 px-6 font-semibold text-center">Kursi</th>
                        <th class="py-3 px-6 font-semibold">Status</th>
                        <th class="py-3 px-6 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    @forelse($transportations as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4 px-6 font-medium text-gray-900">{{ $item->kode }}</td>
                        <td class="py-4 px-6 font-semibold text-gray-800">{{ $item->nama }}</td>
                        <td class="py-4 px-6">
                            <div class="flex items-center">
                                @if($item->jenis == 'kereta')
                                    <i class="fa-solid fa-train text-gray-400 mr-2 w-4"></i> Kereta Api
                                @elseif($item->jenis == 'bus')
                                    <i class="fa-solid fa-bus text-gray-400 mr-2 w-4"></i> Bus
                                @else
                                    <i class="fa-solid fa-plane text-gray-400 mr-2 w-4"></i> Pesawat
                                @endif
                            </div>
                            <span class="text-xs text-gray-500 mt-1 block">{{ $item->kelas }}</span>
                        </td>
                        <td class="py-4 px-6 text-center font-medium text-gray-700">{{ $item->jumlah_kursi }}</td>
                        <td class="py-4 px-6">
                            @if($item->status == 'aktif')
                                <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">Aktif</span>
                            @elseif($item->status == 'maintenance')
                                <span class="bg-orange-100 text-orange-700 text-xs font-bold px-3 py-1 rounded-full">Maintenance</span>
                            @else
                                <span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full">Nonaktif</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex items-center justify-center">
                                <a href="{{ route('admin.transportations.edit', $item->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-primary hover:bg-primary hover:text-white transition mx-1" title="Edit">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                
                                <form action="{{ route('admin.transportations.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus armada ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition mx-1" title="Hapus">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-500">Belum ada data armada transportasi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $transportations->links() }}
        </div>
    </div>
</div>
@endsection