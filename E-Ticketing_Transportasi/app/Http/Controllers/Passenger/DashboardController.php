<?php

namespace App\Http\Controllers\Passenger;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\Schedule;
use App\Models\SeatBooking;
use App\Models\User;

class DashboardController extends Controller
{
    // Halaman Beranda Utama Penumpang
    public function index()
    {
        $userId = Auth::id();

        // 1. Mengambil 1 E-Ticket Aktif Terdekat (Eager Loading Terpisah)
        $ticketAktif = Order::with(['schedule.route', 'schedule.transportation'])
                            ->where('user_id', $userId)
                            ->where('status', 'lunas')
                            ->latest()
                            ->first();

        // 2. Mengambil 3 Riwayat Pemesanan Terakhir (Eager Loading Terpisah)
        $riwayatTerakhir = Order::with(['schedule.route', 'schedule.transportation'])
                                ->where('user_id', $userId)
                                ->latest()
                                ->take(3)
                                ->get();

        // Melempar data ke view passenger/dashboard.blade.php
        return view('passenger.dashboard', compact('ticketAktif', 'riwayatTerakhir'));
    }

    public function searchTickets(Request $request)
    {
        // 1. Validasi parameter pencarian tiket
        $request->validate([
            'jenis' => 'required|in:kereta,bus,pesawat',
            'kota_asal' => 'required|string',
            'kota_tujuan' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        // 2. Query pencarian mencocokkan tanggal, jenis kendaraan yang aktif, serta kecocokan kota asal & tujuan
        $schedules = Schedule::with(['route', 'transportation'])
            ->where('departure_date', $request->tanggal)
            ->whereHas('transportation', function ($q) use ($request) {
                $q->where('jenis', $request->jenis)->where('status', 'aktif');
            })
            ->whereHas('route', function ($q) use ($request) {
                $q->where('kota_asal', 'LIKE', '%' . $request->kota_asal . '%')
                ->where('kota_tujuan', 'LIKE', '%' . $request->kota_tujuan . '%');
            })
            ->orderBy('departure_time', 'asc')
            ->get();

        // 3. Lempar hasil temuan ke halaman khusus search-results
        return view('passenger.search-results', compact('schedules', 'request'));
    }

    // Menampilkan semua tiket aktif milik penumpang
    public function myTickets()
    {
        $tickets = Order::with(['schedule.route', 'schedule.transportation'])
                        ->where('user_id', Auth::id())
                        ->where('status', 'lunas')
                        ->latest()
                        ->paginate(10);

        return view('passenger.tickets', compact('tickets'));
    }

    // Menampilkan seluruh riwayat transaksi
    public function history()
    {
        $history = Order::with(['schedule.route', 'schedule.transportation'])
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->paginate(10);

        return view('passenger.history', compact('history'));
    }

    // Menampilkan detail item E-Ticket secara spesifik beserta QR Code
    public function showTicket($order_code)
    {
        $ticket = Order::with(['schedule.route', 'schedule.transportation', 'user'])
                        ->where('user_id', Auth::id())
                        ->where('order_code', $order_code)
                        ->firstOrFail();

        return view('passenger.ticket-detail', compact('ticket'));
    }

    public function bookTicket(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'coach_name' => 'required|string',
            'selected_seats' => 'required|array|min:1',
        ]);
        $schedule = Schedule::findOrFail($request->schedule_id);
        $jumlah_penumpang = count($request->selected_seats);
        $tabrakanKursi = SeatBooking::where('schedule_id', $schedule->id)
                            ->where('coach_name', $request->coach_name)
                            ->whereIn('seat_number', $request->selected_seats)
                            ->exists();
        if ($tabrakanKursi) {
            return redirect()->back()->with('error', 'Maaf, salah satu kursi yang Anda pilih sudah terisi. Silakan pilih kursi lain.');
        }
        $schedule->decrement('remaining_seats', $jumlah_penumpang);
        $totalPrice = $schedule->price * $jumlah_penumpang;
        $order = Order::create([
            'user_id' => Auth::id(),
            'schedule_id' => $schedule->id,
            'order_code' => 'TKT-' . strtoupper(Str::random(6)),
            'total_passengers' => $jumlah_penumpang,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);
        foreach ($request->selected_seats as $seat) {
            SeatBooking::create([
                'schedule_id' => $schedule->id,
                'order_id' => $order->id,
                'coach_name' => $request->coach_name,
                'seat_number' => $seat,
            ]);
        }

        return redirect()->route('passenger.payment.show',$order->order_code);
    }

    public function showPayment($order_code)
    {
        $order = Order::with(['schedule.route', 'schedule.transportation', 'seatBookings'])
            ->where('user_id', Auth::id())
            ->where('order_code', $order_code)
            ->firstOrFail();

        if($order->status == 'lunas'){
            return redirect()->route('passenger.dashboard')->with('error', 'Tiket sudah dibayar');
        }

        $payment_methods = \App\Models\PaymentMethod::where('status', 'aktif')->get();

        return view('passenger.payment', compact('order', 'payment_methods'));
    }

    public function processPayment(Request $request, $order_code)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('order_code', $order_code)
            ->firstOrFail();

        $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        $order->update([
            'status' => 'lunas',
        ]);

        return redirect()->route('passenger.dashboard')->with('success', 'Pembayaran berhasil! E-Ticket Anda telah aktif.');
    }

    public function cancelTicket($order_code){
        $order = Order::with('schedule')
                        ->where('user_id', Auth::id())
                        ->where('order_code', $order_code)
                        ->where('status', '!=', 'dibatalkan')
                        ->firstOrFail();
        $order->schedule->increment('remaining_seats', $order->total_passengers);
        $order->update([
            'status' => 'dibatalkan',
        ]);
        return redirect()->route('passenger.dashboard')
            ->with('success', 'Tiket ' . $order->order_code . ' berhasil dibatalkan. Dana akan dikembalikan ke rekening Anda.');
    }

    public function showSeatSelection($schedule_id)
    {
        $schedule = Schedule::with('route', 'transportation')->findOrFail($schedule_id);
        $bookedSeats = SeatBooking::where('schedule_id', $schedule_id)
                                ->pluck('seat_number')->toArray();

        return view('passenger.select-seat', compact('schedule', 'bookedSeats'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('passenger.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('passenger.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}