import 'package:flutter/material.dart';
import 'package:travelgo_app/services/api_service.dart';
import 'package:travelgo_app/screens/ticket_detail_screen.dart';

class PaymentScreen extends StatefulWidget {
  final Map<String, dynamic> orderData; // Menerima lemparan data transaksi asli dari Database

  const PaymentScreen({super.key, required this.orderData});

  @override
  State<PaymentScreen> createState() => _PaymentScreenState();
}

class _PaymentScreenState extends State<PaymentScreen> {
  String _selectedMethod = 'BCA VA';
  bool _isProcessingPayment = false; // Efek loading saat proses verifikasi bank ke Database

  void _eksekusiBayarKeDatabase() async {
    setState(() {
      _isProcessingPayment = true;
    });

    // Mengambil ID transaksi dari data yang dioper oleh Database
    final int idOrder = widget.orderData['id']; 

    // Menembak endpoint POST /api/order/{id}/bayar
    final hasilBayar = await ApiService.bayarPesanan(idOrder);

    setState(() {
      _isProcessingPayment = false;
    });

    if (hasilBayar != null && hasilBayar['status'] == 'sukses') {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text(hasilBayar['pesan'] ?? 'Pembayaran berhasil!'),
            backgroundColor: const Color(0xFF16A34A),
          ),
        );

