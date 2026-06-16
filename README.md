## TaskMaster — Sistem Manajemen Tugas Sekolah/Kuliah

Aplikasi web manajemen tugas berbasis **Laravel 11** lengkap dengan fitur autentikasi, CRUD, dashboard admin, dan tampilan modern.

Video Presentasi
https://drive.google.com/file/d/10o3K1zleuOQgvRVgKCsBau9oG_yrhzYw/view?usp=drivesdk

---

## Fitur yang Diimplementasikan

| No | Kriteria | Status |
|----|----------|--------|
| 1 | Framework Laravel 11 | ✅ |
| 2 | Database & Relasi Tabel | ✅ |
| 3 | CRUD (Create, Read, Update, Delete) | ✅ |
| 4 | Login / Autentikasi | ✅ |
| 5 | Validasi Input | ✅ |
| 6 | Tampilan Frontend yang Rapi | ✅ |
| 7 | Demo / Cara Kerja Aplikasi | ✅ (lihat bawah) |
| 8 | Login Admin (Bonus) | ✅ |

---

## Struktur Database & Relasi

```
users           → hasMany tasks, hasMany task_comments
tasks           → belongsTo user, belongsTo category, hasMany task_comments
categories      → hasMany tasks
task_comments   → belongsTo task, belongsTo user
```

**Tabel:**
- `users` — id, name, email, password, role (admin/student), nim, jurusan, semester
- `categories` — id, name, color, icon, description
- `tasks` — id, user_id (FK), category_id (FK), title, description, priority, status, due_date, due_time, mata_kuliah, dosen, progress, is_pinned
- `task_comments` — id, task_id (FK), user_id (FK), comment

---

## Cara Instalasi & Menjalankan

### Prasyarat
- PHP >= 8.2
- Composer
- MySQL / MariaDB
- Node.js (opsional, untuk asset)

### Langkah-langkah

```bash
# 1. Clone / extract project ini ke folder
cd taskmaster

# 2. Install dependencies
composer install

# 3. Salin file .env
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Buat database MySQL bernama 'taskmaster'
#    Lalu sesuaikan .env:
# DB_DATABASE=taskmaster
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Jalankan migrasi + seeder
php artisan migrate --seed

# 7. Jalankan server
php artisan serve
```

Buka browser: **http://localhost:8000**

---

## Akun Demo (setelah seeder)

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@taskmaster.com | admin123 |
| **Mahasiswa 1** | budi@student.com | password |
| **Mahasiswa 2** | siti@student.com | password |

---

## Alur Aplikasi (Demo)

### Sebagai Mahasiswa:
1. **Register** → Buat akun baru dengan data akademik
2. **Login** → Masuk ke dashboard
3. **Dashboard** → Lihat statistik tugas (total, dikerjakan, selesai, terlambat)
4. **Tambah Tugas** → Isi judul, mata kuliah, dosen, prioritas, deadline, progress
5. **Filter & Cari** → Filter berdasarkan status, prioritas, kategori
6. **Detail Tugas** → Lihat detail lengkap, ubah status cepat, tambah catatan
7. **Edit Tugas** → Update progress, status, atau informasi lainnya
8. **Hapus Tugas** → Konfirmasi dan hapus tugas

### Sebagai Admin:
1. **Login** dengan akun admin
2. **Dashboard Admin** → Lihat statistik keseluruhan sistem
3. **Kelola Pengguna** → Lihat, edit, hapus akun mahasiswa
4. **Kelola Kategori** → Tambah/edit/hapus kategori tugas
5. **Monitor Tugas** → Lihat semua tugas dari semua mahasiswa

---

## Struktur File Penting

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php      ← Login, Register, Logout
│   │   ├── TaskController.php      ← CRUD Tugas + Komentar
│   │   └── AdminController.php     ← Dashboard Admin + CRUD Users/Categories
│   └── Middleware/
│       └── AdminMiddleware.php     ← Proteksi route admin
├── Models/
│   ├── User.php
│   ├── Task.php
│   ├── Category.php
│   └── TaskComment.php
database/
├── migrations/                     ← 4 tabel dengan relasi
└── seeders/DatabaseSeeder.php      ← Data dummy
resources/views/
├── layouts/app.blade.php           ← Layout utama dengan sidebar
├── auth/login.blade.php
├── auth/register.blade.php
├── tasks/                          ← index, create, edit, show
└── admin/                          ← dashboard, users, categories, tasks
routes/web.php                      ← Semua routing
bootstrap/app.php                   ← Registrasi middleware
```

---

## Fitur Unggulan

- **Dark theme** modern dengan sidebar navigasi
- **Statistik real-time** di dashboard
- **Filter & pencarian** multi-kriteria
- **Progress bar** per tugas (0–100%)
- **Sistem prioritas** 4 level (Rendah, Sedang, Tinggi, Urgent)
- **Pin tugas** penting di atas
- **Komentar/catatan** per tugas
- **Indikator terlambat** otomatis
- **Role-based access** (Admin vs Mahasiswa)

---

## Validasi Input yang Diimplementasikan

- Semua field wajib tervalidasi
- Format email dicek
- Password minimal 8 karakter + konfirmasi
- Email unik (tidak bisa duplikat)
- Enum validation untuk priority dan status
- Format tanggal & waktu
- Panjang karakter maksimum per field
- Pesan error dalam Bahasa Indonesia
