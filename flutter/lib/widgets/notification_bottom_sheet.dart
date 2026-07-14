import 'package:flutter/material.dart';
import '../services/crud_service.dart';
import 'app_drawer.dart';

class NotificationBottomSheet extends StatefulWidget {
  final bool isAdmin;
  const NotificationBottomSheet({super.key, required this.isAdmin});

  @override
  State<NotificationBottomSheet> createState() => _NotificationBottomSheetState();
}

class _NotificationBottomSheetState extends State<NotificationBottomSheet> {
  final CrudService _svc = CrudService();
  List<dynamic> _notifs = [];
  bool _loading = true;

  @override
  void initState() {
    super.initState();
    _load();
  }

  Future<void> _load() async {
    try {
      final data = widget.isAdmin ? await _svc.fetchAdminNotifikasi() : await _svc.fetchMyNotifikasi();
      if (mounted) setState(() { _notifs = data; _loading = false; });
    } catch (_) {
      if (mounted) setState(() { _loading = false; });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: const BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.vertical(top: Radius.circular(20)),
      ),
      padding: const EdgeInsets.symmetric(vertical: 20),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          Container(
            width: 40, height: 4,
            decoration: BoxDecoration(color: Colors.grey.shade300, borderRadius: BorderRadius.circular(4)),
          ),
          const SizedBox(height: 16),
          const Padding(
            padding: EdgeInsets.symmetric(horizontal: 20),
            child: Row(
              children: [
                Icon(Icons.notifications, color: primaryColor),
                SizedBox(width: 8),
                Text('Notifikasi', style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: primaryColor)),
              ],
            ),
          ),
          const Divider(),
          Expanded(
            child: _loading
              ? const Center(child: CircularProgressIndicator(color: primaryColor))
              : _notifs.isEmpty
                ? const Center(child: Text('Tidak ada notifikasi', style: TextStyle(color: Colors.grey)))
                : ListView.builder(
                    itemCount: _notifs.length,
                    itemBuilder: (ctx, i) {
                      final n = _notifs[i];
                      final isUnread = n['status'] == 'belum_dibaca';
                      return Container(
                        color: isUnread ? primaryColor.withOpacity(0.05) : Colors.transparent,
                        child: ListTile(
                          leading: CircleAvatar(
                            backgroundColor: primaryColor.withOpacity(0.1),
                            child: const Icon(Icons.notifications_active, color: primaryColor, size: 20),
                          ),
                          title: Text(n['judul'] ?? 'Notifikasi', style: TextStyle(fontWeight: isUnread ? FontWeight.bold : FontWeight.normal, fontSize: 14)),
                          subtitle: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Text(n['pesan'] ?? '', style: const TextStyle(fontSize: 12)),
                              const SizedBox(height: 4),
                              Text(n['created_at'] != null ? n['created_at'].toString().substring(0, 10) : '', style: const TextStyle(fontSize: 10, color: Colors.grey)),
                            ],
                          ),
                        ),
                      );
                    },
                  ),
          ),
        ],
      ),
    );
  }
}

void showNotificationSheet(BuildContext context, {required bool isAdmin}) {
  showModalBottomSheet(
    context: context,
    backgroundColor: Colors.transparent,
    isScrollControlled: true,
    builder: (ctx) => FractionallySizedBox(
      heightFactor: 0.8,
      child: NotificationBottomSheet(isAdmin: isAdmin),
    ),
  );
}
