import 'package:flutter/material.dart';
import 'package:flutter_map/flutter_map.dart';
import 'package:latlong2/latlong.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class RouteMapPage extends StatefulWidget {
  final String token;
  final int routeId; // ID rute yang ingin ditampilkan

  const RouteMapPage({super.key, required this.token, required this.routeId});

  @override
  State<RouteMapPage> createState() => _RouteMapPageState();
}

class _RouteMapPageState extends State<RouteMapPage> {
  List<LatLng> _jalurRute = [];
  List<Marker> _listMarker = [];
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _tarikDataRute();
  }

  Future<void> _tarikDataRute() async {
    final String urlApi = "http://10.0.2.2:8000/api/rute/${widget.routeId}/transit";

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
        final List titikTransit = data['data']['transit_points'];

        List<LatLng> ruteSementara = [];
        List<Marker> markerSementara = [];

        // Mengolah data JSON menjadi kordinat peta
        for (var i = 0; i < titikTransit.length; i++) {
          var titik = titikTransit[i];
          double lat = double.parse(titik['latitude'].toString());
          double lng = double.parse(titik['longitude'].toString());
          LatLng kordinat = LatLng(lat, lng);

          ruteSementara.add(kordinat);

          // Beri warna berbeda: Hijau (Awal), Merah (Akhir), Oren (Transit di tengah)
          Color warnaMarker = Colors.orange;
          if (i == 0) warnaMarker = Colors.green;
          if (i == titikTransit.length - 1) warnaMarker = Colors.red;

          markerSementara.add(_buatMarker(kordinat, titik['name'], warnaMarker));
        }

        setState(() {
          _jalurRute = ruteSementara;
          _listMarker = markerSementara;
          _isLoading = false;
        });
      } else {
        setState(() => _isLoading = false);
      }
    } catch (e) {
      debugPrint("Gagal memuat peta: $e");
      setState(() => _isLoading = false);
    }
  }

  Marker _buatMarker(LatLng koordinat, String namaLokasi, Color warna) {
    return Marker(
      point: koordinat,
      width: 120,
      height: 60,
      child: Column(
        children: [
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 2),
            decoration: BoxDecoration(
              color: Colors.white.withOpacity(0.9),
              borderRadius: BorderRadius.circular(4),
              border: Border.all(color: Colors.grey),
            ),
            child: Text(
              namaLokasi, 
              style: const TextStyle(fontSize: 10, fontWeight: FontWeight.bold),
              textAlign: TextAlign.center,
              overflow: TextOverflow.ellipsis,
            ),
          ),
          Icon(Icons.location_on, color: warna, size: 30),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Peta Rute & Transit'),
        backgroundColor: const Color(0xFF1BA0E2),
        foregroundColor: Colors.white,
      ),
      body: _isLoading
          ? const Center(child: CircularProgressIndicator())
          : _jalurRute.isEmpty
              ? const Center(child: Text("Data titik transit belum tersedia."))
              : FlutterMap(
                  options: MapOptions(
                    initialCenter: _jalurRute.isNotEmpty ? _jalurRute[0] : const LatLng(-6.2088, 106.8456),
                    initialZoom: 6.0,
                  ),
                  children: [
                    TileLayer(
                      urlTemplate: 'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
                      userAgentPackageName: 'com.example.travelgo',
                    ),
                    PolylineLayer(
                      polylines: [
                        Polyline(
                          points: _jalurRute,
                          color: const Color(0xFFFF5E1F),
                          strokeWidth: 4.0,
                        ),
                      ],
                    ),
                    MarkerLayer(markers: _listMarker),
                  ],
                ),
    );
  }
}