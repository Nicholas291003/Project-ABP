import 'package:flutter/material.dart';

class PaymentStatusScreen extends StatelessWidget {
  const PaymentStatusScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      body: SafeArea(
        child: Center(
          child: SingleChildScrollView(
            padding: const EdgeInsets.all(24.0),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                
                // 1. IKON BULAT CENTANG SUKSES (WARNA UTAMA TRAVELGO)
                Container(
                  padding: const EdgeInsets.all(24),
                  decoration: const BoxDecoration(
                    color: Color(0xFFFF5E1F), 
                    shape: BoxShape.circle,
                  ),
                  child: const Icon(
                    Icons.check_rounded,
                    size: 64,
                    color: Colors.white,
                  ),
                ),
                const SizedBox(height: 24),

                // 2. TEKS STATUS UTAMA
                const Text(
                  'Payment Successful',
                  style: TextStyle(
                    fontSize: 22, 
                    fontWeight: FontWeight.w900, 
                    color: Color(0xFF1E293B),
                  ),
                ),
                const SizedBox(height: 8),
                const Text(
                  'Your transaction has been processed successfully.',
                  textAlign: TextAlign.center,
                  style: TextStyle(
                    fontSize: 14, 
                    color: Color(0xFF64748B),
                  ),
                ),
                const SizedBox(height: 32),

                // 3. KOTAK INFORMASI NOTA TRANSAKSI SINGKAT
                Container(
                  padding: const EdgeInsets.all(20),
                  decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.circular(24),
                    border: Border.all(color: const Color(0xFFE2E8F0)),
                  ),
                  child: Column(
                    children: [
                      _buildDetailRow('Status', 'Success', isBadge: true),
                      const Divider(height: 24, color: Color(0xFFF1F5F9)),
                      _buildDetailRow('Payment Type', 'Digital Payment'),
                      const Divider(height: 24, color: Color(0xFFF1F5F9)),
                      _buildDetailRow('Total Amount', 'Rp 475.220', isOrangeText: true),
                    ],
                  ),
                ),
                const SizedBox(height: 40),

                // 4. TOMBOL KEMBALI KE HALAMAN BERANDA UTAMA
                SizedBox(
                  width: double.infinity,
                  height: 50,
                  child: ElevatedButton(
                    onPressed: () {
                      // Membersihkan tumpukan halaman navigasi dan kembali ke HomeScreen
                      Navigator.of(context).popUntil((route) => route.isFirst);
                    },
                    style: ElevatedButton.styleFrom(
                      backgroundColor: const Color(0xFFFF5E1F),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(14),
                      ),
                      elevation: 0,
                    ),
                    child: const Text(
                      'Back to Homepage',
                      style: TextStyle(
                        color: Colors.white, 
                        fontSize: 14, 
                        fontWeight: FontWeight.w900,
                      ),
                    ),
                  ),
                ),

              ],
            ),
          ),
        ),
      ),
    );
  }

  // Fungsi pembantu pembuat baris informasi nota
  Widget _buildDetailRow(String label, String value, {bool isBadge = false, bool isOrangeText = false}) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        Text(
          label,
          style: const TextStyle(
            fontSize: 13,
            fontWeight: FontWeight.bold,
            color: Color(0xFF94A3B8),
          ),
        ),
        if (isBadge)
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
            decoration: BoxDecoration(
              color: const Color(0xFFF0FDF4),
              borderRadius: BorderRadius.circular(6),
            ),
            child: Text(
              value,
              style: const TextStyle(
                fontSize: 12,
                fontWeight: FontWeight.bold,
                color: Color(0xFF22C55E),
              ),
            ),
          )
        else
          Text(
            value,
            style: TextStyle(
              fontSize: 13,
              fontWeight: FontWeight.w900,
              color: isOrangeText ? const Color(0xFFFF5E1F) : const Color(0xFF1E293B),
            ),
          ),
      ],
    );
  }
}