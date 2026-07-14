import 'dart:convert';
import 'package:http/http.dart' as http;
import '../services/auth_service.dart';

import '../config/app_config.dart';

class DashboardService {
  static const String baseUrl = AppConfig.baseUrl;

  Future<Map<String, dynamic>> fetchAdminDashboard() async {
    final token = await AuthService.getToken();
    final response = await http.get(
      Uri.parse('$baseUrl/dashboard/admin'),
      headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'application/json',
      },
    );
    final data = json.decode(response.body);
    if (response.statusCode == 200 && data['success'] == true) {
      return data['data'] as Map<String, dynamic>;
    }
    throw Exception(data['message'] ?? 'Gagal mengambil data dashboard');
  }

  Future<Map<String, dynamic>> fetchPenghuniDashboard() async {
    final token = await AuthService.getToken();
    final response = await http.get(
      Uri.parse('$baseUrl/dashboard/penghuni'),
      headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'application/json',
      },
    );
    final data = json.decode(response.body);
    if (response.statusCode == 200 && data['success'] == true) {
      return data['data'] as Map<String, dynamic>;
    }
    throw Exception(data['message'] ?? 'Gagal mengambil data dashboard');
  }
}
