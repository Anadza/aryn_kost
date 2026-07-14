import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/kamar_model.dart';

import '../config/app_config.dart';

class ApiService {
  static const String baseUrl = AppConfig.baseUrl;

  Future<List<KamarModel>> fetchKamar() async {
    try {
      final response = await http.get(Uri.parse('$baseUrl/kost'));

      if (response.statusCode == 200) {
        final Map<String, dynamic> jsonResponse = json.decode(response.body);
        
        if (jsonResponse['success'] == true) {
          final List<dynamic> data = jsonResponse['data'];
          return data.map((item) => KamarModel.fromJson(item)).toList();
        } else {
          throw Exception(jsonResponse['message'] ?? 'Gagal mengambil data.');
        }
      } else {
        throw Exception('Gagal terhubung ke server: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Terjadi kesalahan: $e');
    }
  }
}
