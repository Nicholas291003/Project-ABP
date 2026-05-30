import 'package:flutter/material.dart';

class TicketDetailScreen extends StatefulWidget {
  final Map<String, dynamic> orderData; // Menerima data tiket dari halaman pembayaran

  const TicketDetailScreen({super.key, required this.orderData});

  @override
  State<TicketDetailScreen> createState() => _TicketDetailScreenState();
}

class _TicketDetailScreenState extends State<TicketDetailScreen> {
  late String _ticketStatus;

  @override
  void initState() {
    super.initState();
    // Membaca status awal dari data yang dikirim Laravel ('lunas')
    _ticketStatus = widget.orderData['status'] ?? 'pending';
  }

  @override
  Widget build(BuildContext context) {
    // Membaca variabel manifes asli dari database orders
    final String orderCode = widget.orderData['order_code'] ?? 'TK-UNKNOWN';
    final String totalPassengers = "${widget.orderData['total_passengers'] ?? 1} Pax";
    final String totalBayar = "Rp ${widget.orderData['total_price'] ?? 0}";
    
    bool isLunas = _ticketStatus == 'lunas';

    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      appBar: AppBar(
        title: const Text(
          'Detail E-Ticket',
          style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Color(0xFF1E293B)),
        ),
        backgroundColor: Colors.white,
        elevation: 0,
        leading: IconButton(
          icon: const Icon(Icons.close_rounded, color: Color(0xFF1E293B)), // Tombol silang untuk kembali ke hub utama
          onPressed: () {
            Navigator.of(context).popUntil((route) => route.isFirst);
          },
        ),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.symmetric(horizontal: 20.0, vertical: 20.0),
        child: Column(
          children: [
            // KARTU UTAMA BOARDING PASS
            Container(
              width: double.infinity,
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(28.0),
                border: Border.all(color: const Color(0xFFE2E8F0)),
                boxShadow: const [
                  BoxShadow(
                    color: Color(0x08000000),
                    blurRadius: 20.0,
                    offset: Offset(0, 10.0),
                  ),
                ],
              ),
              child: Column(
                children: [
                  // Header Gradasi Toska Boarding Pass
                  Container(
                    width: double.infinity,
                    padding: const EdgeInsets.symmetric(horizontal: 20.0, vertical: 16.0),
                    decoration: const BoxDecoration(
                      gradient: LinearGradient(
                        colors: [Color(0xFF0D9488), Color(0xFF06B6D4)],
                      ),
                      borderRadius: BorderRadius.only(
                        topLeft: Radius.circular(27.0),
                        topRight: Radius.circular(27.0),
                      ),
                    ),
                    child: const Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        Icon(Icons.airplane_ticket_outlined, color: Colors.white, size: 20.0),
                        SizedBox(width: 8.0),
                        Text(
                          'E-TICKET BOARDING PASS',
                          style: TextStyle(
                            color: Colors.white, 
                            fontWeight: FontWeight.w900, 
                            fontSize: 13, 
                            letterSpacing: 0.5
                          ),
                        ),
                      ],
                    ),
                  ),

                  // Bagian Konten Manifes Tiket Asli dari Database
                  Padding(
                    padding: const EdgeInsets.all(24.0),
                    child: Column(
                      children: [
                        _buildTicketRow('KODE TRANSAKSI', orderCode, isBold: true),
                        _buildDivider(),
                        _buildTicketRow('KUANTITAS KURSI', totalPassengers),
                        _buildDivider(),
                        _buildTicketRow('TOTAL BIAYA', totalBayar, isPrimaryColor: true),
                        _buildDivider(),
                        _buildTicketRow('METODE VERIFIKASI', 'Aplikasi Mobile (Gate Instan)'),
                        
                        const SizedBox(height: 28.0),
                        const Divider(height: 1, color: Color(0xFFE2E8F0), thickness: 1),
                        const SizedBox(height: 24.0),

                        // AREA VISUALISASI QR CODE KONDISIONAL
                        if (isLunas) ...[
                          const Icon(Icons.qr_code_2_rounded, size: 140.0, color: Color(0xFF1E293B)),
                          const SizedBox(height: 12.0),
                          Container(
                            padding: const EdgeInsets.symmetric(horizontal: 14.0, vertical: 6.0),
                            decoration: BoxDecoration(
                              color: const Color(0xFFDCFCE7),
                              borderRadius: BorderRadius.circular(100.0),
                              border: Border.all(color: const Color(0xFFBBF7D0)),
                            ),
                            child: const Row(
                              mainAxisSize: MainAxisSize.min,
                              children: [
                                Icon(Icons.check_circle_rounded, color: Color(0xFF16A34A), size: 14.0),
                                SizedBox(width: 6.0),
                                Text(
                                  'Status: E-Ticket Aktif',
                                  style: TextStyle(fontSize: 11, fontWeight: FontWeight.bold, color: Color(0xFF16A34A)),
                                ),
                              ],
                            ),
                          ),
                        ] else ...[
                          const Icon(Icons.block_rounded, size: 120.0, color: Color(0xFFCBD5E1)),
                          const SizedBox(height: 16.0),
                          Container(
                            padding: const EdgeInsets.symmetric(horizontal: 14.0, vertical: 6.0),
                            decoration: BoxDecoration(
                              color: const Color(0xFFFEE2E2),
                              borderRadius: BorderRadius.circular(100.0),
                              border: Border.all(color: const Color(0xFFFECACA)),
                            ),
                            child: const Text(
                              'Status: Tiket Dibatalkan / Refunded',
                              style: TextStyle(fontSize: 11, fontWeight: FontWeight.bold, color: Color(0xFFDC2626)),
                            ),
                          ),
                        ],
                      ],
                    ),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 24.0),

            // TOMBOL AJUKAN REFUND / PEMBATALAN
            if (isLunas) ...[
              SizedBox(
                width: double.infinity,
                height: 48.0,
                child: OutlinedButton(
                  onPressed: () {
                    _showCancelConfirmationDialog();
                  },
                  style: OutlinedButton.styleFrom(
                    side: const BorderSide(color: Color(0xFFFCA5A5)),
                    backgroundColor: const Color(0xFFFEF2F2),
                    shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(14.0)),
                  ),
                  child: const Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Icon(Icons.keyboard_return_rounded, color: Color(0xFFDC2626), size: 16.0),
                      SizedBox(width: 8.0),
                      Text(
                        'Batalkan Tiket & Ajukan Refund',
                        style: TextStyle(color: Color(0xFFDC2626), fontWeight: FontWeight.bold, fontSize: 13),
                      ),
                    ],
                  ),
                ),
              ),
            ],
          ],
        ),
      ),
    );
  }

  Widget _buildTicketRow(String title, String value, {bool isBold = false, bool isPrimaryColor = false}) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        Text(
          title,
          style: const TextStyle(fontSize: 13, color: Color(0xFF94A3B8), fontWeight: FontWeight.w500),
        ),
        Text(
          value,
          style: TextStyle(
            fontSize: 13,
            fontWeight: (isBold || isPrimaryColor) ? FontWeight.bold : FontWeight.w700,
            color: isPrimaryColor ? const Color(0xFFFF5E1F) : const Color(0xFF1E293B),
          ),
        ),
      ],
    );
  }

  Widget _buildDivider() {
    return const Padding(
      padding: EdgeInsets.symmetric(vertical: 12.0),
      child: Divider(height: 1, color: Color(0xFFF1F5F9)),
    );
  }

  void _showCancelConfirmationDialog() {
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return AlertDialog(
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20.0)),
          title: const Text('Konfirmasi Pembatalan', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 16)),
          content: const Text(
            'Apakah Anda yakin ingin membatalkan tiket ini? Dana Anda akan dikembalikan lewat Refund otomatis.',
            style: TextStyle(fontSize: 13, color: Color(0xFF475569)),
          ),
          actions: [
            TextButton(
              onPressed: () => Navigator.pop(context),
              child: const Text('Kembali', style: TextStyle(color: Color(0xFF64748B), fontWeight: FontWeight.bold)),
            ),
            TextButton(
              onPressed: () {
                Navigator.pop(context);
                setState(() {
                  _ticketStatus = 'batal'; // Simulasi perubahan status pembatalan tiket
                });
              },
              child: const Text('Ya, Batalkan', style: TextStyle(color: Color(0xFFDC2626), fontWeight: FontWeight.w900)),
            ),
          ],
        );
      },
    );
  }
}