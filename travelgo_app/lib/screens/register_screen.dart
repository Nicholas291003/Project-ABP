import 'package:flutter/material.dart';
import 'package:travelgo_app/screens/main_navigation_hub.dart';

class RegisterScreen extends StatelessWidget {
  const RegisterScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      body: Stack(
        children: [
          Positioned(
            top: -100,
            left: -100,
            child: Container(
              width: 300,
              height: 300,
              decoration: const BoxDecoration(
                shape: BoxShape.circle,
                boxShadow: [
                  BoxShadow(
                    color: Color(0x2606B6D4),
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
                    const Text(
                      'Buat Akun Baru',
                      style: TextStyle(fontSize: 26, fontWeight: FontWeight.w900, color: Color(0xFF1E293B)),
                    ),
                    const SizedBox(height: 4.0),
                    const Text(
                      'Gabung bersama Travelgo dan rasakan kemudahan traveling',
                      style: TextStyle(fontSize: 13, color: Color(0xFF64748B)),
                      textAlign: TextAlign.center,
                    ),
                    const SizedBox(height: 28.0),
                    Container(
                      padding: const EdgeInsets.all(20.0),
                      decoration: BoxDecoration(
                        color: const Color(0xD9FFFFFF),
                        borderRadius: BorderRadius.circular(24.0),
                        border: Border.all(color: const Color(0x99FFFFFF), width: 1.5),
                      ),
                      child: Column(
                        children: [
                          _buildTextField('Nama Lengkap', 'Masukkan nama lengkap', Icons.person_outline_rounded),
                          const SizedBox(height: 14.0),
                          _buildTextField('Email Address', 'Masukkan alamat email', Icons.email_outlined),
                          const SizedBox(height: 14.0),
                          _buildTextField('Password', 'Buat kata sandi minimal 8 karakter', Icons.lock_outline, isObscure: true),
                          const SizedBox(height: 24.0),
                          SizedBox(
                            width: double.infinity,
                            height: 48.0,
                            child: ElevatedButton(
                              onPressed: () {
                                Navigator.pushReplacement(
                                  context,
                                  MaterialPageRoute(builder: (context) => const MainNavigationHub()),
                                );
                              },
                              style: ElevatedButton.styleFrom(
                                backgroundColor: const Color(0xFF0D9488),
                                shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(14.0)),
                                elevation: 0,
                              ),
                              child: const Text(
                                'Daftar Akun',
                                style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold, fontSize: 14),
                              ),
                            ),
                          ),
                        ],
                      ),
                    ),
                    const SizedBox(height: 20.0),
                    Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        const Text('Sudah memiliki akun? ', style: TextStyle(fontSize: 13, color: Color(0xFF64748B))),
                        TextButton(
                          onPressed: () {
                            Navigator.pop(context);
                          },
                          child: const Text(
                            'Masuk Disini',
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

  Widget _buildTextField(String label, String hint, IconData icon, {bool isObscure = false}) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          label.toUpperCase(),
          style: const TextStyle(fontSize: 9, fontWeight: FontWeight.w800, color: Color(0xFF94A3B8), letterSpacing: 0.8),
        ),
        const SizedBox(height: 6.0),
        TextField(
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