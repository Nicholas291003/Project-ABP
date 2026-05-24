import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class PaymentPage extends StatefulWidget {
  final String token;
  final int orderId;
  final String bookingCode;
  final String totalPrice;

  const PaymentPage({
    super.key,
    required this.token,
    required this.orderId,
    required this.bookingCode,
    required this.totalPrice,
  });

  @override
  State<PaymentPage> createState() => _PaymentPageState();
}

class _PaymentPageState extends State<PaymentPage> {
  bool _isLoading = false;

  Future<void> _prosesPembayaran() async {
    setState(() => _isLoading = true);
    final String urlApi = "http://10.0.2.2:8000/api/order/${widget.orderId}/bayar";

    try {
      final response = await http.post(
        Uri.parse(urlApi),
        headers: {
          'Authorization': 'Bearer ${widget.token}',
          'Accept': 'application/json',
        },
      );

      final data = jsonDecode(response.body);

      if (response.statusCode == 200 && data['status'] == 'sukses') {
        if (mounted) {
          showDialog(
            context: context,
            barrierDismissible: false,
            builder: (c) => AlertDialog(
              title: const Text('Pembayaran Sukses! ✅', style: TextStyle(color: Colors.green)),
              content: Text('Tiket dengan kode ${widget.bookingCode} berhasil dilunasi.'),
              actions: [
                TextButton(
                  onPressed: () {
                    Navigator.pop(c); // Tutup dialog
                    Navigator.pop(context, true); // Kembali ke halaman sebelumnya dan kirim sinyal 'true' (sukses)
                  },
                  child: const Text('Kembali ke Tiket Saya'),
                ),
              ],
            ),
          );
        }
      } else {
        if (mounted) ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(data['pesan'] ?? 'Gagal memproses pembayaran')));
        setState(() => _isLoading = false);
      }
    } catch (e) {
      if (mounted) ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text('Error: $e')));
      setState(() => _isLoading = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Pembayaran'),
        backgroundColor: const Color(0xFF1BA0E2),
        foregroundColor: Colors.white,
      ),
      body: Padding(
        padding: const EdgeInsets.all(24.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.stretch,
          children: [
            const Icon(Icons.account_balance_wallet, size: 80, color: Color(0xFF1BA0E2)),
            const SizedBox(height: 24),
            const Text('Total Tagihan', textAlign: TextAlign.center, style: TextStyle(fontSize: 16, color: Colors.grey)),
            const SizedBox(height: 8),
            Text(
              'Rp ${widget.totalPrice}',
              textAlign: TextAlign.center,
              style: const TextStyle(fontSize: 32, fontWeight: FontWeight.bold, color: Color(0xFFFF5E1F)),
            ),
            const SizedBox(height: 12),
            Text(
              'Kode Booking: ${widget.bookingCode}',
              textAlign: TextAlign.center,
              style: const TextStyle(fontSize: 16, fontWeight: FontWeight.w600),
            ),
            const Spacer(),
            ElevatedButton(
              onPressed: _isLoading ? null : _prosesPembayaran,
              style: ElevatedButton.styleFrom(
                backgroundColor: const Color(0xFF22C55E),
                padding: const EdgeInsets.symmetric(vertical: 16),
                shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
              ),
              child: _isLoading
                  ? const CircularProgressIndicator(color: Colors.white)
                  : const Text('Bayar Sekarang', style: TextStyle(fontSize: 18, color: Colors.white, fontWeight: FontWeight.bold)),
            ),
          ],
        ),
      ),
    );
  }
}