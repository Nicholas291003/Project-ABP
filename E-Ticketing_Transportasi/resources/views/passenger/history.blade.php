@extends('layouts.passenger')

@section('title', 'Riwayat Pemesanan')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Transaksi</h1>
        <p class="text-sm text-gray-500 mt-1">Catatan seluruh riwayat pembelian tiket perjalanan Anda di TiketKuy.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="py-3.5 px-6 font-semibold">Tanggal</th>
                        <th class="py-3.5 px-6 font-semibold">Kode Order</th>
                        <th class="py-3.5 px-6 font-semibold">Detail Perjalanan</th>
                        <th class="py-3.5 px-6 font-semibold">Total Bayar</th>
                        <th class="py-3.5 px-6 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-50">
                    @forelse($history as $item)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="py-4 px-6 text-gray-500 font-medium">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                            </td>
                            <td class="py-4 px-6 font-bold text-gray-800">{{ $item->order_code }}</td>
                            <td class="py-4 px-6">
                                <p class="font-semibold text-gray-700">{{ $item->schedule->route->kota_asal }} ➔ {{ $item->schedule->route->kota_tujuan }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $item->schedule->transportation->name }} ({{ $item->total_passengers }} Pax)</p>
                            </td>
                            <td class="py-4 px-6 font-bold text-gray-800">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                            <td class="py-4 px-6">
                                @if($item->status == 'lunas')
                                    <span class="bg-green-50 text-green-700 text-xs font-bold px-2.5 py-1 rounded-full">Selesai</span>
                                @elseif($item->status == 'pending')
                                    <span class="bg-orange-50 text-orange-700 text-xs font-bold px-2.5 py-1 rounded-full">Pending</span>
                                @else
                                    <span class="bg-red-50 text-red-700 text-xs font-bold px-2.5 py-1 rounded-full">Batal</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-400">Belum ada transaksi terekam.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        {{ $history->links() }}
    </div>
</div>
@endsection