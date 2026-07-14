import 'package:flutter/material.dart';
import '../../services/crud_service.dart';
import '../../widgets/app_drawer.dart';

class BookingKamarScreen extends StatefulWidget {
  const BookingKamarScreen({super.key});
  @override
  State<BookingKamarScreen> createState() => _BookingKamarScreenState();
}

class _BookingKamarScreenState extends State<BookingKamarScreen> {
  final CrudService _svc = CrudService();
  List<dynamic> _kamars = [];
  bool _loading = true;
  String _tipeFilter = '';
  String _statusFilter = '';

  @override
  void initState() { super.initState(); _load(); }

  Future<void> _load() async {
    setState(() => _loading = true);
    try {
      _kamars = await _svc.fetchKamar(status: _statusFilter.isNotEmpty ? _statusFilter : null);
      if (_tipeFilter.isNotEmpty) {
        _kamars = _kamars.where((k) => k['tipe'] == _tipeFilter).toList();
      }
    } catch (_) { _kamars = []; }
    setState(() => _loading = false);
  }

  @override
  Widget build(BuildContext context) {
    return Column(children: [
      // Filter sidebar row (matching web's left sidebar filter)
      Container(padding: const EdgeInsets.all(16), child: Row(children: [
        // Filter chips
        Container(padding: const EdgeInsets.symmetric(horizontal: 12), decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(8)),
          child: DropdownButtonHideUnderline(child: DropdownButton<String>(
            value: _tipeFilter.isEmpty ? null : _tipeFilter, hint: const Text('Tipe Kamar'),
            items: [const DropdownMenuItem(value: '', child: Text('Semua Tipe')), ...['Standar','Deluxe','VIP'].map((e) => DropdownMenuItem(value: e, child: Text(e)))],
            onChanged: (v) { _tipeFilter = v ?? ''; _load(); }))),
        const SizedBox(width: 12),
        Container(padding: const EdgeInsets.symmetric(horizontal: 12), decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(8)),
          child: DropdownButtonHideUnderline(child: DropdownButton<String>(
            value: _statusFilter.isEmpty ? null : _statusFilter, hint: const Text('Status'),
            items: [const DropdownMenuItem(value: '', child: Text('Semua')), ...['kosong','terisi','booking'].map((e) => DropdownMenuItem(value: e, child: Text(e)))],
            onChanged: (v) { _statusFilter = v ?? ''; _load(); }))),
        const Spacer(),
        Text('Menampilkan ${_kamars.length} kamar', style: const TextStyle(color: Color(0xFF6B7280), fontSize: 13)),
      ])),
      // Card grid
      Expanded(child: _loading
        ? const Center(child: CircularProgressIndicator(color: primaryColor))
        : _kamars.isEmpty
          ? const Center(child: Column(mainAxisAlignment: MainAxisAlignment.center, children: [
              Text('📦', style: TextStyle(fontSize: 48)),
              SizedBox(height: 8),
              Text('Tidak ada kamar ditemukan', style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Color(0xFF4B5563))),
            ]))
          : GridView.builder(
            padding: const EdgeInsets.symmetric(horizontal: 16),
            gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
              crossAxisCount: MediaQuery.of(context).size.width > 800 ? 4 : MediaQuery.of(context).size.width > 500 ? 3 : 2,
              crossAxisSpacing: 16, 
              mainAxisSpacing: 16, 
              mainAxisExtent: 380,
            ),
            itemCount: _kamars.length,
            itemBuilder: (ctx, i) => _kamarCard(_kamars[i]),
          ),
      ),
    ]);
  }

  Widget _kamarCard(Map<String, dynamic> k) {
    final st = k['status'] ?? '';
    final stColor = st == 'kosong' ? Colors.green : st == 'booking' ? Colors.amber : Colors.red;
    final stLabel = k['status_label'] ?? st;
    final fotoUrl = k['foto_url'] ?? '';
    final fasilitas = (k['fasilitas'] as List<dynamic>?) ?? [];

    return Container(
      decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(16), border: Border.all(color: Colors.grey.shade200),
        boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.04), blurRadius: 8)]),
      clipBehavior: Clip.antiAlias,
      child: Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
        // Photo + status badge
        Stack(children: [
          Image.asset('assets/images/kamar/${k['tipe'].toString().toLowerCase()}.png',
            height: 130, width: double.infinity, fit: BoxFit.cover,
            errorBuilder: (_, __, ___) => Container(height: 130, color: const Color(0xFFF3F4F6), child: const Center(child: Icon(Icons.apartment, size: 40, color: Colors.grey)))),
          Positioned(top: 8, right: 8, child: Container(
            padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
            decoration: BoxDecoration(color: stColor, borderRadius: BorderRadius.circular(12)),
            child: Text(stLabel, style: const TextStyle(color: Colors.white, fontSize: 11, fontWeight: FontWeight.w600)))),
        ]),
        // Content
        Expanded(child: Padding(padding: const EdgeInsets.all(12), child: Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
          Text('${k['tipe']} ${k['no_kamar']}', style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Color(0xFF1F2937))),
          const SizedBox(height: 6),
          Row(children: [
            Text('👤 ${k['kapasitas'] ?? '-'}', style: const TextStyle(fontSize: 12, color: Color(0xFF6B7280))),
            const SizedBox(width: 12),
            Text('📐 ${k['ukuran'] ?? '-'}', style: const TextStyle(fontSize: 12, color: Color(0xFF6B7280))),
            const SizedBox(width: 12),
            Text('🛏 ${k['kasur'] ?? '-'}', style: const TextStyle(fontSize: 12, color: Color(0xFF6B7280))),
          ]),
          const SizedBox(height: 8),
          // Fasilitas chips
          if (fasilitas.isNotEmpty)
            Wrap(spacing: 4, runSpacing: 4, children: fasilitas.take(3).map((f) => Container(
              padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 3),
              decoration: BoxDecoration(color: const Color(0xFFF3F4F6), borderRadius: BorderRadius.circular(12)),
              child: Text('$f', style: const TextStyle(fontSize: 10, color: Color(0xFF4B5563))))).toList()),
          const Spacer(),
          // Price
          const Text('Harga', style: TextStyle(fontSize: 11, color: Color(0xFF6B7280))),
          Text('${k['harga_formatted']}', style: const TextStyle(fontSize: 20, fontWeight: FontWeight.bold, color: primaryColor)),
          const Text('/ bulan', style: TextStyle(fontSize: 11, color: Color(0xFF6B7280))),
          const SizedBox(height: 8),
          // Button
          SizedBox(width: double.infinity, child: ElevatedButton(
            style: ElevatedButton.styleFrom(
              backgroundColor: st == 'kosong' ? primaryColor : Colors.grey.shade300,
              foregroundColor: st == 'kosong' ? Colors.white : Colors.grey.shade600,
              padding: const EdgeInsets.symmetric(vertical: 10),
              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8))),
            onPressed: st == 'kosong' ? () => _showBookingDialog(k) : null,
            child: Text(st == 'kosong' ? 'Pesan Sekarang' : 'Tidak Tersedia', style: const TextStyle(fontWeight: FontWeight.w600, fontSize: 13)),
          )),
        ]))),
      ]),
    );
  }

  void _showBookingDialog(Map<String, dynamic> k) {
    final durasiC = TextEditingController(text: '1');
    final catatanC = TextEditingController();

    showDialog(context: context, builder: (ctx) => AlertDialog(
      title: const Text('Booking Kamar', style: TextStyle(color: primaryColor, fontWeight: FontWeight.bold)),
      content: SingleChildScrollView(child: Column(mainAxisSize: MainAxisSize.min, children: [
        Text('Anda akan memesan kamar ${k['no_kamar']} dengan harga ${k['harga_formatted']}/bulan.', style: const TextStyle(fontSize: 13)),
        const SizedBox(height: 16),
        TextField(controller: durasiC, keyboardType: TextInputType.number, decoration: const InputDecoration(labelText: 'Durasi (Bulan)', border: OutlineInputBorder())),
        const SizedBox(height: 12),
        TextField(controller: catatanC, maxLines: 3, decoration: const InputDecoration(labelText: 'Catatan (Opsional)', border: OutlineInputBorder())),
      ])),
      actions: [
        TextButton(onPressed: () => Navigator.pop(ctx), child: const Text('Batal')),
        ElevatedButton(
          style: ElevatedButton.styleFrom(backgroundColor: primaryColor),
          onPressed: () async {
            final durasi = int.tryParse(durasiC.text) ?? 1;
            final body = {'durasi': durasi, 'catatan': catatanC.text};
            
            Navigator.pop(ctx);
            setState(() => _loading = true);
            
            final ok = await _svc.bookKamar(k['id'], body);
            
            if (ok) {
              ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('Booking berhasil! Silakan cek menu tagihan untuk pembayaran.'), backgroundColor: Colors.green));
              _load();
            } else {
              ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('Gagal melakukan booking.'), backgroundColor: Colors.red));
              setState(() => _loading = false);
            }
          },
          child: const Text('Konfirmasi Booking', style: TextStyle(color: Colors.white)),
        ),
      ],
    ));
  }
}
