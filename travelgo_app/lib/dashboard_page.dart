import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

// Import halaman-halaman lain yang saling terhubung
import 'route_map_page.dart';
import 'search_results_page.dart';
import 'my_tickets_page.dart';
import 'profile_page.dart';

class DashboardPage extends StatefulWidget {
  final String namaUser;
  final String token;

  const DashboardPage({super.key, required this.namaUser, required this.token});

  @override
  State<DashboardPage> createState() => _DashboardPageState();
}

class _DashboardPageState extends State<DashboardPage> {
  int _selectedIndex = 0;
  
  // Variabel penampung data dari Laravel
  List _jadwalPopuler = [];
  bool _isLoadingJadwal = true;

  // Controller untuk Form Pencarian
  final TextEditingController _asalController = TextEditingController();
  final TextEditingController _tujuanController = TextEditingController();
  DateTime _tanggalPilih = DateTime.now();

  @override
  void initState() {
    super.initState();
    _ambilJadwalPopuler(); 
  }

  // Fungsi memanggil API Rute Terpopuler
  Future<void> _ambilJadwalPopuler() async {
    const String urlApi = "http://10.0.2.2:8000/api/jadwal/populer";

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
          _jadwalPopuler = data['data'];
          _isLoadingJadwal = false;
        });
      } else {
        setState(() => _isLoadingJadwal = false);
      }
    } catch (e) {
      setState(() => _isLoadingJadwal = false);
      debugPrint("Gagal menarik data: $e");
    }
  }

  // Fungsi untuk memunculkan kalender HP
  Future<void> _pilihTanggal(BuildContext context) async {
    final DateTime? tanggalDipilih = await showDatePicker(
      context: context,
      initialDate: _tanggalPilih,
      firstDate: DateTime.now(),
      lastDate: DateTime(2030),
    );

    if (tanggalDipilih != null && tanggalDipilih != _tanggalPilih) {
      setState(() {
        _tanggalPilih = tanggalDipilih;
      });
    }
  }

  // Memisahkan konten Beranda ke dalam fungsi khusus agar rapi
  Widget _buildBeranda() {
    return SafeArea(
      child: SingleChildScrollView(
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // 1. HEADER PROFIL
            Container(
              padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 30),
              decoration: const BoxDecoration(
                color: Color(0xFF1BA0E2),
                borderRadius: BorderRadius.only(bottomLeft: Radius.circular(30), bottomRight: Radius.circular(30)),
              ),
              child: Row(
                children: [
                  const CircleAvatar(
                    radius: 28, 
                    backgroundColor: Colors.white, 
                    child: Icon(Icons.person, color: Color(0xFF1BA0E2), size: 35)
                  ),
                  const SizedBox(width: 16),
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        const Text('Selamat Datang,', style: TextStyle(color: Colors.white70, fontSize: 14)),
                        Text(widget.namaUser, style: const TextStyle(color: Colors.white, fontSize: 22, fontWeight: FontWeight.bold), overflow: TextOverflow.ellipsis),
                      ],
                    ),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 24),

            // 2. FORM PENCARIAN TIKET
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 24),
              child: Container(
                padding: const EdgeInsets.all(20),
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(20),
                  boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.05), blurRadius: 15, offset: const Offset(0, 5))],
                ),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    const Text('Mau pergi ke mana hari ini?', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
                    const SizedBox(height: 20),

                    // Input Kota Asal
                    TextField(
                      controller: _asalController,
                      decoration: InputDecoration(
                        hintText: 'Asal (Contoh: Bandung)',
                        prefixIcon: const Icon(Icons.flight_takeoff, color: Color(0xFF1BA0E2)),
                        border: OutlineInputBorder(borderRadius: BorderRadius.circular(12)),
                        contentPadding: const EdgeInsets.symmetric(vertical: 0),
                      ),
                    ),
                    const SizedBox(height: 12),

                    // Input Kota Tujuan
                    TextField(
                      controller: _tujuanController,
                      decoration: InputDecoration(
                        hintText: 'Tujuan (Contoh: Jakarta)',
                        prefixIcon: const Icon(Icons.flight_land, color: Color(0xFFFF5E1F)),
                        border: OutlineInputBorder(borderRadius: BorderRadius.circular(12)),
                        contentPadding: const EdgeInsets.symmetric(vertical: 0),
                      ),
                    ),
                    const SizedBox(height: 12),

                    // Input Pemilihan Tanggal
                    InkWell(
                      onTap: () => _pilihTanggal(context),
                      child: Container(
                        padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 15),
                        decoration: BoxDecoration(
                          border: Border.all(color: Colors.grey[400]!),
                          borderRadius: BorderRadius.circular(12),
                        ),
                        child: Row(
                          children: [
                            const Icon(Icons.calendar_today, color: Color(0xFF22C55E)),
                            const SizedBox(width: 12),
                            Text(
                              "${_tanggalPilih.year}-${_tanggalPilih.month.toString().padLeft(2, '0')}-${_tanggalPilih.day.toString().padLeft(2, '0')}",
                              style: const TextStyle(fontSize: 16),
                            ),
                          ],
                        ),
                      ),
                    ),
                    const SizedBox(height: 20),

                    // Tombol Cari Tiket & Shortcut Peta
                    Row(
                      children: [
                        Expanded(
                          child: ElevatedButton(
                            onPressed: () {
                              if (_asalController.text.trim().isEmpty || _tujuanController.text.trim().isEmpty) {
                                ScaffoldMessenger.of(context).showSnackBar(
                                  const SnackBar(content: Text('Kota Asal dan Tujuan wajib diisi!')),
                                );
                                return;
                              }

                              String tanggalFormat = "${_tanggalPilih.year}-${_tanggalPilih.month.toString().padLeft(2, '0')}-${_tanggalPilih.day.toString().padLeft(2, '0')}";

                              Navigator.push(
                                context,
                                MaterialPageRoute(
                                  builder: (context) => SearchResultsPage(
                                    token: widget.token,
                                    asal: _asalController.text.trim(),
                                    tujuan: _tujuanController.text.trim(),
                                    tanggal: tanggalFormat,
                                  ),
                                ),
                              );
                            },
                            style: ElevatedButton.styleFrom(
                              backgroundColor: const Color(0xFF1BA0E2),
                              padding: const EdgeInsets.symmetric(vertical: 14),
                              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                            ),
                            child: const Text('Cari Tiket', style: TextStyle(color: Colors.white, fontSize: 16, fontWeight: FontWeight.bold)),
                          ),
                        ),
                        const SizedBox(width: 12),
                        
                        // Tombol Peta
                        InkWell(
                          onTap: () {
                            Navigator.push(
                              context,
                              MaterialPageRoute(
                                builder: (context) => RouteMapPage(
                                  token: widget.token,
                                  routeId: 1, 
                                ),
                              ),
                            );
                          },
                          child: Container(
                            padding: const EdgeInsets.all(12),
                            decoration: BoxDecoration(
                              color: const Color(0xFF8B5CF6).withOpacity(0.15),
                              borderRadius: BorderRadius.circular(12),
                            ),
                            child: const Icon(Icons.map_outlined, color: Color(0xFF8B5CF6)),
                          ),
                        )
                      ],
                    ),
                  ],
                ),
              ),
            ),
            const SizedBox(height: 30),

            // 3. RUTE TERPOPULER DARI API DATABASE
            const Padding(
              padding: EdgeInsets.symmetric(horizontal: 24),
              child: Text('Rute Terpopuler', style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold)),
            ),
            const SizedBox(height: 15),
            
            SizedBox(
              height: 180,
              child: _isLoadingJadwal
                  ? const Center(child: CircularProgressIndicator())
                  : _jadwalPopuler.isEmpty
                      ? const Center(child: Text("Belum ada rute tersedia"))
                      : ListView.builder(
                          scrollDirection: Axis.horizontal,
                          padding: const EdgeInsets.symmetric(horizontal: 16),
                          itemCount: _jadwalPopuler.length,
                          itemBuilder: (context, index) {
                            final jadwal = _jadwalPopuler[index];
                            final armada = jadwal['transportation'];
                            final rute = jadwal['route'];
                            
                            return Container(
                              width: 260,
                              margin: const EdgeInsets.symmetric(horizontal: 8),
                              padding: const EdgeInsets.all(16),
                              decoration: BoxDecoration(
                                color: Colors.white,
                                borderRadius: BorderRadius.circular(15),
                                border: Border.all(color: Colors.grey[200]!),
                                boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.02), blurRadius: 10)],
                              ),
                              child: Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Row(
                                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                    children: [
                                      Text(armada['nama'], style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 16, color: Color(0xFF1BA0E2))),
                                      Container(
                                        padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                                        decoration: BoxDecoration(color: const Color(0xFFFF5E1F).withOpacity(0.1), borderRadius: BorderRadius.circular(8)),
                                        child: Text(armada['kelas'], style: const TextStyle(color: Color(0xFFFF5E1F), fontSize: 10, fontWeight: FontWeight.bold)),
                                      )
                                    ],
                                  ),
                                  const SizedBox(height: 12),
                                  Row(
                                    children: [
                                      const Icon(Icons.location_on, size: 16, color: Colors.grey),
                                      const SizedBox(width: 4),
                                      Expanded(child: Text("${rute['kota_asal']} - ${rute['kota_tujuan']}", style: const TextStyle(fontWeight: FontWeight.w600, fontSize: 14))),
                                    ],
                                  ),
                                  const SizedBox(height: 8),
                                  Row(
                                    children: [
                                      const Icon(Icons.calendar_today, size: 14, color: Colors.grey),
                                      const SizedBox(width: 4),
                                      Text("${jadwal['departure_date']} | ${jadwal['departure_time']}", style: const TextStyle(color: Colors.grey, fontSize: 12)),
                                    ],
                                  ),
                                  const Spacer(),
                                  Row(
                                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                    children: [
                                      Text("Rp ${jadwal['price']}", style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 16, color: Color(0xFF22C55E))),
                                      const Icon(Icons.arrow_forward_ios, size: 14, color: Colors.grey),
                                    ],
                                  ),
                                ],
                              ),
                            );
                          },
                        ),
            )
          ],
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey[50],
      
      // Mengubah isi layar berdasarkan menu bawah yang ditekan
      body: _selectedIndex == 0 
          ? _buildBeranda() 
          : _selectedIndex == 1 
              ? MyTicketsPage(token: widget.token) 
              : ProfilePage(namaUser: widget.namaUser, token: widget.token),

      bottomNavigationBar: BottomNavigationBar(
        currentIndex: _selectedIndex,
        onTap: (index) => setState(() => _selectedIndex = index),
        selectedItemColor: const Color(0xFF1BA0E2),
        unselectedItemColor: Colors.grey,
        items: const [
          BottomNavigationBarItem(icon: Icon(Icons.home), label: 'Beranda'),
          BottomNavigationBarItem(icon: Icon(Icons.confirmation_number), label: 'Tiket Saya'),
          BottomNavigationBarItem(icon: Icon(Icons.person), label: 'Profil'),
        ],
      ),
    );
  }
}