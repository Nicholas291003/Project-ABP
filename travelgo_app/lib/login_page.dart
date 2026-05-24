import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'register_page.dart';
import 'dashboard_page.dart';

class LoginPage extends StatefulWidget {
  const LoginPage({super.key});

  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  // Controller untuk merekam ketikan text dari user
  final TextEditingController _emailController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();
  
  bool _isLoading = false;

  void fungsiLogin() async {
    // Validasi dasar jika inputan kosong
    if (_emailController.text.isEmpty || _passwordController.text.isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Email dan Password wajib diisi!')),
      );
      return;
    }

    setState(() { _isLoading = true; });

    // Jalur khusus emulator menuju localhost XAMPP komputer Anda
    const String urlLogin = "http://10.0.2.2:8000/api/login";

    try {
      // Mengirim HTTP POST ke Laravel dengan membawa Body data form
      final response = await http.post(
        Uri.parse(urlLogin),
        body: {
          'email': _emailController.text.trim(),
          'password': _passwordController.text,
        },
      );

      final Map<String, dynamic> dataResponse = jsonDecode(response.body);

      if (response.statusCode == 200 && dataResponse['status'] == 'sukses') {
        // LOGIN BERHASIL!
        String namaUser = dataResponse['user']['name'];
        String tokenAkses = dataResponse['token'];

        // Munculkan notifikasi sukses
        if (mounted) {
          showDialog(
            context: context,
            builder: (context) => AlertDialog(
              title: const Text('Login Sukses! ✅'),
              content: Text('Selamat datang kembali, $namaUser!\n\nToken Anda:\n$tokenAkses'),
              actions: [
                TextButton(
                  onPressed: () => Navigator.pop(context),
                  child: const Text('OK'),
                ),
              ],
            ),
          );
          // Navigasi ke halaman dashboard setelah login sukses
          Navigator.pushReplacement(
            context,
            MaterialPageRoute(
              builder: (context) => DashboardPage(namaUser: namaUser, token: tokenAkses),
            ),
          );
        }
      } else {
        // LOGIN GAGAL (Email/Password salah)
        if (mounted) {
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(content: Text(dataResponse['pesan'] ?? 'Login Gagal!')),
          );
        }
      }
    } catch (e) {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Tidak dapat terhubung ke server: $e')),
        );
      }
    } finally {
      setState(() { _isLoading = false; });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      body: Center(
        child: SingleChildScrollView(
          padding: const EdgeInsets.all(24.0),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            crossAxisAlignment: CrossAxisAlignment.stretch,
            children: [
              // Logo/Icon Identitas App
              const Icon(Icons.rocket_launch, size: 80, color: Color(0xFF1BA0E2)),
              const SizedBox(height: 16),
              const Text(
                'Travelgo Mobile',
                textAlign: TextAlign.center,
                style: TextStyle(fontSize: 28, fontWeight: FontWeight.bold, color: Color(0xFF1BA0E2)),
              ),
              const SizedBox(height: 40),

              // Kolom Input Email
              TextField(
                controller: _emailController,
                keyboardType: TextInputType.emailAddress,
                decoration: InputDecoration(
                  labelText: 'Alamat Email',
                  prefixIcon: const Icon(Icons.email),
                  border: OutlineInputBorder(borderRadius: BorderRadius.circular(12)),
                ),
              ),
              const SizedBox(height: 16),

              // Kolom Input Password
              TextField(
                controller: _passwordController,
                obscureText: true, // Menyembunyikan password jadi bulatan bintang
                decoration: InputDecoration(
                  labelText: 'Password',
                  prefixIcon: const Icon(Icons.lock),
                  border: OutlineInputBorder(borderRadius: BorderRadius.circular(12)),
                ),
              ),
              const SizedBox(height: 24),

              // Tombol Masuk / Login
              ElevatedButton(
                onPressed: _isLoading ? null : fungsiLogin,
                style: ElevatedButton.styleFrom(
                  backgroundColor: const Color(0xFFFF5E1F),
                  foregroundColor: Colors.white,
                  padding: const EdgeInsets.symmetric(vertical: 16),
                  shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
                ),
                child: _isLoading 
                  ? const CircularProgressIndicator(color: Colors.white) 
                  : const Text('Masuk Ke Akun', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
              ),

              TextButton(onPressed: () {
                // Navigasi ke halaman pendaftaran
                Navigator.push(
                  context,
                  MaterialPageRoute(builder: (context) => const RegisterPage()),
                );
              }, 
              child: const Text('Belum punya akun? Daftar sekarang!')
              )
            ],
          ),
        ),
      ),
    );
  }
}