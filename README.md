# KARA - Kelola Administrasi & Rapor Akademik

**KARA** adalah aplikasi administrasi sekolah berbasis modular yang memungkinkan pengguna untuk mengelola berbagai aspek akademik seperti **SPP, PKL, KBM, dan rapor** sesuai kebutuhan. Fitur-fitur akan dikembangkan secara bertahap sesuai roadmap pengembangan.

## 🚀 Fitur (Dalam Pengembangan)
- **Modular & Fleksibel** - Pilih modul sesuai kebutuhan sekolah.
- **Manajemen Administrasi** - Kelola data siswa, guru, dan keuangan dengan mudah.
- **Rapor Digital** - Otomatisasi pembuatan dan distribusi rapor.
- **Keamanan Data** - Menggunakan autentikasi JWT dan role-based access control.
- **Integrasi API** - Terhubung dengan sistem eksternal dengan REST API.

> **Catatan:** Beberapa fitur masih dalam tahap pengembangan dan akan diperbarui secara berkala.

---

## 📌 Requirements
- **PHP** >= 8.1
- **Composer**
- **Laravel** >= 10.x
- **MySQL** atau database lain yang didukung

---

## 🛠 Instalasi
### 1️⃣ Clone Repository
```sh
git clone https://github.com/tajillahibnu/kara.git
cd kara
```

### 2️⃣ Instal Dependensi
```sh
composer install
```

### 3️⃣ Konfigurasi Environment
Buat file `.env` berdasarkan contoh `.env.example` dan sesuaikan dengan konfigurasi database:
```sh
cp .env.example .env
php artisan key:generate
```

### 4️⃣ Konfigurasi Database
Edit `.env` dengan pengaturan database yang sesuai:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kara_db
DB_USERNAME=root
DB_PASSWORD=
```
Lalu jalankan migrasi dengan seeder:
```sh
php artisan migrate:fresh --seed
```

### Clear and optimize the application:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

```

### 5️⃣ Jalankan Aplikasi
```sh
php artisan serve
```
Akses aplikasi di `http://127.0.0.1:8000`

---

## 📖 Common Artisan Commands
### 🔹 Buat Model dengan Migration & Seeder
```sh
php artisan make:model Tingkat -m -s
```
- `-m` : Membuat file migration.
- `-s` : Membuat file seeder.

### 🔹 Buat Factory
```sh
php artisan make:factory PostFactory
```
Membuat class factory untuk seeding model.

### 🔹 Reset Database dengan Seeder
```sh
php artisan migrate:fresh --seed
```
Menghapus semua tabel, membuat ulang, dan menambahkan data awal.

---

## 📌 SOP: Standard Operating Procedures
### 🔹 Buat Request dalam Modul
```sh
php artisan module:make-request Management/PegawaiRequest pkl
```
- `Management/PegawaiRequest` : Lokasi dan nama request class.
- `pkl` : Nama modul.

### 🔹 Buat Controller dalam Modul
```sh
php artisan module:make-controller Master/TahunController pkl
```
- `Master/TahunController` : Lokasi dan nama controller.
- `pkl` : Nama modul.

### 🔹 Buat Service dalam Modul
```sh
php artisan module:make-service Master/TahunService pkl
```
- `Master/TahunService` : Lokasi dan nama service class.
- `pkl` : Nama modul.

### 🔹 Buat Repository dalam Modul
```sh
php artisan module:make-repository TahunRepository pkl
```
- `TahunRepository` : Nama repository.
- `pkl` : Nama modul.

---

## 📂 Struktur Folder Utama
```
kara/
├── app/
│   ├── Http/
│   ├── Models/
│   ├── Services/
│   ├── Policies/
├── database/
│   ├── migrations/
│   ├── seeders/
├── Modules/
│   ├── NamaModul/
│   │   ├── Config/
│   │   ├── Http/
│   │   ├── Models/
│   │   ├── Routes/
├── public/
├── resources/
│   ├── views/
│   ├── js/
│   ├── css/
├── routes/
│   ├── api.php
│   ├── web.php
├── .env
├── composer.json
├── package.json
└── README.md
```

---

## 📢 Kontribusi & Format Commit Git
Gunakan format berikut untuk setiap commit:
```
[nama modul/menu][fitur/fungsi]: deskripsi singkat
```
Contoh:
```
[SPP][add]: Tambah fitur pembayaran SPP online
[PKL][fix]: Perbaiki bug pada laporan PKL
```
### Cara Kontribusi
1. **Fork** repositori ini.
2. **Buat branch** dengan fitur atau perbaikan baru: `git checkout -b feature-branch`
3. **Commit perubahan**: `git commit -m '[modul][fitur]: deskripsi'`
4. **Push ke branch**: `git push origin feature-branch`
5. **Buat Pull Request**

---

## 📧 Kontak & Dukungan
Jika ada pertanyaan atau ingin berkontribusi, hubungi: 
📩 Email: support@karaapp.com  
🌐 Website: [karaapp.com](https://karaapp.com)

---

## 📜 Lisensi
Aplikasi ini dirilis di bawah lisensi **MIT**. Silakan gunakan dan modifikasi sesuai kebutuhan.

---

💡 **KARA - Solusi Administrasi Sekolah Modular yang Fleksibel!**
