import 'package:flutter/material.dart';
import 'package:travelgo_app/services/api_service.dart';
import 'package:travelgo_app/screens/payment_screen.dart';

class SelectSeatScreen extends StatefulWidget {
  final int scheduleId; // Menerima lemparan ID Jadwal dari halaman hasil cari

  const SelectSeatScreen({super.key, required this.scheduleId});

  @override
  State<SelectSeatScreen> createState() => _SelectSeatScreenState();
}

class _SelectSeatScreenState extends State<SelectSeatScreen> {
  final List<String> _selectedSeats = [];
  final List<String> _bookedSeats = ['1A', '2B', '4C', '5D', '6A', '6B', '8D'];
  bool _isProcessingOrder = false; // Efek loading saat mencatatkan pesanan ke Laravel

  void _toggleSeat(String seatId) {
    setState(() {
      if (_selectedSeats.contains(seatId)) {
        _selectedSeats.remove(seatId);
      } else {
        if (_selectedSeats.length >= 4) {
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(
              content: Text('Maksimal pemesanan adalah 4 kursi dalam satu transaksi kelompok.'),
              backgroundColor: Color(0xFFEF4444),
            ),
          );
          return;
        }
        _selectedSeats.add(seatId);
      }
    });
  }

  // Fungsi Kirim Transaksi ke Laravel Backend
  void _submitBookingKeLaravel() async {
    setState(() {
      _isProcessingOrder = true;
    });

    // Menembak endpoint POST /api/order di Laravel
    final hasilOrder = await ApiService.buatPesanan(widget.scheduleId);

    setState(() {
      _isProcessingOrder = false;
    });

    if (hasilOrder != null && hasilOrder['status'] == 'sukses') {
      // Jika pesanan berhasil dicatat di tabel 'orders' Laravel
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text(hasilOrder['pesan'] ?? 'Pesanan berhasil dibuat!'),
            backgroundColor: const Color(0xFF16A34A),
          ),
        );

        // Pindah ke halaman Pembayaran membawa data transaksi
        Navigator.push(
          context,
          MaterialPageRoute(
            builder: (context) => PaymentScreen(
              orderData: hasilOrder['data'], // Data order yang dikembalikan dari Laravel
            ),
          ),
        );
      }
    } else {
      // Jika kursi habis atau sistem error
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(
            content: Text('Gagal membuat pesanan. Mohon coba kembali atau pilih jadwal lain.'),
            backgroundColor: Color(0xFFEF4444),
          ),
        );
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      appBar: AppBar(
        title: const Text(
          'Pilih Kursi Perjalanan',
          style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Color(0xFF1E293B)),
        ),
        backgroundColor: Colors.white,
        elevation: 0,
        leading: const BackButton(color: Color(0xFF1E293B)),
      ),
      body: Column(
        children: [
          // 1. KOTAK INFO JADWAL
          Container(
            width: double.infinity,
            margin: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
            padding: const EdgeInsets.all(16),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(20),
              border: Border.all(color: const Color(0xFFE2E8F0)),
            ),
            child: Column(
              children: [
                const Text(
                  'Jakarta (GMR) ➔ Yogyakarta (YK)',
                  style: TextStyle(fontSize: 14, fontWeight: FontWeight.w900, color: Color(0xFF1E293B)),
                ),
                const SizedBox(height: 4),
                Text(
                  'ID JADWAL DIGITAL: #${widget.scheduleId}',
                  style: const TextStyle(fontSize: 11, fontWeight: FontWeight.bold, color: Color(0xFF0D9488)),
                ),
              ],
            ),
          ),

          // 2. LEGENDA INDIKATOR
          Container(
            margin: const EdgeInsets.symmetric(horizontal: 16),
            padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 12),
            decoration: BoxDecoration(
              color: const Color(0xFFF1F5F9),
              borderRadius: BorderRadius.circular(16),
            ),
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceAround,
              children: [
                _buildLegendItem(const Color(0xFF0D9488), 'Dipilih'),
                _buildLegendItem(const Color(0xFF1E293B), 'Terisi'),
                _buildLegendItem(const Color(0xFFE2E8F0), 'Tersedia'),
              ],
            ),
          ),
          const SizedBox(height: 20),

          // Label Kolom Kursi
          const Padding(
            padding: EdgeInsets.symmetric(horizontal: 32),
            child: Row(
              children: [
                Expanded(child: Center(child: Text('A', style: TextStyle(fontWeight: FontWeight.bold, color: Color(0xFF94A3B8))))),
                Expanded(child: Center(child: Text('B', style: TextStyle(fontWeight: FontWeight.bold, color: Color(0xFF94A3B8))))),
                SizedBox(width: 40),
                Expanded(child: Center(child: Text('C', style: TextStyle(fontWeight: FontWeight.bold, color: Color(0xFF94A3B8))))),
                Expanded(child: Center(child: Text('D', style: TextStyle(fontWeight: FontWeight.bold, color: Color(0xFF94A3B8))))),
              ],
            ),
          ),
          const SizedBox(height: 8),

          // 3. AREA GRID GERBONG KURSI (Scrollable)
          Expanded(
            child: ListView.builder(
              itemCount: 12,
              padding: const EdgeInsets.symmetric(horizontal: 24),
              itemBuilder: (context, index) {
                int rowNum = index + 1;
                return Padding(
                  padding: const EdgeInsets.symmetric(vertical: 6),
                  child: Row(
                    children: [
                      Expanded(child: _buildSeatButton('${rowNum}A')),
                      const SizedBox(width: 8),
                      Expanded(child: _buildSeatButton('${rowNum}B')),
                      Container(
                        width: 40,
                        alignment: Alignment.center,
                        child: Text(
                          '$rowNum',
                          style: const TextStyle(fontSize: 12, fontWeight: FontWeight.bold, color: Color(0xFF94A3B8)),
                        ),
                      ),
                      Expanded(child: _buildSeatButton('${rowNum}C')),
                      const SizedBox(width: 8),
                      Expanded(child: _buildSeatButton('${rowNum}D')),
                    ],
                  ),
                );
              },
            ),
          ),

          // 4. BOTTOM ACTION PANEL
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 16),
            decoration: BoxDecoration(
              color: Colors.white,
              boxShadow: [
                BoxShadow(
                  color: Colors.black.withOpacity(0.04),
                  blurRadius: 10,
                  offset: const Offset(0, -4),
                ),
              ],
            ),
            child: Row(
              children: [
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      const Text('Kursi Terpilih', style: TextStyle(fontSize: 11, color: Color(0xFF64748B))),
                      const SizedBox(height: 2),
                      Text(
                        _selectedSeats.isEmpty ? '-' : _selectedSeats.join(', '),
                        style: const TextStyle(fontSize: 16, fontWeight: FontWeight.w900, color: Color(0xFF0D9488)),
                      ),
                    ],
                  ),
                ),
                ElevatedButton(
                  onPressed: (_selectedSeats.isEmpty || _isProcessingOrder) ? null : _submitBookingKeLaravel,
                  style: ElevatedButton.styleFrom(
                    backgroundColor: const Color(0xFFFF5E1F),
                    disabledBackgroundColor: const Color(0xFFE2E8F0),
                    shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                    padding: const EdgeInsets.symmetric(horizontal: 28, vertical: 12),
                    elevation: 0,
                  ),
                  child: _isProcessingOrder
                      ? const SizedBox(
                          width: 16,
                          height: 16,
                          child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2),
                        )
                      : const Text(
                          'Lanjutkan',
                          style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold, fontSize: 13),
                        ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildLegendItem(Color color, String label) {
    return Row(
      children: [
        Container(
          width: 14,
          height: 14,
          decoration: BoxDecoration(
            color: color,
            borderRadius: BorderRadius.circular(4),
          ),
        ),
        const SizedBox(width: 6),
        Text(
          label,
          style: const TextStyle(fontSize: 12, color: Color(0xFF475569), fontWeight: FontWeight.w600),
        ),
      ],
    );
  }

  Widget _buildSeatButton(String seatId) {
    bool isBooked = _bookedSeats.contains(seatId);
    bool isSelected = _selectedSeats.contains(seatId);

    Color backgroundColor = const Color(0xFFE2E8F0);
    Color textColor = const Color(0xFF475569);

    if (isBooked) {
      backgroundColor = const Color(0xFF1E293B).withOpacity(0.2);
      textColor = const Color(0xFF94A3B8);
    } else if (isSelected) {
      backgroundColor = const Color(0xFF0D9488);
      textColor = Colors.white;
    }

    return SizedBox(
      height: 36,
      child: ElevatedButton(
        onPressed: isBooked ? null : () => _toggleSeat(seatId),
        style: ElevatedButton.styleFrom(
          backgroundColor: backgroundColor,
          elevation: 0,
          padding: EdgeInsets.zero,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
        ),
        child: Text(
          seatId,
          style: TextStyle(
            fontSize: 11,
            fontWeight: FontWeight.bold,
            color: isBooked ? const Color(0xFF94A3B8).withOpacity(0.4) : textColor,
          ),
        ),
      ),
    );
  }
}