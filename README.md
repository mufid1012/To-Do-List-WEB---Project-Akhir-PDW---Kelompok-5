# To Do List Web App

Project ini adalah aplikasi manajemen tugas berbasis web dengan fitur autentikasi user, panel admin, serta pengelolaan jadwal dan informasi kuliah.

## Fitur Utama

- **Autentikasi**: Registrasi, login, dan logout pengguna.
- **Dashboard**: Menampilkan tugas yang harus diselesaikan.
- **CRUD Tugas**: Tambah, edit, hapus tugas harian.
- **Jadwal Kuliah**: Manajemen jadwal mata kuliah.
- **Panel Admin**: Manajemen user, jadwal, dan informasi kuliah.
- **Informasi Kuliah**: Fitur input dan update info kuliah oleh admin.

## Teknologi yang Digunakan

- **Backend**: PHP (tanpa framework)
- **Frontend**: HTML, CSS, JavaScript
- **Database**: MySQL (akses via `includes/koneksi.php`)
- **UI Asset**: Folder `assets/` (CSS, gambar, JS, dsb.)

## Instalasi & Cara Menjalankan

1. **Clone repo atau ekstrak ZIP:**
atau ekstrak file ZIP ke folder htdocs (jika pakai XAMPP).

2. **Setup Database:**
- Import database yang ada di folder `db/` (`db.sql` atau sejenisnya) ke MySQL, contoh via phpMyAdmin.

3. **Edit Koneksi Database:**
- Ubah konfigurasi database di `includes/koneksi.php` sesuai setting MySQL-mu.

4. **Jalankan di Localhost:**
- Gunakan XAMPP, Laragon, atau built-in PHP server:
  ```
  php -S localhost:8000
  ```
- Akses via browser ke `http://localhost/To Do List/` atau sesuai folder kamu simpan.

## Struktur Direktori

- `index.php`         : Halaman utama (login)
- `dashboard.php`     : Dashboard tugas user
- `add_tugas.php`     : Menambah tugas baru
- `edit_tugas.php`    : Edit tugas
- `delete_tugas.php`  : Hapus tugas
- `register.php`      : Registrasi user
- `admin_panel.php`   : Panel admin
- `jadwal_kuliah.php` : Lihat jadwal kuliah
- `informasi.php`     : Informasi kuliah
- `includes/`         : File PHP pendukung (koneksi, fungsi, dsb.)
- `assets/`           : CSS, JS, gambar

## Catatan

- Pastikan ekstensi PHP aktif di server.
- Login sebagai admin untuk mengakses fitur panel admin dan manajemen jadwal/informasi kuliah.

## Kontribusi

Pull request dan masukan sangat diterima! Silakan buat issue jika ada bug/masukan.

---



