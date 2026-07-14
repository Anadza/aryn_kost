import 'package:flutter/material.dart';
import '../../services/dashboard_service.dart';
import '../../widgets/app_drawer.dart';
import '../admin/profil_screen.dart';
import 'booking_kamar_screen.dart';
import 'pengaduan_penghuni_screen.dart';
import 'tagihan_penghuni_screen.dart';

class PenghuniHomeScreen extends StatefulWidget {
  const PenghuniHomeScreen({super.key});
  @override
  State<PenghuniHomeScreen> createState() => _PenghuniHomeScreenState();
}

class _PenghuniHomeScreenState extends State<PenghuniHomeScreen> {
  int _selectedIndex = 0;
  late Future<Map<String, dynamic>> _future;

  @override
  void initState() { super.initState(); _future = DashboardService().fetchPenghuniDashboard(); }

  String get _title => ['Dashboard', 'Booking Kamar', 'Pengaduan', 'Tagihan', 'Profil'][_selectedIndex];

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
      drawer: AppDrawer(role: 'penghuni', selectedIndex: _selectedIndex, onTap: (i) => setState(() => _selectedIndex = i)),
      body: IndexedStack(index: _selectedIndex, children: [
        _buildDashboard(),
        const BookingKamarScreen(),
        const PengaduanPenghuniScreen(),
        const TagihanPenghuniScreen(),
        const ProfilScreen(),
      ]),
    );
  }

  Widget _buildDashboard() {
    return FutureBuilder<Map<String, dynamic>>(
      future: _future,
      builder: (context, snap) {
        if (snap.connectionState == ConnectionState.waiting) return const Center(child: CircularProgressIndicator(color: primaryColor));
        if (snap.hasError) return Center(child: Text('${snap.error}'));

        final data = snap.data!;
        final penghuni = data['penghuni'] as Map<String, dynamic>?;
        final kamar = data['kamar'] as Map<String, dynamic>?;
        final tagihan = data['tagihan_aktif'] as Map<String, dynamic>?;
        final riwayat = data['riwayat_pembayaran'] as List<dynamic>;

        return SingleChildScrollView(padding: const EdgeInsets.all(16), child: Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
          // Quick links
          _card(Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
            const Text('Menu Utama Penghuni', style: TextStyle(fontSize: 16, fontWeight: FontWeight.w600, color: primaryColor)),
            const SizedBox(height: 12),
            Row(children: [
              _quickLink(Icons.warning_amber_outlined, 'Pengaduan & Keluhan', 'Lihat riwayat pengaduan', Colors.orange, () => setState(() => _selectedIndex = 2)),
              const SizedBox(width: 12),
              _quickLink(Icons.add_circle_outline, 'Buat Keluhan Baru', 'Laporkan masalah fasilitas', Colors.red, () => setState(() => _selectedIndex = 2)),
            ]),
          ])),
          const SizedBox(height: 16),
          // Kamar + Tagihan
          Row(crossAxisAlignment: CrossAxisAlignment.start, children: [
            Expanded(child: _card(Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
              const Text('Kamar Saya', style: TextStyle(fontSize: 16, fontWeight: FontWeight.w600, color: primaryColor)),
              const SizedBox(height: 12),
              if (kamar != null) ...[
                ClipRRect(borderRadius: BorderRadius.circular(8),
                  child: Image.asset('assets/images/kamar/${kamar['tipe'].toString().toLowerCase()}.png', height: 120, width: double.infinity, fit: BoxFit.cover,
                    errorBuilder: (_, __, ___) => Container(height: 120, color: const Color(0xFFF3F4F6),
                      child: const Center(child: Icon(Icons.apartment, color: Colors.grey, size: 40))))),
                const SizedBox(height: 12),
                Row(children: [
                  Text('Kamar ${kamar['no_kamar']}', style: const TextStyle(fontWeight: FontWeight.bold, color: primaryColor, fontSize: 16)),
                  const SizedBox(width: 8),
                  if (penghuni?['status'] != null)
                    Container(padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 3),
                      decoration: BoxDecoration(color: Colors.green.shade50, borderRadius: BorderRadius.circular(12)),
                      child: Text(penghuni!['status'], style: TextStyle(fontSize: 11, color: Colors.green.shade700, fontWeight: FontWeight.w600))),
                ]),
                const SizedBox(height: 8),
                _kv('Check-in', penghuni?['check_in'] ?? '-'),
                _kv('Tipe Kamar', kamar['tipe'] ?? '-'),
              ] else
                const Padding(padding: EdgeInsets.all(16), child: Text('Data kamar belum terhubung.', style: TextStyle(color: Color(0xFF6B7280)))),
            ]))),
            const SizedBox(width: 16),
            Expanded(child: _card(Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
              Row(mainAxisAlignment: MainAxisAlignment.spaceBetween, children: [
                const Text('Tagihan Bulan Ini', style: TextStyle(fontSize: 16, fontWeight: FontWeight.w600, color: primaryColor)),
                if (tagihan != null) Text(tagihan['bulan_tagihan'] ?? '', style: const TextStyle(fontSize: 13, color: Color(0xFF6B7280))),
              ]),
              const SizedBox(height: 12),
              if (tagihan != null) ...[
                Row(children: [
                  Text(tagihan['jumlah_tagihan_formatted'] ?? '', style: const TextStyle(fontSize: 22, fontWeight: FontWeight.bold, color: primaryColor)),
                  const SizedBox(width: 12),
                  _statusBadge(tagihan['status_pembayaran'] ?? ''),
                ]),
                const SizedBox(height: 12),
                _kv('Tanggal Jatuh Tempo', tagihan['tanggal_jatuh_tempo'] ?? '-'),
                const SizedBox(height: 16),
                if (tagihan['status_pembayaran'] == 'Belum Dibayar')
                  SizedBox(width: double.infinity, child: ElevatedButton(
                    style: ElevatedButton.styleFrom(backgroundColor: primaryColor, padding: const EdgeInsets.symmetric(vertical: 12),
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8))),
                    onPressed: () {}, child: const Text('Bayar Sekarang', style: TextStyle(color: Colors.white, fontWeight: FontWeight.w600)))),
                if (tagihan['status_pembayaran'] == 'Menunggu Konfirmasi')
                  Container(padding: const EdgeInsets.all(12), decoration: BoxDecoration(color: Colors.yellow.shade50, borderRadius: BorderRadius.circular(8)),
                    child: const Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
                      Text('Bukti transfer sudah dikirim!', style: TextStyle(fontWeight: FontWeight.w600, fontSize: 12)),
                      Text('Mohon tunggu admin mengecek pembayaran Anda.', style: TextStyle(fontSize: 11, color: Color(0xFF92400E))),
                    ])),
                if (tagihan['status_pembayaran'] == 'Lunas')
                  Container(padding: const EdgeInsets.all(12), decoration: BoxDecoration(color: Colors.green.shade50, borderRadius: BorderRadius.circular(8)),
                    child: const Center(child: Text('✓ Tagihan bulan ini telah diselesaikan', style: TextStyle(fontWeight: FontWeight.w600, color: Colors.green, fontSize: 12)))),
              ] else ...[
                const SizedBox(height: 24),
                Icon(Icons.check_circle_outline, size: 48, color: Colors.green.shade400),
                const SizedBox(height: 8),
                const Text('Semua tagihan Anda lunas.', style: TextStyle(color: Color(0xFF6B7280), fontWeight: FontWeight.w500)),
                const SizedBox(height: 24),
              ],
            ]))),
          ]),
          const SizedBox(height: 16),
          // Riwayat
          _card(Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
            const Text('Riwayat Pembayaran Terakhir', style: TextStyle(fontSize: 16, fontWeight: FontWeight.w600, color: primaryColor)),
            const SizedBox(height: 12),
            riwayat.isEmpty
              ? const Padding(padding: EdgeInsets.all(24), child: Center(child: Text('Belum ada riwayat pembayaran tercatat.', style: TextStyle(color: Color(0xFF9CA3AF)))))
              : Column(children: riwayat.map((t) {
                  final st = t['status_pembayaran'] ?? '';
                  return Container(padding: const EdgeInsets.symmetric(vertical: 12),
                    decoration: BoxDecoration(border: Border(bottom: BorderSide(color: Colors.grey.shade100))),
                    child: Row(children: [
                      Expanded(child: Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
                        Text('${t['bulan_tagihan']}', style: const TextStyle(fontWeight: FontWeight.w600)),
                        const Text('Tagihan Bulanan', style: TextStyle(fontSize: 11, color: Color(0xFF6B7280))),
                      ])),
                      Expanded(child: Text('${t['jumlah_tagihan_formatted']}', style: const TextStyle(fontWeight: FontWeight.bold))),
                      _statusBadge(st),
                    ]),
                  );
                }).toList()),
          ])),
          const SizedBox(height: 24),
        ]));
      },
    );
  }

  Widget _card(Widget child) => Container(
    decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12),
      boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.04), blurRadius: 8)]),
    padding: const EdgeInsets.all(20), child: child);

  Widget _quickLink(IconData icon, String title, String sub, Color color, VoidCallback onTap) => Expanded(
    child: InkWell(onTap: onTap, child: Container(padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(color: const Color(0xFFF9FAFB), border: Border.all(color: const Color(0xFFF3F4F6)), borderRadius: BorderRadius.circular(12)),
      child: Row(children: [
        Container(width: 48, height: 48, decoration: BoxDecoration(color: color.withOpacity(0.1), borderRadius: BorderRadius.circular(12)),
          child: Icon(icon, color: color, size: 24)),
        const SizedBox(width: 12),
        Expanded(child: Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
          Text(title, style: const TextStyle(fontWeight: FontWeight.w600, fontSize: 14, color: Colors.black87)),
          Text(sub, style: const TextStyle(fontSize: 12, color: Color(0xFF6B7280))),
        ])),
      ]))));

  Widget _kv(String k, String v) => Padding(padding: const EdgeInsets.only(bottom: 6),
    child: Row(children: [
      Expanded(child: Text(k, style: const TextStyle(fontSize: 13, color: Color(0xFF6B7280)))),
      Text(v, style: const TextStyle(fontSize: 13, fontWeight: FontWeight.w500)),
    ]));

  Widget _statusBadge(String st) {
    final color = st == 'Lunas' ? Colors.green : st == 'Menunggu Konfirmasi' ? Colors.amber : Colors.red;
    return Container(padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
      decoration: BoxDecoration(color: color.withOpacity(0.12), borderRadius: BorderRadius.circular(12)),
      child: Text(st, style: TextStyle(fontSize: 11, fontWeight: FontWeight.bold, color: color)));
  }
}
