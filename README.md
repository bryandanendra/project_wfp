"Self-Ordering for Healthly Food System"
Sejak tahun 2021, sistem self-ordering telah banyak diterapkan di berbagai restoran cepat saji seperti McDonald's dan IKEA di Indonesia. Sistem ini memungkinkan pelanggan untuk memesan makanan sendiri melalui kiosk digital atau aplikasi web, tanpa perlu berinteraksi langsung dengan kasir. Hal ini tidak hanya meningkatkan efisiensi layanan tetapi juga memberikan pengalaman yang lebih cepat dan nyaman bagi pelanggan.
Di sisi lain, tren gaya hidup sehat semakin meningkat, dengan banyak orang lebih selektif dalam memilih makanan yang mereka konsumsi. Namun, restoran sehat sering kali memiliki sistem pemesanan yang kurang praktis dibandingkan restoran cepat saji. Oleh karena itu, sistem Self-Ordering for Healthly Food hadir sebagai solusi untuk memudahkan pelanggan dalam memesan makanan sehat dengan cepat, akurat, dan fleksibel.
Sistem ini adalah sebuah aplikasi berbasis web yang memungkinkan pelanggan untuk melakukan pemesanan makanan sehat secara mandiri melalui sebuah antarmuka interaktif. Sistem ini akan menyediakan fitur-fitur utama seperti:
Menu Digital - Pelanggan dapat melihat daftar makanan dan minuman sehat yang tersedia, lengkap dengan informasi nutrisi dan harga.
Kustomisasi Pesanan - Pelanggan dapat menyesuaikan pesanan mereka, seperti memilih jenis bahan, ukuran porsi, atau menghindari alergi tertentu.
Metode Pemesanan  - Dine-in / Take-away
Metode Pembayaran Digital - Pembayaran dilakukan secara cashless menggunakan dompet digital, kartu kredit/debit, atau QRIS.
Notifikasi Status Pesanan - Setelah memesan, pelanggan akan mendapatkan status pesanan secara real-time, apakah sedang diproses atau sudah siap diambil.
Dashboard Admin - Pihak restoran dapat mengelola menu, melihat riwayat pesanan, serta melaporkan data seperti (siapa member teraktif, siapa member terbanyak membeli, transaksi terbanyak, total omzet, produk terlaris, produk yg perlu diendorse)

Lihat contoh Project sejenis dalam realworld = https://www.behance.net/gallery/153664009/Food-Ordering-Kiosk

menggunakan Laravel Framework
menggunakan Data & Integrasi dengan Laravel Framework
menggunakan routing dan Query dalam studi kasus Anda
menggunakan Template
menggunakan Modals dan JQuery secara sederhana

## Instruksi Setup Project

### Persyaratan
- PHP >= 8.1
- Composer
- MySQL
- Node.js & NPM (untuk asset compilation)

### Langkah-langkah Setup

1. Clone repository dari GitHub
   ```
   git clone <repository-url>
   cd project-folder
   ```

2. Install dependency PHP
   ```
   composer install
   ```

3. Salin file .env.example ke .env
   ```
   cp .env.example .env
   ```

4. Generate application key
   ```
   php artisan key:generate
   ```

5. Konfigurasi database di file .env
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database
   DB_USERNAME=username
   DB_PASSWORD=password
   ```

6. Jalankan migrasi dan seeder
   ```
   php artisan migrate --seed
   ```

7. Buat symbolic link untuk storage dan atur permission folder
   ```
   php artisan storage:fix-permissions
   ```
   Command ini akan:
   - Membuat symbolic link dari public/storage ke storage/app/public
   - Membuat folder storage/app/public/foods dan storage/app/public/categories jika belum ada
   - Mengatur permission folder dan file agar dapat diakses di semua OS (Mac, Windows, Linux)

   **Catatan**: Jika terjadi error permission denied, jalankan perintah berikut sesuai OS:
   
   **Mac/Linux**:
   ```
   sudo chmod -R 777 storage
   ```
   
   **Windows**:
   ```
   icacls storage /grant Everyone:(OI)(CI)F /T
   ```

8. Jalankan development server
   ```
   php artisan serve
   ```

9. Buka browser dan akses http://localhost:8000

### Troubleshooting

#### Gambar tidak muncul setelah clone dari GitHub
- Jalankan `php artisan storage:fix-permissions` untuk memperbaiki permission dan symbolic link
- Atau buka URL `/fix-storage-permissions` di browser untuk menjalankan command secara otomatis
- Jika command di atas error, jalankan perintah berikut sesuai OS:

  **Mac/Linux**:
  ```
  sudo chmod -R 777 storage
  php artisan storage:link
  ```
  
  **Windows**:
  ```
  icacls storage /grant Everyone:(OI)(CI)F /T
  php artisan storage:link
  ```

#### Error saat upload gambar
- Pastikan folder storage memiliki permission yang benar dengan menjalankan perintah sesuai OS:

  **Mac/Linux**:
  ```
  sudo chmod -R 777 storage
  ```
  
  **Windows**:
  ```
  icacls storage /grant Everyone:(OI)(CI)F /T
  ```

- Pastikan web server (Apache/Nginx) memiliki akses write ke folder storage
- Cek ukuran file upload tidak melebihi batas maksimum (5MB)
- Pastikan format file sesuai (JPG, PNG, JPEG, GIF)

#### Masalah dengan Server Apache
Jika menggunakan server Apache dan gambar masih tidak muncul, salin file `.htaccess-for-storage` ke folder berikut:
- `public/storage/.htaccess`
- `storage/app/public/.htaccess`

File ini berisi konfigurasi untuk mengizinkan akses ke folder storage dan mengatur header untuk gambar.

#### Masalah Permission di Shared Hosting
Jika menggunakan shared hosting dan tidak memiliki akses sudo:
1. Gunakan File Manager dari panel hosting
2. Cari folder storage
3. Klik kanan dan pilih "Change Permissions"
4. Set permission ke 755 untuk folder dan 644 untuk file
5. Centang opsi "Recursive" untuk mengubah semua subfolder dan file

#### Solusi Terbaru untuk Masalah Upload
Jika masih mengalami masalah saat upload gambar, aplikasi sekarang menggunakan metode alternatif untuk menyimpan file:
- Menggunakan `file_put_contents()` langsung daripada `storeAs()` dari Laravel
- Mengabaikan error permission dengan operator `@` untuk mencegah aplikasi crash
- Middleware `EnsureStoragePermissions` yang memastikan folder storage ada sebelum mengakses halaman admin
- File bootstrap yang berjalan saat aplikasi dimulai untuk mengatur permission folder storage

Dengan perubahan ini, aplikasi seharusnya dapat berjalan dengan baik di berbagai lingkungan tanpa masalah permission.

#### Mengatasi Error "Call to undefined method Illuminate\Container\Container::storagePath()"
Jika Anda melihat error ini, itu berarti aplikasi mencoba mengakses helper `storage_path()` sebelum Laravel sepenuhnya dimuat. Untuk memperbaikinya:

1. Buka URL `/fix-storage-path` di browser untuk memperbaiki masalah secara otomatis
2. Jika masih error, jalankan perintah berikut di terminal:
   ```
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   php artisan route:clear
   ```
3. Restart server Laravel dengan `php artisan serve`

Jika masih mengalami masalah, coba hapus file bootstrap/storage_permissions.php dan jalankan aplikasi kembali.