import 'dart:convert';
import 'package:http/http.dart' as http;
import 'auth_service.dart';
import '../config/app_config.dart';

class CrudService {
  static const String baseUrl = AppConfig.baseUrl;

  Future<Map<String, String>> _headers() async {
    final token = await AuthService.getToken();
    return {'Authorization': 'Bearer $token', 'Accept': 'application/json', 'Content-Type': 'application/json'};
  }

  // ========== KAMAR ==========
  Future<List<dynamic>> fetchKamar({String? search, String? status}) async {
    final h = await _headers();
    String url = '$baseUrl/kost';
    final params = <String>[];
    if (search != null && search.isNotEmpty) params.add('search=$search');
    if (status != null && status.isNotEmpty) params.add('status=$status');
    if (params.isNotEmpty) url += '?${params.join('&')}';
    final res = await http.get(Uri.parse(url), headers: h);
    final data = json.decode(res.body);
    return data['data'] ?? [];
  }

  Future<bool> storeKamar(Map<String, dynamic> body) async {
    final h = await _headers();
    final res = await http.post(Uri.parse('$baseUrl/kost'), headers: h, body: json.encode(body));
    return res.statusCode == 201;
  }

  Future<bool> updateKamar(int id, Map<String, dynamic> body) async {
    final h = await _headers();
    final res = await http.put(Uri.parse('$baseUrl/kost/$id'), headers: h, body: json.encode(body));
    return res.statusCode == 200;
  }

  Future<bool> deleteKamar(int id) async {
    final h = await _headers();
    final res = await http.delete(Uri.parse('$baseUrl/kost/$id'), headers: h);
    return res.statusCode == 200;
  }

  // ========== PENGHUNI ==========
  Future<Map<String, dynamic>> fetchPenghuni({String? search, String? status}) async {
    final h = await _headers();
    String url = '$baseUrl/penghuni';
    final params = <String>[];
    if (search != null && search.isNotEmpty) params.add('search=$search');
    if (status != null && status.isNotEmpty) params.add('status=$status');
    if (params.isNotEmpty) url += '?${params.join('&')}';
    final res = await http.get(Uri.parse(url), headers: h);
    return json.decode(res.body);
  }

  Future<bool> storePenghuni(Map<String, dynamic> body) async {
    final h = await _headers();
    final res = await http.post(Uri.parse('$baseUrl/penghuni'), headers: h, body: json.encode(body));
    return res.statusCode == 201;
  }

  Future<bool> updatePenghuni(int id, Map<String, dynamic> body) async {
    final h = await _headers();
    final res = await http.put(Uri.parse('$baseUrl/penghuni/$id'), headers: h, body: json.encode(body));
    return res.statusCode == 200;
  }

  Future<bool> deletePenghuni(int id) async {
    final h = await _headers();
    final res = await http.delete(Uri.parse('$baseUrl/penghuni/$id'), headers: h);
    return res.statusCode == 200;
  }

  // ========== PENGADUAN ==========
  Future<Map<String, dynamic>> fetchPengaduan() async {
    final h = await _headers();
    final res = await http.get(Uri.parse('$baseUrl/pengaduan'), headers: h);
    return json.decode(res.body);
  }

  Future<bool> updatePengaduanStatus(int id, String status) async {
    final h = await _headers();
    final res = await http.patch(Uri.parse('$baseUrl/pengaduan/$id/status'), headers: h, body: json.encode({'status': status}));
    return res.statusCode == 200;
  }

  // ========== TAGIHAN ==========
  Future<Map<String, dynamic>> fetchTagihan({String? status}) async {
    final h = await _headers();
    String url = '$baseUrl/tagihan';
    if (status != null && status.isNotEmpty) url += '?status=$status';
    final res = await http.get(Uri.parse(url), headers: h);
    return json.decode(res.body);
  }

  Future<bool> updateTagihanStatus(int id, String status) async {
    final h = await _headers();
    final res = await http.put(Uri.parse('$baseUrl/tagihan/$id'), headers: h, body: json.encode({'status_pembayaran': status}));
    return res.statusCode == 200;
  }

  // ========== PENGHUNI SPECIFIC ==========
  Future<List<dynamic>> fetchMyPengaduan() async {
    final h = await _headers();
    final res = await http.get(Uri.parse('$baseUrl/my/pengaduan'), headers: h);
    final data = json.decode(res.body);
    return data['data']?['data'] ?? [];
  }

  Future<bool> storePengaduan(Map<String, dynamic> body) async {
    final h = await _headers();
    final res = await http.post(Uri.parse('$baseUrl/my/pengaduan'), headers: h, body: json.encode(body));
    return res.statusCode == 201;
  }

  Future<List<dynamic>> fetchMyTagihan() async {
    final h = await _headers();
    final res = await http.get(Uri.parse('$baseUrl/my/tagihan'), headers: h);
    final data = json.decode(res.body);
    return data['data'] ?? [];
  }
}
