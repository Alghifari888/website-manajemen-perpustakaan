# 📖 Sistem Manajemen Perpustakaan Digital v1.0

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css)
![License](https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge)

Repositori ini berisi kode sumber lengkap untuk aplikasi **Sistem Manajemen Perpustakaan Digital** yang dibangun dari nol menggunakan **Laravel 12**. Proyek ini dirancang sebagai studi kasus nyata untuk mempelajari arsitektur, praktik terbaik, dan fitur-fitur modern dari framework Laravel.

Aplikasi ini mencakup semua fungsionalitas inti yang dibutuhkan oleh sebuah perpustakaan, mulai dari manajemen koleksi buku, pengelolaan anggota, hingga sistem transaksi peminjaman, pengembalian, dan denda.

![Tampilan Aplikasi Perpustakaan](https://i.ibb.co/L5w2R7x/Screenshot-2025-06-14-142218.png)

---

## 📚 Daftar Isi

1.  [Tentang Proyek](#-tentang-proyek)
2.  [Fitur Utama](#-fitur-utama)
3.  [Struktur Teknologi](#-struktur-teknologi)
4.  [Diagram Relasi Database (ERD)](#-diagram-relasi-database-erd)
5.  [Panduan Instalasi](#-panduan-instalasi)
6.  [Cara Penggunaan](#-cara-penggunaan)
7.  [Lisensi](#-lisensi)

---

## 🌟 Tentang Proyek

Proyek "Perpustakaan Digital" ini dibangun sebagai sebuah buku panduan interaktif. Tujuannya adalah untuk mendemonstrasikan bagaimana membangun aplikasi web skala kecil hingga menengah dengan Laravel 12, dengan fokus pada kode yang bersih, aman, *scalable*, dan mudah dipelihara.

Setiap modul dirancang untuk memperkenalkan konsep-konsep Laravel secara bertahap, mulai dari dasar-dasar seperti Routing dan CRUD, hingga topik yang lebih lanjut seperti Middleware, Form Request Validation, Eager Loading, Database Transaction, dan integrasi dengan paket pihak ketiga.

---

## ✨ Fitur Utama

Aplikasi ini dilengkapi dengan fitur-fitur komprehensif yang dibagi berdasarkan peran pengguna.

#### 👨‍💻 Fitur untuk Admin:
* **Dashboard Statistik:** Menampilkan ringkasan data penting seperti buku terpopuler, anggota teraktif, dan status peminjaman.
* **Manajemen Buku (CRUD):** Kemampuan untuk menambah, melihat, mengedit, dan menghapus data buku, termasuk mengunggah gambar sampul.
* **Manajemen Kategori (CRUD):** Mengelola kategori buku yang berelasi dengan data buku.
* **Manajemen Anggota (CRUD):** Mengelola data pengguna dengan peran "Anggota", termasuk profil dan foto.
* **Manajemen Transaksi:** Memproses dan mencatat semua transaksi peminjaman dan pengembalian buku.
* **Manajemen Denda:** Memantau denda yang belum dibayar dan menandainya sebagai "Lunas".
* **Laporan:** Menghasilkan laporan statistik dalam bentuk halaman web dan kemampuan untuk **mengekspor ke PDF**.

#### 👤 Fitur untuk Petugas (Potensi Pengembangan):
* Peran "Petugas" telah disiapkan dan dapat login.
* Dapat dikembangkan untuk memiliki akses terbatas, misalnya hanya pada modul Transaksi dan Denda.

#### 🧑 Fitur untuk Anggota:
* Dapat login ke sistem dan melihat dashboard standar.
* Profil pengguna yang dapat diedit (nama, email, foto profil).
* Dapat dikembangkan untuk melihat riwayat peminjaman pribadi dan katalog buku.

#### ⚙️ Fitur Umum:
* **Sistem Autentikasi:** Registrasi dan login yang aman menggunakan Laravel Breeze.
* **Manajemen Peran & Hak Akses:** Pembatasan akses ke halaman dan fitur tertentu berdasarkan peran (Admin, Petugas, Anggota) menggunakan Middleware.
* **Desain Responsif:** Tampilan yang beradaptasi dengan baik di berbagai ukuran layar, dari desktop hingga mobile, menggunakan Tailwind CSS.
* **Validasi Form:** Validasi data yang kuat dan aman di sisi server menggunakan Form Request class.

---

## 🛠️ Struktur Teknologi

Proyek ini dibangun menggunakan ekosistem dan teknologi modern:

* **Framework:** Laravel 12
* **Bahasa:** PHP 8.2+
* **Frontend:** Blade Templates, Tailwind CSS, Alpine.js
* **Database:** MySQL
* **Sistem Autentikasi:** Laravel Breeze
* **PDF Generation:** `barryvdh/laravel-dompdf`

---

## Diagram Relasi Database (ERD)

Struktur database dirancang untuk menormalkan data dan memastikan integritas relasional.

```mermaid
erDiagram
    USERS {
        bigint id PK
        string name
        string email UK
        string password
        string role
        timestamp created_at
        timestamp updated_at
    }
    USER_PROFILES {
        bigint user_id PK, FK
        string nis_nim UK
        text address
        string phone_number
        string profile_photo_path
    }
    CATEGORIES {
        bigint id PK
        string name UK
        string slug UK
    }
    BOOKS {
        bigint id PK
        bigint category_id FK
        string title
        string author
        integer stock_quantity
        integer available_quantity
    }
    BORROWINGS {
        bigint id PK
        bigint user_id FK
        bigint book_id FK
        timestamp borrowed_at
        timestamp due_at
        timestamp returned_at
        string status
    }
    FINES {
        bigint id PK
        bigint borrowing_id FK
        bigint user_id FK
        decimal amount
        string status
    }
    USERS ||--o{ USER_PROFILES : "has one"
    USERS ||--o{ BORROWINGS : "borrows"
    USERS ||--o{ FINES : "has"
    BOOKS ||--|{ CATEGORIES : "belongs to"
    BOOKS ||--o{ BORROWROWINGS : "is part of"
    BORROWINGS ||--o{ FINES : "can result in"
🚀 Panduan Instalasi
Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda.

Prasyarat
PHP >= 8.2
Composer
Node.js & NPM
Database Server (misal: MySQL, MariaDB)
Langkah-langkah Instalasi
Clone repositori ini:

Bash

git clone [https://github.com/NAMA_USER_ANDA/NAMA_REPO_ANDA.git](https://github.com/NAMA_USER_ANDA/NAMA_REPO_ANDA.git)
cd NAMA_REPO_ANDA
Install dependensi PHP:

Bash

composer install
Siapkan file lingkungan (.env):

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
Akses: Dapat login, namun belum memiliki menu khusus (dapat dikembangkan lebih lanjut).
Akun Anggota:

Email: anggota@perpus.com
Password: password
Akses: Dapat login dan melihat dashboard standar.