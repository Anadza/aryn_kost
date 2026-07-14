import 'package:flutter/material.dart';
import '../../services/crud_service.dart';
import '../../widgets/app_drawer.dart';

class DataKamarScreen extends StatefulWidget {
  const DataKamarScreen({super.key});
  @override
  State<DataKamarScreen> createState() => _DataKamarScreenState();
}

class _DataKamarScreenState extends State<DataKamarScreen> {
  final CrudService _svc = CrudService();
  List<dynamic> _kamars = [];
  bool _loading = true;
  String _search = '';
  String _statusFilter = '';

  @override
  void initState() { super.initState(); _load(); }

  Future<void> _load() async {
    setState(() => _loading = true);
    try {
      _kamars = await _svc.fetchKamar(search: _search, status: _statusFilter);
    } catch (e) { _kamars = []; }
    setState(() => _loading = false);
  }

  void _showForm({Map<String, dynamic>? kamar}) {
    final isEdit = kamar != null;
    final noC = TextEditingController(text: kamar?['no_kamar'] ?? '');
    final hargaC = TextEditingController(text: kamar?['harga']?.toString() ?? '');
    String tipe = kamar?['tipe'] ?? 'Standar';
    String status = kamar?['status'] ?? 'kosong';

    showDialog(context: context, builder: (ctx) => AlertDialog(
      title: Text(isEdit ? 'Edit Kamar' : '+ Tambah Kamar', style: const TextStyle(color: primaryColor, fontWeight: FontWeight.bold)),
      content: SingleChildScrollView(child: Column(mainAxisSize: MainAxisSize.min, children: [
        TextField(controller: noC, decoration: const InputDecoration(labelText: 'No. Kamar', border: OutlineInputBorder())),
        const SizedBox(height: 12),
        DropdownButtonFormField<String>(value: tipe, items: ['Standar','Deluxe','VIP'].map((e) => DropdownMenuItem(value: e, child: Text(e))).toList(),
          onChanged: (v) => tipe = v!, decoration: const InputDecoration(labelText: 'Tipe', border: OutlineInputBorder())),
        const SizedBox(height: 12),
        TextField(controller: hargaC, keyboardType: TextInputType.number, decoration: const InputDecoration(labelText: 'Harga / Bulan', border: OutlineInputBorder())),
        const SizedBox(height: 12),
        DropdownButtonFormField<String>(value: status, items: ['kosong','terisi','booking'].map((e) => DropdownMenuItem(value: e, child: Text(e))).toList(),
          onChanged: (v) => status = v!, decoration: const InputDecoration(labelText: 'Status', border: OutlineInputBorder())),
      ])),
      actions: [
        TextButton(onPressed: () => Navigator.pop(ctx), child: const Text('Batal')),
        ElevatedButton(
          style: ElevatedButton.styleFrom(backgroundColor: primaryColor),
          onPressed: () async {
            final body = {'no_kamar': noC.text, 'tipe': tipe, 'harga': int.tryParse(hargaC.text) ?? 0, 'status': status};
            final ok = isEdit ? await _svc.updateKamar(kamar!['id'], body) : await _svc.storeKamar(body);
            if (ctx.mounted) Navigator.pop(ctx);
            if (ok) { _load(); ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(isEdit ? 'Kamar diperbarui!' : 'Kamar ditambahkan!'), backgroundColor: Colors.green)); }
          },
          child: Text(isEdit ? 'Simpan' : 'Tambah', style: const TextStyle(color: Colors.white)),
        ),
      ],
    ));
  }

  @override
  Widget build(BuildContext context) {
    return Column(children: [
      // Search & filter bar
      Container(
        padding: const EdgeInsets.all(16),
        child: Row(children: [
          Expanded(child: TextField(
            onChanged: (v) { _search = v; _load(); },
            decoration: InputDecoration(hintText: 'Cari Kamar', prefixIcon: const Icon(Icons.search), filled: true, fillColor: Colors.white,
              border: OutlineInputBorder(borderRadius: BorderRadius.circular(8), borderSide: BorderSide.none)),
          )),
          const SizedBox(width: 12),
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 12),
            decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(8)),
            child: DropdownButtonHideUnderline(child: DropdownButton<String>(
              value: _statusFilter.isEmpty ? null : _statusFilter,
              hint: const Text('Status'),
              items: [
                const DropdownMenuItem(value: '', child: Text('Semua')),
                ...['kosong', 'terisi', 'booking'].map((e) => DropdownMenuItem(value: e, child: Text(e))),
              ],
              onChanged: (v) { _statusFilter = v ?? ''; _load(); },
            )),
          ),
          const SizedBox(width: 12),
          ElevatedButton.icon(
            style: ElevatedButton.styleFrom(backgroundColor: primaryColor, padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 14)),
            onPressed: () => _showForm(),
            icon: const Icon(Icons.add, color: Colors.white, size: 18),
            label: const Text('Tambah Kamar', style: TextStyle(color: Colors.white, fontWeight: FontWeight.w600)),
          ),
        ]),
      ),
      // Table
      Expanded(child: _loading
        ? const Center(child: CircularProgressIndicator(color: primaryColor))
        : Container(
          margin: const EdgeInsets.symmetric(horizontal: 16),
          decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12)),
          child: SingleChildScrollView(
            scrollDirection: Axis.horizontal,
            child: DataTable(
              headingRowColor: WidgetStateProperty.all(const Color(0xFFF9FAFB)),
              columns: const [
                DataColumn(label: Text('NO', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
                DataColumn(label: Text('NO. KAMAR', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
                DataColumn(label: Text('TIPE', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
                DataColumn(label: Text('HARGA / BULAN', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
                DataColumn(label: Text('STATUS', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
                DataColumn(label: Text('AKSI', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Color(0xFF6B7280)))),
              ],
              rows: List.generate(_kamars.length, (i) {
                final k = _kamars[i];
                final st = k['status'] ?? '';
                final stColor = st == 'terisi' ? Colors.green : st == 'booking' ? Colors.amber : Colors.grey;
                return DataRow(cells: [
                  DataCell(Text('${i + 1}')),
                  DataCell(Text('${k['no_kamar']}', style: const TextStyle(fontWeight: FontWeight.bold))),
                  DataCell(Text('${k['tipe']}')),
                  DataCell(Text('${k['harga_formatted']}')),
                  DataCell(Container(
                    padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                    decoration: BoxDecoration(color: stColor.withOpacity(0.12), borderRadius: BorderRadius.circular(12)),
                    child: Row(mainAxisSize: MainAxisSize.min, children: [
                      if (st == 'terisi') Container(width: 6, height: 6, margin: const EdgeInsets.only(right: 4), decoration: BoxDecoration(color: stColor, shape: BoxShape.circle)),
                      Text(st[0].toUpperCase() + st.substring(1), style: TextStyle(fontSize: 12, fontWeight: FontWeight.w600, color: stColor)),
                    ]),
                  )),
                  DataCell(Row(children: [
                    IconButton(icon: Icon(Icons.visibility_outlined, color: Colors.grey.shade400, size: 20), onPressed: () {}),
                    IconButton(icon: Icon(Icons.edit_outlined, color: Colors.grey.shade400, size: 20), onPressed: () => _showForm(kamar: k)),
                  ])),
                ]);
              }),
            ),
          ),
        ),
      ),
      const SizedBox(height: 16),
    ]);
  }
}
