import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'login_page.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return const MaterialApp(
      debugShowCheckedModeBanner: false,
      home: LoginPage(),
    );
  }
}

class HalamanTesKoneksi extends StatefulWidget {
  const HalamanTesKoneksi({super.key});

  @override
  State<HalamanTesKoneksi> createState() => _HalamanTesKoneksiState();
}

class _HalamanTesKoneksiState extends State<HalamanTesKoneksi> {
  // Variabel untuk menampung teks status di layar HP
  String _statusLog = "Tekan tombol di bawah untuk memulai tes.";

  void testKoneksi() async {
    // Gunakan 10.0.2.2 jika pakai Emulator. Ganti ke IP laptop jika pakai HP Fisik.
    const String baseUrl = "http://10.0.2.2:8000/api"; 

    setState(() {
      _statusLog = "Sedang mencoba menghubungi backend...";
    });

    try {
      final response = await http.get(Uri.parse('$baseUrl/ping'));

      if (response.statusCode == 200) {
        Map<String, dynamic> data = jsonDecode(response.body);
        setState(() {
          _statusLog = "=== KONEKSI SUKSES ===\n\n"
              "Pesan Server: ${data['pesan']}\n"
              "Waktu: ${data['waktu']}";
        });
      } else {
        setState(() {
          _statusLog = "Terhubung ke server, tetapi error HTTP: ${response.statusCode}";
        });
      }
    } catch (e) {
      setState(() {
        _statusLog = "=== KONEKSI GAGAL ===\n\n"
            "Detail Error: $e\n\n"
            "Tips: Pastikan 'php artisan serve --host=0.0.0.0' sudah menyala di backend!";
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('TiketKuy Connection Bridge'),
        backgroundColor: const Color(0xFF5E1F),
      ),
      body: Padding(
        padding: const EdgeInsets.all(24.0),
        child: Center(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Container(
                width: double.infinity,
                padding: const EdgeInsets.all(16),
                decoration: BoxDecoration(
                  color: Colors.grey[100],
                  borderRadius: BorderRadius.circular(12),
                  border: Border.all(color: Colors.grey[300]!),
                ),
                child: Text(
                  _statusLog,
                  textAlign: TextAlign.center,
                  style: const TextStyle(fontSize: 14, fontFamily: 'monospace'),
                ),
              ),
              const SizedBox(height: 30),
              ElevatedButton.icon(
                onPressed: testKoneksi,
                icon: const Icon(Icons.wifi),
                label: const Text('Cek Koneksi ke Laravel XAMPP'),
                style: ElevatedButton.styleFrom(
                  padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 12),
                  backgroundColor: const Color(0xFF5E1F),
                  foregroundColor: Colors.white,
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}