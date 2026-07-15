class AppConfig {
  // Menggunakan IP lokal agar bisa diakses dari HP (Hotspot)
  // Karena Anda menjalankan php artisan serve, pastikan menggunakan port 8000
  static const String baseUrl = 'http://10.111.151.181:8000/api';
}
