# LITTLESTU (CodeIgniter 4)

Aplikasi katalog daring dan panel admin untuk toko pakaian anak LITTLESTU, dibuat menggunakan CodeIgniter 4 dan MySQL/MariaDB. Pengunjung bisa melihat daftar koleksi, menelusuri lookbook dengan titik produk, memakai kalkulator ukuran anak, lalu melanjutkan pemesanan melalui Shopee, TikTok Shop, atau WhatsApp.

## Tampilan aplikasi

Halaman beranda:

![Halaman beranda LITTLESTU](docs/screenshots/storefront-hero.png)

Katalog produk:

![Katalog produk LITTLESTU](docs/screenshots/storefront-catalog.png)

Dashboard admin:

![Dashboard admin LITTLESTU](docs/screenshots/admin-dashboard.png)

## Catatan aset gambar

Berkas foto produk di folder `public/images/` sengaja dikosongkan dan tidak disertakan di repositori ini (hanya `placeholder.svg` yang dipertahankan sebagai gambar cadangan). Untuk mengisi gambar produk, unggah langsung melalui panel admin atau letakkan berkas gambar di folder `public/images/`.

## Fitur

Halaman publik:
- Katalog produk dengan penyaringan kategori, pencarian, dan pratinjau varian warna
- Lookbook interaktif dengan titik hotspot yang mengarah ke detail produk
- Kalkulator ukuran anak berdasarkan usia, tinggi badan, dan berat badan
- Bagian ulasan pembeli, FAQ, dan formulir pendaftaran newsletter
- Pencatatan tayangan produk serta klik tombol Shopee, TikTok Shop, dan WhatsApp

Panel admin (`/admin`):
- Ringkasan statistik produk yang paling sering dilihat dan distribusi klik per kanal
- Pengelolaan produk (tambah, ubah, aktif/nonaktif, hapus)
- Pengelolaan slide lookbook beserta koordinat hotspot
- Pengelolaan ulasan, FAQ, tabel panduan ukuran, dan teks pengaturan toko
- Daftar pelanggan newsletter beserta ekspor ke format CSV

## Kebutuhan sistem

- PHP 8.2 atau lebih baru dengan ekstensi `intl`, `mbstring`, dan `mysqli`
- Composer
- MySQL atau MariaDB

## Cara menjalankan

1. Pasang dependensi PHP:
   ```bash
   composer install
   ```

2. Salin berkas `env` menjadi `.env`, lalu sesuaikan `app.baseURL` dan konfigurasi database:
   ```ini
   app.baseURL = 'http://localhost:8080/'

   database.default.hostname = 127.0.0.1
   database.default.database = littlestu
   database.default.username = root
   database.default.password =
   database.default.DBDriver = MySQLi
   database.default.port = 3306
   ```

3. Buat database kosong di MySQL/MariaDB, lalu jalankan migrasi dan seeder:
   ```bash
   php spark migrate
   php spark db:seed LittlestuSeeder
   ```

4. Jalankan server lokal:
   ```bash
   php spark serve
   ```
   Jika port `8080` sedang dipakai, gunakan opsi `--port`:
   ```bash
   php spark serve --port=8081
   ```

Halaman publik bisa dibuka di `http://localhost:8080` dan halaman masuk admin di `http://localhost:8080/admin/login`.

## Akun admin bawaan

Seeder `LittlestuSeeder` membuat satu akun admin awal:

- Username: `littlestu` (atau email `admin@littlestu.id`)
- Password: `admin`

Segera ganti kata sandi ini sebelum aplikasi dipakai di lingkungan produksi.