        // Jika lunas, lempar langsung ke halaman E-Ticket utama
        final Map<String, dynamic> dataTiketLunas = Map<String, dynamic>.from(widget.orderData);
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(
            builder: (context) => TicketDetailScreen(
              orderData: dataTiketLunas),
          ),
        );
      }
    } else {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(
            content: Text('Gagal melakukan verifikasi pembayaran. Silakan coba kembali.'),
            backgroundColor: Color(0xFFEF4444),
          ),
        );
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    // Membaca manifest dinamis dari data tabel orders Database
    final String kodeTiket = widget.orderData['order_code'] ?? 'TK-UNKNOWN';
    final int pax = widget.orderData['total_passengers'] ?? 1;
    final String totalHarga = "Rp ${widget.orderData['total_price']}";

    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      appBar: AppBar(
        title: const Text(
          'Pembayaran',
          style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Color(0xFF1E293B)),
        ),
        backgroundColor: Colors.white,
        elevation: 0,
        leading: const BackButton(color: Color(0xFF1E293B)),
      ),
      body: Column(
        children: [
          Expanded(
            child: SingleChildScrollView(
              padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 16.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const Text(
                    'Selesaikan Pembayaran',
                    style: TextStyle(fontSize: 18, fontWeight: FontWeight.w900, color: Color(0xFF1E293B)),
                  ),
                  const SizedBox(height: 4.0),
                  const Text(
                    'Pilih metode pembayaran untuk menerbitkan E-Ticket Anda.',
                    style: TextStyle(fontSize: 13, color: Color(0xFF64748B)),
                  ),
                  const SizedBox(height: 20.0),

                  // KOMPONEN 1: RINGKASAN TIKET REAL-TIME DARI Database
                  Container(
                    width: double.infinity,
                    padding: const EdgeInsets.all(16.0),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(20.0),
                      border: Border.all(color: const Color(0xFFE2E8F0)),
                    ),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        const Row(
                          children: [
                            Icon(Icons.receipt_long_outlined, color: Color(0xFF94A3B8), size: 18.0),
                            SizedBox(width: 8.0),
                            Text(
                              'Ringkasan Tiket',
                              style: TextStyle(fontSize: 14, fontWeight: FontWeight.bold, color: Color(0xFF1E293B)),
                            ),
                          ],
                        ),
                        const Padding(
                          padding: EdgeInsets.symmetric(vertical: 12.0),
                          child: Divider(height: 1, color: Color(0xFFF1F5F9)),
                        ),
                        _buildSummaryRow('KODE TRANSAKSI TIKET', kodeTiket, isTeal: true),
                        const SizedBox(height: 12.0),
                        _buildSummaryRow('KUANTITAS PEMESANAN', '$pax Penumpang (Pax)'),
                        const SizedBox(height: 12.0),
                        _buildSummaryRow('STATUS TAGIHAN', 'PENDING (Menunggu Pembayaran)', isOrange: true),
                      ],
                    ),
                  ),
                  const SizedBox(height: 24.0),

                  // KOMPONEN 2: PILIHAN METODE PEMBAYARAN
                  const Text(
                    'Pilih Metode Pembayaran',
                    style: TextStyle(fontSize: 14, fontWeight: FontWeight.bold, color: Color(0xFF475569)),
                  ),
                  const SizedBox(height: 12.0),
                  
                  _buildPaymentMethodTile(
                    id: 'BCA VA',
                    title: 'BCA Virtual Account',
                    subtitle: 'Transfer dicek otomatis',
                    logoText: 'BCA',
                  ),
                  const SizedBox(height: 10.0),
                  _buildPaymentMethodTile(
                    id: 'Mandiri VA',
                    title: 'Mandiri Virtual Account',
                    subtitle: 'Transfer dari bank mandiri',
                    logoText: 'Mandiri',
                  ),
                  const SizedBox(height: 10.0),
                  _buildPaymentMethodTile(
                    id: 'GOPAY',
                    title: 'GoPay / E-Wallet',
                    subtitle: 'Konfirmasi instan via smartphone',
                    iconData: Icons.account_balance_wallet_outlined,
                  ),
                ],
              ),
            ),
          ),

          // KOMPONEN 3: BOTTOM TOTAL BAR & ACTION BUTTON
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 20.0, vertical: 16.0),
            decoration: BoxDecoration(
              color: Colors.white,
              boxShadow: const [
                BoxShadow(
                  color: Color(0x0A000000),
                  blurRadius: 10.0,
                  offset: Offset(0, -4),
                ),
              ],
            ),
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Text(
                      'Total Tagihan ($pax Pax)',
                      style: const TextStyle(fontSize: 11, color: Color(0xFF64748B)),
                    ),
                    const SizedBox(height: 2.0),
                    Text(
                      totalHarga,
                      style: const TextStyle(fontSize: 20, fontWeight: FontWeight.w900, color: Color(0xFFFF5E1F)),
                    ),
                  ],
                ),
                SizedBox(
                  height: 46.0,
                  child: ElevatedButton(
                    onPressed: _isProcessingPayment ? null : _eksekusiBayarKeDatabase, // Kunci tombol saat loading
                    style: ElevatedButton.styleFrom(
                      backgroundColor: const Color(0xFFFF5E1F),
                      disabledBackgroundColor: const Color(0xFFCBD5E1),
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12.0)),
                      padding: const EdgeInsets.symmetric(horizontal: 24.0),
                      elevation: 0,
                    ),
                    child: _isProcessingPayment
                        ? const SizedBox(
                            width: 18,
                            height: 18,
                            child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2),
                          )
                        : const Row(
                            children: [
                              Icon(Icons.check_circle_outline, color: Colors.white, size: 18.0),
                              SizedBox(width: 8.0),
                              Text(
                                'Bayar Sekarang',
                                style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold, fontSize: 14),
                              ),
                            ],
                          ),
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildSummaryRow(String title, String mainText, {bool isTeal = false, bool isOrange = false}) {
    Color textColor = const Color(0xFF1E293B);
    if (isTeal) textColor = const Color(0xFF0D9488);
    if (isOrange) textColor = const Color(0xFFEA580C);

    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          title.toUpperCase(),
          style: const TextStyle(fontSize: 9, fontWeight: FontWeight.bold, color: Color(0xFF94A3B8), letterSpacing: 0.5),
        ),
        const SizedBox(height: 2.0),
        Text(
          mainText,
          style: TextStyle(fontSize: 13, fontWeight: FontWeight.bold, color: textColor),
        ),
      ],
    );
  }

  Widget _buildPaymentMethodTile({
    required String id,
    required String title,
    required String subtitle,
    String? logoText,
    IconData? iconData,
  }) {
    bool isSelected = _selectedMethod == id;

    return GestureDetector(
      onTap: () {
        setState(() {
          _selectedMethod = id;
        });
      },
      child: Container(
        padding: const EdgeInsets.all(14.0),
        decoration: BoxDecoration(
          color: isSelected ? const Color(0x0A0D9488) : const Color(0xFFF8FAFC),
          borderRadius: BorderRadius.circular(16.0),
          border: Border.all(
            color: isSelected ? const Color(0xFF0D9488) : const Color(0xFFE2E8F0),
            width: isSelected ? 2.0 : 1.0,
          ),
        ),
        child: Row(
          children: [
            Container(
              width: 50,
              height: 38,
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(10.0),
                border: Border.all(color: const Color(0xFFE2E8F0)),
              ),
              alignment: Alignment.center,
              child: logoText != null
                  ? Text(
                      logoText,
                      style: TextStyle(
                        fontSize: 10, 
                        fontWeight: FontWeight.bold, 
                        color: logoText == 'BCA' ? const Color(0xFF0F766E) : const Color(0xFF1D4ED8),
                      ),
                    )
                  : Icon(iconData, color: const Color(0xFF10B981), size: 20.0),
            ),
            const SizedBox(width: 14.0),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    title,
                    style: const TextStyle(fontSize: 13, fontWeight: FontWeight.bold, color: Color(0xFF1E293B)),
                  ),
                  const SizedBox(height: 2.0),
                  Text(
                    subtitle,
                    style: const TextStyle(fontSize: 11, color: Color(0xFF94A3B8)),
                  ),
                ],
              ),
            ),
            Container(
              width: 16,
              height: 16,
              decoration: BoxDecoration(
                shape: BoxShape.circle,
                border: Border.all(
                  color: isSelected ? const Color(0xFF0D9488) : const Color(0xFFCBD5E1),
                  width: isSelected ? 5.0 : 1.5,
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}