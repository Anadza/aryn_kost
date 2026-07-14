import 'package:flutter/material.dart';
import 'screens/home_kost_screen.dart';
import 'screens/login_screen.dart';
import 'screens/admin/admin_home_screen.dart';
import 'screens/owner/owner_home_screen.dart';
import 'screens/penghuni/penghuni_home_screen.dart';
import 'services/auth_service.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  Future<Widget> _getInitialScreen() async {
    final token = await AuthService.getToken();
    final role = await AuthService.getRole();

    if (token != null && role != null) {
      if (role == 'admin') return const AdminHomeScreen();
      if (role == 'owner') return const OwnerHomeScreen();
      if (role == 'penghuni') return const PenghuniHomeScreen();
    }
    
    // Default to HomeKostScreen if not authenticated
    return const HomeKostScreen();
  }

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Aryn Kost',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(seedColor: Colors.deepPurple),
        useMaterial3: true,
      ),
      home: FutureBuilder<Widget>(
        future: _getInitialScreen(),
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Scaffold(
              body: Center(child: CircularProgressIndicator()),
            );
          }
          if (snapshot.hasData) {
            return snapshot.data!;
          }
          return const HomeKostScreen();
        },
      ),
    );
  }
}
