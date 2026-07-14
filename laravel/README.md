# Link Demo Aplikasi

Demo Aplikasi: https://youtu.be/qAPgjYqzJ48

# Aryn Kost - Backend & Dashboard Admin

Aplikasi backend dan dashboard admin berbasis **Laravel 13** untuk mengelola sistem manajemen kost (boarding house), mencakup data kamar, penghuni, booking, pengaduan, tagihan, dan pembayaran. Backend ini menyediakan halaman web (dashboard multi-role: Admin, Owner, Penghuni) sekaligus **REST API** yang dikonsumsi oleh aplikasi mobile Flutter (**Aryn Kost**).

## Fitur Utama

- Autentikasi & manajemen role-permission (Admin, Owner, Penghuni) menggunakan Laravel Breeze + Spatie Permission
- Dashboard statistik untuk masing-masing role
- CRUD: Data Kamar, Data Penghuni, Pengaduan, Tagihan/Pembayaran
- Booking kamar (pengajuan, approve/reject oleh admin)
- Search, sort, dan pagination pada tabel data
- REST API (dengan autentikasi token Laravel Sanctum) untuk aplikasi mobile Flutter
- Notifikasi untuk admin dan penghuni

## Tech Stack

- **Laravel** ^13.8
- **PHP** ^8.3
- **MySQL** 8 (default `.env`: SQLite untuk kemudahan setup lokal — lihat bagian Instalasi)
- **Laravel Breeze** (Blade) — scaffolding autentikasi
- **Laravel Sanctum** ^4.0 — autentikasi token untuk REST API
- **Spatie Laravel Permission** ^8.3 — manajemen role & permission
- **Tailwind CSS** ^3.1, **Alpine.js** ^3.4 — UI
- **Vite** ^8.0 — build asset frontend

## Instalasi

1. **Clone repository & masuk ke folder backend**

   ```bash
   cd laravel
   ```

2. **Install dependency PHP**

   ```bash
   composer install
   ```

3. **Install dependency JavaScript & build asset**

   ```bash
   npm install
   npm run build
   ```

4. **Salin file environment**

   ```bash
   cp .env.example .env
   ```

5. **Generate application key**

   ```bash
   php artisan key:generate
   ```

6. **Konfigurasi database**

   Secara default proyek ini menggunakan **SQLite** (`DB_CONNECTION=sqlite`), sehingga cukup pastikan file database tersedia:

   ```bash
   touch database/database.sqlite
   ```

   Jika ingin menggunakan **MySQL**, ubah konfigurasi pada `.env` menjadi:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=aryn_kost
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   lalu buat database `aryn_kost` di MySQL sebelum lanjut ke langkah berikutnya.

7. **Migrasi & seeding database**

   ```bash
   php artisan migrate --seed
   ```

   Perintah ini akan membuat seluruh struktur tabel sekaligus mengisi data awal (role, permission, akun default, data kamar, penghuni, tagihan, dan pengaduan contoh) agar aplikasi siap didemokan dari database kosong.

8. **Buat symbolic link storage** (diperlukan untuk file upload, mis. bukti pembayaran/pengaduan)

   ```bash
   php artisan storage:link
   ```

## Menjalankan Local Server

```bash
php artisan serve
```

Server akan berjalan di `http://127.0.0.1:8000` (atau `http://localhost:8000`).

Untuk keperluan pengembangan asset (hot reload Tailwind/Alpine), jalankan juga secara terpisah:

```bash
npm run dev
```

> **Untuk diakses dari aplikasi mobile Flutter**, jalankan server dengan opsi `--host` agar bisa diakses dari perangkat lain di jaringan yang sama, misalnya:
>
> ```bash
> php artisan serve --host=0.0.0.0 --port=8000
> ```
>
> Kemudian sesuaikan `baseUrl` di aplikasi Flutter (`lib/config/app_config.dart`) dengan alamat IP lokal komputer ini, contoh: `http://192.168.1.10:8000/api`.

## 👥 Akun Default

| Email | Password | Role |
|---|---|---|
| admin@gmail.com | password | admin |
| owner@gmail.com | password | owner |
| penghuni@gmail.com | password | penghuni |

## Dokumentasi Endpoint REST API

Base URL: `http://<host>:8000/api`

Autentikasi menggunakan **Bearer Token** (Laravel Sanctum). Setelah login, sertakan header `Authorization: Bearer <token>` pada request yang memerlukan autentikasi.

### Publik (tanpa autentikasi)

| Method | Endpoint | Keterangan |
|---|---|---|
| POST | `/login` | Login, mengembalikan token & data user |
| POST | `/register` | Registrasi akun baru |
| GET | `/kost` | Daftar semua kamar kost |
| GET | `/kost/tersedia` | Daftar kamar kost yang tersedia |
| GET | `/kost/{id}` | Detail satu kamar kost |

### Memerlukan Autentikasi (`Authorization: Bearer <token>`)

| Method | Endpoint | Keterangan |
|---|---|---|
| POST | `/logout` | Logout & invalidasi token |
| GET | `/me` | Data user yang sedang login |
| GET | `/dashboard/admin` | Statistik dashboard admin |
| GET | `/dashboard/penghuni` | Statistik dashboard penghuni |
| POST | `/kost` | Tambah kamar |
| PUT | `/kost/{kamar}` | Update kamar |
| DELETE | `/kost/{kamar}` | Hapus kamar |
| GET | `/penghuni` | Daftar penghuni (mendukung `?search=` & `?status=`) |
| POST | `/penghuni` | Tambah penghuni |
| PUT | `/penghuni/{id}` | Update penghuni |
| DELETE | `/penghuni/{id}` | Hapus penghuni |
| GET | `/pengaduan` | Daftar seluruh pengaduan |
| PATCH | `/pengaduan/{id}/status` | Update status pengaduan |
| GET | `/tagihan` | Daftar tagihan (mendukung `?status=`) |
| PUT | `/tagihan/{id}` | Update status tagihan/pembayaran |
| PUT | `/profile` | Update profil user |
| GET | `/my/pengaduan` | Daftar pengaduan milik penghuni yang login |
| POST | `/my/pengaduan` | Kirim pengaduan baru (penghuni) |
| GET | `/my/tagihan` | Daftar tagihan milik penghuni yang login |

Semua response menggunakan format JSON standar:

```json
{
  "success": true,
  "message": "...",
  "data": { }
}
```

## Struktur Database & Relasi Singkat

Migration utama yang membentuk struktur database: `users`, `penghunis`, `kamars`, `bookings`, `pengaduans`, `tagihans`, `pembayaran`, `notifikasis`, `notifikasi_penghunis`, beserta tabel bawaan Spatie Permission (roles, permissions) dan Sanctum (personal_access_tokens). Struktur dibuat sepenuhnya melalui migration dan dapat direproduksi dari database kosong menggunakan `php artisan migrate --seed`.

## Git Workflow

Proyek ini menggunakan alur kerja Git kolaboratif:

- Branch `master` sebagai branch utama/stabil
- Setiap fitur dikerjakan pada branch terpisah dengan format `feature/nama-fitur` (contoh: `feature/upload-pembayaran`)
- Perubahan diajukan melalui Pull Request untuk direview sebelum di-merge ke `master`
- Riwayat commit mencerminkan kontribusi masing-masing anggota tim
