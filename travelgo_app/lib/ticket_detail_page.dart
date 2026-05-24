import 'package:flutter/material.dart';
import 'package:qr_flutter/qr_flutter.dart';

class TicketDetailPage extends StatelessWidget {
  final Map pesanan;

  const TicketDetailPage({super.key, required this.pesanan});

  @override
  Widget build(BuildContext context) {
    final jadwal = pesanan['schedule'];
    final rute = jadwal['route'];
    final armada = jadwal['transportation'];

    return Scaffold(
      backgroundColor: const Color(0xFF1BA0E2), // Latar belakang biru
      appBar: AppBar(
        title: const Text('E-Ticket Saya'),
        backgroundColor: Colors.transparent,
        elevation: 0,
        foregroundColor: Colors.white,
      ),
      body: SafeArea(
        child: Center(
          child: SingleChildScrollView(
            padding: const EdgeInsets.all(24.0),
            child: Container(
              padding: const EdgeInsets.all(24),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(20),
              ),
              child: Column(
                mainAxisSize: MainAxisSize.min,
                children: [
                  const Text(
                    'BOARDING PASS',
                    style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold, letterSpacing: 2, color: Colors.grey),
                  ),
                  const SizedBox(height: 20),
                  
                  // QR Code
                  QrImageView(
                    data: pesanan['order_code'], // Mengubah kode booking menjadi QR Code
                    version: QrVersions.auto,
                    size: 200.0,
                    foregroundColor: const Color(0xFF121212),
                  ),
                  
                  const SizedBox(height: 10),
                  Text(
                    pesanan['order_code'],
                    style: const TextStyle(fontSize: 24, fontWeight: FontWeight.bold, color: Color(0xFFFF5E1F)),
                  ),
                  const SizedBox(height: 30),
                  
                  // Garis putus-putus
                  LayoutBuilder(
                    builder: (BuildContext context, BoxConstraints constraints) {
                      final boxWidth = constraints.constrainWidth();
                      const dashWidth = 10.0;
                      final dashCount = (boxWidth / (2 * dashWidth)).floor();
                      return Flex(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        direction: Axis.horizontal,
                        children: List.generate(dashCount, (_) {
                          return const SizedBox(width: dashWidth, height: 2, child: DecoratedBox(decoration: BoxDecoration(color: Colors.grey)));
                        }),
                      );
                    },
                  ),
                  const SizedBox(height: 30),
                  
                  // Detail Perjalanan
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          const Text('Asal', style: TextStyle(color: Colors.grey)),
                          Text(rute['kota_asal'], style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold)),
                          Text(jadwal['departure_time'], style: const TextStyle(fontSize: 16)),
                        ],
                      ),
                      const Icon(Icons.flight_takeoff, color: Color(0xFF1BA0E2), size: 30),
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.end,
                        children: [
                          const Text('Tujuan', style: TextStyle(color: Colors.grey)),
                          Text(rute['kota_tujuan'], style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold)),
                          Text(jadwal['arrival_time'] ?? '-', style: const TextStyle(fontSize: 16)),
                        ],
                      ),
                    ],
                  ),
                  const SizedBox(height: 24),
                  
                  // Detail Kendaraan & Tanggal
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          const Text('Transportasi', style: TextStyle(color: Colors.grey)),
                          Text("${armada['jenis']} (${armada['nama']}) (${armada['kelas']})", style: const TextStyle(fontWeight: FontWeight.bold)),
                        ],
                      ),
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.end,
                        children: [
                          const Text('Tanggal', style: TextStyle(color: Colors.grey)),
                          Text(jadwal['departure_date'], style: const TextStyle(fontWeight: FontWeight.bold)),
                        ],
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }
}