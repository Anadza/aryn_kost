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
    return SingleChildScrollView(padding: const EdgeInsets.all(16), child: Column(children: [
      // Header panel (sama seperti web)
      Container(
        decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(16),
          boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.04), blurRadius: 8)]),
        padding: const EdgeInsets.all(20),
        child: Row(mainAxisAlignment: MainAxisAlignment.spaceBetween, children: [
          Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
            const Text('Pengaduan & Keluhan Saya', style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: primaryColor)),
            const SizedBox(height: 4),
            Text('Pantau progress penanganan masalah fasilitas kamar kamu.', style: TextStyle(fontSize: 12, color: Colors.grey.shade500)),
          ]),
          ElevatedButton.icon(
            style: ElevatedButton.styleFrom(backgroundColor: primaryColor, padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12))),
            onPressed: () => _showCreateDialog(),
            icon: const Icon(Icons.add, color: Colors.white, size: 16),
            label: const Text('Buat Keluhan Baru', style: TextStyle(color: Colors.white, fontWeight: FontWeight.w600, fontSize: 13)),
          ),
        ]),
      ),
      const SizedBox(height: 16),
      // Table
      Container(
        decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(16),
          boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.04), blurRadius: 8)]),
        padding: const EdgeInsets.all(20),
        child: _loading
          ? const Center(child: Padding(padding: EdgeInsets.all(40), child: CircularProgressIndicator(color: primaryColor)))
          : _list.isEmpty
            ? const Padding(padding: EdgeInsets.all(40), child: Center(child: Text('Kamu belum pernah mengajukan keluhan.', style: TextStyle(color: Color(0xFF9CA3AF)))))
            : SingleChildScrollView(scrollDirection: Axis.horizontal, child: DataTable(
                headingRowColor: WidgetStateProperty.all(const Color(0xFFF9FAFB)),
                columns: const [
                  DataColumn(label: Text('TANGGAL', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 11, color: Color(0xFF6B7280)))),
                  DataColumn(label: Text('KATEGORI', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 11, color: Color(0xFF6B7280)))),
                  DataColumn(label: Text('DESKRIPSI KELUHAN', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 11, color: Color(0xFF6B7280)))),
                  DataColumn(label: Text('STATUS PROGRESS', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 11, color: Color(0xFF6B7280)))),
                ],
                rows: _list.map((p) {
                  final st = p['status'] ?? '';
                  final stLabel = st == 'pending' ? 'Menunggu Admin' : st == 'diproses' ? 'Sedang Diperbaiki' : 'Selesai Ditangani';
                  final stColor = st == 'pending' ? Colors.amber : st == 'diproses' ? Colors.blue : Colors.green;
                  return DataRow(cells: [
                    DataCell(Text(p['created_at']?.toString().split('T').first ?? '', style: const TextStyle(color: Color(0xFF4B5563)))),
                    DataCell(Container(padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                      decoration: BoxDecoration(color: const Color(0xFFF3F4F6), borderRadius: BorderRadius.circular(6)),
                      child: Text('${p['kategori']}', style: const TextStyle(fontSize: 12, fontWeight: FontWeight.w500, color: Color(0xFF4B5563))))),
                    DataCell(SizedBox(width: 200, child: Text('${p['deskripsi'] ?? ''}', overflow: TextOverflow.ellipsis, style: const TextStyle(color: Color(0xFF4B5563))))),
                    DataCell(Container(padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                      decoration: BoxDecoration(color: stColor.withOpacity(0.1), borderRadius: BorderRadius.circular(12)),
                      child: Text(stLabel, style: TextStyle(fontSize: 11, fontWeight: FontWeight.w600, color: stColor)))),
                  ]);
                }).toList(),
              )),
      ),
    ]));
  }

  void _showCreateDialog() {
    final kamarC = TextEditingController();
    final deskC = TextEditingController();
    String kategori = 'Fasilitas Kamar';

    showDialog(context: context, builder: (ctx) => AlertDialog(
      title: const Text('Form Pengajuan Keluhan', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: primaryColor)),
      content: SingleChildScrollView(child: Column(mainAxisSize: MainAxisSize.min, crossAxisAlignment: CrossAxisAlignment.start, children: [
        const Text('Laporkan kerusakan kamar agar segera ditangani.', style: TextStyle(fontSize: 12, color: Color(0xFF6B7280))),
        const SizedBox(height: 16),
        TextField(controller: kamarC, decoration: const InputDecoration(labelText: 'Nomor Kamar', hintText: 'Contoh: A002', border: OutlineInputBorder())),
        const SizedBox(height: 12),
        DropdownButtonFormField<String>(value: kategori,
          items: ['Fasilitas Kamar', 'Air / Listrik', 'Fasilitas Umum', 'Lainnya'].map((e) => DropdownMenuItem(value: e, child: Text(e))).toList(),
          onChanged: (v) => kategori = v!, decoration: const InputDecoration(labelText: 'Kategori Masalah', border: OutlineInputBorder())),
        const SizedBox(height: 12),
        TextField(controller: deskC, maxLines: 4, decoration: const InputDecoration(labelText: 'Jelaskan Detail Keluhan', hintText: 'Contoh: Lampu kamar mandi mati...', border: OutlineInputBorder())),
      ])),
      actions: [
        TextButton(onPressed: () => Navigator.pop(ctx), child: const Text('Batal')),
        ElevatedButton(style: ElevatedButton.styleFrom(backgroundColor: primaryColor, shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12))),
          onPressed: () async {
            final ok = await _svc.storePengaduan({'kamar': kamarC.text, 'kategori': kategori, 'deskripsi': deskC.text});
            if (ctx.mounted) Navigator.pop(ctx);
            if (ok) {
              _load();
              if (mounted) ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('Pengaduan berhasil dikirim!'), backgroundColor: Colors.green));
            }
          }, child: const Text('Kirim Laporan', style: TextStyle(color: Colors.white, fontWeight: FontWeight.w600))),
      ],
    ));
  }
}
