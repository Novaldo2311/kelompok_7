# Aplikasi Parkir

## Menyiapkan database

1. Jalankan Apache dan MySQL dari XAMPP.
2. Buka phpMyAdmin, lalu impor file `parkir (2).sql` yang disediakan. File tersebut membuat database `parkir` beserta tabel dan data awal.
3. Pengaturan default di `config/s/koneksi.php` adalah host `localhost`, user `root`, password kosong, dan database `parkir` (default XAMPP).
4. Jika memakai akun atau password MySQL yang berbeda, ubah nilai `$host`, `$username`, dan `$password` di file koneksi tersebut. Setiap komputer harus menjalankan MySQL sendiri dan mengimpor dump database.

## Menggunakan koneksi

Sertakan file koneksi dari halaman di dalam `pages/` atau modul di dalam `modules/`:

```php
require_once __DIR__ . '/../config/s/koneksi.php';
```

Koneksi MySQLi tersedia pada variabel `$conn` dan menggunakan charset `utf8mb4`. Pastikan ekstensi `mysqli` aktif pada PHP XAMPP.