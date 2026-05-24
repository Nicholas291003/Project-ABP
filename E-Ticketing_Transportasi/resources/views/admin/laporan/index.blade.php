@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Laporan Transaksi TravelGo Mobile</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Memantau tiket yang dipesan melalui aplikasi Android/iOS</li>
    </</ol>

    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2" style="border-left: 5px solid #22C55E;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Pendapatan Masuk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4 shadow">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-table me-1"></i> Data Pemesanan Tiket Penumpang
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Booking</th>
                        <th>Nama Penumpang</th>
                        <th>Rute & Transportasi</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th>Tanggal Pesan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($semuaTransaksi as $key => $transaksi)
                    <tr>
                        <td>{{ $semuaTransaksi->firstItem() + $key }}</td>
                        <td class="font-weight-bold text-danger">{{ $transaksi->booking_code }}</td>
                        <td>{{ $transaksi->user->name }}</td>
                        <td>
                            <strong>{{ $transaksi->schedule->transportation->nama }}</strong> <br>
                            <small>{{ $transaksi->schedule->route->kota_asal }} ➔ {{ $transaksi->schedule->route->kota_tujuan }}</small>
                        </td>
                        <td>Rp {{ number_format($transaksi->total_price, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $transaksi->status == 'lunas' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ strtoupper($transaksi->status) }}
                            </span>
                        </td>
                        <td>{{ $transaksi->created_at->format('d M Y, H:i') }} WIB</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada transaksi masuk dari aplikasi mobile.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="d-flex justify-content-center">
                {{ $semuaTransaksi->links() }}
            </div>
        </div>
    </div>
</div>
@endsection