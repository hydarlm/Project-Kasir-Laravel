# Website Kasir Sederhana

Ini adalah tugas akhir/project untuk memenuhi tugas UAS Pemrograman Web Lanjut, menggunakan Laravel. website ini lumayan sederhana, bisa dipake untuk mencatat produk, kategori, sama transaksi penjualan.

## Fitur yang Ada

- **Manajemen Produk** - Bisa bisa menambahkan produk
- **Kategori Produk** - Nge-group produk berdasarkan kategori
- **Transaksi Penjualan** - Nyatet transaksi sama detail pembeliannya
- **Login System** - Harus login dulu buat akses aplikasi
- **Dashboard** - Ada tampilan ringkasan data gitu

### Folder-folder Penting

**app/** - Ini tempat logic utama aplikasi
- `Http/Controllers/` - Controller buat handle request dari user
- `Models/` - Model database (User, Product, Category, Transaction)
- `View/Components/` - Komponen UI yang bisa dipake berulang-ulang

**resources/views/** - Template HTML pake Blade
- `categories/` - Halaman buat kelola kategori produk
- `products/` - Halaman buat kelola produk
- `transactions/` - Halaman buat kelola transaksi
- `components/` - Komponen UI yang udah dibuat
- `layouts/` - Layout dasar aplikasi

**database/** - Semua yang berhubungan sama database
- `migrations/` - File migrasi buat bikin struktur database
- `seeders/` - Data dummy buat testing
- `database.sqlite` - Database SQLite-nya

**routes/** - Pengaturan routing aplikasi
- `web.php` - Route buat halaman web

**public/** - File yang bisa diakses dari luar
- `index.php` - Entry point aplikasi

## Cara Jalanin

1. **Install dependencies dulu**
   ```bash
   composer install
   ```

2. **Setup database**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

3. **Jalankan aplikasinya**
   ```bash
   php artisan serve
   ```

4. **Buka di browser**
   Tinggal buka `http://localhost:8000`

## Database

Pake SQLite aja biar simple, gak perlu install MySQL segala. Ada beberapa tabel:
- `users` - Data user yang bisa login
- `categories` - Kategori produk
- `products` - Data produk
- `transactions` - Header transaksi
- `transaction_details` - Detail item dalam transaksi

## Tech Stack

- **Laravel** - Framework PHP yang populer
- **SQLite** - Database ringan
- **Blade** - Template engine bawaan Laravel
- **Tailwind CDN** - Styling pake CDN, gak perlu compile
- **Alpine.js CDN** - Buat interaksi JavaScript yang ringan

## Catatan Penting

- Database SQLite udah include dalam project, jadi gak ribet setup database server
- Pake Blade Components buat bikin UI yang reusable dan bersih
- Blade Components ada di `app/View/Components/` (PHP class) dan `resources/views/components/` (template)
- Pake struktur MVC standar Laravel jadi mudah dipahami
- Frontend pake CDN jadi gak perlu compile, tinggal refresh browser
- Alpine.js dipake buat interaksi JavaScript yang simple dan ringan
- Kalo ada bug atau error, coba cek di log Laravel

## Cara Pakai

1. Login pake akun yang udah dibuat lewat seeder
2. Kelola kategori produk di menu Categories
3. Tambahin produk di menu Products
4. Catat transaksi penjualan di menu Transactions
5. Cek laporan dan data di dashboard

Project ini cocok banget buat toko kecil yang butuh sistem simple buat nyatet penjualan dan stock produk. Lumayan lengkap fiturnya tapi gak terlalu ribet. Pake Blade Components jadi kode lebih bersih dan mudah di-maintain.

## Pemecahan Masalah

Kalo ada masalah:
- Pastikan composer udah diinstall (gak perlu npm)
- Cek file `.env` udah bener
- Jalanin `php artisan config:clear` kalo ada error config
- Kalo database error, coba hapus database.sqlite terus migrate ulang
- Frontend pake CDN jadi gak ada masalah compile
- Alpine.js error biasanya gara-gara syntax x-data atau x-show, cek console browser
- Blade Components error biasanya gara-gara nama component gak match sama class-nya
