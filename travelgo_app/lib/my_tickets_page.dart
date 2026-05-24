import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'payment_page.dart';
import 'ticket_detail_page.dart';

class MyTicketsPage extends StatefulWidget {
  final String token;

  const MyTicketsPage({super.key, required this.token});

  @override
  State<MyTicketsPage> createState() => _MyTicketsPageState();
}

class _MyTicketsPageState extends State<MyTicketsPage> {
  List _riwayatTiket = [];
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _tarikRiwayat();
  }

  Future<void> _tarikRiwayat() async {
    const String urlApi = "http://10.0.2.2:8000/api/pesanan/riwayat";

    try {
      final response = await http.get(
        Uri.parse(urlApi),
        headers: {
          'Authorization': 'Bearer ${widget.token}',
          'Accept': 'application/json',
        },
      );

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        setState(() {
          _riwayatTiket = data['data'];
          _isLoading = false;
        });
      } else {
        setState(() => _isLoading = false);
      }
    } catch (e) {
      debugPrint("Error: $e");
      setState(() => _isLoading = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey[100],
      appBar: AppBar(
        title: const Text('Tiket Saya'),
        backgroundColor: const Color(0xFF1BA0E2),
        foregroundColor: Colors.white,
        automaticallyImplyLeading: false,
      ),
      body: _isLoading
          ? const Center(child: CircularProgressIndicator())
          : _riwayatTiket.isEmpty
              ? const Center(child: Text("Belum ada riwayat pemesanan tiket."))
              : ListView.builder(
                  padding: const EdgeInsets.all(16),
                  itemCount: _riwayatTiket.length,
                  itemBuilder: (context, index) {
                    final pesanan = _riwayatTiket[index];
                    final jadwal = pesanan['schedule'];
                    final rute = jadwal['route'];
                    final armada = jadwal['transportation'];

                    return InkWell(
                      onTap: () async {
                        if (pesanan['status'] == 'pending') {
                          final result = await Navigator.push(
                            context,
                            MaterialPageRoute(
                              builder: (context) => PaymentPage(
                                orderId: pesanan['id'],
                                bookingCode: pesanan['order_code'],
                                totalPrice: pesanan['total_price'].toString(),
                                token: widget.token,
                              ),
                            ),
                          );
                          if (result == true) {
                              _tarikRiwayat(); // Refresh data setelah pembayaran sukses
                            }
                        } else {
                          Navigator.push(
                            context,
                            MaterialPageRoute(
                              builder: (context) => TicketDetailPage(pesanan: pesanan),
                            ),
                          );
                        }
                      },
                      child: Card(
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
                                    "Kode: ${pesanan['order_code']}",
                                    style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 16, color: Color(0xFFFF5E1F)),
                                  ),
                                  Container(
                                    padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                                    decoration: BoxDecoration(
                                      color: pesanan['status'] == 'pending' ? Colors.orange[100] : Colors.green[100],
                                      borderRadius: BorderRadius.circular(8)
                                    ),
                                    child: Text(
                                      pesanan['status'].toString().toUpperCase(),
                                      style: TextStyle(
                                        color: pesanan['status'] == 'pending' ? Colors.orange[800] : Colors.green[800],
                                        fontSize: 10,
                                        fontWeight: FontWeight.bold
                                      ),
                                    ),
                                  )
                                ],
                              ),
                              const Divider(height: 24),
                              Text("${armada['jenis']} (${armada['nama']}) (${armada['kelas']})", style: const TextStyle(fontWeight: FontWeight.bold)),
                              const SizedBox(height: 8),
                              Row(
                                children: [
                                  const Icon(Icons.location_on, size: 16, color: Colors.grey),
                                  const SizedBox(width: 4),
                                  Text("${rute['kota_asal']} ➔ ${rute['kota_tujuan']}"),
                                ],
                              ),
                              const SizedBox(height: 4),
                              Row(
                                children: [
                                  const Icon(Icons.calendar_today, size: 14, color: Colors.grey),
                                  const SizedBox(width: 4),
                                  Text("${jadwal['departure_date']} | ${jadwal['departure_time']}", style: const TextStyle(color: Colors.grey, fontSize: 12)),
                                ],
                              ),
                            ],
                          ),
                        ),
                      ),
                    );
                  },
                ),
    );
  }
}