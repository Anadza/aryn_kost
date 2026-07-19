import 'package:flutter/material.dart';
import '../../services/crud_service.dart';
import '../../widgets/app_drawer.dart';

class PengaduanPenghuniScreen extends StatefulWidget {
  const PengaduanPenghuniScreen({super.key});
  @override
  State<PengaduanPenghuniScreen> createState() => _PengaduanPenghuniScreenState();
}

class _PengaduanPenghuniScreenState extends State<PengaduanPenghuniScreen> {
  final CrudService _svc = CrudService();
  List<dynamic> _list = [];
  bool _loading = true;

  @override
  void initState() { super.initState(); _load(); }

  Future<void> _load() async {
    setState(() => _loading = true);
    try { _list = await _svc.fetchMyPengaduan(); } catch (_) { _list = []; }
    setState(() => _loading = false);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF5F0E8),
      body: RefreshIndicator(
        onRefresh: _load,
        color: primaryColor,
        child: ListView(padding: const EdgeInsets.all(16), children: [
          // Header
          Container(
            decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(16),
              boxShadow: [BoxShadow(color: Colors.black.withValues(alpha: 0.04), blurRadius: 8)]),
            padding: const EdgeInsets.all(20),
            child: Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
              const Text('Pengaduan & Keluhan Saya',
                  style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: primaryColor)),
              const SizedBox(height: 4),
              Text('Pantau progress penanganan masalah fasilitas kamar kamu.',
                  style: TextStyle(fontSize: 12, color: Colors.grey.shade500)),
              const SizedBox(height: 14),
              SizedBox(width: double.infinity, child: ElevatedButton.icon(
                style: ElevatedButton.styleFrom(
                    backgroundColor: primaryColor,
                    padding: const EdgeInsets.symmetric(vertical: 13),
                    shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10))),
                onPressed: _showCreateDialog,
                icon: const Icon(Icons.add_circle_outline, color: Colors.white, size: 18),
                label: const Text('Buat Keluhan Baru',
                    style: TextStyle(color: Colors.white, fontWeight: FontWeight.w700, fontSize: 14)))),
            ]),
          ),
          const SizedBox(height: 16),
          // Content
          Container(
            decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(16),
              boxShadow: [BoxShadow(color: Colors.black.withValues(alpha: 0.04), blurRadius: 8)]),
            child: _loading
              ? const Padding(padding: EdgeInsets.all(48), child: Center(child: CircularProgressIndicator(color: primaryColor)))
              : _list.isEmpty
                ? Padding(padding: const EdgeInsets.all(48), child: Column(children: [
                    Icon(Icons.inbox_outlined, size: 56, color: Colors.grey.shade300),
                    const SizedBox(height: 12),
                    Text('Belum ada pengaduan',
                        style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Colors.grey.shade500)),
                    const SizedBox(height: 4),
                    Text('Tekan tombol di atas untuk membuat laporan baru',
                        style: TextStyle(fontSize: 12, color: Colors.grey.shade400), textAlign: TextAlign.center),
                  ]))
                : Column(children: [
                    // Header tabel
                    Container(
                      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
                      decoration: const BoxDecoration(
                          color: Color(0xFFF9FAFB),
                          borderRadius: BorderRadius.vertical(top: Radius.circular(16))),
                      child: Row(children: [
                        const Text('KELUHAN', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 11, color: Color(0xFF6B7280))),
                        const Spacer(),
                        const Text('STATUS', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 11, color: Color(0xFF6B7280))),
                      ]),
                    ),
                    const Divider(height: 1),
                    ..._list.asMap().entries.map((entry) {
                      final i = entry.key;
                      final p = entry.value;
                      final st = p['status'] ?? '';
                      final stLabel = st == 'pending' ? 'Menunggu Admin' : st == 'diproses' ? 'Sedang Diproses' : 'Selesai';
                      final stColor = st == 'pending' ? Colors.amber : st == 'diproses' ? Colors.blue : Colors.green;
                      final stIcon = st == 'pending' ? Icons.access_time : st == 'diproses' ? Icons.autorenew : Icons.check_circle;
                      return Column(children: [
                        if (i > 0) const Divider(height: 1),
                        Padding(
                          padding: const EdgeInsets.all(16),
                          child: Row(crossAxisAlignment: CrossAxisAlignment.start, children: [
                            // Left icon
                            Container(
                              width: 40, height: 40,
                              decoration: BoxDecoration(
                                  color: stColor.withValues(alpha: 0.1),
                                  borderRadius: BorderRadius.circular(10)),
                              child: Icon(stIcon, color: stColor, size: 20)),
                            const SizedBox(width: 12),
                            // Content
                            Expanded(child: Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
                              Row(children: [
                                Container(
                                  padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 2),
                                  decoration: BoxDecoration(
                                      color: const Color(0xFFF3F4F6),
                                      borderRadius: BorderRadius.circular(6)),
                                  child: Text('${p['kategori']}',
                                      style: const TextStyle(fontSize: 11, fontWeight: FontWeight.w600, color: Color(0xFF4B5563)))),
                                const Spacer(),
                                Text(p['created_at']?.toString().split('T').first ?? '',
                                    style: TextStyle(fontSize: 11, color: Colors.grey.shade400)),
                              ]),
                              const SizedBox(height: 6),
                              Text('${p['deskripsi'] ?? ''}',
                                  style: const TextStyle(fontSize: 13, color: Color(0xFF374151), height: 1.4)),
                              if (p['kamar'] != null) ...[
                                const SizedBox(height: 4),
                                Row(children: [
                                  const Icon(Icons.door_back_door_outlined, size: 12, color: Color(0xFF9CA3AF)),
                                  const SizedBox(width: 4),
                                  Text('Kamar ${p['kamar']}', style: const TextStyle(fontSize: 11, color: Color(0xFF9CA3AF))),
                                ]),
                              ],
                              const SizedBox(height: 8),
                              Container(
                                padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                                decoration: BoxDecoration(
                                    color: stColor.withValues(alpha: 0.1),
                                    borderRadius: BorderRadius.circular(20)),
                                child: Row(mainAxisSize: MainAxisSize.min, children: [
                                  Icon(stIcon, size: 12, color: stColor),
                                  const SizedBox(width: 4),
                                  Text(stLabel, style: TextStyle(fontSize: 11, fontWeight: FontWeight.w600, color: stColor)),
                                ])),
                            ])),
                          ]),
                        ),
                      ]);
                    }),
                  ]),
          ),
        ]),
      ),
    );
  }

  void _showCreateDialog() {
    final kamarC = TextEditingController();
    final deskC = TextEditingController();
    String kategori = 'Fasilitas Kamar';

    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      backgroundColor: Colors.transparent,
      builder: (ctx) => StatefulBuilder(
        builder: (ctx2, setModal) => Container(
          padding: EdgeInsets.only(
              left: 20, right: 20, top: 20,
              bottom: MediaQuery.of(ctx2).viewInsets.bottom + 20),
          decoration: const BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.vertical(top: Radius.circular(24))),
          child: SingleChildScrollView(child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            mainAxisSize: MainAxisSize.min,
            children: [
              Center(child: Container(width: 40, height: 4,
                  decoration: BoxDecoration(color: Colors.grey.shade300, borderRadius: BorderRadius.circular(4)))),
              const SizedBox(height: 16),
              Row(children: [
                Container(width: 48, height: 48,
                  decoration: BoxDecoration(color: Colors.orange.withValues(alpha: 0.1), borderRadius: BorderRadius.circular(12)),
                  child: const Icon(Icons.report_problem_outlined, color: Colors.orange, size: 24)),
                const SizedBox(width: 12),
                const Expanded(child: Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
                  Text('Buat Laporan Keluhan', style: TextStyle(fontSize: 17, fontWeight: FontWeight.bold, color: primaryColor)),
                  Text('Isi form di bawah dengan detail yang jelas', style: TextStyle(fontSize: 12, color: Colors.grey)),
                ])),
              ]),
              const SizedBox(height: 20),
              const Text('Nomor Kamar', style: TextStyle(fontWeight: FontWeight.w600, fontSize: 14)),
              const SizedBox(height: 8),
              TextField(
                controller: kamarC,
                decoration: InputDecoration(
                    hintText: 'Contoh: A002',
                    prefixIcon: const Icon(Icons.door_back_door_outlined, size: 18),
                    border: OutlineInputBorder(borderRadius: BorderRadius.circular(10)),
                    focusedBorder: OutlineInputBorder(
                        borderSide: const BorderSide(color: primaryColor, width: 2),
                        borderRadius: BorderRadius.circular(10)))),
              const SizedBox(height: 16),
              const Text('Kategori Masalah', style: TextStyle(fontWeight: FontWeight.w600, fontSize: 14)),
              const SizedBox(height: 8),
              DropdownButtonFormField<String>(
                initialValue: kategori,
                items: ['Fasilitas Kamar', 'Air / Listrik', 'Fasilitas Umum', 'Lainnya']
                    .map((e) => DropdownMenuItem(value: e, child: Text(e))).toList(),
                onChanged: (v) => setModal(() => kategori = v!),
                decoration: InputDecoration(
                    prefixIcon: const Icon(Icons.category_outlined, size: 18),
                    border: OutlineInputBorder(borderRadius: BorderRadius.circular(10)),
                    focusedBorder: OutlineInputBorder(
                        borderSide: const BorderSide(color: primaryColor, width: 2),
                        borderRadius: BorderRadius.circular(10)))),
              const SizedBox(height: 16),
              const Text('Detail Keluhan', style: TextStyle(fontWeight: FontWeight.w600, fontSize: 14)),
              const SizedBox(height: 8),
              TextField(
                controller: deskC,
                maxLines: 4,
                decoration: InputDecoration(
                    hintText: 'Jelaskan kerusakan/masalah secara detail agar mudah ditangani...',
                    hintStyle: const TextStyle(fontSize: 12),
                    border: OutlineInputBorder(borderRadius: BorderRadius.circular(10)),
                    focusedBorder: OutlineInputBorder(
                        borderSide: const BorderSide(color: primaryColor, width: 2),
                        borderRadius: BorderRadius.circular(10)))),
              const SizedBox(height: 20),
              Row(children: [
                Expanded(child: OutlinedButton(
                  style: OutlinedButton.styleFrom(
                      side: const BorderSide(color: primaryColor),
                      padding: const EdgeInsets.symmetric(vertical: 14),
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10))),
                  onPressed: () => Navigator.pop(ctx2),
                  child: const Text('Batal', style: TextStyle(color: primaryColor, fontWeight: FontWeight.w600)))),
                const SizedBox(width: 12),
                Expanded(flex: 2, child: ElevatedButton(
                  style: ElevatedButton.styleFrom(
                      backgroundColor: primaryColor,
                      padding: const EdgeInsets.symmetric(vertical: 14),
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10))),
                  onPressed: () async {
                    if (kamarC.text.isEmpty || deskC.text.isEmpty) {
                      ScaffoldMessenger.of(ctx2).showSnackBar(const SnackBar(
                          content: Text('Nomor kamar dan detail keluhan wajib diisi!'),
                          backgroundColor: Colors.orange));
                      return;
                    }
                    final ok = await _svc.storePengaduan({
                      'kamar': kamarC.text,
                      'kategori': kategori,
                      'deskripsi': deskC.text,
                    });
                    if (ctx2.mounted) Navigator.pop(ctx2);
                    if (ok) {
                      _load();
                      if (mounted) {
                        ScaffoldMessenger.of(context).showSnackBar(SnackBar(
                        content: const Row(children: [
                          Icon(Icons.check_circle, color: Colors.white),
                          SizedBox(width: 8),
                          Text('Pengaduan berhasil dikirim ke admin!'),
                        ]),
                        backgroundColor: Colors.green.shade600,
                        behavior: SnackBarBehavior.floating,
                        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10))));
                      }
                    } else {
                      if (mounted) {
                        ScaffoldMessenger.of(context).showSnackBar(SnackBar(
                        content: const Row(children: [
                          Icon(Icons.error_outline, color: Colors.white),
                          SizedBox(width: 8),
                          Text('Gagal mengirim pengaduan. Silakan coba lagi.'),
                        ]),
                        backgroundColor: Colors.red.shade600,
                        behavior: SnackBarBehavior.floating,
                        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10))));
                      }
                    }
                  },
                  child: const Text('Kirim Laporan',
                      style: TextStyle(color: Colors.white, fontWeight: FontWeight.w700)))),
              ]),
            ],
          )),
        ),
      ),
    );
  }
}
