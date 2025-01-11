## Manajemen Inventaris/Penjualan

### Instalasi
- clone repositori
- jalankan perintah `composer install`
- copy file `.env.example` ke `.env` dan atur database
- jalankan perintah `php artisan key:generate`
- jalankan perintah `php artisan migrate`
- jalankan perintah `php artisan db:seed`
- jalankan perintah `php artisan serve`

### Penggunaan
- admin: admin@admin.com
- password: admin4321

### Fitur
- Dashboard
    - Penjualan Hari Ini
    - Penjualan Bulan Ini
    - Grafik Penjualan
    - Produk Terlaris
- Produk
- Penjualan (Stok berkurang otomatis)
- Pengguna (Admin & Karyawan)
- Laporan Penjualan Periode Tanggal