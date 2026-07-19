class AppConfig {
  // Menggunakan IP lokal agar bisa diakses dari HP (Hotspot)
  // Karena Anda menjalankan php artisan serve, pastikan menggunakan port 8000
  static const String baseUrl = 'http://175.165.35.112:8000/api';
}
