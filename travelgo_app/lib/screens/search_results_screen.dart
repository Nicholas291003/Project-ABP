import 'package:flutter/material.dart';
import 'package:travelgo_app/services/api_service.dart';
import 'package:travelgo_app/screens/select_seat_screen.dart';

class SearchResultsScreen extends StatefulWidget {
  final String kotaAsal;
  final String kotaTujuan;
  final String tanggalPergi;

  const SearchResultsScreen({
    super.key,
    required this.kotaAsal,
    required this.kotaTujuan,
    required this.tanggalPergi,
  });

  @override
  State<SearchResultsScreen> createState() => _SearchResultsScreenState();
}

class _SearchResultsScreenState extends State<SearchResultsScreen> {
  List<dynamic> _daftarJadwalHasil = [];
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _eksekusiCariTiket();
  }

  void _eksekusiCariTiket() async {
    // Memanggil API searchJadwal dengan data kiriman dari halaman beranda
    final data = await ApiService.searchJadwal(
      widget.kotaAsal,
      widget.kotaTujuan,
      widget.tanggalPergi,
    );

    if (data != null) {
      setState(() {
        _daftarJadwalHasil = data;
        _isLoading = false;
      });
    } else {
      setState(() {
        _isLoading = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      body: Stack(
        children: [
          // BEBOLA GRADASI AMBIENT GLOW
          Positioned(
            top: -50,
            right: -100,
            child: Container(
              width: 300,
              height: 300,
              decoration: BoxDecoration(
                shape: BoxShape.circle,
                boxShadow: [
                  BoxShadow(
                    color: const Color(0xFF2DD4BF).withOpacity(0.1),
                    blurRadius: 100,
                    spreadRadius: 40,
                  ),
                ],
              ),
            ),
          ),

          // KONTEN UTAMA LAYAR
          SafeArea(
            child: Column(
              children: [
                // 1. HEADER RINGKASAN PENCARIAN
                Container(
                  width: double.infinity,
                  margin: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 16.0),
                  padding: const EdgeInsets.all(16.0),
                  decoration: BoxDecoration(
                    color: Colors.white.withOpacity(0.85),
                    borderRadius: BorderRadius.circular(24.0),
                    border: Border.all(color: Colors.white.withOpacity(0.6), width: 1.5),
                    boxShadow: [
                      BoxShadow(
                        color: const Color(0xFF71717A).withOpacity(0.08),
                        blurRadius: 15.0,
                        offset: const Offset(0, 4.0),
                      ),
                    ],
                  ),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Container(
                        padding: const EdgeInsets.symmetric(horizontal: 10.0, vertical: 4.0),
                        decoration: BoxDecoration(
                          color: const Color(0xFF0D9488).withOpacity(0.1),
                          borderRadius: BorderRadius.circular(8.0),
                        ),
                        child: const Text(
                          'HASIL PENCARIAN TIKET',
                          style: TextStyle(
                            fontSize: 9,
                            fontWeight: FontWeight.w900,
                            color: Color(0xFF0F766E),
                            letterSpacing: 1.0,
                          ),
                        ),
                      ),
                      const SizedBox(height: 12.0),
                      Row(
                        children: [
                          Text(
                            widget.kotaAsal,
                            style: const TextStyle(fontSize: 18, fontWeight: FontWeight.w900, color: Color(0xFF1E293B)),
                          ),
                          const Padding(
                            padding: EdgeInsets.symmetric(horizontal: 8.0),
                            child: Icon(Icons.arrow_forward_rounded, size: 16.0, color: Color(0xFF94A3B8)),
                          ),
                          Text(
                            widget.kotaTujuan,
                            style: const TextStyle(fontSize: 18, fontWeight: FontWeight.w900, color: Color(0xFF1E293B)),
                          ),
                        ],
                      ),
                      const SizedBox(height: 4.0),
                      Row(
                        children: [
                          const Icon(Icons.calendar_today_outlined, size: 12.0, color: Color(0xFF64748B)),
                          const SizedBox(width: 6.0),
                          Text(
                            widget.tanggalPergi,
                            style: const TextStyle(fontSize: 12, fontWeight: FontWeight.w600, color: Color(0xFF64748B)),
                          ),
                        ],
                      ),
                    ],
                  ),
                ),

                // 2. AREA TAMPILAN JADWAL (KONDISIONAL)
                Expanded(
                  child: _isLoading
                      ? const Center(
                          child: CircularProgressIndicator(color: Color(0xFF0D9488)),
                        )
                      : _daftarJadwalHasil.isEmpty
                          ? Center(
                              child: Column(
                                mainAxisAlignment: MainAxisAlignment.center,
                                children: [
                                  const Icon(Icons.sentiment_dissatisfied_rounded, size: 48.0, color: Color(0xFF94A3B8)),
                                  const SizedBox(height: 12.0),
                                  const Text(
                                    'Maaf, tiket tidak tersedia\nuntuk rute dan tanggal tersebut.',
                                    textAlign: TextAlign.center,
                                    style: TextStyle(fontSize: 14, color: Color(0xFF64748B), fontWeight: FontWeight.w500),
                                  ),
                                ],
                              ),
                            )
                          : ListView.builder(
                              itemCount: _daftarJadwalHasil.length,
                              padding: const EdgeInsets.symmetric(horizontal: 16.0),
                              itemBuilder: (context, index) {
                                final jadwal = _daftarJadwalHasil[index];
                                
                                // Memetakan data JSON dari database Laravel Anda
                                String namaArmada = jadwal['transportation']['name'] ?? 'Armada';
                                String tipeKelas = (jadwal['class'] ?? 'EKSEKUTIF').toString().toUpperCase();
                                String jamMulai = (jadwal['departure_time'] ?? '00:00').toString().substring(0, 5);
                                String jamSelesai = (jadwal['arrival_time'] ?? '00:00').toString().substring(0, 5);
                                int sisaKursi = jadwal['remaining_seats'] ?? 0;
                                String hargaTiket = 'Rp ${jadwal['price']}';

                                return Container(
                                  margin: const EdgeInsets.only(bottom: 14.0),
                                  padding: const EdgeInsets.all(16.0),
                                  decoration: BoxDecoration(
                                    color: Colors.white.withOpacity(0.85),
                                    borderRadius: BorderRadius.circular(24.0),
                                    border: Border.all(color: Colors.white.withOpacity(0.6), width: 1.5),
                                    boxShadow: [
                                      BoxShadow(
                                        color: const Color(0xFF71717A).withOpacity(0.06),
                                        blurRadius: 15.0,
                                        offset: const Offset(0, 6.0),
                                      ),
                                    ],
                                  ),
                                  child: Column(
                                    children: [
                                      Row(
                                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                        children: [
                                          Text(
                                            namaArmada,
                                            style: const TextStyle(fontSize: 15, fontWeight: FontWeight.w900, color: Color(0xFF1E293B)),
                                          ),
                                          Container(
                                            padding: const EdgeInsets.symmetric(horizontal: 8.0, vertical: 2.0),
                                            decoration: BoxDecoration(
                                              color: const Color(0xFFF1F5F9),
                                              borderRadius: BorderRadius.circular(6.0),
                                            ),
                                            child: Text(
                                              tipeKelas,
                                              style: const TextStyle(fontSize: 9, fontWeight: FontWeight.w800, color: Color(0xFF475569)),
                                            ),
                                          ),
                                        ],
                                      ),
                                      const SizedBox(height: 16.0),
                                      Row(
                                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                        children: [
                                          Column(
                                            crossAxisAlignment: CrossAxisAlignment.start,
                                            children: [
                                              Text(jamMulai, style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Color(0xFF1E293B))),
                                              const SizedBox(height: 2.0),
                                              const Text('ASAL', style: TextStyle(fontSize: 11, color: Color(0xFF94A3B8), fontWeight: FontWeight.w600)),
                                            ],
                                          ),
                                          Column(
                                            children: [
                                              Container(
                                                width: 80,
                                                height: 1,
                                                color: const Color(0xFFE2E8F0),
                                              ),
                                            ],
                                          ),
                                          Column(
                                            crossAxisAlignment: CrossAxisAlignment.end,
                                            children: [
                                              Text(jamSelesai, style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Color(0xFF1E293B))),
                                              const SizedBox(height: 2.0),
                                              const Text('TUJUAN', style: TextStyle(fontSize: 11, color: Color(0xFF94A3B8), fontWeight: FontWeight.w600)),
                                            ],
                                          ),
                                        ],
                                      ),
                                      const SizedBox(height: 16.0),
                                      const Divider(height: 1, color: Color(0xFFF1F5F9)),
                                      const SizedBox(height: 12.0),
                                      Row(
                                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                        children: [
                                          Column(
                                            crossAxisAlignment: CrossAxisAlignment.start,
                                            children: [
                                              Text(
                                                'Sisa $sisaKursi Kursi Tersedia',
                                                style: const TextStyle(fontSize: 11, fontWeight: FontWeight.w800, color: Color(0xFF0D9488)),
                                              ),
                                              const SizedBox(height: 2.0),
                                              Text(
                                                hargaTiket,
                                                style: const TextStyle(fontSize: 16, fontWeight: FontWeight.w900, color: Color(0xFFFF5E1F)),
                                              ),
                                            ],
                                          ),
                                          SizedBox(
                                            height: 36.0,
                                            child: ElevatedButton(
                                              onPressed: () {
                                                // Mengambil ID jadwal asli dari database Laravel
                                                final int idJadwal = jadwal['id']; 

                                                Navigator.push(
                                                  context,
                                                  MaterialPageRoute(
                                                    builder: (context) => SelectSeatScreen(
                                                      scheduleId: idJadwal, // Kirim ID jadwal ke halaman kursi
                                                    ),
                                                  ),
                                                );
                                              },
                                              style: ElevatedButton.styleFrom(
                                                backgroundColor: const Color(0xFF0D9488),
                                                shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10.0)),
                                                padding: const EdgeInsets.symmetric(horizontal: 16.0),
                                                elevation: 0,
                                              ),
                                              child: const Text(
                                                'PILIH',
                                                style: TextStyle(color: Colors.white, fontSize: 11, fontWeight: FontWeight.w900),
                                              ),
                                            ),
                                          ),
                                        ],
                                      ),
                                    ],
                                  ),
                                );
                              },
                            ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}