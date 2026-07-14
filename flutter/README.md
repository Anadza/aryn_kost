# Aryn Kost - Aplikasi Mobile Manajemen Kost

Aplikasi mobile berbasis **Flutter** untuk manajemen kost (boarding house), yang menyediakan tiga jenis akses pengguna: **Admin**, **Owner**, dan **Penghuni**. Aplikasi ini memudahkan proses pencarian kamar, booking, pembayaran/tagihan, pengaduan, hingga pengelolaan data kamar dan penghuni — semuanya dari perangkat mobile.

## Prasyarat Sistem

Pastikan perangkat pengembangan sudah memiliki:

- **Flutter SDK** `^3.11.4` (Dart SDK terkait mengikuti Flutter)
- **Android Studio** atau **VS Code** dengan plugin Flutter & Dart
- Emulator Android/iOS, atau perangkat fisik dengan USB debugging aktif
- Koneksi jaringan yang sama dengan server backend (lihat bagian **Konfigurasi Koneksi Backend** di bawah)

Cek instalasi Flutter dengan:

```bash
flutter doctor
```

## Getting Started (Instalasi & Menjalankan Aplikasi)

1. **Clone repository** (atau masuk ke folder proyek `aryn_kost`)

   ```bash
   cd flutter
   ```

2. **Install dependencies**

   ```bash
   flutter pub get
   ```

3. **Konfigurasi URL Backend**

   Buka `lib/config/app_config.dart` dan sesuaikan `baseUrl` dengan alamat server Laravel yang sedang berjalan (lihat penjelasan di bagian bawah):

   ```dart
   class AppConfig {
     static const String baseUrl = 'http://<IP-ADDRESS-BACKEND>/tugas-besar-nara/laravel/public/api';
   }
   ```

4. **Jalankan aplikasi**

   ```bash
   flutter run
   ```

   Pilih device/emulator yang tersedia saat diminta.

> **Catatan:** Jika menjalankan di perangkat fisik/emulator yang terpisah dari komputer server, gunakan alamat IP lokal komputer (bukan `localhost`/`127.0.0.1`) agar backend dapat diakses, dan pastikan keduanya berada dalam jaringan Wi-Fi/hotspot yang sama.

## Fitur Utama

- **Autentikasi** — Login & Register dengan penyimpanan sesi (token & role) menggunakan `shared_preferences`.
- **Multi-Role Access** — Tampilan dan navigasi berbeda untuk role **Admin**, **Owner**, dan **Penghuni**, ditentukan otomatis setelah login.
- **Katalog Kamar Kost** — Menampilkan daftar kamar kost yang tersedia untuk calon penghuni (dapat diakses tanpa login).
- **Booking Kamar** — Penghuni dapat mengajukan booking kamar.
- **Manajemen Data Kamar** *(Admin)* — Create, Read, Update, Delete data kamar kost.
- **Manajemen Data Penghuni** *(Admin)* — Create, Read, Update, Delete data penghuni, lengkap dengan pencarian dan filter status.
- **Pengaduan** — Penghuni dapat mengirim pengaduan; Admin dapat melihat dan memperbarui status pengaduan.
- **Tagihan & Pembayaran** — Penghuni dapat melihat tagihan; Admin mengelola data pembayaran/status pembayaran.
- **Dashboard Statistik** — Ringkasan data untuk Admin dan Penghuni yang diambil langsung dari backend.
- **Profil Pengguna** — Melihat dan mengelola data profil.

## Struktur Folder Utama

```
lib/
├── config/
│   └── app_config.dart          # Konfigurasi URL dasar (base URL) API backend
├── models/
│   └── kamar_model.dart         # Model data untuk entitas Kamar
├── screens/
│   ├── admin/                   # Halaman-halaman khusus role Admin
│   │   ├── admin_home_screen.dart
│   │   ├── data_kamar_screen.dart
│   │   ├── data_pengaduan_screen.dart
│   │   ├── data_penghuni_screen.dart
│   │   ├── pembayaran_screen.dart
│   │   └── profil_screen.dart
│   ├── owner/                   # Halaman khusus role Owner
│   │   └── owner_home_screen.dart
│   ├── penghuni/                # Halaman-halaman khusus role Penghuni
│   │   ├── booking_kamar_screen.dart
│   │   ├── pengaduan_penghuni_screen.dart
│   │   ├── penghuni_home_screen.dart
│   │   └── tagihan_penghuni_screen.dart
│   ├── home_kost_screen.dart     # Halaman utama publik (katalog kamar)
│   ├── login_screen.dart         # Halaman login
│   └── register_screen.dart      # Halaman registrasi
├── services/
│   ├── api_service.dart          # Layanan pengambilan data kamar (publik)
│   ├── auth_service.dart         # Layanan autentikasi (login, register, logout, token)
│   ├── crud_service.dart         # Layanan CRUD (kamar, penghuni, pengaduan, tagihan)
│   └── dashboard_service.dart    # Layanan pengambilan data dashboard
├── widgets/
│   └── app_drawer.dart           # Widget drawer navigasi bersama
└── main.dart                     # Entry point aplikasi & routing awal berdasarkan role
```

## Konfigurasi Koneksi Backend

Aplikasi ini **terhubung ke backend Laravel melalui RESTful API** (bukan GraphQL). Seluruh komunikasi data — autentikasi, CRUD kamar/penghuni/pengaduan/tagihan, hingga dashboard — dilakukan melalui HTTP request (GET, POST, PUT, PATCH, DELETE) ke endpoint yang tersedia di:

```
<BASE_URL_BACKEND>/api/...
```

- Autentikasi berbasis **token** (Laravel Sanctum) yang dikirim melalui header `Authorization: Bearer <token>` pada setiap request yang memerlukan login.
- Response API menggunakan format JSON standar: `{ "success": bool, "message": string, "data": ... }`.
- Base URL API dikonfigurasi secara terpusat di `lib/config/app_config.dart` — **wajib disesuaikan** dengan alamat server backend Laravel sebelum aplikasi dijalankan (lihat README backend Laravel untuk cara menjalankan servernya).