import 'package:flutter/material.dart';
import 'dart:async'; // ➔ WAJIB DITAMBAHKAN UNTUK MENGAKTIFKAN TIMER
import 'package:travelgo_app/services/api_service.dart';
import 'package:travelgo_app/screens/payment_status_screen.dart';

class PaymentScreen extends StatefulWidget {
  final Map<String, dynamic>? orderData;

  const PaymentScreen({super.key, this.orderData});

  @override
  State<PaymentScreen> createState() => _PaymentScreenState();
}

class _PaymentScreenState extends State<PaymentScreen> {
  List<dynamic> _paymentMethods = []; 
  bool _isLoadingMethods = true; 
  int? _selectedMethodId; 
  bool _isProcessingPayment = false;

  // VARIABEL STATE UNTUK HITUNG MUNDUR JALAN
  Timer? _countdownTimer;
  int _remainingSeconds = 900; // 15 menit = 15 * 60 detik

  @override
  void initState() {
    super.initState();
    _muatMetodePembayaranDariAdmin();
    _mulaiHitungMundur(); // ➔ Jalankan fungsi timer saat halaman dibuka
  }

  @override
  void dispose() {
    _countdownTimer?.cancel(); // ➔ Matikan timer saat keluar dari halaman agar RAM tidak bocor
    super.dispose();
  }

  // FUNGSI MENGGERAKKAN TIMER SETIAP DETIK
  void _mulaiHitungMundur() {
    _countdownTimer = Timer.periodic(const Duration(seconds: 1), (timer) {
      if (_remainingSeconds > 0) {
        setState(() {
          _remainingSeconds--; // Kurangi 1 detik
        });
      } else {
        _countdownTimer?.cancel();
        _tanganiWaktuHabis(); // Picu fungsi jika waktu habis
      }
    });
  }

  // FUNGSI FORMAT DETIK MENJADI HH:MM:SS (Contoh: 00:14:59)
  String _formatDurasiWaktu(int totalDetik) {
    int jam = totalDetik ~/ 3600;
    int menit = (totalDetik % 3600) ~/ 60;
    int detik = totalDetik % 60;

    String jamStr = jam.toString().padLeft(2, '0');
    String menitStr = menit.toString().padLeft(2, '0');
    String detikStr = detik.toString().padLeft(2, '0');

    return "$jamStr:$menitStr:$detikStr";
  }

