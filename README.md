# Cinemora

Web pemesanan tiket bioskop sederhana (PHP + MySQL).

## Cara menjalankan
1. Install XAMPP, nyalakan Apache dan MySQL.
2. Taruh folder ini di `C:\xampp\htdocs\project_cinema`.
3. Buka phpMyAdmin → Import → pilih `database/db_bioskop.sql`.
4. Buka `http://localhost/project_cinema/`.

## Akun admin
1. Daftar akun lewat halaman Daftar.
2. Di phpMyAdmin jalankan:
   UPDATE users SET role='admin' WHERE email='emailmu@contoh.com';
3. Login ulang.
