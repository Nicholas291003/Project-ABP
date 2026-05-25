import 'package:flutter/material.dart';
import 'package:travelgo_app/screens/home_screen.dart';
import 'package:travelgo_app/screens/history_screen.dart';
import 'package:travelgo_app/screens/profile_screen.dart';

class MainNavigationHub extends StatefulWidget {
  const MainNavigationHub({super.key});

  @override
  State<MainNavigationHub> createState() => _MainNavigationHubState();
}

class _MainNavigationHubState extends State<MainNavigationHub> {
  int _currentIndex = 0;

  // Daftar halaman yang akan diakses lewat tombol menu bawah
  final List<Widget> _children = [
    const HomeScreen(),
    const HistoryScreen(),
    const ProfileScreen(),
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: _children[_currentIndex],
      bottomNavigationBar: BottomNavigationBar(
        currentIndex: _currentIndex,
        onTap: (int index) {
          setState(() {
            _currentIndex = index;
          });
        },
        selectedItemColor: const Color(0xFF0D9488), // Warna toska saat aktif
        unselectedItemColor: const Color(0xFF94A3B8), // Warna abu-abu saat redup
        showUnselectedLabels: true,
        type: BottomNavigationBarType.fixed,
        items: const [
          BottomNavigationBarItem(
            icon: Icon(Icons.home_filled),
            label: 'Beranda',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.confirmation_number_outlined),
            label: 'Riwayat',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.person_outline),
            label: 'Profil',
          ),
        ],
      ),
    );
  }
}