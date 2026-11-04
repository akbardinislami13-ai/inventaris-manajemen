# Manajemen Buku

Aplikasi Manajemen Buku dengan autentikasi Laravel Breeze dan role/permission Spatie.

## Akun Pengujian

| Role      | Email                     | Password |
| --------- | ------------------------- | -------- |
| Admin     | admin@inventaris.test     | password |
| Dosen     | dosen@inventaris.test     | password |
| Mahasiswa | mahasiswa@inventaris.test | password |

Admin: admin@inventaris.test (password : password)
Dosen: dosen@inventaris.test (password = password)
Mahasiswa: mahasiswa@inventaris.test (password = password)

Akun di atas dibuat oleh `RolePermissionSeeder`. Jalankan `php artisan migrate:fresh --seed` untuk menyiapkannya.
