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
      // Filter bar
      Container(
        color: Colors.white,
        padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 10),
        child: Row(children: [
          Expanded(child: Container(
            padding: const EdgeInsets.symmetric(horizontal: 10),
            decoration: BoxDecoration(color: const Color(0xFFF3F4F6), borderRadius: BorderRadius.circular(8)),
            child: DropdownButtonHideUnderline(child: DropdownButton<String>(
              value: _tipeFilter.isEmpty ? null : _tipeFilter,
              hint: const Text('Tipe Kamar', style: TextStyle(fontSize: 13)),
              isExpanded: true,
              items: [const DropdownMenuItem(value: '', child: Text('Semua Tipe')),
                ...['Standar','Deluxe','VIP'].map((e) => DropdownMenuItem(value: e, child: Text(e)))],
              onChanged: (v) { _tipeFilter = v ?? ''; _load(); })),
          )),
          const SizedBox(width: 8),
          Expanded(child: Container(
            padding: const EdgeInsets.symmetric(horizontal: 10),
            decoration: BoxDecoration(color: const Color(0xFFF3F4F6), borderRadius: BorderRadius.circular(8)),
            child: DropdownButtonHideUnderline(child: DropdownButton<String>(
              value: _statusFilter.isEmpty ? null : _statusFilter,
              hint: const Text('Semua Status', style: TextStyle(fontSize: 13)),
              isExpanded: true,
              items: [const DropdownMenuItem(value: '', child: Text('Semua Status')),
                ...['kosong','terisi','booking'].map((e) => DropdownMenuItem(value: e, child: Text(e)))],
              onChanged: (v) { _statusFilter = v ?? ''; _load(); })),
          )),
        ]),
      ),
      Padding(
        padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 6),
        child: Row(mainAxisAlignment: MainAxisAlignment.end, children: [
          Text('Menampilkan ${_kamars.length} kamar',
              style: const TextStyle(color: Color(0xFF6B7280), fontSize: 12)),
        ]),
      ),
      // Card grid
      Expanded(child: _loading
        ? const Center(child: CircularProgressIndicator(color: primaryColor))
        : _kamars.isEmpty
          ? const Center(child: Column(mainAxisAlignment: MainAxisAlignment.center, children: [
              Text('📦', style: TextStyle(fontSize: 48)),
              SizedBox(height: 8),
              Text('Tidak ada kamar ditemukan',
                  style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Color(0xFF4B5563))),
            ]))
          : GridView.builder(
              padding: const EdgeInsets.fromLTRB(12, 0, 12, 16),
              gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                crossAxisCount: MediaQuery.of(context).size.width > 700 ? 3 : 2,
                crossAxisSpacing: 12,
                mainAxisSpacing: 12,
                mainAxisExtent: 360,
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
    final stLabel = k['status_label'] ?? (st == 'kosong' ? 'Kosong' : st == 'terisi' ? 'Terisi' : 'Booking');
    final fasilitas = (k['fasilitas'] as List<dynamic>?) ?? [];
    final isAvailable = st == 'kosong';

    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: isAvailable ? primaryColor.withValues(alpha: 0.3) : Colors.grey.shade200),
        boxShadow: [BoxShadow(color: Colors.black.withValues(alpha: 0.06), blurRadius: 8, offset: const Offset(0, 2))],
      ),
      clipBehavior: Clip.antiAlias,
      child: Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
        // Photo + badge
        Stack(children: [
          Image.asset(
            'assets/images/kamar/${k['tipe'].toString().toLowerCase()}.png',
            height: 110, width: double.infinity, fit: BoxFit.cover,
            errorBuilder: (_, _, _) => Container(
              height: 110, color: const Color(0xFFF3F4F6),
              child: const Center(child: Icon(Icons.apartment, size: 36, color: Colors.grey)))),
          // Gradient overlay
          Positioned.fill(child: Container(
            decoration: BoxDecoration(
              gradient: LinearGradient(
                begin: Alignment.topCenter, end: Alignment.bottomCenter,
                colors: [Colors.transparent, Colors.black.withValues(alpha: 0.3)])))),
          Positioned(top: 8, left: 8, child: Container(
            padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 3),
            decoration: BoxDecoration(color: stColor, borderRadius: BorderRadius.circular(20)),
            child: Text(stLabel, style: const TextStyle(color: Colors.white, fontSize: 10, fontWeight: FontWeight.w700)))),
        ]),
        // Content
        Expanded(child: Padding(padding: const EdgeInsets.all(10), child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text('${k['tipe']} ${k['no_kamar']}',
                style: const TextStyle(fontSize: 14, fontWeight: FontWeight.bold, color: Color(0xFF1F2937)),
                overflow: TextOverflow.ellipsis),
            const SizedBox(height: 4),
            Row(children: [
              const Icon(Icons.person_outline, size: 12, color: Color(0xFF6B7280)),
              const SizedBox(width: 2),
              Text('${k['kapasitas'] ?? '-'}', style: const TextStyle(fontSize: 11, color: Color(0xFF6B7280))),
              const SizedBox(width: 8),
              const Icon(Icons.straighten, size: 12, color: Color(0xFF6B7280)),
              const SizedBox(width: 2),
              Expanded(child: Text('${k['ukuran'] ?? '-'}',
                  style: const TextStyle(fontSize: 11, color: Color(0xFF6B7280)), overflow: TextOverflow.ellipsis)),
            ]),
            const SizedBox(height: 6),
            // Fasilitas chips
            if (fasilitas.isNotEmpty)
              Wrap(spacing: 3, runSpacing: 3, children: fasilitas.take(3).map((f) => Container(
                padding: const EdgeInsets.symmetric(horizontal: 6, vertical: 2),
                decoration: BoxDecoration(color: const Color(0xFFF0FDF4), borderRadius: BorderRadius.circular(4),
                    border: Border.all(color: Colors.green.shade200)),
                child: Text('$f', style: TextStyle(fontSize: 9, color: Colors.green.shade700)))).toList()),
            const Spacer(),
            // Price
            Text('${k['harga_formatted']}',
                style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: primaryColor)),
            const Text('/ bulan', style: TextStyle(fontSize: 10, color: Color(0xFF6B7280))),
            const SizedBox(height: 8),
            // Button
            SizedBox(width: double.infinity, child: ElevatedButton(
              style: ElevatedButton.styleFrom(
                backgroundColor: isAvailable ? primaryColor : Colors.grey.shade200,
                foregroundColor: isAvailable ? Colors.white : Colors.grey.shade500,
                padding: const EdgeInsets.symmetric(vertical: 9),
                elevation: isAvailable ? 2 : 0,
                shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8))),
              onPressed: isAvailable ? () => _showBookingDialog(k) : null,
              child: Text(
                isAvailable ? 'Pesan Sekarang' : 'Tidak Tersedia',
                style: const TextStyle(fontWeight: FontWeight.w600, fontSize: 12)),
            )),
          ],
        ))),
      ]),
    );
  }

  void _showBookingDialog(Map<String, dynamic> k) {
    int durasi = 1;
    final catatanC = TextEditingController();

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
              // Handle bar
              Center(child: Container(
                width: 40, height: 4,
                decoration: BoxDecoration(color: Colors.grey.shade300, borderRadius: BorderRadius.circular(4)))),
              const SizedBox(height: 16),
              // Header
              Row(children: [
                Container(
                  width: 48, height: 48,
                  decoration: BoxDecoration(color: primaryColor.withValues(alpha: 0.1), borderRadius: BorderRadius.circular(12)),
                  child: const Icon(Icons.hotel_rounded, color: primaryColor, size: 24)),
                const SizedBox(width: 12),
                Expanded(child: Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
                  const Text('Form Booking Kamar', style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: primaryColor)),
                  Text('${k['tipe']} ${k['no_kamar']}', style: TextStyle(fontSize: 13, color: Colors.grey.shade600)),
                ])),
              ]),
              const SizedBox(height: 16),
              // Info card
              Container(
                padding: const EdgeInsets.all(14),
                decoration: BoxDecoration(
                    color: const Color(0xFFF0FDF4),
                    borderRadius: BorderRadius.circular(12),
                    border: Border.all(color: Colors.green.shade200)),
                child: Row(children: [
                  const Icon(Icons.info_outline, color: Colors.green, size: 18),
                  const SizedBox(width: 8),
                  Expanded(child: Text(
                    'Kamar ini tersedia. Harga: ${k['harga_formatted']}/bulan',
                    style: const TextStyle(fontSize: 12, color: Colors.green))),
                ]),
              ),
              const SizedBox(height: 16),
              const Text('Durasi Sewa', style: TextStyle(fontWeight: FontWeight.w600, fontSize: 14)),
              const SizedBox(height: 8),
              Row(children: [
                IconButton(
                  style: IconButton.styleFrom(
                      backgroundColor: primaryColor.withValues(alpha: 0.1),
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8))),
                  icon: const Icon(Icons.remove, color: primaryColor),
                  onPressed: () { if (durasi > 1) setModal(() => durasi--); }),
                Expanded(child: Center(child: Text(
                  '$durasi Bulan',
                  style: const TextStyle(fontSize: 20, fontWeight: FontWeight.bold, color: primaryColor)))),
                IconButton(
                  style: IconButton.styleFrom(
                      backgroundColor: primaryColor.withValues(alpha: 0.1),
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8))),
                  icon: const Icon(Icons.add, color: primaryColor),
                  onPressed: () => setModal(() => durasi++)),
              ]),
              const SizedBox(height: 16),
              // Total
              Container(
                padding: const EdgeInsets.all(14),
                decoration: BoxDecoration(color: primaryColor.withValues(alpha: 0.05), borderRadius: BorderRadius.circular(12)),
                child: Row(mainAxisAlignment: MainAxisAlignment.spaceBetween, children: [
                  const Text('Total Pembayaran:', style: TextStyle(fontWeight: FontWeight.w600, fontSize: 14)),
                  Text(
                    'Rp ${_formatHarga((k['harga'] as num? ?? 0) * durasi)}',
                    style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: primaryColor)),
                ]),
              ),
              const SizedBox(height: 16),
              const Text('Catatan (Opsional)', style: TextStyle(fontWeight: FontWeight.w600, fontSize: 14)),
              const SizedBox(height: 8),
              TextField(
                controller: catatanC,
                maxLines: 3,
                decoration: InputDecoration(
                  hintText: 'Contoh: Saya akan pindah tanggal 20 Juli...',
                  hintStyle: TextStyle(color: Colors.grey.shade400, fontSize: 12),
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
                    Navigator.pop(ctx2);
                    setState(() => _loading = true);
                    try {
                      final ok = await _svc.bookKamar(k['id'], {'durasi': durasi, 'catatan': catatanC.text});
                      if (ok) {
                        if (mounted) {
                          ScaffoldMessenger.of(context).showSnackBar(SnackBar(
                          content: const Row(children: [
                            Icon(Icons.check_circle, color: Colors.white),
                            SizedBox(width: 8),
                            Expanded(child: Text('Booking berhasil! Silakan cek menu Tagihan.')),
                          ]),
                          backgroundColor: Colors.green.shade600,
                          behavior: SnackBarBehavior.floating,
                          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
                        ));
                        }
                        _load();
                      } else {
                        if (mounted) {
                          ScaffoldMessenger.of(context).showSnackBar(const SnackBar(
                          content: Text('Gagal melakukan booking. Coba lagi.'),
                          backgroundColor: Colors.red));
                        }
                        setState(() => _loading = false);
                      }
                    } catch (e) {
                      if (mounted) {
                        ScaffoldMessenger.of(context).showSnackBar(SnackBar(
                        content: Text('Error: $e'), backgroundColor: Colors.red));
                      }
                      setState(() => _loading = false);
                    }
                  },
                  child: const Text('Konfirmasi Booking',
                      style: TextStyle(color: Colors.white, fontWeight: FontWeight.w700, fontSize: 14)))),
              ]),
            ],
          )),
        ),
      ),
    );
  }

  String _formatHarga(num val) {
    return val.toInt().toString().replaceAllMapped(
        RegExp(r'(\d)(?=(\d{3})+(?!\d))'), (m) => '${m[1]}.');
  }
}
