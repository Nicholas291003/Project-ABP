import 'dart:convert';
import 'package:http/http.dart' as http;

class ApiService {
  static const String baseUrl = 'http://10.0.2.2:8000/api';
  
  // Variabel statis untuk menyimpan token selama aplikasi berjalan
  static String? tokenAkses;

  // 1. FUNGSI LOGIN (POST /api/login)
  static Future<Map<String, dynamic>?> login(String email, String password) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/login'),
        headers: <String, String>{
          'Content-Type': 'application/json; charset=UTF-8',
          'Accept': 'application/json',
        },
        body: jsonEncode(<String, String>{'email': email, 'password': password}),
      );

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body) as Map<String, dynamic>;
        // Simpan token token Sanctum yang dikirim oleh AuthController  
        tokenAkses = data['token']; 
        return data;
      }
      return null;
    } catch (e) {
      return null;
    }
  }

  // 2. FUNGSI AMBIL RUTE POPULER (GET /api/jadwal/populer) - Butuh Token
  static Future<List<dynamic>?> getRutePopuler() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/jadwal/populer'),
        headers: <String, String>{
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer $tokenAkses', // Mengirim token sanctum  
        },
      );

      if (response.statusCode == 200) {
        final res = jsonDecode(response.body);
        return res['data'] as List<dynamic>;
      }
      return null;
    } catch (e) {
      return null;
    }
  }

  // 3. FUNGSI AMBIL RIWAYAT PESANAN (GET /api/pesanan/riwayat) - Butuh Token
  static Future<List<dynamic>?> getRiwayatPesanan() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/pesanan/riwayat'),
        headers: <String, String>{
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer $tokenAkses',
        },
      );

      if (response.statusCode == 200) {
        final res = jsonDecode(response.body);
        return res['data'] as List<dynamic>;
      }
      return null;
    } catch (e) {
      return null;
    }
  }

  // 4. FUNGSI CARI TIKET (GET /api/jadwal/search) - Membutuhkan Token Sanctum
  static Future<List<dynamic>?> searchJadwal(String asal, String tujuan, String tanggal) async {
    try {
      // Menyusun URL dengan Query Parameter sesuai kebutuhan ScheduleController  
      final String urlPencarian = '$baseUrl/jadwal/search?asal=$asal&tujuan=$tujuan&tanggal=$tanggal';
      
      final response = await http.get(
        Uri.parse(urlPencarian),
        headers: <String, String>{
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer $tokenAkses', // Token wajib dikirim karena rute terkunci middleware
        },
      );

      if (response.statusCode == 200) {
        final Map<String, dynamic> res = jsonDecode(response.body) as Map<String, dynamic>;
        return res['data'] as List<dynamic>; // Mengambil array tiket dari objek 'data'
      }
      return null;
    } catch (e) {
      return null;
    }
  }

  // 5. FUNGSI BUAT PESANAN BARU (POST /api/order) - Membutuhkan Token Sanctum
  static Future<Map<String, dynamic>?> buatPesanan(int scheduleId) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/order'),
        headers: <String, String>{
          'Content-Type': 'application/json; charset=UTF-8',
          'Accept': 'application/json',
          'Authorization': 'Bearer $tokenAkses', // Token wajib untuk rute auth:sanctum
        },
        body: jsonEncode(<String, dynamic>{
          'schedule_id': scheduleId, 
        }),
      );

      if (response.statusCode == 201) {
        // Berhasil dibuat (Status 201 Created dari Laravel)
        return jsonDecode(response.body) as Map<String, dynamic>;
      }
      return null;
    } catch (e) {
      return null;
    }
  }

  // 6. FUNGSI VERIFIKASI PEMBAYARAN (POST /api/order/{id}/bayar) - Membutuhkan Token Sanctum
  static Future<Map<String, dynamic>?> bayarPesanan(int orderId) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/order/$orderId/bayar'),
        headers: <String, String>{
          'Content-Type': 'application/json; charset=UTF-8',
          'Accept': 'application/json',
          'Authorization': 'Bearer $tokenAkses', // Token sanctum wajib disertakan
        },
      );

      if (response.statusCode == 200) {
        // Pembayaran berhasil diverifikasi oleh OrderController@bayar
        return jsonDecode(response.body) as Map<String, dynamic>;
      }
      return null;
    } catch (e) {
      return null;
    }
  }
}