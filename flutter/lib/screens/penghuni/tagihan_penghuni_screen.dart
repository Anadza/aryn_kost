import 'package:flutter/material.dart';
import '../../services/crud_service.dart';
import '../../widgets/app_drawer.dart';

class TagihanPenghuniScreen extends StatefulWidget {
  const TagihanPenghuniScreen({super.key});
  @override
  State<TagihanPenghuniScreen> createState() => _TagihanPenghuniScreenState();
}

class _TagihanPenghuniScreenState extends State<TagihanPenghuniScreen> {
  final CrudService _svc = CrudService();
  List<dynamic> _list = [];
  bool _loading = true;

  @override
  void initState() { super.initState(); _load(); }

  Future<void> _load() async {
    setState(() => _loading = true);
    try { _list = await _svc.fetchMyTagihan(); } catch (_) { _list = []; }
    setState(() => _loading = false);
  }

  Color _stColor(String s) => s == 'Lunas' ? Colors.green : s == 'Menunggu Konfirmasi' ? Colors.amber : Colors.red;

  @override
  Widget build(BuildContext context) {
    if (_loading) return const Center(child: CircularProgressIndicator(color: primaryColor));
    return SingleChildScrollView(padding: const EdgeInsets.all(16), child: Column(children: [
      // Header
      Container(
        decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(16),
          boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.04), blurRadius: 8)]),
        padding: const EdgeInsets.all(20),
        child: Row(children: [
          const Expanded(child: Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
            Text('Tagihan Saya', style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: primaryColor)),
            SizedBox(height: 4),
            Text('Riwayat tagihan bulanan kamar kost kamu.', style: TextStyle(fontSize: 12, color: Color(0xFF6B7280))),
          ])),
        ]),
      ),
      const SizedBox(height: 16),
      // Table
      Container(
        width: double.infinity,
        decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(16),
          boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.04), blurRadius: 8)]),
        padding: const EdgeInsets.all(20),
        child: _list.isEmpty
          ? const Padding(padding: EdgeInsets.all(40), child: Center(child: Column(children: [
              Icon(Icons.check_circle_outline, size: 48, color: Colors.green),
              SizedBox(height: 8),
              Text('Belum ada tagihan tercatat.', style: TextStyle(color: Color(0xFF9CA3AF))),
            ])))
          : SingleChildScrollView(scrollDirection: Axis.horizontal, child: DataTable(
              headingRowColor: WidgetStateProperty.all(const Color(0xFFF9FAFB)),
              columns: const [
                DataColumn(label: Text('NO', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 11, color: Color(0xFF6B7280)))),
                DataColumn(label: Text('NOMOR TAGIHAN', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 11, color: Color(0xFF6B7280)))),
                DataColumn(label: Text('BULAN', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 11, color: Color(0xFF6B7280)))),
                DataColumn(label: Text('JUMLAH', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 11, color: Color(0xFF6B7280)))),
                DataColumn(label: Text('JATUH TEMPO', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 11, color: Color(0xFF6B7280)))),
                DataColumn(label: Text('STATUS', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 11, color: Color(0xFF6B7280)))),
              ],
              rows: List.generate(_list.length, (i) {
                final t = _list[i];
                final st = t['status_pembayaran'] ?? '';
                final stColor = _stColor(st);
                return DataRow(cells: [
                  DataCell(Text('${i+1}')),
                  DataCell(Text('${t['nomor_tagihan'] ?? '-'}', style: const TextStyle(fontWeight: FontWeight.bold))),
                  DataCell(Text('${t['bulan_tagihan'] ?? ''}')),
                  DataCell(Text('${t['jumlah_tagihan_formatted'] ?? ''}')),
                  DataCell(Text('${t['tanggal_jatuh_tempo'] ?? ''}')),
                  DataCell(Container(padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                    decoration: BoxDecoration(color: stColor.withOpacity(0.12), borderRadius: BorderRadius.circular(12)),
                    child: Text(st, style: TextStyle(fontSize: 11, fontWeight: FontWeight.w600, color: stColor)))),
                ]);
              }),
            )),
      ),
    ]));
  }
}
