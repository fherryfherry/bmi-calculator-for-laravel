# Aplikasi BMI - Admin Panel

Proyek ini adalah sistem manajemen **Kalkulator BMI (Body Mass Index)** yang dibangun dengan **Laravel 12**, dilengkapi dengan admin panel modern yang mendukung Dark Mode, RBAC (Role-Based Access Control), dan dialog konfirmasi interaktif.

## 🏗️ Arsitektur & Struktur Proyek

Proyek ini mengikuti pola arsitektur **MVC (Model-View-Controller)** standar Laravel dengan struktur admin yang terorganisir:

- **Namespace Admin**: Controller admin dikelompokkan dalam `App\Http\Controllers\Admin` untuk pemisahan logika yang bersih.
- **Blade Templating**: Sistem layouting menggunakan `@extends`, `@section`, dan `@yield` untuk reusability komponen UI.
- **Middleware Auth**: Mengamankan rute `/admin/*` menggunakan middleware `auth` bawaan Laravel.
- **RBAC Layer**: Authorization menggunakan `spatie/laravel-permission` dengan guard `web`, permission granular per action, dan bypass penuh untuk role `super-admin`.

## 🛠️ Tech Stack & Library

### Backend
- **Framework**: Laravel 12.x
- **Database**: SQLite (`database/database.sqlite`)
- **PHP**: ^8.2
- **Authorization**: [spatie/laravel-permission](https://spatie.be/docs/laravel-permission) ^6.9
- **HTTP Client**: Guzzle ^7.2
- **API Authentication**: Laravel Sanctum ^4.0

### Frontend
- **CSS Framework**: [Tailwind CSS](https://tailwindcss.com/) (via CDN dengan konfigurasi kustom)
- **Icons**: [Material Symbols Outlined](https://fonts.google.com/icons) (Google Fonts)
- **Fonts**: Space Grotesk & Public Sans
- **Dialog & Notifications**: [SweetAlert2](https://sweetalert2.github.io/)
- **Build Tool**: Vite ^5.0 (untuk asset compilation)

## ⚙️ Konfigurasi Utama

### Environment Variables

| Variable | Deskripsi | Default |
|----------|-----------|---------|
| `ADMIN_NAV_LAYOUT` | Layout navigasi admin (`sidebar` atau `topbar`) | `sidebar` |
| `ADMIN_LOGIN_LAYOUT` | Tampilan halaman login (`panel`, `split`, `spotlight`) | `panel` |
| `ADMIN_DEFAULT_EMAIL` | Email admin default | `admin@example.com` |
| `ADMIN_DEFAULT_PASSWORD` | Password admin default (digenerate random) | - |
| `AGENT_LOGIN_TOKEN` | Token bypass auth untuk development | - |

### Navigation Layout

Admin panel mendukung dua mode navigasi desktop:

- `ADMIN_NAV_LAYOUT=sidebar` → menu tampil di panel kiri (default)
- `ADMIN_NAV_LAYOUT=topbar` → menu tampil di navbar atas

### Login Layout

Halaman login admin mendukung tiga model tampilan:

- `ADMIN_LOGIN_LAYOUT=panel` → card login tunggal di tengah (default)
- `ADMIN_LOGIN_LAYOUT=split` → split screen dengan panel informatif di sisi kiri
- `ADMIN_LOGIN_LAYOUT=spotlight` → hero layout dengan form floating di sisi kanan

> **Catatan**: Jika mengubah nilai env pada environment yang memakai config cache, jalankan `php artisan optimize:clear` lalu restart server.

## 🔐 Dev Bypass Auth (Local Only)

Untuk memudahkan pengecekan URL yang membutuhkan autentikasi saat pengembangan lokal:

1. Set variabel pada `.env`: `AGENT_LOGIN_TOKEN=<token_rahasia>`
2. Kirim header pada request: `x-login-token: <token_rahasia>`
3. Middleware akan otomatis melakukan login sebagai user pertama yang tersedia

**Fitur ini HANYA aktif pada environment `local`.**

## 📋 Fitur Aplikasi

### 🔒 Autentikasi & Autorisasi
- Login/Logout admin dengan proteksi middleware
- Seed role dan permission otomatis
- Authorization `403` untuk akses tanpa permission
- Visibility menu dan action berdasarkan permission
- Proteksi role sistem `super-admin` (tidak bisa dihapus/dimodifikasi)

### 📊 Dashboard
- Ringkasan statistik sistem
- UI responsif dengan dukungan tema Light & Dark

### 📈 Manajemen BMI Records
- Daftar catatan perhitungan BMI pengguna
- Detail rekaman BMI per user
- Riwayat kalkulasi dengan interpretasi status (Underweight, Normal, Overweight, Obese)

### 👥 Manajemen User
- CRUD user admin
- Assign role ke user
- Validasi proteksi agar `super-admin` terakhir tidak bisa hilang

### 🛡️ Manajemen Role
- CRUD role
- Permission matrix per modul
- Proteksi role sistem `super-admin`

### 👤 Profil Admin
- Pengaturan informasi akun (Nama, Email)
- Perubahan kata sandi

### 🌓 Fitur Tema & UI
- **Toggle Dark/Light Mode**: Berfungsi di seluruh area admin dan halaman login, status disimpan di `localStorage`
- **SweetAlert2 Integration**: Notifikasi sukses dan dialog konfirmasi yang cantik
- **Responsive Mobile Menu**: Navigasi mobile menggunakan drawer untuk konsistensi di semua layout

## 🛠️ Cara Menjalankan Proyek

### Prasyarat
- PHP ^8.2 terinstall
- Composer terinstall
- SQLite extension enabled

### Langkah Instalasi

1. **Clone atau buka folder proyek**
   ```bash
   cd path/to/project
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Buat database SQLite**
   ```bash
   touch database/database.sqlite
   ```

5. **Jalankan migrasi dan seeder**
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Jalankan server development**
   ```bash
   php artisan serve
   ```

7. **Akses aplikasi**
   - URL: `http://localhost:8000/admin/login`
   - Email: `admin@example.com`
   - Password: Lihat nilai `ADMIN_DEFAULT_PASSWORD` di `.env`

## ✅ Testing

Untuk memastikan auth, RBAC, dan modul admin berjalan dengan baik:

```bash
php artisan test
```

Coverage testing mencakup:
- Login/logout admin
- Seed role dan permission
- Authorization `403`
- Visibility menu/action berdasarkan permission
- CRUD users
- CRUD roles
- Safety rules `super-admin`
- Update profile

## 📁 Struktur Direktori Penting

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── AuthController.php
│   │   │   │   ├── BmiRecordController.php
│   │   │   │   ├── ProfileController.php
│   │   │   │   ├── RoleController.php
│   │   │   │   └── UserController.php
│   │   │   └── Controller.php
│   │   └── Middleware/
│   ├── Models/
│   ├── Support/
│   │   ├── AccessControl.php
│   │   └── admin_copy.php
│   └── Providers/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   │   ├── bmi-records/
│   │   │   ├── roles/
│   │   │   ├── users/
│   │   │   ├── login/
│   │   │   ├── dashboard.blade.php
│   │   │   ├── layout.blade.php
│   │   │   └── profile.blade.php
│   │   └── welcome.blade.php
│   └── js/
├── routes/
│   └── web.php
├── config/
│   └── admin.php
└── themes/
    ├── backend/
    └── frontend/
```

## 🔧 Development Commands

| Command | Deskripsi |
|---------|-----------|
| `php artisan serve` | Jalankan server development |
| `php artisan migrate:fresh --seed` | Reset database dan seed data |
| `php artisan test` | Jalankan test suite |
| `php artisan optimize:clear` | Clear semua cache |
| `php artisan route:list` | Lihat daftar routes |
| `php artisan pint` | Format kode dengan Laravel Pint |

## 📝 Catatan Penting

1. **Database**: Proyek menggunakan SQLite sebagai default. Untuk production, pertimbangkan PostgreSQL atau MySQL.
2. **File Upload**: Pastikan direktori `storage/app/public` writable dan sudah jalankan `php artisan storage:link`.
3. **Permission Cache**: Jika mengubah permission/role, clear cache dengan `php artisan optimize:clear`.
4. **Dark Mode**: Status tema disimpan di browser localStorage, reset dengan clear browser data.

## 📄 License

Proyek ini menggunakan license MIT sesuai dengan Laravel framework.

---

**Dibuat dengan ❤️ menggunakan Laravel 12 & CRUDBooster**
