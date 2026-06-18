Sistem Informasi Makeup Artist by Lala
Sistem informasi reservasi makeup artist berbasis web yang dibangun menggunakan framework Laravel dengan arsitektur MVC dan role-based access control (Admin, MUA, Customer).

Persyaratan Sistem
1. PHP >= 8.1
2. Composer
3. Node.js & NPM
4. MySQL
5. Git


Instalasi
1. Clone Repository
bashgit clone https://github.com/username/nama-repo.git
cd nama-repo

2. Install Dependensi PHP
bashcomposer install

4. Install Dependensi JavaScript
bashnpm install

5. Konfigurasi Environment
bashcp .env.example .env
php artisan key:generate
Lalu buka file .env dan sesuaikan konfigurasi database:
envDB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=

6. Buat Database
Buat database baru di MySQL dengan nama yang sudah kamu tulis di .env, lalu jalankan migrasi:
bashphp artisan migrate

7. Seed Data Awal (Opsional)
bashphp artisan db:seed

8. Buat Storage Link
bashphp artisan storage:link

9. Menjalankan Aplikasi
php artisan serve

11. Akses aplikasi di browser: http://127.0.0.1:8000



Fitur Utama

Admin — Manajemen layanan, booking, MUA, customer, pembayaran, laporan, chat, dan notifikasi
MUA — Manajemen jadwal, data klien, review, dan chat
Customer — Katalog layanan, booking, review, chat, dan notifikasi

