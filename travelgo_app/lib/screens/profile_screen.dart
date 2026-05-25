import 'package:flutter/material.dart';

class ProfileScreen extends StatelessWidget {
  const ProfileScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      appBar: AppBar(
        title: const Text(
          'Profil Pengguna',
          style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Color(0xFF1E293B)),
        ),
        backgroundColor: Colors.white,
        elevation: 0,
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(24.0),
        child: Column(
          children: [
            // Sesi Foto Avatar
            Center(
              child: Stack(
                children: [
                  CircleAvatar(
                    radius: 50.0,
                    backgroundColor: const Color(0xFF0D9488).withOpacity(0.1),
                    child: const Icon(Icons.person, size: 50.0, color: Color(0xFF0D9488)),
                  ),
                  Positioned(
                    bottom: 0,
                    right: 0,
                    child: Container(
                      padding: const EdgeInsets.all(6.0),
                      decoration: const BoxDecoration(color: Color(0xFF0D9488), shape: BoxShape.circle),
                      child: const Icon(Icons.camera_alt, color: Colors.white, size: 16.0),
                    ),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 32.0),

            // Form Isian Profil Kaca
            Container(
              padding: const EdgeInsets.all(20.0),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(24.0),
                border: Border.all(color: const Color(0xFFE2E8F0)),
              ),
              child: Column(
                children: [
                  _buildProfileField('Nama Lengkap', 'Budi Santoso'),
                  const SizedBox(height: 16.0),
                  _buildProfileField('Alamat Email', 'budi.santoso@gmail.com'),
                  const SizedBox(height: 16.0),
                  _buildProfileField('Kata Sandi Baru', '********', isPassword: true),
                  const SizedBox(height: 28.0),
                  
                  // Tombol Simpan
                  SizedBox(
                    width: double.infinity,
                    height: 48.0,
                    child: ElevatedButton(
                      onPressed: () {},
                      style: ElevatedButton.styleFrom(
                        backgroundColor: const Color(0xFF0D9488),
                        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(14.0)),
                        elevation: 0,
                      ),
                      child: const Text(
                        'Simpan Perubahan',
                        style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold, fontSize: 14),
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildProfileField(String label, String value, {bool isPassword = false}) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          label.toUpperCase(),
          style: const TextStyle(fontSize: 9, fontWeight: FontWeight.w800, color: Color(0xFF94A3B8), letterSpacing: 0.8),
        ),
        const SizedBox(height: 6.0),
        TextFormField(
          initialValue: value,
          obscureText: isPassword,
          decoration: InputDecoration(
            filled: true,
            fillColor: const Color(0xFFF8FAFC),
            contentPadding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 14.0),
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