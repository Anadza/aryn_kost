import 'package:flutter/material.dart';
import '../../services/crud_service.dart';
import '../../widgets/app_drawer.dart';

class DataPengaduanScreen extends StatefulWidget {
  const DataPengaduanScreen({super.key});
  @override
  State<DataPengaduanScreen> createState() => _DataPengaduanScreenState();
}

class _DataPengaduanScreenState extends State<DataPengaduanScreen> {
  final CrudService _svc = CrudService();
  Map<String, dynamic> _stats = {};
  List<dynamic> _list = [];
  bool _loading = true;

  @override
  void initState() { super.initState(); _load(); }

  Future<void> _load() async {
    setState(() => _loading = true);
    try {
      final res = await _svc.fetchPengaduan();
      _stats = res['stats'] ?? {};
      _list = res['data']?['data'] ?? [];
    } catch (e) {
      if (mounted) ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text('Gagal memuat pengaduan: $e')));
    }
    setState(() => _loading = false);
  }

  Color _statusColor(String s) => s == 'selesai' ? Colors.green : s == 'diproses' ? Colors.blue : Colors.orange;

  @override
  Widget build(BuildContext context) {
    if (_loading) return const Center(child: CircularProgressIndicator(color: primaryColor));
    return LayoutBuilder(
      builder: (context, constraints) {
        final isDesktop = constraints.maxWidth > 600;
        return SingleChildScrollView(padding: const EdgeInsets.all(16), child: Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
          // Stats cards responsive
          GridView.count(
            shrinkWrap: true, physics: const NeverScrollableScrollPhysics(),
            crossAxisCount: isDesktop ? 3 : 1,
            crossAxisSpacing: 12, mainAxisSpacing: 12, childAspectRatio: isDesktop ? 2.5 : 3.5,
            children: [
              _statCard('Total Pengaduan', '${_stats['total'] ?? 0}', primaryColor),
              _statCard('Sedang Diproses', '${_stats['diproses'] ?? 0}', Colors.orange),
              _statCard('Selesai', '${_stats['selesai'] ?? 0}', Colors.green),
            ],
          ),
          const SizedBox(height: 16),
          // Table
          Container(decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12)), padding: const EdgeInsets.all(16),
            child: Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
              const Text('Daftar Pengaduan Masuk', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: primaryColor)),
              const SizedBox(height: 12),
              SingleChildScrollView(scrollDirection: Axis.horizontal, child: DataTable(
                headingRowColor: WidgetStateProperty.all(const Color(0xFFF9FAFB)),
                columns: const [
                  DataColumn(label: Text('TANGGAL', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
                  DataColumn(label: Text('PENYEWA', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
                  DataColumn(label: Text('KAMAR', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
                  DataColumn(label: Text('KATEGORI', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
                  DataColumn(label: Text('DESKRIPSI', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
                  DataColumn(label: Text('STATUS', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
                  DataColumn(label: Text('AKSI', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
                ],
                rows: _list.map((p) {
                  final st = p['status'] as String? ?? '';
                  final stColor = _statusColor(st);
                  return DataRow(cells: [
                    DataCell(Text(p['created_at']?.toString().split('T').first ?? '')),
                    DataCell(Text('${p['penyewa']}', style: const TextStyle(fontWeight: FontWeight.bold))),
                    DataCell(Text('${p['kamar']}')),
                    DataCell(Text('${p['kategori']}')),
                    DataCell(SizedBox(width: 150, child: Text('${p['deskripsi'] ?? ''}', overflow: TextOverflow.ellipsis))),
                    DataCell(Container(padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                      decoration: BoxDecoration(color: stColor.withOpacity(0.12), borderRadius: BorderRadius.circular(12)),
                      child: Text(st.isEmpty ? '-' : st[0].toUpperCase() + st.substring(1), style: TextStyle(fontSize: 12, fontWeight: FontWeight.w600, color: stColor)))),
                    DataCell(Row(children: [
                      IconButton(icon: Icon(Icons.visibility_outlined, color: Colors.grey.shade400, size: 20), onPressed: () {}),
                      IconButton(icon: Icon(Icons.edit_outlined, color: Colors.grey.shade400, size: 20), onPressed: () {
                        _showStatusDialog(p['id'], st);
                      }),
                    ])),
                  ]);
                }).toList(),
              )),
            ]),
          ),
        ]));
      }
    );
  }

  void _showStatusDialog(int id, String current) {
    String selected = current.isEmpty ? 'pending' : current;
    showDialog(context: context, builder: (ctx) => AlertDialog(
      title: const Text('Ubah Status Pengaduan', style: TextStyle(color: primaryColor, fontWeight: FontWeight.bold)),
      content: DropdownButtonFormField<String>(value: selected,
        items: ['pending','diproses','selesai'].map((e) => DropdownMenuItem(value: e, child: Text(e[0].toUpperCase() + e.substring(1)))).toList(),
        onChanged: (v) => selected = v!, decoration: const InputDecoration(border: OutlineInputBorder())),
      actions: [
        TextButton(onPressed: () => Navigator.pop(ctx), child: const Text('Batal')),
        ElevatedButton(style: ElevatedButton.styleFrom(backgroundColor: primaryColor),
          onPressed: () async {
            await _svc.updatePengaduanStatus(id, selected);
            if (ctx.mounted) Navigator.pop(ctx);
            _load();
          }, child: const Text('Simpan', style: TextStyle(color: Colors.white))),
      ],
    ));
  }

  Widget _statCard(String title, String value, Color color) => Container(
    padding: const EdgeInsets.all(16), 
    decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12),
      boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.04), blurRadius: 8)]),
    child: Column(mainAxisAlignment: MainAxisAlignment.center, children: [
      Text(title, style: const TextStyle(fontSize: 12, color: Color(0xFF6B7280))),
      const SizedBox(height: 8),
      Text(value, style: TextStyle(fontSize: 28, fontWeight: FontWeight.bold, color: color)),
    ]),
  );
}
