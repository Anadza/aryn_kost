import 'package:flutter/material.dart';
import '../services/auth_service.dart';
import '../screens/home_kost_screen.dart';

const Color primaryColor = Color(0xFF254D70);
const Color secondaryColor = Color(0xFFEFE4D2);
const Color bgColor = Color(0xFFF8EFD8);

class AppDrawer extends StatelessWidget {
  final String role;
  final int selectedIndex;
  final Function(int) onTap;

  const AppDrawer({super.key, required this.role, required this.selectedIndex, required this.onTap});

  @override
  Widget build(BuildContext context) {
    final isAdmin = role == 'admin' || role == 'owner';
    final menuItems = isAdmin
      ? [
          _MenuItem(Icons.dashboard_outlined, 'Dashboard', 0),
          _MenuItem(Icons.meeting_room_outlined, 'Data Kamar', 1),
          _MenuItem(Icons.receipt_long_outlined, 'Pembayaran', 2),
          _MenuItem(Icons.people_outlined, 'Data Penghuni', 3),
          _MenuItem(Icons.campaign_outlined, 'Data Pengaduan', 4),
          _MenuItem(Icons.person_outlined, 'Profil', 5),
        ]
      : [
          _MenuItem(Icons.dashboard_outlined, 'Dashboard', 0),
          _MenuItem(Icons.home_outlined, 'Booking Kamar', 1),
          _MenuItem(Icons.campaign_outlined, 'Pengaduan', 2),
          _MenuItem(Icons.receipt_long_outlined, 'Tagihan', 3),
          _MenuItem(Icons.person_outlined, 'Profil', 4),
        ];

    return Drawer(
      backgroundColor: primaryColor,
      child: SafeArea(
        child: Column(
          children: [
            // Logo header
            Padding(
              padding: const EdgeInsets.symmetric(vertical: 24, horizontal: 16),
              child: Row(children: [
                Image.asset('assets/images/logof.png', width: 40, height: 40,
                  errorBuilder: (_, _, _) => Container(width: 40, height: 40,
                    decoration: BoxDecoration(color: Colors.white24, borderRadius: BorderRadius.circular(8)),
                    child: const Icon(Icons.apartment, color: Colors.white))),
                const SizedBox(width: 12),
                const Text('arynKost', style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold, fontSize: 20)),
              ]),
            ),
            // Menu items
            ...menuItems.map((item) {
              final isSelected = item.index == selectedIndex;
              return Container(
                margin: const EdgeInsets.symmetric(horizontal: 8, vertical: 2),
                decoration: BoxDecoration(
                  color: isSelected ? Colors.white.withValues(alpha: 0.15) : Colors.transparent,
                  borderRadius: BorderRadius.circular(8),
                ),
                child: ListTile(
                  leading: Icon(item.icon, color: Colors.white.withValues(alpha: isSelected ? 1 : 0.7), size: 20),
                  title: Text(item.label, style: TextStyle(color: Colors.white.withValues(alpha: isSelected ? 1 : 0.7), fontSize: 14, fontWeight: isSelected ? FontWeight.w600 : FontWeight.normal)),
                  dense: true,
                  onTap: () { Navigator.pop(context); onTap(item.index); },
                ),
              );
            }),
            const Spacer(),
            // Logout
            Container(
              margin: const EdgeInsets.all(8),
              child: ListTile(
                leading: Icon(Icons.logout, color: Colors.white.withValues(alpha: 0.7), size: 20),
                title: Text('Logout', style: TextStyle(color: Colors.white.withValues(alpha: 0.7), fontSize: 14)),
                dense: true,
                onTap: () async {
                  await AuthService.logout();
                  if (!context.mounted) return;
                  Navigator.pushAndRemoveUntil(context, MaterialPageRoute(builder: (_) => const HomeKostScreen()), (_) => false);
                },
              ),
            ),
            const SizedBox(height: 8),
          ],
        ),
      ),
    );
  }
}

class _MenuItem {
  final IconData icon;
  final String label;
  final int index;
  _MenuItem(this.icon, this.label, this.index);
}
