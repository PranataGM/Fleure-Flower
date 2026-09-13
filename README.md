# 🌸 Fleure Flower - Premium Florist E-Commerce

Fleure Flower adalah aplikasi e-Commerce toko bunga premium yang dibangun menggunakan framework **Laravel 11**. Aplikasi ini dirancang untuk memberikan pengalaman berbelanja bunga (buket, fresh flower, dan kartu ucapan) yang elegan, responsif, dan aman.

## ✨ Fitur Utama

### 🛒 Fitur Pelanggan (User)
*   **Autentikasi Modern:** Mendukung pendaftaran dan login standar (Email/Password) serta **Login via Google** (OAuth 2.0 menggunakan Laravel Socialite).
*   **Manajemen Profil:** Pengguna dapat memperbarui nama (dengan batasan 24 jam), bio profil, serta memilih avatar kustom dari *icon library* bawaan atau menggunakan foto profil Google.
*   **Katalog Interaktif:** Menampilkan koleksi bunga dengan fitur filter berdasarkan kategori (*Buket, Fresh Flower, Amplop/Kartu*).
*   **Keranjang Belanja (Cart):** Penyimpanan keranjang belanja terintegrasi dengan *session* untuk kemudahan *checkout*.
*   **Checkout & Payment Gateway:** Integrasi **Midtrans** (Snap API) memungkinkan pelanggan melakukan pembayaran dengan berbagai metode (GoPay, Transfer Bank, Kartu Kredit, dll) secara *real-time*.

### 📊 Fitur Admin Panel
*   **Dashboard Analitik:** Menampilkan statistik jumlah produk, total pesanan, pesanan terbayar, beserta **Grafik Pendapatan 7 Hari Terakhir** (menggunakan *Chart.js*).
*   **Manajemen Produk (CRUD):** Tambah, edit, hapus, dan perbarui status produk (Tersedia / Sold Out). Mendukung pengunggahan foto produk.
*   **Manajemen Pesanan:** Melihat detail pesanan masuk, memantau status pembayaran secara *real-time*, dan mengubah status pengiriman barang.
*   **Pengaturan Toko:** Mengelola nama toko, alamat, kontak WhatsApp, dan Instagram yang akan tercermin langsung pada halaman *footer* pengunjung.

### 🛡️ Keamanan & Performa (Security Standards)
*   **Proteksi Brute-Force (Rate Limiting):** Membatasi jumlah percobaan *login* yang gagal berturut-turut pada akun Pelanggan maupun Admin untuk mencegah serangan *brute-force* bot.
*   **Database Race-Condition Lock (Pessimistic Locking):** Menggunakan `DB::transaction()` dan `lockForUpdate()` pada *webhook/callback* Midtrans untuk mencegah anomali pemrosesan data (pemrosesan ganda) saat *traffic* tinggi.
*   **XSS & CSRF Protection:** Seluruh form dilindungi dengan token `@csrf`. Input pengguna pada saat *checkout* disanitasi ketat menggunakan `strip_tags()` untuk mencegah injeksi skrip HTML/JS.
*   **Graceful Error Handling:** Implementasi *try-catch* pada integrasi API pihak ketiga (Midtrans) sehingga jika server *payment gateway* sedang *down*, pelanggan tidak akan mendapati layar *error crash*, melainkan notifikasi yang sopan untuk mencoba lagi.
*   **Strict Unique ID Generation:** Pembuatan kode struk (Order ID) dijamin unik dengan sistem *do-while existence check*.

---

## 🚀 Panduan Instalasi (Development)

1. **Clone Repository:**
   ```bash
   git clone https://github.com/PranataGM/Fleure-Flower.git
   cd Fleure-Flower
   ```

2. **Install Dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup:**
   Salin file konfigurasi lingkungan dan sesuaikan nilainya:
   ```bash
   cp .env.example .env
   ```
   *Pastikan Anda telah mengisi kredensial database, Midtrans Server Key, dan Google OAuth Client ID.*

4. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

5. **Migrasi Database & Seeder:**
   ```bash
   php artisan migrate --seed
   ```

6. **Storage Link:**
   ```bash
   php artisan storage:link
   ```

7. **Jalankan Aplikasi:**
   ```bash
   npm run dev
   php artisan serve
   ```
   Akses aplikasi di `http://localhost:8000`.

---

## 🛠️ Tech Stack
*   **Backend:** Laravel 11 (PHP 8.2+)
*   **Frontend:** Tailwind CSS, Alpine.js, Phosphor Icons, Chart.js
*   **Database:** MySQL
*   **Payment Gateway:** Midtrans Snap API
*   **OAuth:** Google Socialite

---
*Didesain dan dikembangkan dengan penuh dedikasi untuk kebutuhan e-Commerce modern.*
