import 'package:flutter/material.dart';

class HistoryScreen extends StatelessWidget {
  const HistoryScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      appBar: AppBar(
        title: const Text(
          'Riwayat Pemesanan',
          style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Color(0xFF1E293B)),
        ),
        backgroundColor: Colors.white,
        elevation: 0,
      ),
      body: ListView.builder(
        itemCount: 2, // Simulasi isi manifes riwayat belanja tiket
        padding: const EdgeInsets.all(16.0),
        itemBuilder: (context, index) {
          List<String> kodeTiket = ["TGO-8821A", "TGO-1102B"];
          List<String> rute = ["Jakarta ➔ Yogyakarta", "Surabaya ➔ Bandung"];
          List<String> tanggal = ["20 Mei 2026", "12 April 2026"];
          List<String> status = ["sukses", "batal"];
          
          bool isSukses = status[index] == "sukses";

          return Container(
            margin: const EdgeInsets.only(bottom: 14.0),
            padding: const EdgeInsets.all(16.0),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(20.0),
              border: Border.all(color: const Color(0xFFE2E8F0)),
            ),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Text(
                      kodeTiket[index],
                      style: const TextStyle(fontWeight: FontWeight.w900, fontSize: 14, color: Color(0xFF1E293B)),
                    ),
                    
                    // Badge status transaksional
                    Container(
                      padding: const EdgeInsets.symmetric(horizontal: 10.0, vertical: 4.0),
                      decoration: BoxDecoration(
                        color: isSukses ? const Color(0xFFDCFCE7) : const Color(0xFFFEE2E2),
                        borderRadius: BorderRadius.circular(8.0),
                      ),
                      child: Text(
                        isSukses ? 'Selesai' : 'Dibatalkan',
                        style: TextStyle(
                          fontSize: 11, 
                          fontWeight: FontWeight.bold, 
                          color: isSukses ? const Color(0xFF16A34A) : const Color(0xFFDC2626)
                        ),
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 12.0),
                Text(
                  rute[index],
                  style: const TextStyle(fontSize: 15, fontWeight: FontWeight.bold, color: Color(0xFF334155)),
                ),
                const SizedBox(height: 4.0),
                Row(
                  children: [
                    const Icon(Icons.calendar_today, size: 12.0, color: Color(0xFF94A3B8)),
                    const SizedBox(width: 6.0),
                    Text(
                      tanggal[index],
                      style: const TextStyle(fontSize: 12, color: Color(0xFF64748B), fontWeight: FontWeight.w500),
                    ),
                  ],
                ),
              ],
            ),
          );
        },
      ),
    );
  }
}