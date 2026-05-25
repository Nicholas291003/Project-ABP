import 'package:flutter/material.dart';
import 'package:travelgo_app/services/api_service.dart';
import 'package:travelgo_app/screens/search_results_screen.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({super.key});

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  String _selectedTransport = 'kereta'; 
  List<dynamic> _rutePopulerDinas = []; 
  bool _isLoadingRute = true;           

  // 1. DEKLARASI CONTROLLER INPUT MANUAL
  final TextEditingController _asalController = TextEditingController(text: 'Jakarta');
  final TextEditingController _tujuanController = TextEditingController(text: 'Yogyakarta');
  DateTime _tanggalTerpilih = DateTime.now(); // Default tanggal hari ini

  @override
  void initState() {
    super.initState();
    _muatRutePopuler(); 
  }

  void _muatRutePopuler() async {
    final data = await ApiService.getRutePopuler();
    if (data != null) {
      setState(() {
        _rutePopulerDinas = data;
        _isLoadingRute = false;
      });
    } else {
      setState(() {
        _isLoadingRute = false;
      });
    }
  }

  // 2. FUNGSI MEMBUKA KALENDER DI MOBILE
  Future<void> _pilihTanggalPerjalanan(BuildContext context) async {
    final DateTime? picked = await showDatePicker(
      context: context,
      initialDate: _tanggalTerpilih,
      firstDate: DateTime(2026), // Batas awal tahun kalender
      lastDate: DateTime(2030),  // Batas akhir tahun kalender
      builder: (context, child) {
        return Theme(
          data: Theme.of(context).copyWith(
            colorScheme: const ColorScheme.light(
              primary: Color(0xFF0D9488), // Warna tema toska utama kalender
              onPrimary: Colors.white,
              onSurface: Color(0xFF1E293B),
            ),
          ),
          child: child!,
        );
      },
    );
    if (picked != null && picked != _tanggalTerpilih) {
      setState(() {
        _tanggalTerpilih = picked;
      });
    }
  }

  // Helper untuk mengubah object DateTime menjadi teks string YYYY-MM-DD sesuai standar Laravel
  String _formatTanggalKeString(DateTime date) {
    return "${date.year}-${date.month.toString().padLeft(2, '0')}-${date.day.toString().padLeft(2, '0')}";
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      body: Stack(
        children: [
          // BEBOLA GRADASI AMBIENT GLOW
          Positioned(
            top: -100,
            left: -100,
            child: Container(
              width: 300,
              height: 300,
              decoration: BoxDecoration(
                shape: BoxShape.circle,
                boxShadow: [
                  BoxShadow(
                    color: const Color(0xFF6EE7B7).withOpacity(0.15),
                    blurRadius: 100,
                    spreadRadius: 50,
                  ),
                ],
              ),
            ),
          ),

          // KONTEN UTAMA
          SafeArea(
            child: SingleChildScrollView(
              padding: const EdgeInsets.all(20.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const Text(
                    'Halo, Budi! 👋',
                    style: TextStyle(fontSize: 26, fontWeight: FontWeight.w900, color: Color(0xFF1E293B), letterSpacing: -0.5),
                  ),
                  const SizedBox(height: 4),
                  const Text(
                    'Mau ke mana hari ini?',
                    style: TextStyle(fontSize: 14, color: Color(0xFF64748B)),
                  ),
                  const SizedBox(height: 24),

                  // BENTO BOX BARIS 1: Cuaca
                  _buildBentoBox(
                    child: Row(
                      children: [
                        Container(
                          padding: const EdgeInsets.all(10),
                          decoration: BoxDecoration(
                            color: const Color(0xFF0EA5E9).withOpacity(0.1),
                            borderRadius: BorderRadius.circular(12),
                          ),
                          child: const Icon(Icons.cloud_queue, color: Color(0xFF0EA5E9)),
                        ),
                        const SizedBox(width: 14),
                        const Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              'CUACA HARI INI',
                              style: TextStyle(fontSize: 10, fontWeight: FontWeight.w800, color: Color(0xFF94A3B8), letterSpacing: 1.2),
                            ),
                            SizedBox(height: 2),
                            Row(
                              children: [
                                Text('Surabaya', style: TextStyle(fontSize: 14, fontWeight: FontWeight.bold, color: Color(0xFF1E293B))),
                                SizedBox(width: 6),
                                Text('29°C', style: TextStyle(fontSize: 14, fontWeight: FontWeight.w800, color: Color(0xFF64748B))),
                              ],
                            ),
                          ],
                        ),
                      ],
                    ),
                  ),
                  const SizedBox(height: 16),

                  // BENTO BOX BARIS 2: Pilihan Jenis Kendaraan
                  Row(
                    children: [
                      Expanded(child: _buildTransportTab('kereta', '🚄', 'Kereta')),
                      const SizedBox(width: 10),
                      Expanded(child: _buildTransportTab('bus', '🚌', 'Bus & Travel')),
                      const SizedBox(width: 10),
                      Expanded(child: _buildTransportTab('pesawat', '✈️', 'Pesawat')),
                    ],
                  ),
                  const SizedBox(height: 16),

                  // BENTO BOX BARIS 3: Form Utama Pencarian Rute (Dinamis / Manual)
                  _buildBentoBox(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        // Input Kota Asal
                        _buildInputFieldManual(
                          icon: Icons.location_on_outlined, 
                          label: 'Dari', 
                          controller: _asalController,
                        ),
                        const Padding(
                          padding: EdgeInsets.symmetric(vertical: 8.0),
                          child: Divider(height: 1, color: Color(0xFFF1F5F9)),
                        ),
                        // Input Kota Tujuan
                        _buildInputFieldManual(
                          icon: Icons.my_location_outlined, 
                          label: 'Ke', 
                          controller: _tujuanController,
                        ),
                        const Padding(
                          padding: EdgeInsets.symmetric(vertical: 8.0),
                          child: Divider(height: 1, color: Color(0xFFF1F5F9)),
                        ),
                        // Input Pilihan Tanggal Klik Interaktif
                        GestureDetector(
                          onTap: () => _pilihTanggalPerjalanan(context),
                          child: Container(
                            color: Colors.transparent, // Mengamankan area sentuh klik
                            padding: const EdgeInsets.symmetric(vertical: 6.0),
                            child: Row(
                              children: [
                                const Icon(Icons.calendar_month_outlined, color: Color(0xFF94A3B8), size: 20),
                                const SizedBox(width: 14),
                                Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    const Text(
                                      'TANGGAL PERGI',
                                      style: TextStyle(fontSize: 9, fontWeight: FontWeight.w800, color: Color(0xFF94A3B8), letterSpacing: 0.8),
                                    ),
                                    const SizedBox(height: 2),
                                    Text(
                                      _formatTanggalKeString(_tanggalTerpilih), // Menampilkan string dinamis tanggal pilihan
                                      style: const TextStyle(fontSize: 14, fontWeight: FontWeight.bold, color: Color(0xFF1E293B)),
                                    ),
                                  ],
                                ),
                              ],
                            ),
                          ),
                        ),
                        const SizedBox(height: 24),
                        
                        // Tombol Cari Tiket Berdasarkan Input Manual
                        Container(
                          width: double.infinity,
                          height: 48,
                          decoration: BoxDecoration(
                            borderRadius: BorderRadius.circular(14),
                            gradient: const LinearGradient(colors: [Color(0xFFFF5E1F), Color(0xFFE04A0D)]),
                          ),
                          child: ElevatedButton(
                            onPressed: () {
                              Navigator.push(
                                context,
                                MaterialPageRoute(
                                  builder: (context) => SearchResultsScreen(
                                    kotaAsal: _asalController.text,         // Mengambil teks dari input Dari
                                    kotaTujuan: _tujuanController.text,     // Mengambil teks dari input Ke
                                    tanggalPergi: _formatTanggalKeString(_tanggalTerpilih), // Mengambil tanggal string terpilih
                                  ),
                                ),
                              );
                            },
                            style: ElevatedButton.styleFrom(
                              backgroundColor: Colors.transparent,
                              shadowColor: Colors.transparent,
                              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(14)),
                            ),
                            child: const Text(
                              'Cari Tiket Perjalanan',
                              style: TextStyle(color: Colors.white, fontWeight: FontWeight.w800, fontSize: 14),
                            ),
                          ),
                        ),
                      ],
                    ),
                  ),
                  const SizedBox(height: 24),

                  // BENTO BOX BARIS 4: Info Sekilas Rute Populer
                  const Row(
                    children: [
                      Icon(Icons.local_fire_department_rounded, color: Colors.orange, size: 20),
                      SizedBox(width: 6),
                      Text(
                        'Rute Populer Saat Ini',
                        style: TextStyle(fontSize: 16, fontWeight: FontWeight.w900, color: Color(0xFF334155), letterSpacing: -0.3),
                      ),
                    ],
                  ),
                  const SizedBox(height: 12),
                  
                  if (_isLoadingRute)
                    const Center(child: Padding(padding: EdgeInsets.all(20.0), child: CircularProgressIndicator(color: Color(0xFF2DD4BF))))
                  else if (_rutePopulerDinas.isEmpty)
                    _buildBentoBox(child: const Center(child: Text('Belum ada rute populer tersedia saat ini.', style: TextStyle(fontSize: 13, color: Colors.grey))))
                  else
                    Column(
                      children: _rutePopulerDinas.map((jadwal) {
                        String asal = jadwal['route']['kota_asal'] ?? '-';
                        String tujuan = jadwal['route']['kota_tujuan'] ?? '-';
                        String armada = jadwal['transportation']['name'] ?? 'Armada';
                        String harga = 'Rp ${jadwal['price']}';

                        return Padding(
                          padding: const EdgeInsets.only(bottom: 10.0),
                          child: _buildBentoBox(
                            child: Row(
                              mainAxisAlignment: MainAxisAlignment.spaceBetween,
                              children: [
                                Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    Text('$asal ➔ $tujuan', style: const TextStyle(fontWeight: FontWeight.w800, fontSize: 14, color: Color(0xFF1E293B))),
                                    const SizedBox(height: 2),
                                    Text('$armada • Tersedia ${jadwal['remaining_seats']} Kursi', style: const TextStyle(fontSize: 11, color: Color(0xFF64748B), fontWeight: FontWeight.w500)),
                                  ],
                                ),
                                Text(harga, style: const TextStyle(fontWeight: FontWeight.w900, fontSize: 14, color: Color(0xFFC2410C))),
                              ],
                            ),
                          ),
                        );
                      }).toList(),
                    ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildBentoBox({required Widget child}) {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(18),
      decoration: BoxDecoration(
        color: Colors.white.withOpacity(0.85),
        borderRadius: BorderRadius.circular(24),
        border: Border.all(color: Colors.white.withOpacity(0.6), width: 1.5),
        boxShadow: [BoxShadow(color: const Color(0xFF71717A).withOpacity(0.1), blurRadius: 20, offset: const Offset(0, 8))],
      ),
      child: child,
    );
  }

  Widget _buildTransportTab(String jenis, String emoji, String label) {
    bool isActive = _selectedTransport == jenis;
    return GestureDetector(
      onTap: () {
        setState(() {
          _selectedTransport = jenis;
        });
      },
      child: Container(
        padding: const EdgeInsets.symmetric(vertical: 12),
        decoration: BoxDecoration(
          color: isActive ? const Color(0xFF2DD4BF).withOpacity(0.12) : Colors.white.withOpacity(0.85),
          borderRadius: BorderRadius.circular(16),
          border: Border.all(color: isActive ? const Color(0xFF2DD4BF).withOpacity(0.4) : Colors.white.withOpacity(0.6), width: 1.5),
        ),
        child: Column(
          children: [
            Text(emoji, style: const TextStyle(fontSize: 20)),
            const SizedBox(height: 4),
            Text(
              label,
              style: TextStyle(fontSize: 11, fontWeight: isActive ? FontWeight.w900 : FontWeight.w600, color: isActive ? const Color(0xFF0F766E) : const Color(0xFF475569)),
            ),
          ],
        ),
      ),
    );
  }

  // 3. WIDGET BARU: INPUT TEXT FIELD YANG BISA DIKETIK MANUAL
  Widget _buildInputFieldManual({required IconData icon, required String label, required TextEditingController controller}) {
    return Row(
      children: [
        Icon(icon, color: const Color(0xFF94A3B8), size: 20),
        const SizedBox(width: 14),
        Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                label.toUpperCase(),
                style: const TextStyle(fontSize: 9, fontWeight: FontWeight.w800, color: Color(0xFF94A3B8), letterSpacing: 0.8),
              ),
              SizedBox(
                height: 36,
                child: TextField(
                  controller: controller,
                  style: const TextStyle(fontSize: 14, fontWeight: FontWeight.bold, color: Color(0xFF1E293B)),
                  decoration: const InputDecoration(
                    border: InputBorder.none,
                    contentPadding: EdgeInsets.zero,
                    isDense: true,
                  ),
                ),
              ),
            ],
          ),
        ),
      ],
    );
  }
}