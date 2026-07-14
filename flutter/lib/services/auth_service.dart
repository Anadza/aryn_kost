import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import '../config/app_config.dart';

class AuthService {
  static const String baseUrl = AppConfig.baseUrl;

  // Menyimpan token login
  static Future<void> saveToken(String token) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString('auth_token', token);
  }

  // Mengambil token login
  static Future<String?> getToken() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString('auth_token');
  }

  // Menyimpan role pengguna
  static Future<void> saveRole(String role) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString('user_role', role);
  }

  // Mengambil role pengguna
  static Future<String?> getRole() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString('user_role');
  }

  // Logout & hapus session lokal
  static Future<void> logout() async {
    final token = await getToken();
    if (token != null) {
      try {
        await http.post(
          Uri.parse('$baseUrl/logout'),
          headers: {
            'Authorization': 'Bearer $token',
            'Accept': 'application/json',
          },
        );
      } catch (e) {
        // Abaikan error jaringan saat logout
      }
    }
    
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('auth_token');
    await prefs.remove('user_role');
  }

  // Proses Login
  Future<Map<String, dynamic>> login(String email, String password) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/login'),
        body: {
          'email': email,
          'password': password,
        },
        headers: {
          'Accept': 'application/json',
        }
      );

      final Map<String, dynamic> data = json.decode(response.body);

      if (response.statusCode == 200 && data['success'] == true) {
        // Simpan token & role
        await saveToken(data['data']['token']);
        await saveRole(data['data']['user']['role']);
        
        return {'success': true, 'role': data['data']['user']['role']};
      } else {
        return {'success': false, 'message': data['message'] ?? 'Login gagal'};
      }
    } catch (e) {
      return {'success': false, 'message': 'Kesalahan jaringan: $e'};
    }
  }

  // Proses Register
  Future<Map<String, dynamic>> register(String name, String email, String password) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/register'),
        body: {
          'name': name,
          'email': email,
          'password': password,
        },
        headers: {
          'Accept': 'application/json',
        }
      );

      final Map<String, dynamic> data = json.decode(response.body);

      if (response.statusCode == 201 && data['success'] == true) {
        // Simpan token & role
        await saveToken(data['data']['token']);
        await saveRole(data['data']['user']['role']);
        
        return {'success': true, 'role': data['data']['user']['role']};
      } else {
        // Gabungkan pesan error validasi jika ada
        String errorMsg = data['message'] ?? 'Pendaftaran gagal';
        if (data['errors'] != null) {
          final errors = data['errors'] as Map<String, dynamic>;
          errorMsg = errors.values.map((v) => (v as List).join(', ')).join('\n');
        }
        return {'success': false, 'message': errorMsg};
      }
    } catch (e) {
      return {'success': false, 'message': 'Kesalahan jaringan: $e'};
    }
  }
}
