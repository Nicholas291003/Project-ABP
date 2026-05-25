import 'package:flutter/material.dart';
import 'package:travelgo_app/services/api_service.dart'; // Import layanan API
import 'package:travelgo_app/screens/main_navigation_hub.dart';
import 'package:travelgo_app/screens/register_screen.dart';

class LoginScreen extends StatefulWidget {
  const LoginScreen({super.key});

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  // Pengontrol teks untuk mengambil apa yang diketik user
  final TextEditingController _emailController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();
  bool _isLoading = false; // Indikator loading saat memproses API

  void _prosesLogin() async {
    setState(() {
      _isLoading = true;
    });

    // Menembak fungsi API Service
    final hasil = await ApiService.login(
      _emailController.text,
      _passwordController.text,
    );

    setState(() {
      _isLoading = false;
    });

    if (hasil != null) {
      // JIKA LOGIN SUKSES DI LARAVEL
      if (mounted) {
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(builder: (context) => const MainNavigationHub()),
        );
      }
    } else {
      // JIKA LOGIN GAGAL
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(
            content: Text('Login Gagal! Periksa kembali email dan password Anda.'),
            backgroundColor: Color(0xFFEF4444),
          ),
        );
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      body: Stack(
        children: [
          // Latar Belakang Ambient Glow
          Positioned(
            top: -100,
            right: -100,
            child: Container(
              width: 300,
              height: 300,
              decoration: const BoxDecoration(
                shape: BoxShape.circle,
                boxShadow: [
                  BoxShadow(
                    color: Color(0x266EE7B7),
                    blurRadius: 100,
                    spreadRadius: 50,
                  ),
                ],
              ),
            ),
          ),
          
          SafeArea(
            child: Center(
              child: SingleChildScrollView(
                padding: const EdgeInsets.symmetric(horizontal: 24.0),
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Container(
                      padding: const EdgeInsets.all(16.0),
                      decoration: const BoxDecoration(
                        color: Color(0x1A0D9488),
                        shape: BoxShape.circle,
                      ),
                      child: const Icon(Icons.airplane_ticket_rounded, size: 40.0, color: Color(0xFF0D9488)),
                    ),
                    const SizedBox(height: 16.0),
                    const Text(
                      'Travelgo',
                      style: TextStyle(fontSize: 28, fontWeight: FontWeight.w900, color: Color(0xFF1E293B)),
                    ),
                    const SizedBox(height: 8.0),
                    const Text(
                      'Masuk untuk mulai memesan tiket perjalanan',
                      style: TextStyle(fontSize: 14, color: Color(0xFF64748B)),
                      textAlign: TextAlign.center,
                    ),
                    const SizedBox(height: 32.0),

                    // Kotak Input Jendela Kaca
                    Container(
                      padding: const EdgeInsets.all(20.0),
                      decoration: BoxDecoration(
                        color: const Color(0xD9FFFFFF),
                        borderRadius: BorderRadius.circular(24.0),
                        border: Border.all(color: const Color(0x99FFFFFF), width: 1.5),
                      ),
                      child: Column(
                        children: [
                          _buildTextField('Email Address', 'Masukkan email Anda', Icons.email_outlined, _emailController),
                          const SizedBox(height: 16.0),
                          _buildTextField('Password', 'Masukkan password Anda', Icons.lock_outline, _passwordController, isObscure: true),
                          const SizedBox(height: 24.0),
                          
                          // Tombol Login dengan Efek Kondisional Loading
                          SizedBox(
                            width: double.infinity,
                            height: 48.0,
                            child: ElevatedButton(
                              onPressed: _isLoading ? null : _prosesLogin, // Matikan tombol jika sedang memproses API
                              style: ElevatedButton.styleFrom(
                                backgroundColor: const Color(0xFF0D9488),
                                disabledBackgroundColor: const Color(0xFF94A3B8),
                                shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(14.0)),
                                elevation: 0,
                              ),
                              child: _isLoading 
                                ? const SizedBox(
                                    width: 20,
                                    height: 20,
                                    child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2),
                                  )
                                : const Text(
                                    'Masuk Sekarang',
                                    style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold, fontSize: 14),
                                  ),
                            ),
                          ),
                        ],
                      ),
                    ),
                    const SizedBox(height: 24.0),
                    
                    Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        const Text('Belum punya akun? ', style: TextStyle(fontSize: 13, color: Color(0xFF64748B))),
                        TextButton(
                          onPressed: () {
                            Navigator.push(
                              context,
                              MaterialPageRoute(builder: (context) => const RegisterScreen()),
                            );
                          },
                          child: const Text(
                            'Daftar Disini',
                            style: TextStyle(fontSize: 13, fontWeight: FontWeight.bold, color: Color(0xFF0D9488)),
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildTextField(String label, String hint, IconData icon, TextEditingController controller, {bool isObscure = false}) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          label.toUpperCase(),
          style: const TextStyle(fontSize: 9, fontWeight: FontWeight.w800, color: Color(0xFF94A3B8), letterSpacing: 0.8),
        ),
        const SizedBox(height: 6.0),
        TextField(
          controller: controller, // Pasang controller di sini
          obscureText: isObscure,
          decoration: InputDecoration(
            hintText: hint,
            hintStyle: const TextStyle(fontSize: 13, color: Color(0xFFCBD5E1)),
            prefixIcon: Icon(icon, color: const Color(0xFF94A3B8), size: 18.0),
            filled: true,
            fillColor: const Color(0xFFF8FAFC),
            contentPadding: const EdgeInsets.symmetric(vertical: 14.0),
            border: OutlineInputBorder(
              borderRadius: BorderRadius.circular(12.0),
              borderSide: const BorderSide(color: Color(0xFFE2E8F0)),
            ),
            enabledBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(12.0),
              borderSide: const BorderSide(color: Color(0xFFE2E8F0)),
            ),
          ),
        ),
      ],
    );
  }
}