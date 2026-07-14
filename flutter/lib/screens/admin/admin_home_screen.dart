import 'package:flutter/material.dart';
import '../../services/auth_service.dart';
import '../../services/dashboard_service.dart';
import '../../widgets/app_drawer.dart';
import '../login_screen.dart';
import 'data_kamar_screen.dart';
import 'data_penghuni_screen.dart';
import 'data_pengaduan_screen.dart';
import 'pembayaran_screen.dart';
import 'profil_screen.dart';

class AdminHomeScreen extends StatefulWidget {
  const AdminHomeScreen({super.key});
  @override
  State<AdminHomeScreen> createState() => _AdminHomeScreenState();
}

class _AdminHomeScreenState extends State<AdminHomeScreen> {
  int _selectedIndex = 0;
  late Future<Map<String, dynamic>> _dashFuture;

  @override
  void initState() { super.initState(); _dashFuture = DashboardService().fetchAdminDashboard(); }

  String get _title => ['Dashboard', 'Data Kamar', 'Pembayaran', 'Data Penghuni', 'Data Pengaduan', 'Profil'][_selectedIndex];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: bgColor,
      appBar: AppBar(
        backgroundColor: primaryColor, elevation: 0, foregroundColor: Colors.white,
        title: Text(_title, style: const TextStyle(fontWeight: FontWeight.w600, fontSize: 18)),
        actions: [
          IconButton(icon: const Icon(Icons.notifications_outlined), onPressed: () {}),
          const Padding(padding: EdgeInsets.only(right: 12),
            child: CircleAvatar(radius: 16, backgroundColor: Colors.white24, child: Icon(Icons.person, color: Colors.white, size: 18))),
        ],
      ),
      drawer: AppDrawer(role: 'admin', selectedIndex: _selectedIndex, onTap: (i) => setState(() => _selectedIndex = i)),
      body: IndexedStack(index: _selectedIndex, children: [
        _buildDashboard(),
        const DataKamarScreen(),
        const PembayaranScreen(),
        const DataPenghuniScreen(),
        const DataPengaduanScreen(),
        const ProfilScreen(),
      ]),
    );
  }

  Widget _buildDashboard() {
    return FutureBuilder<Map<String, dynamic>>(
      future: _dashFuture,
      builder: (context, snap) {
        if (snap.connectionState == ConnectionState.waiting) return const Center(child: CircularProgressIndicator(color: primaryColor));
        if (snap.hasError) return Center(child: Column(mainAxisAlignment: MainAxisAlignment.center, children: [
          const Icon(Icons.error_outline, size: 48, color: Colors.red),
          Text('${snap.error}', textAlign: TextAlign.center),
          ElevatedButton(onPressed: () => setState(() => _dashFuture = DashboardService().fetchAdminDashboard()), child: const Text('Coba Lagi')),
        ]));

        final stats = snap.data!['stats'] as Map<String, dynamic>;
        final grafik = snap.data!['grafik'] as List<dynamic>;
        final pengaduan = snap.data!['pengaduan_terbaru'] as List<dynamic>;

        return RefreshIndicator(
          onRefresh: () async { setState(() => _dashFuture = DashboardService().fetchAdminDashboard()); await _dashFuture; },
          child: LayoutBuilder(
            builder: (context, constraints) {
              final isDesktop = constraints.maxWidth > 800;
              return SingleChildScrollView(padding: const EdgeInsets.all(16), physics: const AlwaysScrollableScrollPhysics(),
                child: Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
                  // Stats cards responsive
                  GridView.count(
                    shrinkWrap: true, 
                    physics: const NeverScrollableScrollPhysics(), 
                    crossAxisCount: isDesktop ? 4 : (constraints.maxWidth > 500 ? 2 : 1), 
                    crossAxisSpacing: 12, mainAxisSpacing: 12, childAspectRatio: isDesktop ? 2.2 : 2.5,
                    children: [
                      _statCard('Total Kamar', '${stats['total_kamar']}'),
                      _statCard('Penyewa Aktif', '${stats['penyewa_aktif']}'),
                      _statCard('Pendapatan Bulan ini', '${stats['pendapatan_bulan_ini_formatted']}'),
                      _statCard('Pembayaran Tertunda', '${stats['pembayaran_tertunda']}'),
                    ],
                  ),
                  const SizedBox(height: 16),
                  // Grafik + Pengaduan responsive
                  if (isDesktop)
                    Row(crossAxisAlignment: CrossAxisAlignment.start, children: [
                      Expanded(flex: 2, child: _card(_buildGrafikContent(grafik))),
                      const SizedBox(width: 16),
                      Expanded(flex: 1, child: _card(_buildPengaduanContent(pengaduan))),
                    ])
                  else
                    Column(children: [
                      _card(_buildGrafikContent(grafik)),
                      const SizedBox(height: 16),
                      _card(_buildPengaduanContent(pengaduan)),
                    ]),
                  const SizedBox(height: 24),
                ]),
              );
            }
          ),
        );
      },
    );
  }

  Widget _buildGrafikContent(List<dynamic> grafik) {
    return Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
      const Text('Grafik Pemasukan Bulanan', style: TextStyle(fontSize: 16, fontWeight: FontWeight.w600, color: primaryColor)),
      const SizedBox(height: 16),
      grafik.isEmpty
        ? Container(height: 200, decoration: BoxDecoration(color: const Color(0xFFF9FAFB), borderRadius: BorderRadius.circular(8)),
            child: const Center(child: Text('Belum ada pemasukan tercatat.', style: TextStyle(color: Color(0xFF9CA3AF)))))
        : _barChart(grafik),
    ]);
  }

  Widget _buildPengaduanContent(List<dynamic> pengaduan) {
    return Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
      const Text('Data Pengaduan', style: TextStyle(fontSize: 16, fontWeight: FontWeight.w600, color: primaryColor)),
      const SizedBox(height: 12),
      ...pengaduan.map(_pengaduanItem),
      if (pengaduan.isEmpty) const Text('Belum ada pengaduan.', style: TextStyle(color: Color(0xFF9CA3AF))),
    ]);
  }

  Widget _card(Widget child) => Container(
    width: double.infinity,
    decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12),
      boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.04), blurRadius: 8, offset: const Offset(0, 2))]),
    padding: const EdgeInsets.all(20), child: child);

  Widget _statCard(String title, String value) => Container(
    decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12),
      boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.04), blurRadius: 8, offset: const Offset(0, 2))]),
    padding: const EdgeInsets.all(16),
    child: Column(crossAxisAlignment: CrossAxisAlignment.start, mainAxisAlignment: MainAxisAlignment.center, children: [
      Text(title, style: const TextStyle(fontSize: 13, color: Color(0xFF6B7280))),
      const SizedBox(height: 8),
      Text(value, style: const TextStyle(fontSize: 26, fontWeight: FontWeight.bold, color: primaryColor)),
    ]),
  );

  Widget _barChart(List<dynamic> grafik) {
    final maxVal = grafik.fold<int>(1, (prev, e) => (e['total'] as int) > prev ? e['total'] as int : prev);
    return SizedBox(height: 220, child: Row(crossAxisAlignment: CrossAxisAlignment.end,
      children: grafik.map((item) {
        final total = item['total'] as int;
        final bulan = item['bulan'] as String;
        final h = (total / maxVal) * 170.0;
        return Expanded(child: Padding(padding: const EdgeInsets.symmetric(horizontal: 2),
          child: Column(mainAxisAlignment: MainAxisAlignment.end, children: [
            Text('Rp${_short(total)}', style: const TextStyle(fontSize: 9, fontWeight: FontWeight.w600, color: primaryColor)),
            const SizedBox(height: 4),
            Container(width: double.infinity, height: h < 4 ? 4 : h,
              decoration: BoxDecoration(color: primaryColor.withOpacity(0.8), borderRadius: const BorderRadius.vertical(top: Radius.circular(4)))),
            const SizedBox(height: 6),
            Text(bulan.split(' ').first, style: const TextStyle(fontSize: 9, color: Color(0xFF6B7280)), textAlign: TextAlign.center, overflow: TextOverflow.ellipsis),
          ]),
        ));
      }).toList(),
    ));
  }

  String _short(int n) { if (n >= 1000000) return '${(n / 1000000).toStringAsFixed(0)}.${((n % 1000000) / 1000).toStringAsFixed(0).padLeft(3, '0')}.000'; if (n >= 1000) return '${(n / 1000).toStringAsFixed(0)}Rb'; return '$n'; }

  Widget _pengaduanItem(dynamic p) {
    final status = p['status'] as String? ?? '';
    final color = {'pending': Colors.amber, 'diproses': Colors.blue, 'selesai': Colors.green}[status] ?? Colors.grey;
    return Container(margin: const EdgeInsets.only(bottom: 10), padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(border: Border.all(color: const Color(0xFFF3F4F6)), borderRadius: BorderRadius.circular(8)),
      child: Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
        Container(padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 3),
          decoration: BoxDecoration(color: color.withOpacity(0.15), borderRadius: BorderRadius.circular(12)),
          child: Text(status.isEmpty ? '-' : status[0].toUpperCase() + status.substring(1), style: TextStyle(fontSize: 11, fontWeight: FontWeight.bold, color: color))),
        const SizedBox(height: 6),
        Text('${p['penyewa']} · Kamar ${p['kamar']} · ${p['kategori']}', style: const TextStyle(fontSize: 13, color: Color(0xFF4B5563))),
      ]),
    );
  }
}
