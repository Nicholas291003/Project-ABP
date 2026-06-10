<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $order->order_code }} - Travelgo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-100 p-8 flex justify-center items-center min-h-screen">
    <div class="max-w-3xl w-full bg-slate-900 border border-slate-800 p-8 rounded-3xl shadow-2xl relative">
        <div class="absolute top-8 right-8">
            <span class="px-4 py-1.5 text-xs font-black tracking-widest rounded-full {{ $order->status == 'lunas' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-amber-500/10 text-amber-400 border border-amber-500/20' }}">
                {{ strtoupper($order->status) }}
            </span>
        </div>

        <div class="border-b border-slate-800 pb-6 mb-6">
            <h1 class="text-2xl font-black text-white tracking-tight flex items-center">
                ✈️ TRAVELGO INVOICE SYSTEM
            </h1>
            <p class="text-xs text-slate-500 mt-1">Kode Transaksi Resmi Komputerisasi Digital</p>
        </div>

        <div class="grid grid-cols-2 gap-6 text-xs mb-8">
            <div>
                <p class="text-slate-500 font-bold uppercase tracking-wider">Diterbitkan Untuk:</p>
                <p class="text-sm font-bold text-slate-200 mt-1">{{ $order->user->name ?? 'Pelanggan' }}</p>
                <p class="text-slate-400 mt-0.5">{{ $order->user->email ?? '-' }}</p>
            </div>
            <div class="text-right">
                <p class="text-slate-500 font-bold uppercase tracking-wider">Rincian Nota:</p>
                <p class="text-sm font-mono font-bold text-teal-400 mt-1">{{ $order->order_code }}</p>
                <p class="text-slate-400 mt-0.5">Tanggal: {{ $order->created_at->format('d M Y - H:i') }} WIB</p>
            </div>
        </div>

        <div class="border border-slate-800 rounded-2xl overflow-hidden mb-6 text-xs">
            <div class="grid grid-cols-3 bg-slate-950 p-4 font-bold text-slate-400 uppercase tracking-wider border-b border-slate-800">
                <div>Deskripsi Perjalanan</div>
                <div class="text-center">Kuantitas</div>
                <div class="text-right">Total Tarif</div>
            </div>
            <div class="grid grid-cols-3 p-4 items-center bg-slate-900/40">
                <div>
                    <p class="font-bold text-slate-200">{{ $order->schedule->route->kota_asal }} ➔ {{ $order->schedule->route->kota_tujuan }}</p>
                    <p class="text-[11px] text-slate-500 mt-0.5">{{ $order->schedule->transportation->name }} ({{ $order->schedule->transportation->kelas }})</p>
                </div>
                <div class="text-center font-bold text-slate-300">{{ $order->total_passengers }} Pax</div>
                <div class="text-right font-black text-white">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="flex justify-between items-center bg-slate-950 p-4 rounded-xl border border-slate-800 mb-8">
            <span class="text-xs font-bold text-slate-400 uppercase">Jumlah Total Tagihan</span>
            <span class="text-xl font-black text-orange-400">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
        </div>

        <div class="flex justify-end space-x-3">
            <button onclick="window.print()" class="px-5 py-2 text-xs font-bold bg-slate-800 hover:bg-slate-700 text-slate-200 rounded-xl transition-all border border-slate-700">
                🖨️ Cetak Faktur (Print)
            </button>
            <a href="{{ route('admin.payments.index') }}" class="px-5 py-2 text-xs font-bold bg-teal-500 text-slate-950 rounded-xl hover:brightness-110 transition-all font-black">
                Selesai
            </a>
        </div>
    </div>
</body>
</html>