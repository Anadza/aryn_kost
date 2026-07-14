import 'package:flutter/material.dart';
import '../../services/crud_service.dart';
import '../../widgets/app_drawer.dart';

class DataPenghuniScreen extends StatefulWidget {
  const DataPenghuniScreen({super.key});
  @override
  State<DataPenghuniScreen> createState() => _DataPenghuniScreenState();
}

class _DataPenghuniScreenState extends State<DataPenghuniScreen> {
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
      final res = await _svc.fetchPenghuni(search: _search, status: _statusFilter);
      _list = res['data']?['data'] ?? [];
    } catch (_) { _list = []; }
    setState(() => _loading = false);
  }

  void _showForm({Map<String, dynamic>? p}) {
    final isEdit = p != null;
    final namaC = TextEditingController(text: p?['nama'] ?? '');
    final kamarC = TextEditingController(text: p?['nomor_kamar'] ?? '');
    final hpC = TextEditingController(text: p?['no_hp'] ?? '');
    final checkInC = TextEditingController(text: p?['check_in']?.toString().split('T').first ?? '');
    String status = p?['status'] ?? 'Active';

    showDialog(context: context, builder: (ctx) => AlertDialog(
      title: Text(isEdit ? 'Edit Penghuni' : '+ Tambah Penghuni', style: const TextStyle(color: primaryColor, fontWeight: FontWeight.bold)),
      content: SingleChildScrollView(child: Column(mainAxisSize: MainAxisSize.min, children: [
        TextField(controller: namaC, decoration: const InputDecoration(labelText: 'Nama', border: OutlineInputBorder())),
        const SizedBox(height: 12),
        TextField(controller: kamarC, decoration: const InputDecoration(labelText: 'Nomor Kamar', border: OutlineInputBorder())),
        const SizedBox(height: 12),
        TextField(controller: hpC, keyboardType: TextInputType.phone, decoration: const InputDecoration(labelText: 'No HP', border: OutlineInputBorder())),
        const SizedBox(height: 12),
        TextField(controller: checkInC, decoration: const InputDecoration(labelText: 'Check In (YYYY-MM-DD)', border: OutlineInputBorder())),
        const SizedBox(height: 12),
        DropdownButtonFormField<String>(value: status, items: ['Active','Inactive'].map((e) => DropdownMenuItem(value: e, child: Text(e))).toList(),
          onChanged: (v) => status = v!, decoration: const InputDecoration(labelText: 'Status', border: OutlineInputBorder())),
      ])),
      actions: [
        TextButton(onPressed: () => Navigator.pop(ctx), child: const Text('Batal')),
        ElevatedButton(
          style: ElevatedButton.styleFrom(backgroundColor: primaryColor),
          onPressed: () async {
            final body = {'nama': namaC.text, 'nomor_kamar': kamarC.text, 'no_hp': hpC.text, 'check_in': checkInC.text, 'status': status};
            final ok = isEdit ? await _svc.updatePenghuni(p!['id'], body) : await _svc.storePenghuni(body);
            if (ctx.mounted) Navigator.pop(ctx);
            if (ok) { _load(); ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(isEdit ? 'Penghuni diperbarui!' : 'Penghuni ditambahkan!'), backgroundColor: Colors.green)); }
          },
          child: Text(isEdit ? 'Simpan' : 'Tambah', style: const TextStyle(color: Colors.white)),
        ),
      ],
    ));
  }

  @override
  Widget build(BuildContext context) {
    return Column(children: [
      Container(padding: const EdgeInsets.all(16), child: Row(children: [
        Expanded(child: TextField(onChanged: (v) { _search = v; _load(); },
          decoration: InputDecoration(hintText: 'Cari Penghuni...', prefixIcon: const Icon(Icons.search), filled: true, fillColor: Colors.white,
            border: OutlineInputBorder(borderRadius: BorderRadius.circular(8), borderSide: BorderSide.none)))),
        const SizedBox(width: 12),
        Container(padding: const EdgeInsets.symmetric(horizontal: 12), decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(8)),
          child: DropdownButtonHideUnderline(child: DropdownButton<String>(
            value: _statusFilter.isEmpty ? null : _statusFilter, hint: const Text('Semua Status'),
            items: [const DropdownMenuItem(value: '', child: Text('Semua Status')), ...['Active','Inactive'].map((e) => DropdownMenuItem(value: e, child: Text(e)))],
            onChanged: (v) { _statusFilter = v ?? ''; _load(); }))),
        const SizedBox(width: 12),
        ElevatedButton.icon(
          style: ElevatedButton.styleFrom(backgroundColor: primaryColor, padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 14)),
          onPressed: () => _showForm(),
          icon: const Icon(Icons.add, color: Colors.white, size: 18),
          label: const Text('Tambah Penghuni', style: TextStyle(color: Colors.white, fontWeight: FontWeight.w600))),
      ])),
      Expanded(child: _loading
        ? const Center(child: CircularProgressIndicator(color: primaryColor))
        : Container(margin: const EdgeInsets.symmetric(horizontal: 16), decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12)),
          child: SingleChildScrollView(scrollDirection: Axis.horizontal, child: DataTable(
            headingRowColor: WidgetStateProperty.all(const Color(0xFFF9FAFB)),
            columns: const [
              DataColumn(label: Text('NO', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
              DataColumn(label: Text('NAMA PENGHUNI', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
              DataColumn(label: Text('NOMOR KAMAR', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
              DataColumn(label: Text('NO HP', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
              DataColumn(label: Text('CHECK IN', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
              DataColumn(label: Text('STATUS', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
              DataColumn(label: Text('AKSI', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
            ],
            rows: List.generate(_list.length, (i) {
              final p = _list[i];
              final isActive = p['status'] == 'Active';
              return DataRow(cells: [
                DataCell(Text('${i+1}')),
                DataCell(Text('${p['nama']}', style: const TextStyle(fontWeight: FontWeight.bold))),
                DataCell(Text('${p['nomor_kamar']}')),
                DataCell(Text('${p['no_hp']}')),
                DataCell(Text('${p['check_in']?.toString().split('T').first ?? ''}')),
                DataCell(Container(padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                  decoration: BoxDecoration(color: (isActive ? Colors.green : Colors.grey).withOpacity(0.12), borderRadius: BorderRadius.circular(12)),
                  child: Row(mainAxisSize: MainAxisSize.min, children: [
                    Container(width: 6, height: 6, margin: const EdgeInsets.only(right: 4), decoration: BoxDecoration(color: isActive ? Colors.green : Colors.grey, shape: BoxShape.circle)),
                    Text(p['status'] ?? '', style: TextStyle(fontSize: 12, fontWeight: FontWeight.w600, color: isActive ? Colors.green : Colors.grey)),
                  ]))),
                DataCell(Row(children: [
                  IconButton(icon: Icon(Icons.visibility_outlined, color: Colors.grey.shade400, size: 20), onPressed: () {}),
                  IconButton(icon: Icon(Icons.edit_outlined, color: Colors.grey.shade400, size: 20), onPressed: () => _showForm(p: p)),
                ])),
              ]);
            }),
          )),
        ),
      ),
      const SizedBox(height: 16),
    ]);
  }
}
