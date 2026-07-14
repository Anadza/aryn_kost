import 'package:flutter/material.dart';
import '../../services/crud_service.dart';
import '../../widgets/app_drawer.dart';

class PembayaranScreen extends StatefulWidget {
  const PembayaranScreen({super.key});
  @override
  State<PembayaranScreen> createState() => _PembayaranScreenState();
}

class _PembayaranScreenState extends State<PembayaranScreen> {
  final CrudService _svc = CrudService();
  List<dynamic> _list = [];
  bool _loading = true;
  String _search = '';
  String _statusFilter = '';

  @override
  void initState() { super.initState(); _load(); }

  Future<void> _load() async {
    setState(() => _loading = true);
    try {
      final res = await _svc.fetchTagihan(status: _statusFilter);
      _list = res['data']?['data'] ?? [];
    } catch (e) { debugPrint('Error: $e'); _list = []; }
    setState(() => _loading = false);
  }

  Color _stColor(String s) => s == 'Lunas' ? Colors.green : s == 'Menunggu Konfirmasi' ? Colors.amber : Colors.red;

  @override
  Widget build(BuildContext context) {
    if (_loading) return const Center(child: CircularProgressIndicator(color: primaryColor));
    return SingleChildScrollView(padding: const EdgeInsets.all(16), child: Column(children: [
      // Search + filter bar (sama seperti web)
      Row(children: [
        Expanded(child: TextField(onChanged: (v) { _search = v; },
          decoration: InputDecoration(hintText: 'Cari Pembayaran...', prefixIcon: const Icon(Icons.search), filled: true, fillColor: Colors.white,
            border: OutlineInputBorder(borderRadius: BorderRadius.circular(8), borderSide: BorderSide.none)))),
        const SizedBox(width: 12),
        Container(padding: const EdgeInsets.symmetric(horizontal: 12), decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(8)),
          child: DropdownButtonHideUnderline(child: DropdownButton<String>(
            value: _statusFilter.isEmpty ? null : _statusFilter, hint: const Text('Semua Status'),
            items: [
              const DropdownMenuItem(value: '', child: Text('Semua Status')),
              ...['Belum Dibayar', 'Menunggu Konfirmasi', 'Lunas'].map((e) => DropdownMenuItem(value: e, child: Text(e))),
            ],
            onChanged: (v) { _statusFilter = v ?? ''; _load(); }))),
      ]),
      const SizedBox(height: 16),
      // Table
      Container(
        width: double.infinity,
        decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12)),
        child: SingleChildScrollView(scrollDirection: Axis.horizontal, child: DataTable(
          headingRowColor: WidgetStateProperty.all(const Color(0xFFF9FAFB)),
          columns: const [
            DataColumn(label: Text('NO', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
            DataColumn(label: Text('NOMOR TAGIHAN', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
            DataColumn(label: Text('BULAN', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
            DataColumn(label: Text('JUMLAH', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
            DataColumn(label: Text('STATUS', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
            DataColumn(label: Text('AKSI', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
          ],
          rows: List.generate(_list.length, (i) {
            final t = _list[i];
            final st = t['status_pembayaran'] ?? '';
            final stColor = _stColor(st);
            return DataRow(cells: [
              DataCell(Text('${i + 1}')),
              DataCell(Text('${t['nomor_tagihan'] ?? '-'}', style: const TextStyle(fontWeight: FontWeight.bold))),
              DataCell(Text('${t['bulan_tagihan'] ?? ''}')),
              DataCell(Text('Rp ${_fmt(t['jumlah_tagihan'])}')),
              DataCell(Container(padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                decoration: BoxDecoration(color: stColor.withOpacity(0.12), borderRadius: BorderRadius.circular(12)),
                child: Text(st, style: TextStyle(fontSize: 12, fontWeight: FontWeight.w600, color: stColor)))),
              DataCell(Row(children: [
                IconButton(icon: Icon(Icons.visibility_outlined, color: Colors.grey.shade400, size: 20), onPressed: () {}),
                IconButton(icon: Icon(Icons.edit_outlined, color: Colors.grey.shade400, size: 20), onPressed: () => _showStatusDialog(t['id'], st)),
              ])),
            ]);
          }),
        )),
      ),
    ]));
  }

  String _fmt(dynamic n) {
    final val = int.tryParse(n.toString()) ?? 0;
    return val.toString().replaceAllMapped(RegExp(r'(\d)(?=(\d{3})+(?!\d))'), (m) => '${m[1]}.');
  }

  void _showStatusDialog(int id, String current) {
    String selected = current;
    showDialog(context: context, builder: (ctx) => AlertDialog(
      title: const Text('Ubah Status Pembayaran', style: TextStyle(color: primaryColor, fontWeight: FontWeight.bold)),
      content: DropdownButtonFormField<String>(value: selected,
        items: ['Belum Dibayar', 'Menunggu Konfirmasi', 'Lunas'].map((e) => DropdownMenuItem(value: e, child: Text(e))).toList(),
        onChanged: (v) => selected = v!, decoration: const InputDecoration(border: OutlineInputBorder())),
      actions: [
        TextButton(onPressed: () => Navigator.pop(ctx), child: const Text('Batal')),
        ElevatedButton(style: ElevatedButton.styleFrom(backgroundColor: primaryColor),
          onPressed: () async {
            await _svc.updateTagihanStatus(id, selected);
            if (ctx.mounted) Navigator.pop(ctx);
            _load();
          }, child: const Text('Simpan', style: TextStyle(color: Colors.white))),
      ],
    ));
  }
}
