
---
# 📚 Sistem Manajemen Perpustakaan Digital v1.0

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php)

## ✨ Kutipan
"Aku tidak berilmu; yang berilmu hanyalah DIA. Jika tampak ilmu dariku, itu hanyalah pantulan dari Cahaya-Nya."

## 🎥 Demo
![Demo](./videoujicoba.gif)


## 📖 Daftar Isi
1. [Deskripsi Proyek](#-deskripsi-proyek)
2. [Fitur Utama](#-fitur-utama)
3. [Teknologi Digunakan](#-teknologi-digunakan)
4. [Struktur Database](#-struktur-database)
5. [Panduan Instalasi](#-panduan-instalasi)
6. [Panduan Penggunaan](#-panduan-penggunaan)
7. [Testing](#-testing)
8. [Roadmap](#-roadmap)
9. [Kontribusi](#-kontribusi)

## 🌟 Deskripsi Proyek
Sistem Manajemen Perpustakaan Digital adalah aplikasi web berbasis Laravel yang dirancang untuk:
- Mengelola koleksi buku digital
- Memproses transaksi peminjaman
- Mengelola keanggotaan perpustakaan
- Menghasilkan laporan statistik


## ✨ Fitur Utama

### 🛠️ Fitur Administrasi
- **Manajemen Buku** (CRUD lengkap dengan upload cover)
- **Manajemen Kategori** dengan sistem relasi
- **Manajemen Anggota** dengan verifikasi data
- **Sistem Peminjaman** dengan tracking status
- **Perhitungan Denda** otomatis
- 
### 👤 Fitur Petugas
- Bisa melihat seluruh daftar riwayat peminjaman dan pengembalian.
- Bisa mencatat peminjaman baru untuk anggota (+ Catat Peminjaman).
- Bisa memproses pengembalian buku (Kembalikan), yang juga secara otomatis akan membuat denda jika terlambat.
  Mengelola Modul Denda:

- Bisa melihat daftar semua denda yang belum dibayar.
- Bisa menandai denda sebagai "Lunas" setelah anggota membayarnya.

### 👤 Fitur Member (User)
- Profil lengkap + statistik peminjaman & denda
- Riwayat Peminjaman Anggota
- Daftar Denda Pribadi

### 📊 Fitur Laporan
- Statistik peminjaman
- Ekspor data ke PDF
- Riwayat transaksi

### 👤 Manajemen Pengguna
- Sistem role-based (Admin, Petugas, Anggota)
- Autentikasi aman dengan Laravel Breeze
- Profil pengguna yang dapat dikustomisasi

## 🛠️ Teknologi Digunakan
| Komponen | Teknologi |
|----------|-----------|
| Backend  | Laravel 12, PHP 8.2+ |
| Frontend | Blade, Tailwind CSS, Alpine.js |
| Database | MySQL |
| Lainnya  | Laravel Breeze, DomPDF |

## 🗃️ Struktur Database
![Diagram ERD](https://i.ibb.co/0jQY5Lk/Screenshot-2025-06-14-142345.png)

```mermaid
erDiagram
    USERS ||--o{ USER_PROFILES : "has"
    USERS ||--o{ BORROWINGS : "makes"
    BOOKS ||--o{ BORROWINGS : "included_in"
    BORROWINGS ||--o{ FINES : "generates"
```

## 🚀 Panduan Instalasi

### Prasyarat
- PHP 8.2+
- Composer
- Node.js 16+
- MySQL 5.7+

### Langkah-langkah
1. Clone repositori:
   ```bash
   git clone https://github.com/username/repo.git
   cd repo
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

Bash

cp .env.example .env
Generate kunci aplikasi:

Bash

php artisan key:generate
Konfigurasi database Anda di file .env:

Cuplikan kode

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_perpustakaan
DB_USERNAME=root
DB_PASSWORD=
Pastikan Anda sudah membuat database db_perpustakaan di server database Anda.

Jalankan migrasi dan seeder database:
Perintah ini akan membuat semua tabel dan mengisinya dengan data awal (termasuk akun admin, petugas, dan anggota).

Bash

php artisan migrate --seed
Buat symbolic link untuk storage:
Ini penting agar file yang di-upload (seperti sampul buku) bisa diakses.

Bash

php artisan storage:link
Install dependensi frontend (Node.js):

Bash

npm install
Jalankan server pengembangan:

Buka satu terminal dan jalankan Vite untuk kompilasi aset:
Bash

npm run dev
Buka terminal kedua dan jalankan server aplikasi Laravel:
Bash

php artisan serve
Selesai! Aplikasi Anda sekarang berjalan di http://127.0.0.1:8000.

🔑 Cara Penggunaan
Setelah instalasi berhasil, Anda dapat login menggunakan akun default yang telah dibuat oleh seeder:

Akun Admin:

Email: admin@perpus.com
Password: password
Akses: Memiliki akses ke semua fitur manajemen.

Akun Petugas:

Email: petugas@perpus.com
Password: password

Akun Anggota:

Email: anggota@perpus.com
Password: password
Akses: Dapat login dan melihat dashboard standar.


# 🤝 Berkontribusi

1. Fork project
2. Buat branch fitur (`git checkout -b fitur-baru`)
3. Commit perubahan (`git commit -m 'Tambahkan fitur'`)
4. Push ke branch (`git push origin fitur-baru`)
5. Buat Pull Request


## ✨ Penghargaan

Dikembangkan dengan ❤ oleh [Alghifari888](https://github.com/Alghifari888)  
---

⭐ Jika project ini membantu, mohon beri star di GitHub!  
🔔 Pantau update terbaru untuk fitur-fitur baru!
```
