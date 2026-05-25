@extends('layouts.passenger')

@section('title', 'Riwayat Pemesanan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    {{-- Header Halaman --}}
    <div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Riwayat Transaksi</h1>
        <p class="text-sm text-slate-500 mt-1">Catatan seluruh riwayat pembelian tiket perjalanan Anda di Travelgo.</p>
    </div>

    {{-- Wadah Utama Tabel Kaca Lembut --}}
    <div class="bg-white/80 border border-white/50 backdrop-blur-md rounded-3xl overflow-hidden shadow-xl shadow-zinc-200/40">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100 text-slate-400 text-[11px] font-extrabold uppercase tracking-widest">
                        <th class="py-4 px-6">Tanggal</th>
                        <th class="py-4 px-6">Kode Order</th>
                        <th class="py-4 px-6">Detail Perjalanan</th>
                        <th class="py-4 px-6">Total Bayar</th>
                        <th class="py-4 px-6 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100/60">
                    @forelse($history as $item)
                        <tr class="hover:bg-white/60 transition-colors group">
                            {{-- Kolom Tanggal --}}
                            <td class="py-4 px-6 text-slate-400 font-bold text-xs">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                            </td>
                            
                            {{-- Kolom Kode Order --}}
                            <td class="py-4 px-6 font-black text-slate-800 tracking-wide group-hover:text-teal-600 transition-colors">
                                {{ $item->order_code }}
                            </td>
                            
                            {{-- Kolom Detail Operasional --}}
                            <td class="py-4 px-6">
                                <div class="font-black text-slate-800 flex items-center">
                                    <span>{{ $item->schedule->route->kota_asal }}</span>
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 mx-1 text-slate-400"></i>
                                    <span>{{ $item->schedule->route->kota_tujuan }}</span>
                                </div>
                                <p class="text-xs text-slate-400 mt-1 font-medium flex items-center">
                                    <span class="mr-1">
                                        @if($item->schedule->transportation->jenis == 'kereta')
                                        <i data-lucide="train" class="w-4 h-4"></i>
                                        @elseif($item->schedule->transportation->jenis == 'bus')
                                        <i data-lucide="bus" class="w-4 h-4"></i>
                                        @else
                                        <i data-lucide="plane-takeoff" class="w-4 h-4"></i>
                                        @endif
                                    </span>
                                    {{ $item->schedule->transportation->nama ?? $item->schedule->transportation->name }}
                                    <span class="mx-1 text-slate-300">|</span> 
                                    <span class="font-bold text-slate-500">{{ $item->total_passengers }} Pax</span>
                                </p>
                            </td>
                            
                            {{-- Kolom Total Harga --}}
                            <td class="py-4 px-6 font-extrabold text-slate-800">
                                Rp {{ number_format($item->total_price, 0, ',', '.') }}
                            </td>
                            
                            {{-- Kolom Status Badge Glowing --}}
                            <td class="py-4 px-6 text-center">
                                @if($item->status == 'lunas')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-600 border border-emerald-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Selesai
                                    </span>
                                @elseif($item->status == 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-500/10 text-amber-600 border border-amber-500/20 animate-pulse">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span> Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-500/10 text-rose-600 border border-rose-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span> Batal
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        {{-- Tampilan Saat Riwayat Kosong --}}
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400 font-medium">
                                <i data-lucide="folder-open" class="w-10 h-10 mx-auto mb-3 text-slate-300"></i>
                                Belum ada transaksi terekam di akun Anda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Navigasi Halaman Paginasi --}}
    <div class="pt-2">
        {{ $history->links() }}
    </div>
</div>
@endsection