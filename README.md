Berikut ini versi terbaru dari README yang **sudah diperbarui** dengan seluruh fitur tambahan yang telah kamu buat, termasuk: katalog interaktif, halaman akun anggota, dan navigasi dinamis. Saya juga rapikan penulisan Bash, Markdown, dan struktur keseluruhan agar lebih profesional dan mudah dibaca.

---

````markdown
# 📚 Sistem Manajemen Perpustakaan Digital v1.1

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php)

> ✨ _"Aku tidak berilmu; yang berilmu hanyalah DIA. Jika tampak ilmu dariku, itu hanyalah pantulan dari Cahaya-Nya."_

---

## 🎥 Demo
![Demo](./videoujicoba.gif)

---

## 📖 Daftar Isi
1. [Deskripsi Proyek](#-deskripsi-proyek)
2. [Fitur Utama](#-fitur-utama)
3. [Fitur Tambahan v1.1](#-fitur-tambahan-v11)
4. [Teknologi Digunakan](#-teknologi-digunakan)
5. [Struktur Database](#-struktur-database)
6. [Panduan Instalasi](#-panduan-instalasi)
7. [Panduan Penggunaan](#-panduan-penggunaan)
8. [Kontribusi](#-kontribusi)
9. [Penghargaan](#-penghargaan)

---

## 🌟 Deskripsi Proyek

Aplikasi web berbasis Laravel untuk mengelola:
- Koleksi buku digital
- Transaksi peminjaman & pengembalian
- Data anggota
- Laporan statistik dan denda

---

## ✨ Fitur Utama

### 🛠️ Fitur Administrasi
- CRUD Manajemen Buku (termasuk upload cover)
- Manajemen Kategori dengan relasi
- Manajemen Anggota dengan verifikasi data
- Sistem Peminjaman dengan tracking status
- Perhitungan Denda otomatis

### 📊 Fitur Laporan
- Statistik peminjaman
- Ekspor PDF
- Riwayat Transaksi

### 👤 Manajemen Pengguna
- Role-based (Admin, Petugas, Anggota)
- Laravel Breeze untuk autentikasi aman
- Profil pengguna dapat dikustomisasi

---

## 🚀 Fitur Tambahan v1.1

### 📚 Katalog Buku Interaktif untuk Anggota
- URL: `/member/catalog`
- Pencarian judul/penulis
- Filter kategori
- Tampilan kartu modern + status ketersediaan

### 👤 Halaman Akun Saya
- Profil lengkap + statistik peminjaman & denda
- Riwayat Peminjaman Anggota
- Daftar Denda Pribadi
- Menggunakan `Auth::id()` untuk personalisasi

### 🧭 Navigasi Dinamis berdasarkan Role
- Navigasi berbeda untuk Admin / Petugas / Anggota
- Khusus anggota: link ke “Katalog Buku” dan “Akun Saya”
- Sinkronisasi tampilan mobile (hamburger) & desktop

---

## 🛠️ Teknologi Digunakan

| Komponen | Teknologi                     |
|----------|-------------------------------|
| Backend  | Laravel 12, PHP 8.2+          |
| Frontend | Blade, Tailwind CSS, Alpine.js|
| Database | MySQL                         |
| Lainnya  | Laravel Breeze, DomPDF        |

---

## 🗃️ Struktur Database

![Diagram ERD](https://i.ibb.co/0jQY5Lk/Screenshot-2025-06-14-142345.png)

```mermaid
erDiagram
    USERS ||--o{ USER_PROFILES : "has"
    USERS ||--o{ BORROWINGS : "makes"
    BOOKS ||--o{ BORROWINGS : "included_in"
    BORROWINGS ||--o{ FINES : "generates"
````

---

## 🚀 Panduan Instalasi

### Prasyarat

* PHP 8.2+
* Composer
* Node.js 16+
* MySQL 5.7+

### Langkah-Langkah Instalasi

```bash
git clone https://github.com/username/repo.git
cd repo

composer install
npm install

cp .env.example .env
php artisan key:generate
```

### Konfigurasi Database

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_perpustakaan
DB_USERNAME=root
DB_PASSWORD=
```

Pastikan database `db_perpustakaan` telah dibuat.

### Migrasi & Seeder

```bash
php artisan migrate --seed
php artisan storage:link
```

### Jalankan Aplikasi

```bash
# Terminal 1 - frontend
npm run dev

# Terminal 2 - backend
php artisan serve
```

Akses aplikasi di: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🔑 Panduan Penggunaan

### Akun Default

| Role    | Email                                           | Password |
| ------- | ----------------------------------------------- | -------- |
| Admin   | [admin@perpus.com](mailto:admin@perpus.com)     | password |
| Petugas | [petugas@perpus.com](mailto:petugas@perpus.com) | password |
| Anggota | [anggota@perpus.com](mailto:anggota@perpus.com) | password |

---

## 🤝 Kontribusi

1. Fork project ini
2. Buat branch baru (`git checkout -b fitur-baru`)
3. Commit perubahan (`git commit -m 'Tambah fitur'`)
4. Push branch (`git push origin fitur-baru`)
5. Buat Pull Request

---

## ✨ Penghargaan

Dikembangkan dengan ❤ oleh [Alghifari888](https://github.com/Alghifari888)

---

⭐ Jika project ini bermanfaat, beri **star** di GitHub
🔔 Jangan lupa pantau update fitur-fitur terbaru!

```

---

Kalau kamu setuju dengan isi ini, saya bisa bantu kamu ubah langsung ke `README.md` atau bantu pecah lagi jadi file `CHANGELOG.md` juga biar dokumentasi makin lengkap. Mau dilanjutkan ke sana?
```
