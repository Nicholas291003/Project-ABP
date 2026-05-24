import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class SearchResultsPage extends StatefulWidget {
  final String token;
  final String asal;
  final String tujuan;
  final String tanggal;

  const SearchResultsPage({
    super.key,
    required this.token,
    required this.asal,
    required this.tujuan,
    required this.tanggal,
  });

  @override
  State<SearchResultsPage> createState() => _SearchResultsPageState();
}

class _SearchResultsPageState extends State<SearchResultsPage> {
  List _hasilPencarian = [];
  bool _isLoading = true;
  String _pesanError = '';

  @override
  void initState() {
    super.initState();
    _cariTiket();
  }

  Future<void> _cariTiket() async {
    // Memasukkan parameter pencarian ke dalam URL
    final String urlApi = 
        "http://10.0.2.2:8000/api/jadwal/search?asal=${widget.asal}&tujuan=${widget.tujuan}&tanggal=${widget.tanggal}";

    try {
      final response = await http.get(
        Uri.parse(urlApi),
        headers: {
          'Authorization': 'Bearer ${widget.token}',
          'Accept': 'application/json',
        },
      );

      final data = jsonDecode(response.body);

      if (response.statusCode == 200 && data['status'] == 'sukses') {
        setState(() {
          _hasilPencarian = data['data'];
          _isLoading = false;
        });
      } else {
        setState(() {
          _pesanError = data['pesan'] ?? 'Terjadi kesalahan saat mencari tiket.';
          _isLoading = false;
        });
      }
    } catch (e) {
      setState(() {
        _pesanError = 'Gagal terhubung ke server: $e';
        _isLoading = false;
      });
    }
  }

  Future<void> _buatPesanan(int scheduleId) async {
    // 1. Munculkan indikator loading (agar tidak diklik berkali-kali)
    showDialog(
      context: context,
      barrierDismissible: false,
      builder: (context) => const Center(child: CircularProgressIndicator()),
    );

    const String urlApi = "http://10.0.2.2:8000/api/order";

    try {
      final response = await http.post(
        Uri.parse(urlApi),
        headers: {
          'Authorization': 'Bearer ${widget.token}',
          'Accept': 'application/json',
        },
        body: {
          'schedule_id': scheduleId.toString(),
        },
      );

      // 2. Tutup indikator loading
      if (mounted) Navigator.pop(context);

      final data = jsonDecode(response.body);

      // 3. Tampilkan Notifikasi Hasilnya
      if (response.statusCode == 201 && data['status'] == 'sukses') {
        final orderData = data['data'];
        
        if (mounted) {
          showDialog(
            context: context,
            barrierDismissible: false,
            builder: (c) => AlertDialog(
              title: const Text('Pemesanan Berhasil! 🎉', style: TextStyle(color: Color(0xFF22C55E))),
              content: Text(
                'Tiket Anda sudah diamankan.\n\nKode Booking:\n${orderData['order_code']}\n\nTotal Bayar:\nRp ${orderData['total_price']}',
                style: const TextStyle(fontSize: 16),
              ),
              actions: [
                TextButton(
                  onPressed: () {
                    // Tutup pop-up
                    Navigator.pop(c); 
                    // (Opsional) Kembali ke halaman Dashboard setelah pesan
                    Navigator.pop(context); 
                  },
                  child: const Text('OK', style: TextStyle(fontWeight: FontWeight.bold)),
                ),
              ],
            ),
          );
        }
      } else {
        if (mounted) {
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(content: Text(data['pesan'] ?? 'Gagal membuat pesanan.')),
          );
        }
      }
    } catch (e) {
      if (mounted) Navigator.pop(context); // Tutup loading jika error
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Terjadi kesalahan: $e')),
        );
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey[100],
      appBar: AppBar(
        title: Text('${widget.asal} ➔ ${widget.tujuan}'),
        backgroundColor: const Color(0xFF1BA0E2),
        foregroundColor: Colors.white,
        elevation: 0,
      ),
      body: _isLoading
          ? const Center(child: CircularProgressIndicator())
          : _pesanError.isNotEmpty
              ? _buildErrorAtauKosong(_pesanError)
              : _hasilPencarian.isEmpty
                  ? _buildErrorAtauKosong("Maaf, tidak ada tiket yang tersedia untuk tanggal tersebut.")
                  : ListView.builder(
                      padding: const EdgeInsets.all(16),
                      itemCount: _hasilPencarian.length,
                      itemBuilder: (context, index) {
                        final jadwal = _hasilPencarian[index];
                        final armada = jadwal['transportation'];
                        
                        return Card(
                          elevation: 2,
                          margin: const EdgeInsets.only(bottom: 16),
                          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
                          child: Padding(
                            padding: const EdgeInsets.all(16),
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Row(
                                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                  children: [
                                    Text(
                                      armada['nama'],
                                      style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 18, color: Color(0xFF1BA0E2)),
                                    ),
                                    Container(
                                      padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                                      decoration: BoxDecoration(
                                        color: const Color(0xFFFF5E1F).withOpacity(0.1),
                                        borderRadius: BorderRadius.circular(8)
                                      ),
                                      child: Text(
                                        armada['kelas'],
                                        style: const TextStyle(color: Color(0xFFFF5E1F), fontWeight: FontWeight.bold, fontSize: 12),
                                      ),
                                    )
                                  ],
                                ),
                                const Divider(height: 24, thickness: 1),
                                Row(
                                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                  children: [
                                    Column(
                                      crossAxisAlignment: CrossAxisAlignment.start,
                                      children: [
                                        const Text('Berangkat', style: TextStyle(color: Colors.grey, fontSize: 12)),
                                        const SizedBox(height: 4),
                                        Text(jadwal['departure_time'], style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 16)),
                                      ],
                                    ),
                                    const Icon(Icons.arrow_forward, color: Colors.grey),
                                    Column(
                                      crossAxisAlignment: CrossAxisAlignment.end,
                                      children: [
                                        const Text('Tiba', style: TextStyle(color: Colors.grey, fontSize: 12)),
                                        const SizedBox(height: 4),
                                        Text(jadwal['arrival_time'] ?? '-', style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 16)),
                                      ],
                                    ),
                                  ],
                                ),
                                const SizedBox(height: 20),
                                Row(
                                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                  children: [
                                    Text(
                                      "Rp ${jadwal['price']}",
                                      style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 20, color: Color(0xFF22C55E)),
                                    ),
                                    ElevatedButton(
                                      onPressed: () {
                                        // Panggil fungsi buat pesanan dengan mengirimkan ID Jadwal
                                        _buatPesanan(jadwal['id']);
                                      },
                                      style: ElevatedButton.styleFrom(
                                        backgroundColor: const Color(0xFFFF5E1F),
                                        foregroundColor: Colors.white,
                                        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
                                      ),
                                      child: const Text('Pilih'),
                                    )
                                  ],
                                )
                              ],
                            ),
                          ),
                        );
                      },
                    ),
    );
  }

  // Tampilan jika tiket kosong atau error
  Widget _buildErrorAtauKosong(String pesan) {
    return Center(
      child: Padding(
        padding: const EdgeInsets.all(24.0),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            const Icon(Icons.search_off, size: 80, color: Colors.grey),
            const SizedBox(height: 16),
            Text(pesan, textAlign: TextAlign.center, style: const TextStyle(fontSize: 16, color: Colors.grey)),
            const SizedBox(height: 24),
            ElevatedButton(
              onPressed: () => Navigator.pop(context), // Kembali ke Dashboard
              child: const Text('Cari Tanggal Lain'),
            )
          ],
        ),
      ),
    );
  }
}