  // FUNGSI JIKA WAKTU TRANSAKSI HABIS
  void _tanganiWaktuHabis() {
    if (mounted) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Waktu pembayaran telah habis! Silakan lakukan booking ulang.'),
          backgroundColor: Color(0xFFEF4444),
        ),
      );
      Navigator.of(context).pop(); // Tendang kembali ke halaman sebelumnya
    }
  }

  void _muatMetodePembayaranDariAdmin() async {
    final data = await ApiService.fetchMetodePembayaran(); 
    if (data != null && data.isNotEmpty) {
      setState(() {
        _paymentMethods = data;
        _selectedMethodId = data.first['id']; 
        _isLoadingMethods = false;
      });
    } else {
      setState(() {
        _isLoadingMethods = false;
      });
    }
  }

  void _eksekusiPembayaran() async {
    if (_selectedMethodId == null) return;

    setState(() {
      _isProcessingPayment = true;
    });

    final int idOrder = widget.orderData?['id'] ?? 102;
    final int idMetode = _selectedMethodId!;

    final hasilBayar = await ApiService.bayarPesanan(idOrder, idMetode);

    setState(() {
      _isProcessingPayment = false;
    });

    if (hasilBayar != null && hasilBayar['status'] == 'sukses') {
      _countdownTimer?.cancel(); // Matikan timer karena sudah lunas
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text(hasilBayar['pesan'] ?? 'Pembayaran Berhasil!'),
            backgroundColor: const Color(0xFF16A34A),
          ),
        );
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(builder: (context) => const PaymentStatusScreen()),
        );
      }
    } else {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text(hasilBayar?['pesan'] ?? 'Gagal memproses transaksi ke server Laravel.'),
            backgroundColor: const Color(0xFFEF4444),
          ),
        );
      }
    }
  }

  IconData _getIconKategori(String? kategori) {
    switch (kategori?.toLowerCase()) {
      case 'qris':
      case 'e-money':
        return Icons.qr_code_scanner_rounded;
      case 'bank':
      case 'va':
      case 'virtual account':
        return Icons.account_balance_rounded;
      default:
        return Icons.payment_rounded;
    }
  }

  @override
  Widget build(BuildContext context) {
    final String totalHargaText = widget.orderData?['total_price'] != null
        ? "Rp ${widget.orderData!['total_price']}"
        : "Rp 475.220";

    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      appBar: AppBar(
        title: const Text('Payment', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Color(0xFF1E293B))),
        backgroundColor: Colors.white,
        elevation: 0,
        leading: const BackButton(color: Color(0xFF1E293B)),
      ),
      body: Column(
        children: [
          // BANNER COUNTDOWN TIME (SUDAH AKTIF BERJALAN MUNDUR)
          Container(
            width: double.infinity,
            padding: const EdgeInsets.symmetric(vertical: 10, horizontal: 16),
            color: const Color(0xFFFEF2F2),
            child: Row(
              children: [
                const Icon(Icons.access_time_rounded, color: Color(0xFFEF4444), size: 16),
                const SizedBox(width: 8),
                Text(
                  'The remaining time of order ${_formatDurasiWaktu(_remainingSeconds)}', // ➔ RENDER WAKTU AKTIF
                  style: const TextStyle(fontSize: 12, fontWeight: FontWeight.bold, color: Color(0xFFEF4444)),
                ),
              ],
            ),
          ),

          Expanded(
            child: SingleChildScrollView(
              padding: const EdgeInsets.all(16.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const Text('Select Payment Method', style: TextStyle(fontSize: 14, fontWeight: FontWeight.w900, color: Color(0xFF1E293B))),
                  const SizedBox(height: 12),

                  if (_isLoadingMethods)
                    const Center(
                      child: Padding(
                        padding: EdgeInsets.all(32.0),
                        child: CircularProgressIndicator(color: Color(0xFFFF5E1F)),
                      ),
                    )
                  else if (_paymentMethods.isEmpty)
                    const Center(
                      child: Padding(
                        padding: EdgeInsets.all(16.0),
                        child: Text('Tidak ada metode pembayaran aktif dari admin.', style: TextStyle(fontSize: 12, color: Colors.grey)),
                      ),
                    )
                  else
                    ListView.builder(
                      shrinkWrap: true,
                      physics: const NeverScrollableScrollPhysics(),
                      itemCount: _paymentMethods.length,
                      itemBuilder: (context, index) {
                        final method = _paymentMethods[index];
                        bool isSelected = _selectedMethodId == method['id'];
                        
                        final String namaMethod = method['nama'] ?? '-';
                        final String detailMethod = method['kategori'] == 'qris' 
                            ? 'Scan QR Code Instant' 
                            : "No. Rek: ${method['nomor_tujuan'] ?? 'Auto Verification'}";

                        return Container(
                          margin: const EdgeInsets.only(bottom: 12),
                          decoration: BoxDecoration(
                            color: Colors.white,
                            borderRadius: BorderRadius.circular(16),
                            border: Border.all(
                              color: isSelected ? const Color(0xFFFF5E1F) : const Color(0xFFE2E8F0),
                              width: isSelected ? 2.0 : 1.0,
                            ),
                          ),
                          child: ListTile(
                            onTap: () {
                              setState(() {
                                _selectedMethodId = method['id'];
                              });
                            },
                            leading: Icon(_getIconKategori(method['kategori']), color: isSelected ? const Color(0xFFFF5E1F) : const Color(0xFF64748B)),
                            title: Text(
                              namaMethod,
                              style: const TextStyle(fontSize: 14, fontWeight: FontWeight.bold, color: Color(0xFF1E293B)),
                            ),
                            subtitle: Text(
                              detailMethod,
                              style: const TextStyle(fontSize: 11, color: Color(0xFF94A3B8)),
                            ),
                            trailing: Radio<int>(
                              value: method['id'] as int,
                              groupValue: _selectedMethodId,
                              activeColor: const Color(0xFFFF5E1F),
                              onChanged: (int? value) {
                                setState(() {
                                  _selectedMethodId = value;
                                });
                              },
                            ),
                          ),
                        );
                      },
                    ),
                ],
              ),
            ),
          ),

          // BOTTOM CONTROL BAR FOR TOTAL PRICE & ACTION
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 16),
            decoration: const BoxDecoration(
              color: Colors.white,
              boxShadow: [BoxShadow(color: Color(0x06000000), blurRadius: 10, offset: Offset(0, -4))],
            ),
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    const Text('Total price', style: TextStyle(fontSize: 11, color: Color(0xFF64748B))),
                    const SizedBox(height: 2),
                    Text(
                      totalHargaText,
                      style: const TextStyle(fontSize: 20, fontWeight: FontWeight.w900, color: Color(0xFFFF5E1F)),
                    ),
                  ],
                ),
                SizedBox(
                  height: 46,
                  child: ElevatedButton(
                    onPressed: (_isProcessingPayment || _selectedMethodId == null) ? null : _eksekusiPembayaran,
                    style: ElevatedButton.styleFrom(
                      backgroundColor: const Color(0xFFFF5E1F),
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                      elevation: 0,
                      padding: const EdgeInsets.symmetric(horizontal: 32),
                    ),
                    child: _isProcessingPayment
                        ? const SizedBox(width: 18, height: 18, child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2))
                        : const Text('Pay Now', style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold, fontSize: 14)),
                  ),
                )
              ],
            ),
          )
        ],
      ),
    );
  }
}