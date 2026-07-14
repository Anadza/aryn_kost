import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:flutter/material.dart';
import '../../widgets/app_drawer.dart';
import '../home_kost_screen.dart';
import '../../config/app_config.dart';
import '../../services/auth_service.dart';

class ProfilScreen extends StatefulWidget {
  const ProfilScreen({super.key});
  @override
  State<ProfilScreen> createState() => _ProfilScreenState();
}

class _ProfilScreenState extends State<ProfilScreen> {
  static const String baseUrl = AppConfig.baseUrl;
  final _namaC = TextEditingController();
  final _emailC = TextEditingController();
  bool _loading = true;
  bool _saving = false;
  String _name = '';
  String _email = '';
  String _role = '';

  @override
  void initState() { super.initState(); _loadProfile(); }

  Future<void> _loadProfile() async {
    setState(() => _loading = true);
    try {
      final token = await AuthService.getToken();
      final res = await http.get(Uri.parse('$baseUrl/me'), headers: {'Authorization': 'Bearer $token', 'Accept': 'application/json'});
      final data = json.decode(res.body);
      if (data['success'] == true) {
        _name = data['data']['name'] ?? '';
        _email = data['data']['email'] ?? '';
        _role = data['data']['role'] ?? '';
        _namaC.text = _name;
        _emailC.text = _email;
      }
    } catch (_) {}
    setState(() => _loading = false);
  }

  Future<void> _updateProfile() async {
    setState(() => _saving = true);
    try {
      final token = await AuthService.getToken();
      final res = await http.put(Uri.parse('$baseUrl/profile'),
        headers: {'Authorization': 'Bearer $token', 'Accept': 'application/json', 'Content-Type': 'application/json'},
        body: json.encode({'name': _namaC.text, 'email': _emailC.text}));
      final data = json.decode(res.body);
      if (data['success'] == true && mounted) {
        ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('Profil berhasil diperbarui!'), backgroundColor: Colors.green));
        _loadProfile();
      }
    } catch (_) {}
    setState(() => _saving = false);
  }

  @override
  Widget build(BuildContext context) {
    if (_loading) return const Center(child: CircularProgressIndicator(color: primaryColor));
    
    return LayoutBuilder(
      builder: (context, constraints) {
        final isDesktop = constraints.maxWidth > 800;
        
        final summaryContent = Container(
          width: double.infinity,
          decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12),
            boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.04), blurRadius: 8)]),
          padding: const EdgeInsets.all(24),
          child: Column(children: [
            CircleAvatar(radius: 48, backgroundColor: primaryColor,
              child: Text(_name.isNotEmpty ? _name[0].toUpperCase() : 'U', style: const TextStyle(fontSize: 36, fontWeight: FontWeight.bold, color: Colors.white))),
            const SizedBox(height: 16),
            Text(_name, style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: primaryColor)),
            const SizedBox(height: 4),
            Text(_email, style: const TextStyle(fontSize: 13, color: Color(0xFF6B7280))),
            const SizedBox(height: 4),
            Container(padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 3),
              decoration: BoxDecoration(color: primaryColor.withOpacity(0.1), borderRadius: BorderRadius.circular(12)),
              child: Text(_role, style: const TextStyle(fontSize: 12, fontWeight: FontWeight.w600, color: primaryColor))),
            const SizedBox(height: 24),
            SizedBox(width: double.infinity, child: OutlinedButton.icon(
              style: OutlinedButton.styleFrom(foregroundColor: Colors.red, side: const BorderSide(color: Colors.red),
                padding: const EdgeInsets.symmetric(vertical: 12), shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8))),
              onPressed: () async {
                await AuthService.logout();
                if (!context.mounted) return;
                Navigator.pushAndRemoveUntil(context, MaterialPageRoute(builder: (_) => const HomeKostScreen()), (_) => false);
              },
              icon: const Icon(Icons.logout, size: 18),
              label: const Text('LOG OUT', style: TextStyle(fontWeight: FontWeight.w600)),
            )),
          ]),
        );

        final formContent = Container(
          width: double.infinity,
          decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12),
            boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.04), blurRadius: 8)]),
          padding: const EdgeInsets.all(24),
          child: Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
            const Text('Perbarui Profil', style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: primaryColor)),
            const SizedBox(height: 20),
            const Text('Nama', style: TextStyle(fontSize: 13, fontWeight: FontWeight.w500, color: Color(0xFF374151))),
            const SizedBox(height: 6),
            TextField(controller: _namaC, decoration: InputDecoration(
              filled: true, fillColor: const Color(0xFFF9FAFB),
              border: OutlineInputBorder(borderRadius: BorderRadius.circular(8), borderSide: BorderSide(color: Colors.grey.shade300)),
              enabledBorder: OutlineInputBorder(borderRadius: BorderRadius.circular(8), borderSide: BorderSide(color: Colors.grey.shade300)),
            )),
            const SizedBox(height: 16),
            const Text('Email', style: TextStyle(fontSize: 13, fontWeight: FontWeight.w500, color: Color(0xFF374151))),
            const SizedBox(height: 6),
            TextField(controller: _emailC, decoration: InputDecoration(
              filled: true, fillColor: const Color(0xFFF9FAFB),
              border: OutlineInputBorder(borderRadius: BorderRadius.circular(8), borderSide: BorderSide(color: Colors.grey.shade300)),
              enabledBorder: OutlineInputBorder(borderRadius: BorderRadius.circular(8), borderSide: BorderSide(color: Colors.grey.shade300)),
            )),
            const SizedBox(height: 24),
            SizedBox(width: double.infinity, child: ElevatedButton(
              style: ElevatedButton.styleFrom(backgroundColor: const Color(0xFF1E293B), padding: const EdgeInsets.symmetric(vertical: 14),
                shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8))),
              onPressed: _saving ? null : _updateProfile,
              child: _saving
                ? const SizedBox(width: 20, height: 20, child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2))
                : const Text('SIMPAN', style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold, letterSpacing: 1)),
            )),
          ]),
        );

        final layout = isDesktop 
            ? Row(crossAxisAlignment: CrossAxisAlignment.start, children: [
                SizedBox(width: 280, child: summaryContent),
                const SizedBox(width: 16),
                Expanded(child: formContent),
              ])
            : Column(children: [
                summaryContent,
                const SizedBox(height: 16),
                formContent,
              ]);

        return SingleChildScrollView(
          padding: const EdgeInsets.all(16),
          child: layout,
        );
      }
    );
  }
}
