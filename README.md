# 🥢 Sistem Angkringan Digital (Laravel)

Sistem Angkringan Digital adalah aplikasi web berbasis Laravel yang dirancang untuk membantu pengelolaan usaha angkringan secara modern dan efisien. Aplikasi ini menyediakan fitur manajemen menu, pemesanan, stok, laporan penjualan, dan mendukung multi-user dengan sistem otentikasi.

## 🚀 Fitur Utama

-   🔐 Autentikasi user (login, register)
-   🍜 Kelola menu (tambah, edit, hapus, stok, ketersediaan)
-   📦 Pemesanan oleh tukang angkringan
-   📊 Laporan penjualan harian dan bulanan
-   📉 Notifikasi stok hampir habis
-   👥 Multi-user: setiap user hanya bisa melihat data angkringan miliknya

## 🗃️ Struktur Tabel (Relasi Database)

-   **Users**: menyimpan data pengguna (nama, email, nama_angkringan, password)
-   **Menus**: data menu makanan/minuman (relasi ke user)
-   **Orders**: pesanan (relasi ke user)
-   **OrderItems**: detail item dari setiap pesanan (relasi ke menu dan order)

## 🛠️ Teknologi

-   Laravel 10/11+
-   Blade Template + Tailwind CSS
-   MySQL / MariaDB
-   Font Awesome (untuk ikon)
-   Laravel Breeze (opsional untuk autentikasi)

## 📦 Instalasi

```bash
git clone https://github.com/IchwanArdi/Sistem-Angkringan-Digital
cd sistem-angkringan
composer install
cp .env.example .env
php artisan key:generate

# Konfigurasi database di file .env
php artisan migrate --seed
php artisan serve
```
