# 🥤 Pocari System - Inventaris & Distribusi

Sistem Informasi Manajemen Inventaris dan Distribusi berbasis web yang dirancang khusus untuk kebutuhan **PT. Amerta Indah Otsuka (Pocari Sweat)**. Aplikasi ini menjembatani proses pengelolaan stok di Gudang Pusat dengan proses pengajuan (request) barang oleh mitra Distributor secara *real-time*, transparan, dan terkomputerisasi.

> 🎓 Proyek ini dibuat sebagai **Tugas Akhir** dengan tema **Inventaris dan Distribusi**.

---

## ✨ Fitur Utama

- **Role-Based Access Control (RBAC):** Menggunakan `spatie/laravel-permission` dengan 3 peran utama: **Super Admin**, **Pusat (HQ)**, dan **Distributor**.
- **Dashboard Terpadu:** Satu tampilan dashboard yang cerdas, di mana statistik dan menu akan menyesuaikan secara otomatis berdasarkan peran pengguna yang sedang login.
- **Manajemen Katalog & Stok:** Pengelolaan produk, kemasan, dan riwayat mutasi stok (barang masuk/keluar) oleh pihak Pusat.
- **Sistem Pengajuan (Request Order):** Distributor dapat mengajukan pesanan, dan Pusat dapat memvalidasi, memproses, hingga mengubah status pengiriman.
- **Cetak Surat Jalan (PDF):** Integrasi dengan DomPDF untuk mencetak surat jalan pengiriman secara otomatis lengkap dengan kolom cek terima.
- **Manajemen Akun & Role:** Super Admin dapat mengelola akun pengguna, mengatur role, dan melakukan *reset password* pengguna lain.
- **Profil Pengguna:** Fitur unggah, ganti, dan hapus foto profil (dengan *fallback* inisial jika belum ada foto). Username dan role bersifat *read-only*.
- **Modern UI/UX:** Tampilan menggunakan Tailwind CSS, dilengkapi dengan **Dark Mode**, sidebar responsif, notifikasi *toast* (SweetAlert2), dan animasi yang halus.

---

## 🛠️ Teknologi yang Digunakan

- **Backend:** Laravel 11.x (PHP 8.4)
- **Database:** MySQL 8.0
- **Frontend:** Tailwind CSS, Alpine.js, Vite, FontAwesome
- **Autentikasi & Otorisasi:** Laravel Breeze (dimodifikasi) & Spatie Laravel Permission
- **PDF Generator:** barryvdh/laravel-dompdf
- **Environment:** Docker & Docker Compose (PHP-FPM, Nginx, Node.js)

---

## 🚀 Panduan Instalasi (Menggunakan Docker)

Proyek ini sudah dilengkapi dengan konfigurasi Docker yang siap pakai. Anda tidak perlu menginstall PHP, MySQL, atau Node.js di laptop Anda.

### 1. Persyaratan

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) sudah terinstall dan berjalan.

### 2. Langkah-langkah

```bash
# 1. Clone repository ini
git clone https://github.com/mlnaarianto/Inventaris-dan-distribusi-laravel.git
cd Inventaris-dan-distribusi-laravel

# 2. Copy file environment
cp .env.example .env

# 3. Build dan jalankan container Docker
docker compose up -d --build

# 4. Install dependensi PHP (Composer)
docker compose exec app composer install

# 5. Generate Application Key
docker compose exec app php artisan key:generate

# 6. Jalankan Migrasi Database beserta Seeder (Data Awal)
docker compose exec app php artisan migrate:fresh --seed

# 7. (Opsional) Bersihkan cache
docker compose exec app php artisan optimize:clear
```

Aplikasi dapat diakses melalui browser di: **http://localhost:8000**

*(Vite / Frontend server sudah berjalan otomatis di dalam container `project_vite`)*

---

## 🔐 Akun Default (Hasil Seeder)

Setelah menjalankan `migrate:fresh --seed`, Anda dapat login menggunakan akun berikut:

| Role | Username | Password | Keterangan |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `superadmin` | `password` | Akses penuh ke seluruh sistem & manajemen user. |
| **Pusat (HQ)** | `pusat` | `password` | Mengelola stok, validasi order, dan cetak surat jalan. |
| **Distributor** | `distributor` | `password` | Membuat pesanan dan memantau status pengiriman. |

> ⚠️ **Catatan:** Segera ganti password default ini jika aplikasi digunakan di lingkungan *production*.

---

## 📂 Struktur Proyek (Poin Penting)

Proyek ini telah melalui proses *refactoring* besar-besaran untuk menghilangkan duplikasi kode antara halaman Pusat dan Distributor:

- **Controllers:** Menggunakan `DashboardController`, `RequestController`, `ProductController`, dan `MutationController` yang disatukan. Logika perbedaan role ditangani menggunakan `@can` (Gate/Permission) di level View dan Controller.
- **Views:** Folder `pusat/` dan `distributor/` telah dihapus. Semua view disatukan di dalam folder `request/`, `produk/`, dan `mutasi/`.
- **Docker:** Konfigurasi terletak pada `Dockerfile`, `docker-compose.yml`, dan `nginx/default.conf`.

---

## 📝 Catatan Progres & Migrasi

### ✅ Selesai

- [x] Migrasi total dari sistem Role lama ke Spatie Permission.
- [x] Penambahan kolom `username` dan `foto` pada tabel `users`.
- [x] Penghapusan fitur Register publik, Forgot Password via email, dan Verify Email (sistem dikelola internal).
- [x] Unifikasi Dashboard Pusat & Distributor menjadi satu `DashboardController`.
- [x] Unifikasi modul Request, Produk, dan Mutasi.
- [x] Fitur Upload Foto Profil (termasuk hapus file lama di storage).
- [x] Implementasi Dark Mode (Tailwind) & *Anti-flash script*.
- [x] Desain ulang UI Login dan Landing Page (Modern SaaS style).
- [x] Integrasi Docker untuk Development Environment.

### 🔧 Yang Perlu Diselesaikan (To-Do)

- [ ] Ubah judul halaman profil dari "Profile" menjadi "Profil Saya".
- [ ] Pasang paket bahasa (`laravel-lang` / `lang/id/validation.php`) agar pesan error validasi berbahasa Indonesia.
- [ ] Perbaiki Font Awesome di sidebar jika ikon sempat tidak muncul (CDN check).
- [ ] Selesaikan bug foto profil di header kanan atas agar merender inisial/foto dengan benar.
- [ ] Tangani error 500 pada `ProductController@destroy` jika produk sudah terikat dengan order.

---

## 📄 Lisensi

Project ini dibangun di atas framework [Laravel](https://laravel.com), yang berlisensi [MIT license](https://opensource.org/licenses/MIT).
