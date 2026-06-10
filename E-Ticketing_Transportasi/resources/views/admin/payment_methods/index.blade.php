@extends('layouts.admin')

@section('title', 'Kelola Metode Pembayaran - Travelgo')

@section('content')
<div class="p-8 space-y-8 flex-1">
    @if(session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-xl flex items-center shadow-lg">
            <i data-lucide="check-circle" class="mr-2 w-5 h-5"></i> 
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tight">Metode Pembayaran</h1>
            <p class="text-sm text-slate-400 mt-1">Konfigurasi saluran pembayaran aplikasi (Bank, VA, E-Wallet, QRIS).</p>
        </div>
        <a href="{{ route('admin.payment-methods.create') }}" class="flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-teal-400 to-cyan-500 text-slate-950 text-sm font-bold hover:brightness-110 transition-all shadow-lg shadow-teal-500/20">
            <i data-lucide="plus" class="w-4.5 h-4.5 stroke-[3px]"></i>
            <span>Tambah Metode Pembayaran</span>
        </a>
    </div>

    <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-800 text-[11px] text-slate-500 font-extrabold uppercase tracking-widest bg-slate-950/20">
                        <th class="py-4 px-6">Kode</th>
                        <th class="py-4 px-6">Nama Metode</th>
                        <th class="py-4 px-6">Kategori</th>
                        <th class="py-4 px-6">Nomor Rekening/Tujuan</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-800/40">
                    @forelse($methods as $item)
                    <tr class="text-slate-300 hover:bg-slate-900/30 transition group">
                        <td class="py-4 px-6 font-bold text-slate-200 group-hover:text-teal-400 transition-colors">{{ $item->kode }}</td>
                        <td class="py-4 px-6 font-semibold text-slate-200">{{ $item->nama }}</td>
                        <td class="py-4 px-6 uppercase text-xs font-bold text-slate-400">{{ str_replace('_', ' ', $item->kategori) }}</td>
                        <td class="py-4 px-6 font-mono text-slate-300">{{ $item->nomor_tujuan }}</td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $item->status == 'aktif' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('admin.payment-methods.edit', $item->id) }}" class="p-2 rounded-lg bg-slate-900 border border-slate-800 text-slate-400 hover:text-teal-400 hover:border-teal-400 transition-all inline-flex items-center" title="Edit">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.payment-methods.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin menghapus channel ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg bg-slate-900 border border-slate-800 text-slate-400 hover:text-rose-400 hover:border-rose-400 transition-all inline-flex items-center cursor-pointer">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500 font-medium">Belum ada channel pembayaran terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-800/60 bg-slate-950/20">
            {{ $methods->links() }}
        </div>
    </div>
</div>
@endsection